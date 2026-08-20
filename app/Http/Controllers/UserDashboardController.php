<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        // Если email не подтвержден — отправляем на ввод кода
        if (auth()->check() && auth()->user()->email_verified_at === null) {
            return redirect()->route('verification.notice');
        }

        return view('user.dashboard');
    }
}