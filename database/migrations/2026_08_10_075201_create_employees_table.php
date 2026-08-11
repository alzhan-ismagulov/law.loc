<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('iin', 12)->unique(); // ИИН (12 символов для РК)
            $table->string('phone', 20)->unique();
            $table->foreignId('role_id')->constrained('roles');
            $table->foreignId('region_id')->constrained('regions');
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->integer('status')->default(1);
            $table->integer('salary')->nullable();
            $table->date('hired_at')->nullable();
            $table->date('fired_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};