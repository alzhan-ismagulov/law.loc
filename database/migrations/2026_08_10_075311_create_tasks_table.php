<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('legal_case_id')->nullable()->constrained('legal_cases')->cascadeOnDelete(); // Задача может относиться к делу
            
            $table->foreignId('creator_id')->constrained('employees'); // Кто поставил (руководитель / тенант)
            $table->foreignId('executor_id')->constrained('employees'); // Кому поставлена (сотрудник)
            
            $table->string('title', 255); // Название задачи
            $table->text('description')->nullable(); // Подробное описание
            $table->date('due_date')->nullable(); // Срок выполнения
            
            $table->string('status')->default('pending'); // pending (в ожидании), in_progress (в работе), completed (выполнено)
            $table->json('documents')->nullable(); // Прикрепленные файлы к задаче
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};