<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nomenclature;
use App\Models\NomenclaturePrice;
use Illuminate\Http\Request;

class NomenclatureController extends Controller
{
    public function index(Request $request)
    {
        $parentId = $request->get('parent_id');
        
        $currentFolder = $parentId ? Nomenclature::findOrFail($parentId) : null;
        
        $items = Nomenclature::with('currentPrice')
            ->where('parent_id', $parentId)
            ->get();

        return view('admin.nomenclature.index', compact('items', 'currentFolder', 'parentId'));
    }

    public function create(Request $request)
    {
        $parentId = $request->get('parent_id');
        $folders = Nomenclature::where('type', 'folder')->get();
        return view('admin.nomenclature.create', compact('parentId', 'folders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:nomenclatures,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:folder,item',
            'category_type' => 'nullable|string|max:255',
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'effective_date' => 'nullable|required_if:type,item|date',
            'base_unit' => 'nullable|string|max:50',
            'purchase_unit' => 'nullable|string|max:50',
            'conversion_factor' => 'nullable|numeric|min:0.0001',
        ]);

        $nomenclature = Nomenclature::create([
            'parent_id' => $validated['parent_id'],
            'name' => $validated['name'],
            'type' => $validated['type'],
            'category_type' => $validated['category_type'] ?? null,
        ]);

        if ($nomenclature->type === 'item') {
            NomenclaturePrice::create([
                'nomenclature_id' => $nomenclature->id,
                'purchase_price' => $validated['purchase_price'] ?? 0,
                'selling_price' => $validated['selling_price'] ?? 0,
                'effective_date' => $validated['effective_date'],
            ]);
        }

        return redirect()->route('admin.nomenclatures.index', ['parent_id' => $nomenclature->parent_id])
            ->with('success', 'Элемент успешно создан.');
    }

    public function show(Nomenclature $nomenclature)
    {
        $nomenclature->load('prices', 'currentPrice', 'parent');
        return view('admin.nomenclature.show', compact('nomenclature'));
    }

    public function edit(Nomenclature $nomenclature)
    {
        $nomenclature->load('currentPrice');
        
        // Исключаем сам элемент и все его подпапки (защита от циклов)
        $excludeIds = [$nomenclature->id];
        $childIds = $nomenclature->children()->pluck('id')->toArray();
        while (!empty($childIds)) {
            $excludeIds = array_merge($excludeIds, $childIds);
            $childIds = Nomenclature::whereIn('parent_id', $childIds)->pluck('id')->toArray();
        }

        // Получаем плоский список доступных папок
        $allFolders = Nomenclature::where('type', 'folder')
            ->whereNotIn('id', $excludeIds)
            ->get();

        // Функция для построения дерева с отступами
        $buildTree = function ($items, $parentId = null, $prefix = '') use (&$buildTree) {
            $branch = collect();
            foreach ($items as $item) {
                if ($item->parent_id == $parentId) {
                    $item->display_name = $prefix . $item->name;
                    $branch->push($item);
                    $branch = $branch->concat($buildTree($items, $item->id, $prefix . '— '));
                }
            }
            return $branch;
        };

        $folders = $buildTree($allFolders);
            
        return view('admin.nomenclature.edit', compact('nomenclature', 'folders'));
    }

    public function update(Request $request, Nomenclature $nomenclature)
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:nomenclatures,id',
            'name' => 'required|string|max:255',
            'category_type' => 'nullable|string|max:255',
            'base_unit' => 'nullable|string|max:50',
            'purchase_unit' => 'nullable|string|max:50',
            'conversion_factor' => 'nullable|numeric|min:0.0001',
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'effective_date' => 'nullable|date',
        ]);

        $nomenclature->update([
            'parent_id' => $validated['parent_id'],
            'name' => $validated['name'],
            'category_type' => $validated['category_type'] ?? $nomenclature->category_type,
            'base_unit' => $validated['base_unit'] ?? $nomenclature->base_unit,
            'purchase_unit' => $validated['purchase_unit'] ?? null,
            'conversion_factor' => $validated['conversion_factor'] ?? 1,
        ]);

        if ($nomenclature->type === 'item') {
            $currentPrice = $nomenclature->currentPrice;
            
            $newPurchase = $validated['purchase_price'] ?? 0;
            $newSelling = $validated['selling_price'] ?? 0;
            $newDate = $validated['effective_date'] ?? date('Y-m-d');

            // Записываем новую цену в историю, если цены изменились или явно указана новая дата
            if (!$currentPrice || $currentPrice->purchase_price != $newPurchase || $currentPrice->selling_price != $newSelling || ($request->filled('effective_date') && $currentPrice->effective_date->format('Y-m-d') != $newDate)) {
                NomenclaturePrice::create([
                    'nomenclature_id' => $nomenclature->id,
                    'purchase_price' => $newPurchase,
                    'selling_price' => $newSelling,
                    'effective_date' => $newDate,
                ]);
            }
        }

        return redirect()->route('admin.nomenclatures.index', ['parent_id' => $nomenclature->parent_id])
            ->with('success', 'Элемент успешно обновлен.');
    }

    public function destroy(Nomenclature $nomenclature)
    {
        $parentId = $nomenclature->parent_id;
        $nomenclature->delete();

        return redirect()->route('admin.nomenclatures.index', ['parent_id' => $parentId])
            ->with('success', 'Элемент удален.');
    }

    // Добавление материала в спецификацию услуги
    public function storeBom(Request $request, Nomenclature $nomenclature)
    {
        $validated = $request->validate([
            'material_item_id' => 'required|exists:nomenclatures,id',
            'quantity' => 'required|numeric|min:0.0001',
        ]);

        $nomenclature->bomItems()->create($validated);

        return redirect()->route('admin.nomenclatures.show', $nomenclature->id)
            .with('success', 'Материал успешно добавлен в спецификацию.');
    }

    // Удаление материала из спецификации
    public function destroyBom(NomenclatureBom $bom)
    {
        $parentId = $bom->parent_item_id;
        $bom->delete();

        return redirect()->route('admin.nomenclatures.show', $parentId)
            .with('success', 'Материал удален из спецификации.');
    }
}