<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['title' => 'Администратор', 'slug' => 'admin'],
            ['title' => 'Юрист', 'slug' => 'lawyer'],
            ['title' => 'Переводчик', 'slug' => 'translator'],
            ['title' => 'Клиент', 'slug' => 'client'],
            ['title' => 'Пользователь', 'slug' => 'user'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['slug' => $role['slug']],
                ['title' => $role['title']]
            );
        }
    }
}