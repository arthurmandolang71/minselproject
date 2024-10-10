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
        Schema::create('tps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('wilayah_id');
            $table->integer('nama');
            $table->integer('jumlah')->nullable();
            $table->integer('jumlah_PB')->nullable();
            $table->integer('jumlah_BB')->nullable();
            $table->integer('jumlah_X')->nullable();
            $table->integer('jumlah_Y')->nullable();
            $table->integer('jumlah_Z')->nullable();
            $table->integer('total_pemilih_kelurahan')->nullable();
            $table->string('kabkota')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan_desa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tps');
    }
};
