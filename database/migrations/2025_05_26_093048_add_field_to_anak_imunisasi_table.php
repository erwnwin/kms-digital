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
        Schema::table('anak_imunisasi', function (Blueprint $table) {
            //
            $table->integer(('bulan'))->after('jenis_imunisasi_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anak_imunisasi', function (Blueprint $table) {
            //
            $table->dropColumn('bulan');
        });
    }
};
