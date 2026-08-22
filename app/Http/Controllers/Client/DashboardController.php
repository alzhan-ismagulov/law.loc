<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\TranslationOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $client = Auth::guard('client')->user();
        $ordersCount = TranslationOrder::where('client_id', $client->id)->count();

        return view('client.dashboard', compact('client', 'ordersCount'));
    }

    public function orders(Request $request)
    {
        $client = Auth::guard('client')->user();
        
        $query = TranslationOrder::with(['nomenclature.parent', 'files', 'translator'])
            ->where('client_id', $client->id);

        // Фильтрация по датам
        if ($request->filled('date_from')) {
            $query->whereDate('order_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('order_date', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhereHas('nomenclature', function($sub) use ($search) {
                      $sub->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->orderBy('order_date', 'desc')->get();

        $totalSum = $orders->sum('client_price');
        $paidSum = $orders->where('is_client_paid', true)->sum('client_price');
        $unpaidSum = $orders->where('is_client_paid', false)->sum('client_price');

        return view('client.orders', compact('orders', 'client', 'totalSum', 'paidSum', 'unpaidSum'));
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