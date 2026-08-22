<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 1. Проверяем администратора (web)
        if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/admin');
        }

        // 2. Проверяем переводчика (translator)
        if (Auth::guard('translator')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/translator/dashboard');
        }

        // 3. Проверяем клиента (client) — ЭТОГО БЫЛО НЕ ХВАТАЕТ
        if (Auth::guard('client')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/client/dashboard');
        }

        return back()->withErrors([
            'email' => 'Введенные учетные данные не соответствуют нашим записям.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        if (Auth::guard('translator')->check()) {
            Auth::guard('translator')->logout();
        } elseif (Auth::guard('client')->check()) {
            Auth::guard('client')->logout();
        } else {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showRegisterForm()
    {
        return view('auth.signup');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $code = random_int(100000, 999999);

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'verification_code' => $code,
        ]);
        
        $userRole = \App\Models\Role::where('slug', 'user')->first();
        if ($userRole) {
            $user->roles()->sync([$userRole->id]);
        }

        $user->notify(new \App\Notifications\VerifyEmailNotification($code));

        Auth::login($user);

        return redirect('/verify')->with('status', 'Пожалуйста, проверьте вашу электронную почту для получения кода подтверждения.');
    }
}