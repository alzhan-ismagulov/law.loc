<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            
            // 01 Сведения
            $table->string('name'); // Название организации
            $table->string('legal_form'); // ТОО, ИП, Индивидуальная практика
            $table->string('bin_iin', 12)->unique(); // БИН или ИИН (12 цифр)
            $table->string('specialization'); // Адвокатская деятельность, Юридический консалтинг
            $table->string('license_number')->nullable(); // Рег. номер лицензии
            
            // 02 География
            $table->string('registration_region'); // Область регистрации
            $table->string('location_region'); // Регион нахождения
            $table->string('city'); // Город
            $table->string('actual_address'); // Фактический адрес офиса
            
            // 03 Директор / Администратор
            $table->string('director_name'); // ФИО руководителя
            $table->string('email')->unique(); // Email (Логин)
            $table->string('phone'); // Контактный телефон
            $table->string('password'); // Пароль администратора ТОО
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};