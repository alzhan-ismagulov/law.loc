<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nomenclature;
use App\Models\NomenclaturePrice;
use App\Models\PoligraphyPurchase;
use App\Models\PoligraphyOrder;
use Illuminate\Http\Request;

class PoligraphyController extends Controller
{
    // Список закупок
    public function purchasesIndex(Request $request)
    {
        $purchases = PoligraphyPurchase::with('nomenclature')->orderBy('purchase_date', 'desc')->get();
        return view('admin.poligraphy.purchases', compact('purchases'));
    }

    // Сохранение закупки
    public function purchasesStore(Request $request)
    {
        $validated = $request->validate([
            'nomenclature_id' => 'required|exists:nomenclatures,id',
            'quantity' => 'required|numeric|min:0.0001',
            'purchase_price' => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
        ]);

        $totalAmount = $validated['quantity'] * $validated['purchase_price'];

        PoligraphyPurchase::create([
            'nomenclature_id' => $validated['nomenclature_id'],
            'quantity' => $validated['quantity'],
            'purchase_price' => $validated['purchase_price'],
            'total_amount' => $totalAmount,
            'purchase_date' => $validated['purchase_date'],
        ]);

        // Обновляем закупочную цену в истории цен номенклатуры
        $nomenclature = Nomenclature::findOrFail($validated['nomenclature_id']);
        $factor = $nomenclature->conversion_factor > 0 ? $nomenclature->conversion_factor : 1;
        $unitPurchasePrice = $validated['purchase_price'] / $factor;

        $currentPrice = $nomenclature->currentPrice;
        $sellingPrice = $currentPrice ? $currentPrice->selling_price : 0;

        NomenclaturePrice::create([
            'nomenclature_id' => $nomenclature->id,
            'purchase_price' => $unitPurchasePrice,
            'selling_price' => $sellingPrice,
            'effective_date' => $validated['purchase_date'],
        ]);

        return redirect()->route('admin.poligraphy.purchases.index')
            ->with('success', 'Закупка успешно оформлена, цены номенклатуры обновлены.');
    }

    // Раздел Продажи (Дашбоард заказов)
    public function salesIndex(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-d'));
        $endDate = $request->get('end_date', date('Y-m-d'));

        // Получаем услуги строго из папки «Полиграфические услуги»
        $services = Nomenclature::with('currentPrice')
            ->where('type', 'item')
            ->whereHas('parent', function ($query) {
                $query->where('name', 'Полиграфические услуги');
            })
            ->get();

        $orders = PoligraphyOrder::with('nomenclature')
            ->whereBetween('order_date', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue = $orders->sum('total_price');
        $totalMaterialCost = $orders->sum('material_cost');

        return view('admin.poligraphy.sales', compact('services', 'orders', 'startDate', 'endDate', 'totalRevenue', 'totalMaterialCost'));
    }

    // Сохранение заказа из плитки
    public function salesStore(Request $request)
    {
        $validated = $request->validate([
            'nomenclature_id' => 'required|exists:nomenclatures,id',
            'quantity' => 'required|numeric|min:0.01',
            'order_date' => 'required|date',
        ]);

        $service = Nomenclature::with('currentPrice', 'bomItems.materialItem.prices', 'bomItems.materialItem.currentPrice')->findOrFail($validated['nomenclature_id']);
        
        $sellingPrice = $service->currentPrice?->selling_price ?? 0;
        $totalPrice = $sellingPrice * $validated['quantity'];

        // Расчет себестоимости материалов по спецификации (технокарте)
        $materialCost = 0;
        foreach ($service->bomItems as $bom) {
            $matPrice = $bom->materialItem->base_purchase_price ?? 0;
            $materialCost += ($bom->quantity * $validated['quantity']) * $matPrice;
        }

        PoligraphyOrder::create([
            'nomenclature_id' => $service->id,
            'quantity' => $validated['quantity'],
            'total_price' => $totalPrice,
            'material_cost' => $materialCost,
            'order_date' => $validated['order_date'],
        ]);

        return redirect()->route('admin.poligraphy.sales.index', ['start_date' => $validated['order_date'], 'end_date' => $validated['order_date']])
            ->with('success', 'Заказ успешно зарегистрирован.');
    }
}