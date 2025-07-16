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
        Schema::create('anak_timbangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')->constrained('anak')->onDelete('cascade');
            $table->date('tanggal');
            $table->integer('umur_bulan');
            $table->decimal('berat', 5, 2);
            $table->decimal('tinggi', 5, 2);
            $table->decimal('lingkar_kepala', 5, 2);
            $table->enum('status_gizi', ['Sangat Kurang', 'Kurang', 'Normal', 'Lebih', 'Obesitas']);
            $table->enum('kategori_berat', ['N', 'T']);
            $table->text('catatan')->nullable();
            $table->foreignId('petugas_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anak_timbangan');
    }
};
