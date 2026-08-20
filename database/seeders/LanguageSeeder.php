<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $languages = [
            'Арабский',
            'Армянский',
            'Английский',
            'Азербайджанский',
            'Белорусский',
            'Болгарский',
            'Венгерский',
            'Вьетнамский',
            'Греческий',
            'Грузинский',
            'Датский',
            'Иврит',
            'Итальянский',
            'Испанский',
            'Индонезийский',
            'Казахский',
            'Китайский',
            'Корейский',
            'Кыргызский',
            'Латышский',
            'Литовский',
            'Немецкий',
            'Нидерландский',
            'Норвежский',
            'Польский',
            'Португальский',
            'Румынский',
            'Русский',
            'Сербский',
            'Словацкий',
            'Словенский',
            'Таджикский',
            'Татарский',
            'Турецкий',
            'Узбекский',
            'Украинский',
            'Финский',
            'Французский',
            'Чешский',
            'Японский',
        ];

        // Сортировка по алфавиту на случай добавления новых
        sort($languages, SORT_STRING);

        foreach ($languages as $language) {
            DB::table('languages')->updateOrInsert(
                ['slug' => Str::slug($language)],
                ['title' => $language, 'updated_at' => now(), 'created_at' => now()]
            );
        }
    }
}