<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        $regions = [
            'Абайская область',
            'Акмолинская область',
            'Актюбинская область',
            'Алматинская область',
            'Атырауская область',
            'Восточно-Казахстанская область',
            'Жамбылская область',
            'Жетысуская область',
            'Западно-Казахстанская область',
            'Карагандинская область',
            'Костанайская область',
            'Кызылординская область',
            'Мангистауская область',
            'Павлодарская область',
            'Северо-Казахстанская область',
            'Туркестанская область',
            'Улытауская область',
            'город Астана',
            'город Алматы',
            'город Шымкент',
        ];

        foreach ($regions as $region) {
            DB::table('regions')->updateOrInsert(
                ['slug' => Str::slug($region)],
                ['title' => $region]
            );
        }
    }
}