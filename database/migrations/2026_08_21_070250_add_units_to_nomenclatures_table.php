<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nomenclatures', function (Blueprint $table) {
            $table->string('base_unit')->default('шт'); // Базовая единица (лист, шт, мл)
            $table->string('purchase_unit')->nullable(); // Единица закупки (пачка, коробка)
            $table->decimal('conversion_factor', 10, 4)->default(1); // Коэффициент (например, 500 листов в пачке)
        });
    }

    public function down(): void
    {
        Schema::table('nomenclatures', function (Blueprint $table) {
            $table->dropColumn(['base_unit', 'purchase_unit', 'conversion_factor']);
        });
    }
};