<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnakTimbangan extends Model
{
    //
    protected $table = 'anak_timbangan';

    protected $fillable = [
        'anak_id',
        'tanggal',
        'umur_bulan',
        'berat',
        'tinggi',
        'lingkar_kepala',
        'status_gizi',
        'kategori_berat',
        'catatan',
        'petugas_id',
        'kbm'
    ];

    public function anak()
    {
        return $this->belongsTo(Anak::class);
    }

    // Relationship to User/Petugas if needed
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
