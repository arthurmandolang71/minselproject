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
        Schema::create('dpt', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->string('jenis_kelamin');
            $table->integer('usia');
            $table->string('kabkota');
            $table->string('kecamatan');
            $table->string('kelurahan_desa');
            $table->string('alamat');
            $table->string('rt');
            $table->string('rw');
            $table->string('tps');
            $table->foreignUuid('wilayah_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dpt');
    }
};
