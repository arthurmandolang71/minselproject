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
        //
        Schema::table('caleg_pendukung_prov', function (Blueprint $table) {
            $table->string('input_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('caleg_pendukung_prov', function (Blueprint $table) {
            $table->dropColumn(['input_id']);
        });
    }
};
