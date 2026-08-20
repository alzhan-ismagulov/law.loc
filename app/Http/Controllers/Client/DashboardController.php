<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $client = Auth::guard('client')->user();
        // Здесь в будущем можно будет подтянуть заказы клиента
        return view('client.dashboard', compact('client'));
    }

    public function orders()
    {
        $client = Auth::guard('client')->user();
        // Список заказов клиента
        return view('client.orders', compact('client'));
    }

    public function profile()
    {
        $client = Auth::guard('client')->user();
        return view('client.profile', compact('client'));
    }

    public function updateProfile(Request $request)
    {
        $client = Auth::guard('client')->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'city' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'iban' => 'nullable|string|max:50',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $client->update($data);

        return back()->with('success', 'Профиль успешно обновлен.');
    }
}