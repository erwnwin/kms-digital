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
        Schema::table('jenis_imunisasi', function (Blueprint $table) {
            //
            $table->string('warna_background')->default('#E9ECEF');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jenis_imunisasi', function (Blueprint $table) {
            //
            $table->dropColumn('warna_background');
        });
    }
};
