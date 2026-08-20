<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with('region')->orderBy('id', 'desc')->get();
        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        $countries = Country::all(); // Пример списка стран
        $regions = Region::all();
        return view('admin.clients.create', compact('countries', 'regions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|string|in:individual,company',
            'name' => 'required|string|max:255',
            'bin_iin' => 'nullable|string|max:50',
            'country' => 'required|string|max:255',
            'region_id' => 'nullable|integer',
            'city' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|unique:clients,email',
            'password' => 'required|string|min:6',
            'source' => 'nullable|string|max:255',
            'status' => 'required|string|in:active,lead,archive',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'bank_name' => 'nullable|string|max:255',
            'iban' => 'nullable|string|max:50',
            'internal_notes' => 'nullable|string',
        ]);

        $data['password'] = Hash::make($request->password);
        $data['discount_percent'] = $request->discount_percent ?? 0;

        Client::create($data);

        return redirect()->route('admin.clients.index')->with('success', 'Клиент успешно создан.');
    }

    public function edit(Client $client)
    {
        $countries = Country::all();
        $regions = Region::all();
        return view('admin.clients.edit', compact('client', 'regions', 'countries'));
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'type' => 'required|string|in:individual,company',
            'name' => 'required|string|max:255',
            'bin_iin' => 'nullable|string|max:50',
            'country' => 'required|string|max:255',
            'region_id' => 'nullable|integer',
            'city' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'password' => 'nullable|string|min:6',
            'source' => 'nullable|string|max:255',
            'status' => 'required|string|in:active,lead,archive',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'bank_name' => 'nullable|string|max:255',
            'iban' => 'nullable|string|max:50',
            'internal_notes' => 'nullable|string',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $data['discount_percent'] = $request->discount_percent ?? 0;

        $client->update($data);

        return redirect()->route('admin.clients.index')->with('success', 'Данные клиента обновлены.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('admin.clients.index')->with('success', 'Клиент удален.');
    }
}