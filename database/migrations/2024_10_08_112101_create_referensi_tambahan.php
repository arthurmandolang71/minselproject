<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('calon_pendukung_referensi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('id_calon_pendukung')->nullable();
            $table->string('id_tim')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calon_pendukung_referensi');
    }
};
