<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nomenclature_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nomenclature_id')->constrained('nomenclatures')->onDelete('cascade');
            $table->decimal('purchase_price', 15, 2)->default(0); // цена покупки
            $table->decimal('selling_price', 15, 2)->default(0);  // цена продажи
            $table->date('effective_date'); // дата, с которой цена актуальна
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nomenclature_prices');
    }
};