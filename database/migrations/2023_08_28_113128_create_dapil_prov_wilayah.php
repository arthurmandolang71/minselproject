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
        Schema::create('dapil_prov_wilayah', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->foreignUuid('dapil_prov_id');
            $table->string('prov');
            $table->string('kabkota');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dapil_prov_wilayah');
    }
};
