<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('anak_vitamin', function (Blueprint $table) {
            $table->string('warna', 10)->nullable()->after('jenis');
        });
    }

    public function down()
    {
        Schema::table('anak_vitamin', function (Blueprint $table) {
            $table->dropColumn('warna');
        });
    }
};
