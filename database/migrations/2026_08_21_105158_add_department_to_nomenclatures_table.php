<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nomenclatures', function (Blueprint $table) {
            $table->string('department')->default('poligraphy'); // poligraphy, translation, legal и т.д.
        });
    }

    public function down(): void
    {
        Schema::table('nomenclatures', function (Blueprint $table) {
            $table->dropColumn('department');
        });
    }
};