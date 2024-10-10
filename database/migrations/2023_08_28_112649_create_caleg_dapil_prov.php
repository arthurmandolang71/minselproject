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
        Schema::create('caleg_dapil_prov', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->nullable();
            $table->foreignUuid('partai_id')->nullable();
            $table->string('nama')->nullable();
            $table->string('no_urut');
            $table->string('keterangan')->nullable();
            $table->foreignUuid('dapil_prov')->nullable();
            $table->string('subdomain')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caleg_dapil_prov');
    }
};
