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
        //
        Schema::table('standar_kms', function (Blueprint $table) {
            $table->decimal('berat_minimal_2sd', 5, 2)->after('berat_minimal')->nullable();
            $table->decimal('berat_minimal_1sd', 5, 2)->after('berat_minimal_2sd')->nullable();
            $table->decimal('berat_maksimal_1sd', 5, 2)->after('berat_ideal')->nullable();
            $table->decimal('berat_maksimal_2sd', 5, 2)->after('berat_maksimal_1sd')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('standar_kms', function (Blueprint $table) {
            $table->dropColumn([
                'berat_minimal_2sd',
                'berat_minimal_1sd',
                'berat_maksimal_1sd',
                'berat_maksimal_2sd',
            ]);
        });
    }
};
