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
        Schema::create('partai', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('no_urut')->nullable();
            $table->string('nama')->nullable();
            $table->string('nama_singkat')->nullable();
            $table->string('logo')->nullable();
            $table->string('logo_text')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partai');
    }
};
