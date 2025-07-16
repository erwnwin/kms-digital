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
        Schema::create('kontak_pesan', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama pengirim
            $table->string('email'); // Email pengirim
            $table->string('subject'); // Subjek pesan
            $table->text('message'); // Isi pesan
            $table->boolean('is_read')->default(false); // Status dibaca
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontak_pesan');
    }
};
