<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('translation_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Мультитенантность (кто создал)
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete(); // Клиент
            $table->foreignId('translator_id')->nullable()->constrained('translators')->nullOnDelete(); // Переводчик
            $table->foreignId('nomenclature_id')->constrained('nomenclatures')->cascadeOnDelete(); // Языковая пара / Услуга
            
            $table->date('order_date');
            $table->string('status')->default('new'); // Статус заказа (новый, в работе, выполнен, отменен)
            
            // Финансы
            $table->decimal('client_price', 12, 2)->default(0); // Стоимость для клиента (по выходу)
            $table->decimal('translator_price', 12, 2)->default(0); // Стоимость для переводчика
            
            // Статусы оплаты
            $table->boolean('is_client_paid')->default(false); // Оплачен ли заказ клиентом
            $table->boolean('is_translator_paid')->default(false); // Оплачена ли работа переводчику
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('translation_orders');
    }
};