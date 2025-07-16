<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnakImunisasi extends Model
{
    //
    protected $table = 'anak_imunisasi';

    protected $fillable =
    [
        'id',
        'anak_id',
        'jenis_imunisasi_id',
        'bulan',
        'tanggal',
        'dosis',
        'keterangan',
        'petugas_id'
    ];
}
