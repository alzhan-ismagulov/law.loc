<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nomenclatures', function (Blueprint $table) {
            // Удаляем старое текстовое поле, если оно было
            if (Schema::hasColumn('nomenclatures', 'department')) {
                $table->dropColumn('department');
            }
            // Добавляем внешний ключ на таблицу departments
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('nomenclatures', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropColumn('department_id');
        });
    }
};