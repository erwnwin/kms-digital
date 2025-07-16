<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnakVitamin extends Model
{
    //
    use HasFactory;

    protected $table = 'anak_vitamin';


    protected $fillable = [
        'anak_id',
        'jenis',
        'tanggal',
        'dosis',
        'keterangan',
        'petugas_id'
    ];

    protected $casts = [
        'tanggal' => 'date'
    ];

    // Relasi ke tabel anak
    public function anak()
    {
        return $this->belongsTo(Anak::class);
    }

    // Relasi ke petugas yang memberikan
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    // Scope untuk filter jenis vitamin
    public function scopeVitaminA($query)
    {
        return $query->where('jenis', 'Vitamin A');
    }

    public function scopeObatCacing($query)
    {
        return $query->where('jenis', 'Obat Cacing');
    }

    // Format tanggal lebih mudah dibaca
    public function getTanggalFormattedAttribute()
    {
        return $this->tanggal->format('d/m/Y');
    }


    public function vitamin()
    {
        return $this->hasMany(AnakVitamin::class)->orderBy('tanggal', 'desc');
    }

    // Untuk mendapatkan hanya vitamin A
    public function vitaminA()
    {
        return $this->hasMany(AnakVitamin::class)->where('jenis', 'Vitamin A');
    }

    // Untuk mendapatkan hanya obat cacing
    public function obatCacing()
    {
        return $this->hasMany(AnakVitamin::class)->where('jenis', 'Obat Cacing');
    }
}
