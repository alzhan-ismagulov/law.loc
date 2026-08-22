<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('translation_orders', function (Blueprint $table) {
            $table->string('service_type')->default('written')->after('nomenclature_id'); // written, oral, sync, notarary, editing
        });
    }

    public function down(): void
    {
        Schema::table('translation_orders', function (Blueprint $table) {
            $table->dropColumn('service_type');
        });
    }
};