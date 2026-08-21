<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('poligraphy_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nomenclature_id')->constrained('nomenclatures')->onDelete('cascade');
            $table->decimal('quantity', 15, 4); // Количество в единицах закупки (например, пачках)
            $table->decimal('purchase_price', 15, 2); // Цена за единицу закупки
            $table->decimal('total_amount', 15, 2); // Общая сумма
            $table->date('purchase_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poligraphy_purchases');
    }
};