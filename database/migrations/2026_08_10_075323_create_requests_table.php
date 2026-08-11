<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('legal_case_id')->constrained('legal_cases')->cascadeOnDelete(); // Запрос привязан к конкретному делу
            $table->foreignId('employee_id')->constrained('employees'); // Какой юрист создал запрос
            
            $table->string('recipient', 255); // Куда направлен запрос (например: Суд №2 г. Астана, ДП г. Алматы, Налоговый департамент)
            $table->string('outgoing_number', 100)->nullable(); // Исходящий номер документа
            $table->date('outgoing_date'); // Дата отправки запроса
            
            $table->date('deadline_date')->nullable(); // Срок ожидания ответа (контрольная дата)
            $table->string('status')->default('sent'); // sent (отправлен), answered (получен ответ), overdue (просрочен)
            
            $table->text('description')->nullable(); // Суть запроса или примечание
            $table->json('documents')->nullable(); // Прикрепленные файлы (сам запрос, почтовая квитанция, ответ органа)
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};