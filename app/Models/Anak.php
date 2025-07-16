<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anak extends Model
{
    //
    protected $table = 'anak';

    protected $fillable = [
        'orang_tua_id',
        'nama_lengkap',
        'jenis_kelamin',
        'tanggal_lahir',
        'berat_lahir',
        'panjang_lahir',
        'anak_ke',
        'golongan_darah'
    ];

    protected $dates = ['tanggal_lahir'];


    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function orangTua()
    {
        return $this->belongsTo(OrangTua::class);
    }

    public function timbangan()
    {
        return $this->hasMany(AnakTimbangan::class)->orderBy('tanggal');
    }

    public function imunisasi()
    {
        return $this->belongsToMany(JenisImunisasi::class, 'anak_imunisasi')
            ->withPivot('id', 'bulan', 'tanggal', 'dosis', 'keterangan', 'petugas_id', 'created_at')
            ->orderByPivot('tanggal');
    }

    public function vitamin()
    {
        return $this->hasMany(AnakVitamin::class);
    }

    public function hasVitaminA($warna, $minAge, $maxAge, $month = null)
    {
        // Validasi range umur
        if ($this->umur_bulan < $minAge || $this->umur_bulan > $maxAge) {
            return false;
        }

        $query = $this->vitamin()
            ->where('jenis', 'Vitamin A')
            ->where('warna', $warna);

        // Filter bulan - PERBAIKAN DI SINI
        if ($warna == 'merah' && $month) {
            $targetMonth = $month == 'feb' ? 2 : 8;
            $query->whereMonth('tanggal', $targetMonth); // Gunakan whereMonth()
        } elseif ($warna == 'biru') {
            $query->where(function ($q) {
                $q->whereMonth('tanggal', 2) // Februari
                    ->orWhereMonth('tanggal', 8); // Agustus
            });
        }

        // Cek 2 tahun terakhir
        $query->where('tanggal', '>=', now()->subYears(2));

        return $query->exists();
    }

    public function hasObatCacing($minAge, $maxAge)
    {
        if ($this->umur_bulan < $minAge || $this->umur_bulan > $maxAge) {
            return false;
        }

        return $this->vitamin()
            ->where('jenis', 'Obat Cacing')
            ->whereMonth('tanggal', 8) // Agustus
            ->where('tanggal', '>=', now()->subYears(2))
            ->exists();
    }

    // public function getUmurBulanAttribute()
    // {
    //     return $this->tanggal_lahir->diffInMonths(now());
    // }

    public function getUmurBulanAttribute()
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->diffInMonths(now()) : 0;
    }
}
