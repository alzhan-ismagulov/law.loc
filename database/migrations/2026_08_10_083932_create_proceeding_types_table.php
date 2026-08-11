<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proceeding_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255); // Гражданское (общее), Уголовное и т.д.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proceeding_types');
    }
};