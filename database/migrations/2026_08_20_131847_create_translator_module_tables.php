<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Таблица переводчиков
        Schema::create('translators', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country')->default('Казахстан');
            $table->string('photo_path')->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->string('city');
            $table->string('address')->nullable();
            $table->string('diploma_path')->nullable();
            $table->string('card_number')->nullable();
            $table->string('card_type')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('iban')->nullable();
            $table->string('phone');
            $table->json('messengers')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('status')->default('active');
            $table->text('internal_notes')->nullable();
            $table->timestamps();
        });

        // 2. Таблица связей языковых пар
        Schema::create('translator_language_pairs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('translator_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('source_language_id');
            $table->unsignedBigInteger('target_language_id');
            $table->timestamps();
        });

        // 3. Таблица истории цен
        Schema::create('translator_price_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_pair_id')->constrained('translator_language_pairs')->onDelete('cascade');
            $table->string('currency', 10);
            $table->decimal('written_price_1800', 12, 2)->nullable();
            $table->decimal('consecutive_price_hour', 12, 2)->nullable();
            $table->decimal('simultaneous_price_hour', 12, 2)->nullable();
            $table->decimal('notarial_fee', 12, 2)->nullable();
            $table->decimal('editing_price_1800', 12, 2)->nullable();
            $table->date('effective_from');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('translator_price_history');
        Schema::dropIfExists('translator_language_pairs');
        Schema::dropIfExists('translators');
    }
};