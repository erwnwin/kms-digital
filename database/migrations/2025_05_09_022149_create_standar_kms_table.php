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
        Schema::create('standar_kms', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->integer('umur_bulan');
            $table->decimal('berat_minimal', 5, 2);
            $table->decimal('berat_ideal', 5, 2);
            $table->decimal('berat_maksimal', 5, 2);
            $table->decimal('tinggi_minimal', 5, 2);
            $table->decimal('tinggi_ideal', 5, 2);
            $table->decimal('lingkar_kepala_minimal', 5, 2);
            $table->decimal('lingkar_kepala_ideal', 5, 2);
            $table->integer('kenaikan_minimal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standar_kms');
    }
};
