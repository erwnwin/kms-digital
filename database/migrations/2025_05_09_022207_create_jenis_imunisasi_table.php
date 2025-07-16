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
        Schema::create('jenis_imunisasi', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->string('deskripsi');
            $table->integer('usia_minimal_bulan');
            $table->integer('usia_maksimal_bulan')->nullable();
            $table->integer('dosis_ke');
            $table->integer('interval_dosis_bulan')->nullable();
            $table->boolean('wajib')->default(true);
            $table->string('warna')->default('#4CAF50');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_imunisasi');
    }
};
