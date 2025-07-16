<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisImunisasi extends Model
{
    //
    protected $table = 'jenis_imunisasi';

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'usia_minimal_bulan',
        'usia_maksimal_bulan',
        'dosis_ke',
        'interval_dosis_bulan',
        'wajib',
        'warna'
    ];

    public function anak()
    {
        return $this->belongsToMany(Anak::class, 'anak_imunisasi')
            ->withPivot('jenis_imunisasi_id', 'tanggal', 'dosis', 'keterangan', 'bulan');
    }


    public function imunisasi()
    {
        return $this->belongsToMany(JenisImunisasi::class, 'anak_imunisasi')
            ->withPivot(
                'id',
                'bulan',
                'tanggal',
                'dosis',
                'keterangan',
                'petugas_id'
            );
    }
}
