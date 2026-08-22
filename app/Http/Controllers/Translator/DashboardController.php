<?php

namespace App\Http\Controllers\Translator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TranslationOrder;
use App\Models\TranslationOrderFile;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $translator = auth('translator')->user();
        
        // Получаем все заказы переводчика
        $orders = \App\Models\TranslationOrder::with(['client', 'nomenclature', 'files'])
            ->where('translator_id', $translator->id)
            ->orderBy('order_date', 'desc')
            ->get();

        // Считаем метрики для дашборда
        $totalOrdersCount = $orders->count();
        $totalEarnedSum = $orders->sum('translator_price');
        $paidSum = $orders->where('is_translator_paid', true)->sum('translator_price');
        $unpaidSum = $orders->where('is_translator_paid', false)->sum('translator_price');
        $languagePairsCount = $translator->languagePairs()->count();

        return view('translator.dashboard', compact(
            'translator', 
            'orders', 
            'totalOrdersCount', 
            'totalEarnedSum', 
            'paidSum', 
            'unpaidSum', 
            'languagePairsCount'
        ));
    }

    public function orders(Request $request)
    {
        $translatorId = auth('translator')->id();
        
        $query = TranslationOrder::with(['client', 'nomenclature.parent', 'files'])
            ->where('translator_id', $translatorId);

        // Фильтрация по датам
        if ($request->filled('date_from')) {
            $query->whereDate('order_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('order_date', '<=', $request->date_to);
        }

        $orders = $query->orderBy('order_date', 'desc')->get();
        $totalSum = $orders->sum('translator_price');

        return view('translator.orders', compact('orders', 'totalSum'));
    }

    public function uploadTranslation(Request $request, $fileId)
    {
        $file = TranslationOrderFile::with(['order.translator.languagePairs.prices', 'order.nomenclature'])->findOrFail($fileId);
        
        if ($file->order->translator_id !== auth('translator')->id()) {
            abort(403);
        }

        $request->validate([
            'translated_file' => 'required|file|max:10240',
        ]);

        if ($file->translated_file_path) {
            Storage::disk('public')->delete($file->translated_file_path);
        }

        $uploadedFile = $request->file('translated_file');
        $path = $uploadedFile->store('translation_results', 'public');

        $charsCount = 0;
        $extension = strtolower($uploadedFile->getClientOriginalExtension());
        $fullPath = storage_path('app/public/' . $path);

        if ($extension === 'txt') {
            $charsCount = mb_strlen(file_get_contents($fullPath));
        } elseif (in_array($extension, ['docx', 'doc'])) {
            try {
                $zip = new \ZipArchive;
                if ($zip->open($fullPath) === TRUE) {
                    $xmlContent = $zip->getFromName('word/document.xml');
                    $zip->close();
                    if ($xmlContent) {
                        $dom = new \DOMDocument();
                        $dom->loadXML($xmlContent);
                        $charsCount = mb_strlen($dom->textContent);
                    }
                }
            } catch (\Exception $e) {
                $charsCount = $file->original_chars_count;
            }
        } else {
            $charsCount = $file->original_chars_count;
        }

        $file->update([
            'translated_file_path' => $path,
            'translated_chars_count' => $charsCount > 0 ? $charsCount : $file->original_chars_count,
        ]);

        // Пересчет суммы для переводчика
        $order = $file->order;
        $translatorPair = $order->translator?->languagePairs()->with('prices')->first();
        $latestPrice = $translatorPair?->prices()->orderByDesc('effective_from')->first();

        if ($latestPrice) {
            $rate = 0;
            if ($order->service_type === 'oral') {
                $rate = $latestPrice->consecutive_price_hour ?? 0;
            } elseif ($order->service_type === 'sync') {
                $rate = $latestPrice->simultaneous_price_hour ?? 0;
            } elseif ($order->service_type === 'editing') {
                $rate = $latestPrice->editing_price_1800 ?? 0;
            } else {
                $rate = $latestPrice->written_price_1800 ?? 0;
            }

            if ($order->service_type === 'written' || $order->service_type === 'editing') {
                $totalChars = $order->files()->sum('translated_chars_count');
                $order->translator_price = ($totalChars / 1800) * $rate;
                $order->save();
            }
        }

        return back()->with('success', 'Перевод успешно загружен, объем и сумма пересчитаны.');
    }

    public function destroyTranslation($fileId)
{
    $file = TranslationOrderFile::with('order')->findOrFail($fileId);
    
    if ($file->order->translator_id !== auth('translator')->id()) {
        abort(403);
    }

    if ($file->translated_file_path) {
        Storage::disk('public')->delete($file->translated_file_path);
        
        // Сбрасываем данные файла
        $file->update([
            'translated_file_path' => null,
            'translated_chars_count' => 0,
        ]);
    }

    // ПРИНУДИТЕЛЬНО обнуляем сумму в заказе
    $order = $file->order;
    $order->translator_price = 0; 
    $order->save();

    return back()->with('success', 'Файл удален, сумма заказа обнулена.');
}

    public function prices(Request $request)
    {
        $translator = auth('translator')->user();
        $pairs = $translator->languagePairs()->with(['sourceLanguage', 'targetLanguage', 'prices'])->get();

        return view('translator.prices', compact('translator', 'pairs'));
    }

    public function updatePrice(Request $request, $pairId)
    {
        $translator = auth('translator')->user();
        $pair = $translator->languagePairs()->where('id', $pairId)->firstOrFail();

        $validated = $request->validate([
            'currency' => 'required|string|max:10', // <--- Добавили валидацию валюты
            'written_price_1800' => 'required|numeric|min:0',
            'consecutive_price_hour' => 'nullable|numeric|min:0',
            'simultaneous_price_hour' => 'nullable|numeric|min:0',
            'notarial_fee' => 'nullable|numeric|min:0',
            'editing_price_1800' => 'nullable|numeric|min:0',
            'effective_from' => 'required|date',
        ]);

        $pair->prices()->updateOrCreate(
            ['effective_from' => $validated['effective_from']],
            $validated
        );

        return back()->with('success', 'Новый тариф успешно установлен.');
    }

    public function profile()
    {
        $translator = auth('translator')->user();
        return view('translator.profile', compact('translator'));
    }

    public function updateProfile(Request $request)
    {
        $translator = auth('translator')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:translators,email,' . $translator->id,
            'phone' => 'nullable|string|max:50',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($translator->photo_path) {
                Storage::disk('public')->delete($translator->photo_path);
            }
            $validated['photo_path'] = $request->file('photo')->store('translator_photos', 'public');
        }

        $translator->update($validated);

        return back()->with('success', 'Профиль успешно обновлен.');
    }
}