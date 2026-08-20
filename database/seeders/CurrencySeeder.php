<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        $currencies = [
            ['code' => 'KZT', 'title' => 'Казахстанский тенге'],
            ['code' => 'USD', 'title' => 'Доллар США'],
            ['code' => 'EUR', 'title' => 'Евро'],
            ['code' => 'RUB', 'title' => 'Российский рубль'],
            ['code' => 'GBP', 'title' => 'Британский фунт'],
            ['code' => 'CNY', 'title' => 'Китайский юань'],
        ];

        foreach ($currencies as $currency) {
            Currency::firstOrCreate(['code' => $currency['code']], $currency);
        }
    }
}