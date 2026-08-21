<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nomenclatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('nomenclatures')->onDelete('cascade');
            $table->string('name');
            $table->enum('type', ['folder', 'item'])->default('folder'); // папка или элемент (товар/услуга/материал)
            $table->string('category_type')->nullable(); // материалы, товары, услуги и т.д.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nomenclatures');
    }
};