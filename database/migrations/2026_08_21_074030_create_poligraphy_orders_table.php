<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('poligraphy_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nomenclature_id')->constrained('nomenclatures')->onDelete('cascade'); // Услуга
            $table->decimal('quantity', 15, 2); // Количество (например, страниц)
            $table->decimal('total_price', 15, 2); // Итоговая стоимость
            $table->decimal('material_cost', 15, 2)->default(0); // Себестоимость материалов
            $table->date('order_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poligraphy_orders');
    }
};