<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Вызываем сидеры справочников и ролей
        $this->call([
            RegionSeeder::class,
            LanguageSeeder::class,
            RoleSeeder::class,
            CurrencySeeder::class,
            CountrySeeder::class,
        ]);

        // Находим роли
        $adminRole = Role::where('slug', 'admin')->first();
        $userRole = Role::where('slug', 'user')->first(); // 
        // 2. Создаем Владельца системы (Суперадмин)
        $owner = User::updateOrCreate(
            ['email' => 'admin@legalcore.kz'],
            [
                'name' => 'Альжан Исмагулов',
                'password' => Hash::make('951632aA*'),
            ]
        );
        if ($adminRole) {
            $owner->roles()->sync([$adminRole->id]);
        }

        // 3. Создаем обычного пользователя
        $regularUser = User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Пользователь',
                'password' => Hash::make('password'),
            ]
        );
        if ($userRole) {
            $regularUser->roles()->sync([$userRole->id]);
        }

        $this->call([
            DepartmentsSeeder::class,
        ]);
    }
    
}