<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalImunisasi extends Model
{
    //
    use HasFactory;

    protected $table = 'jadwal_imunisasi';

    protected $fillable = [
        'type',
        'title',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'day',
        'category',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean'
    ];



    public function scopeRegular($query)
    {
        return $query->where('type', 'regular');
    }

    public function scopeSpecial($query)
    {
        return $query->where('type', 'special');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
