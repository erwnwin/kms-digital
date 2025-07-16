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
        Schema::table('standar_kms', function (Blueprint $table) {
            //
            $table->string('kategori')->default('0-24')->after('lingkar_kepala_ideal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('standar_kms', function (Blueprint $table) {
            //
            $table->dropColumn('kategori');
        });
    }
};
