<?php

namespace App\Models;

use App\Models\Anak;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    //
    protected $table = 'orang_tua';

    protected $fillable = [
        'user_id',
        'alamat',
        'rt',
        'rw',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'provinsi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function anak()
    {
        return $this->hasMany(Anak::class);
    }

    // public function scopeOrderByHas($query, $relation, $column)
    // {
    //     return $query->join(
    //         (new $relation())->getTable(),
    //         $this->getTable() . '.user_id',
    //         '=',
    //         (new $relation())->getTable() . '.id'
    //     )->orderBy((new $relation())->getTable() . '.' . $column);
    // }
}
