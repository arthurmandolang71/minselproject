<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
//

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('caleg_pendukung_prov', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('referensi_id')->nullable();
            $table->foreignUuid('celeg_id');
            $table->foreignUuid('klasifikasi_id')->nullable();
            $table->string('ktp')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('tanggal_lahir')->nullable();
            $table->string('strtime_tanggal_lahir')->nullable();
            $table->string('status_perkawinan')->nullable();
            $table->string('agama')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('alamat_detail')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('no_wa')->nullable();
            $table->string('foto')->nullable();
            $table->string('ref_kabkota')->nullable();
            $table->string('long')->nullable();
            $table->string('lat')->nullable();
            $table->string('jml_referensi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caleg_pendukung_prov');
    }
};
