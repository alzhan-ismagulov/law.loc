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

    public function updateProfile(Request $request)
    {
        $translator = Auth::guard('translator')->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'bank_name' => 'nullable|string|max:255',
            'iban' => 'nullable|string|max:255',
            'card_number' => 'nullable|string|max:255',
            'card_type' => 'nullable|string|max:50',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $translator->update($data);

        return back()->with('success', 'Профиль успешно обновлен.');
    }
}