<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            
            // foreignId гарантирует точное совпадение типов с таблицами roles и users/employees
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            
            // Если вы связываете с таблицей users или employees, укажите соответствующую таблицу:
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); 
            // Или если у вас роли ведут прямо на сотрудников:
            // $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_user');
    }
};