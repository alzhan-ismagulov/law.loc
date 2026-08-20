<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    // Показать страницу ввода кода
    public function notice()
    {
        // return view('auth.verify');
        return view('auth.verify');
    }

    // Проверка кода
    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|string|size:6']);

        $user = auth()->user();

        // Посмотрим в лог, что с чем мы сравниваем
        \Illuminate\Support\Facades\Log::info('Verification check:', [
            'db_code' => $user->verification_code ?? 'NULL',
            'request_code' => $request->code,
            'user_id' => $user->id ?? 'NOT_AUTH'
        ]);

        if ($user && (string) $user->verification_code === (string) $request->code) {
            $user->update([
                'email_verified_at' => now(),
                'verification_code' => null,
            ]);

            return redirect('/dashboard')->with('success', 'Email успешно подтвержден!');
        }

        return back()->withErrors(['code' => 'Неверный код подтверждения.']);
    }
}