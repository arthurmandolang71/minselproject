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
        Schema::table('caleg_pendukung_prov', function (Blueprint $table) {
            $table->string('kk')->nullable();
            $table->string('status_keluarga')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('caleg_pendukung_prov', function (Blueprint $table) {
            $table->dropColumn(['kk', 'status_keluarga']);
        });
    }
};
