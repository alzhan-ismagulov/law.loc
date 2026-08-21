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
            $table->string('type')->default('individual'); // individual / company
            $table->string('name'); // Имя физлица или Название компании
            $table->string('bin_iin')->nullable(); // БИН для компаний или ИИН для физлиц
            $table->string('country')->default('Казахстан');
            $table->unsignedBigInteger('region_id')->nullable();
            $table->string('city');
            $table->string('address')->nullable();
            
            // Только для юрлиц
            $table->string('contact_person')->nullable(); // Ответственное лицо
            $table->string('position')->nullable(); // Должность
            
            // Контакты и авторизация для личного кабинета
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('password'); // Пароль для входа в личный кабинет
            
            // CRM-параметры
            $table->string('source')->nullable(); // Источник привлечения
            $table->string('status')->default('active'); // active, lead, archive
            $table->decimal('discount_percent', 5, 2)->default(0); // Персональная скидка %
            
            // Реквизиты
            $table->string('bank_name')->nullable();
            $table->string('iban')->nullable();
            
            $table->text('internal_notes')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};