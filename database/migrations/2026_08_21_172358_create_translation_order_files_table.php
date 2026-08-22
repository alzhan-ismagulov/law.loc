<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('translation_order_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('translation_order_id')->constrained('translation_orders')->cascadeOnDelete();
            
            $table->string('original_file_path'); // Путь к файлу оригиналу
            $table->string('translated_file_path')->nullable(); // Путь к файлу перевода
            
            $table->unsignedInteger('original_chars_count')->default(0); // Кол-во знаков в оригинале
            $table->unsignedInteger('translated_chars_count')->default(0); // Кол-во знаков в переводе
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('translation_order_files');
    }
};