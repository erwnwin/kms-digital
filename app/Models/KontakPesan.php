<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KontakPesan extends Model
{
    //
    use HasFactory;

    protected $table = 'kontak_pesan';
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'email', 'subject', 'message', 'is_read'];

    protected $casts = [
        'is_read' => 'boolean'
    ];
}
