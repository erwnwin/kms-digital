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
        Schema::create('jadwal_imunisasi', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['regular', 'special']); // Jenis jadwal (rutin/khusus)
            $table->string('title'); // Judul imunisasi
            $table->text('description')->nullable(); // Deskripsi
            $table->date('start_date')->nullable(); // Untuk jadwal khusus
            $table->date('end_date')->nullable(); // Untuk jadwal khusus
            $table->time('start_time'); // Waktu mulai
            $table->time('end_time'); // Waktu selesai
            $table->string('location'); // Lokasi
            $table->enum('day', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'])->nullable(); // Untuk jadwal rutin
            $table->enum('category', ['wajib', 'tambahan', 'nasional'])->default('wajib'); // Kategori imunisasi
            $table->boolean('is_active')->default(true); // Status aktif/tidak
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_imunisasi');
    }
};
