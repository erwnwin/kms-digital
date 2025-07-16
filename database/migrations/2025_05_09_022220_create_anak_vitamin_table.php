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
        Schema::create('anak_vitamin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')->constrained('anak')->onDelete('cascade');
            $table->enum('jenis', ['Vitamin A', 'Obat Cacing', 'Vitamin D', 'Zinc', 'Lainnya']);
            $table->date('tanggal');
            $table->string('dosis');
            $table->text('keterangan')->nullable();
            $table->foreignId('petugas_id')->constrained('users');
            $table->timestamps();

            // Index untuk pencarian lebih cepat
            $table->index(['anak_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anak_vitamin');
    }
};
