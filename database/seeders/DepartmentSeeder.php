<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        Department::firstOrCreate(['slug' => 'poligraphy'], ['name' => 'Полиграфическое подразделение']);
        Department::firstOrCreate(['slug' => 'translation'], ['name' => 'Переводческое подразделение']);
        Department::firstOrCreate(['slug' => 'legal'], ['name' => 'Юридическое подразделение']);
    }
}