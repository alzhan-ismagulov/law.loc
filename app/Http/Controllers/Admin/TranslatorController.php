<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Translator;
use App\Models\TranslatorLanguagePair;
use App\Models\TranslatorPriceHistory;
use App\Models\Region;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class TranslatorController extends Controller
{
    public function index()
    {
        $translators = Translator::all();
        return view('admin.translators.index', compact('translators'));
    }

    public function create()
    {
        $regions = Region::all();
        $languages = Language::all();
        return view('admin.translators.create', compact('regions', 'languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'region_id' => 'required|integer',
            'city' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'card_number' => 'nullable|string|max:50',
            'card_type' => 'nullable|string|max:50',
            'bank_name' => 'nullable|string|max:255',
            'iban' => 'nullable|string|max:50',
            'phone' => 'required|string|max:20',
            'messengers' => 'nullable|string',
            'email' => 'required|email|unique:translators,email',
            'status' => 'required|string|in:active,inactive',
            'internal_notes' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'diploma' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
            'pairs' => 'nullable|array',
            'pairs.*.source' => 'required_with:pairs|integer',
            'pairs.*.target' => 'required_with:pairs|integer',
            'pairs.*.currency' => 'required_with:pairs|string|max:10',
            'pairs.*.written_price_1800' => 'required_with:pairs|numeric',
            'pairs.*.consecutive_price_hour' => 'required_with:pairs|numeric',
            'pairs.*.simultaneous_price_hour' => 'required_with:pairs|numeric',
            'pairs.*.notarial_fee' => 'required_with:pairs|numeric',
            'pairs.*.editing_price_1800' => 'required_with:pairs|numeric',
        ]);

        DB::transaction(function () use ($request) {
            $data = $request->except(['photo', 'diploma', 'pairs']);
            $data['status'] = $request->status ?? 'active';

            if ($request->hasFile('photo')) {
                $data['photo_path'] = $request->file('photo')->store('translators', 'public');
            }
            if ($request->hasFile('diploma')) {
                $data['diploma_path'] = $request->file('diploma')->store('translators/diplomas', 'public');
            }

            $translator = Translator::create($data);

            if ($request->has('pairs')) {
                foreach ($request->pairs as $pairData) {
                    $pair = TranslatorLanguagePair::create([
                        'translator_id' => $translator->id,
                        'source_language_id' => $pairData['source'],
                        'target_language_id' => $pairData['target'],
                    ]);

                    TranslatorPriceHistory::create([
                        'language_pair_id' => $pair->id,
                        'currency' => $pairData['currency'],
                        'written_price_1800' => $pairData['written_price_1800'],
                        'consecutive_price_hour' => $pairData['consecutive_price_hour'],
                        'simultaneous_price_hour' => $pairData['simultaneous_price_hour'],
                        'notarial_fee' => $pairData['notarial_fee'],
                        'editing_price_1800' => $pairData['editing_price_1800'],
                        'effective_from' => now(),
                    ]);
                }
            }
        });

        return redirect()->route('admin.translators.index')->with('success', 'Переводчик успешно создан.');
    }

    public function show(Translator $translator)
    {
        $translator->load('languagePairs.prices');
        return view('admin.translators.show', compact('translator'));
    }

    public function edit(Translator $translator)
    {
        $regions = Region::all();
        return view('admin.translators.edit', compact('translator', 'regions'));
    }

    public function update(Request $request, Translator $translator)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'region_id' => 'required|integer',
            'city' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'card_number' => 'nullable|string|max:50',
            'card_type' => 'nullable|string|max:50',
            'bank_name' => 'nullable|string|max:255',
            'iban' => 'nullable|string|max:50',
            'phone' => 'required|string|max:20',
            'messengers' => 'nullable|string',
            'email' => 'required|email|unique:translators,email,' . $translator->id,
            'status' => 'required|string|in:active,inactive',
            'internal_notes' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'diploma' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        if ($request->hasFile('photo')) {
            if ($translator->photo_path) {
                Storage::disk('public')->delete($translator->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('translators', 'public');
        }

        if ($request->hasFile('diploma')) {
            if ($translator->diploma_path) {
                Storage::disk('public')->delete($translator->diploma_path);
            }
            $data['diploma_path'] = $request->file('diploma')->store('translators/diplomas', 'public');
        }

        $translator->update($data);

        return redirect()->route('admin.translators.index')->with('success', 'Данные успешно обновлены.');
    }

    public function destroy(Translator $translator)
    {
        if ($translator->photo_path) {
            Storage::disk('public')->delete($translator->photo_path);
        }

        if ($translator->diploma_path) {
            Storage::disk('public')->delete($translator->diploma_path);
        }

        $translator->delete();

        return redirect()->route('admin.translators.index')->with('success', 'Переводчик успешно удален.');
    }

    public function addLanguagePair(Request $request, Translator $translator)
    {
        $request->validate([
            'source_language_id' => 'required|integer',
            'target_language_id' => 'required|integer',
        ]);

        TranslatorLanguagePair::create([
            'translator_id' => $translator->id,
            'source_language_id' => $request->source_language_id,
            'target_language_id' => $request->target_language_id,
        ]);

        return back()->with('success', 'Языковая пара успешно добавлена.');
    }

    public function updatePrice(Request $request, TranslatorLanguagePair $pair)
    {
        $data = $request->validate([
            'currency' => 'required|string|max:10',
            'written_price_1800' => 'required|numeric',
            'consecutive_price_hour' => 'required|numeric',
            'simultaneous_price_hour' => 'required|numeric',
            'notarial_fee' => 'required|numeric',
            'editing_price_1800' => 'required|numeric',
            'effective_from' => 'required|date',
        ]);

        $data['language_pair_id'] = $pair->id;

        TranslatorPriceHistory::create($data);

        return back()->with('success', 'Новая цена успешно сохранена.');
    }
}