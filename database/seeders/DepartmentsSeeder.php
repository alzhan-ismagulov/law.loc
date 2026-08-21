<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nomenclature;
use App\Models\NomenclaturePrice;
use App\Models\NomenclatureBom;

class DepartmentsSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. ПОЛИГРАФИЯ
        // ==========================================
        $polyFolder = Nomenclature::firstOrCreate([
            'name' => 'Полиграфия',
            'parent_id' => null,
            'type' => 'folder',
            'department' => 'poligraphy',
        ]);

        $polyMatFolder = Nomenclature::firstOrCreate([
            'name' => 'Материалы',
            'parent_id' => $polyFolder->id,
            'type' => 'folder',
            'department' => 'poligraphy',
        ]);

        $paper = Nomenclature::firstOrCreate([
            'name' => 'Бумага А4 Svetocopy (500л)',
            'parent_id' => $polyMatFolder->id,
            'type' => 'item',
            'category_type' => 'Материалы',
            'department' => 'poligraphy',
            'base_unit' => 'лист',
            'purchase_unit' => 'пачка',
            'conversion_factor' => 500,
        ]);

        NomenclaturePrice::firstOrCreate([
            'nomenclature_id' => $paper->id,
            'effective_date' => now(),
        ], [
            'purchase_price' => 3450.00,
            'selling_price' => 0.00,
        ]);

        $polyServiceFolder = Nomenclature::firstOrCreate([
            'name' => 'Полиграфические услуги',
            'parent_id' => $polyFolder->id,
            'type' => 'folder',
            'department' => 'poligraphy',
        ]);

        $printBw = Nomenclature::firstOrCreate([
            'name' => 'Распечатка/Копирование Ч/Б А4',
            'parent_id' => $polyServiceFolder->id,
            'type' => 'item',
            'category_type' => 'Услуги',
            'department' => 'poligraphy',
            'base_unit' => 'шт',
        ]);

        NomenclaturePrice::firstOrCreate([
            'nomenclature_id' => $printBw->id,
            'effective_date' => now(),
        ], [
            'purchase_price' => 0.00,
            'selling_price' => 50.00,
        ]);

        NomenclatureBom::firstOrCreate([
            'parent_item_id' => $printBw->id,
            'material_item_id' => $paper->id,
        ], ['quantity' => 1]);


        // ==========================================
        // 2. ПЕРЕВОДЫ
        // ==========================================
        $transFolder = Nomenclature::firstOrCreate([
            'name' => 'Переводы',
            'parent_id' => null,
            'type' => 'folder',
            'department' => 'translation',
        ]);

        $transServiceFolder = Nomenclature::firstOrCreate([
            'name' => 'Переводческие услуги',
            'parent_id' => $transFolder->id,
            'type' => 'folder',
            'department' => 'translation',
        ]);

        $transEnRu = Nomenclature::firstOrCreate([
            'name' => 'Перевод с английского на русский',
            'parent_id' => $transServiceFolder->id,
            'type' => 'item',
            'category_type' => 'Услуги',
            'department' => 'translation',
            'base_unit' => 'стр',
        ]);

        NomenclaturePrice::firstOrCreate([
            'nomenclature_id' => $transEnRu->id,
            'effective_date' => now(),
        ], [
            'purchase_price' => 0.00,
            'selling_price' => 2500.00,
        ]);


        // ==========================================
        // 3. ЮРИДИЧЕСКИЙ ОТДЕЛ
        // ==========================================
        $legalFolder = Nomenclature::firstOrCreate([
            'name' => 'Юридический отдел',
            'parent_id' => null,
            'type' => 'folder',
            'department' => 'legal',
        ]);

        $legalServiceFolder = Nomenclature::firstOrCreate([
            'name' => 'Юридические услуги',
            'parent_id' => $legalFolder->id,
            'type' => 'folder',
            'department' => 'legal',
        ]);

        $legalConsultation = Nomenclature::firstOrCreate([
            'name' => 'Юридическая консультация',
            'parent_id' => $legalServiceFolder->id,
            'type' => 'item',
            'category_type' => 'Услуги',
            'department' => 'legal',
            'base_unit' => 'усл',
        ]);

        NomenclaturePrice::firstOrCreate([
            'nomenclature_id' => $legalConsultation->id,
            'effective_date' => now(),
        ], [
            'purchase_price' => 0.00,
            'selling_price' => 10000.00,
        ]);
    }
}