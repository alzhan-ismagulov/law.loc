<?php

namespace App\Http\Controllers\Translator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $translator = Auth::guard('translator')->user();
        return view('translator.dashboard', compact('translator'));
    }

    public function orders()
    {
        $translator = Auth::guard('translator')->user();
        return view('translator.orders', compact('translator'));
    }

    public function prices()
    {
        $translator = Auth::guard('translator')->user()->load('languagePairs.prices');
        return view('translator.prices', compact('translator'));
    }

    public function profile()
    {
        $translator = Auth::guard('translator')->user();
        return view('translator.profile', compact('translator'));
    }

    public function updatePrice(Request $request, TranslatorLanguagePair $pair)
    {
        $translator = Auth::guard('translator')->user();

        // Проверяем, что эта языковая пара принадлежит именно залогиненному переводчику
        if ($pair->translator_id !== $translator->id) {
            abort(403);
        }

        $data = $request->validate([
            'currency' => 'required|string|max:10',
            'written_price_1800' => 'nullable|numeric',
            'consecutive_price_hour' => 'nullable|numeric',
            'simultaneous_price_hour' => 'nullable|numeric',
            'notarial_fee' => 'nullable|numeric',
            'editing_price_1800' => 'nullable|numeric',
            'effective_from' => 'required|date',
        ]);

        $data['language_pair_id'] = $pair->id;

        \App\Models\TranslatorPriceHistory::create($data);

        return back()->with('success', 'Ваш тариф успешно обновлен.');
    }
}