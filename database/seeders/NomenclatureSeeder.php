<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nomenclature;
use App\Models\NomenclaturePrice;
use App\Models\NomenclatureBom;

class NomenclatureSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Создаем основные корневые папки
        $materialsFolder = Nomenclature::firstOrCreate([
            'name' => 'Материалы',
            'parent_id' => null,
        ], [
            'type' => 'folder',
            'category_type' => 'Материалы',
        ]);

        $productsFolder = Nomenclature::firstOrCreate([
            'name' => 'Товары',
            'parent_id' => null,
        ], [
            'type' => 'folder',
            'category_type' => 'Товары',
        ]);

        $servicesFolder = Nomenclature::firstOrCreate([
            'name' => 'Услуги',
            'parent_id' => null,
        ], [
            'type' => 'folder',
            'category_type' => 'Услуги',
        ]);

        // 2. Создаем подразделения (подпапки) внутри папки «Услуги»
        $legalServices = Nomenclature::firstOrCreate([
            'name' => 'Юридические услуги',
            'parent_id' => $servicesFolder->id,
        ], [
            'type' => 'folder',
            'category_type' => 'Услуги',
        ]);

        $translationServices = Nomenclature::firstOrCreate([
            'name' => 'Переводческие услуги',
            'parent_id' => $servicesFolder->id,
        ], [
            'type' => 'folder',
            'category_type' => 'Услуги',
        ]);

        $polyServices = Nomenclature::firstOrCreate([
            'name' => 'Полиграфические услуги',
            'parent_id' => $servicesFolder->id,
        ], [
            'type' => 'folder',
            'category_type' => 'Услуги',
        ]);

        // 3. Материал: Бумага А4 (в папке Материалы)
        $paper = Nomenclature::firstOrCreate([
            'name' => 'Бумага А4 Svetocopy (500л)',
            'parent_id' => $materialsFolder->id,
        ], [
            'type' => 'item',
            'category_type' => 'Материалы',
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

        // ==========================================
        // 4. ПОЛИГРАФИЧЕСКИЕ УСЛУГИ
        // ==========================================
        $polyItems = [
            ['name' => 'Распечатка/Копирование ч/б А4', 'price' => 50.00],
            ['name' => 'Распечатка/Копирование цв. А4', 'price' => 100.00],
            ['name' => 'Сканирование А4', 'price' => 100.00],
            ['name' => 'Ламинирование А4', 'price' => 350.00],
        ];

        foreach ($polyItems as $itemData) {
            $item = Nomenclature::firstOrCreate([
                'name' => $itemData['name'],
                'parent_id' => $polyServices->id,
            ], [
                'type' => 'item',
                'category_type' => 'Услуги',
                'base_unit' => 'шт',
            ]);

            NomenclaturePrice::firstOrCreate([
                'nomenclature_id' => $item->id,
                'effective_date' => now(),
            ], [
                'purchase_price' => 0.00,
                'selling_price' => $itemData['price'],
            ]);

            // Привязываем бумагу как спецификацию для распечатки/ламинирования
            NomenclatureBom::firstOrCreate([
                'parent_item_id' => $item->id,
                'material_item_id' => $paper->id,
            ], ['quantity' => 1]);
        }

        // ==========================================
        // 5. ЮРИДИЧЕСКИЕ УСЛУГИ
        // ==========================================
        $legalItems = [
            ['name' => 'Консультация', 'price' => 10000.00, 'unit' => 'усл'],
            ['name' => 'Представительство в суде 1 инстанции (простое дело)', 'price' => 100000.00, 'unit' => 'дело'],
        ];

        foreach ($legalItems as $itemData) {
            $item = Nomenclature::firstOrCreate([
                'name' => $itemData['name'],
                'parent_id' => $legalServices->id,
            ], [
                'type' => 'item',
                'category_type' => 'Услуги',
                'base_unit' => $itemData['unit'],
            ]);

            NomenclaturePrice::firstOrCreate([
                'nomenclature_id' => $item->id,
                'effective_date' => now(),
            ], [
                'purchase_price' => 0.00,
                'selling_price' => $itemData['price'],
            ]);
        }

        // ==========================================
        // 6. ПЕРЕВОДЧЕСКИЕ УСЛУГИ (Языковые пары)
        // ==========================================
        $translationItems = [
            ['name' => 'Перевод с казахского на русский язык', 'price' => 2000.00],
            ['name' => 'Перевод с русского на казахский язык', 'price' => 2200.00],
            ['name' => 'Перевод с английского на русский язык', 'price' => 2500.00],
            ['name' => 'Перевод с русского на английский язык', 'price' => 2800.00],
            ['name' => 'Перевод с турецкого на русский/казахский язык', 'price' => 3000.00],
            ['name' => 'Перевод с китайского на русский/казахский язык', 'price' => 3500.00],
            ['name' => 'Перевод с немецкого/французского на русский язык', 'price' => 3000.00],
        ];

        foreach ($translationItems as $itemData) {
            $item = Nomenclature::firstOrCreate([
                'name' => $itemData['name'],
                'parent_id' => $translationServices->id,
            ], [
                'type' => 'item',
                'category_type' => 'Услуги',
                'base_unit' => 'стр.', // Стандартная страница (1800 знаков)
            ]);

            NomenclaturePrice::firstOrCreate([
                'nomenclature_id' => $item->id,
                'effective_date' => now(),
            ], [
                'purchase_price' => 0.00,
                'selling_price' => $itemData['price'],
            ]);
        }
    }
}