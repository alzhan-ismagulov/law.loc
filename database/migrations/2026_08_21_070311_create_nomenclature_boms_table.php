<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nomenclature_boms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_item_id')->constrained('nomenclatures')->onDelete('cascade'); // Услуга (Распечатка)
            $table->foreignId('material_item_id')->constrained('nomenclatures')->onDelete('cascade'); // Материал (Бумага А4)
            $table->decimal('quantity', 15, 4)->default(1); // Сколько базовых единиц (листов) уходит на 1 услугу
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nomenclature_boms');
    }
};