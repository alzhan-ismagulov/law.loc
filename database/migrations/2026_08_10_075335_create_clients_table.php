<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20)->default('individual'); // Физическое лицо (individual) или Юридическое лицо (company)
            
            // Основные данные (для физлица или представителя)
            $table->string('name', 255); // Полное ФИО или Название ТОО
            $table->string('iin_bin', 12)->unique(); // ИИН (12 цифр) или БИН для ТОО
            $table->string('phone', 20)->nullable();
            $table->string('email', 255)->nullable();
            
            // Паспортные данные (если физлицо)
            $table->date('birth_date')->nullable();
            $table->string('address', 500)->nullable(); // Адрес по прописке
            $table->string('id_card_number', 20)->nullable(); // № Удостоверения / Паспорта
            $table->date('id_card_date')->nullable(); // Дата выдачи
            $table->string('id_card_issuer', 255)->nullable(); // Кем выдано
            
            // Системные связи
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete(); // Чей клиент (какой юрфирмы)
            $table->foreignId('region_id')->nullable()->constrained('regions'); // Регион
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};