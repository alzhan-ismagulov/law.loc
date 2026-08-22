<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('translator_nomenclature_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('translator_id')->constrained('translators')->cascadeOnDelete();
            $table->foreignId('nomenclature_id')->constrained('nomenclatures')->cascadeOnDelete();
            $table->decimal('rate_price', 12, 2)->default(0); // Ставка переводчика за 1800 знаков для этой пары
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('translator_nomenclature_rates');
    }
};