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
        Schema::create('anak_imunisasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')->constrained('anak')->onDelete('cascade');
            $table->foreignId('jenis_imunisasi_id')->constrained('jenis_imunisasi')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('dosis');
            $table->text('keterangan')->nullable();
            $table->foreignId('petugas_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anak_imunisasi');
    }
};
