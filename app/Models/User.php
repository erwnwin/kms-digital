<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone'
    ];

    public function orangTua()
    {
        return $this->hasOne(OrangTua::class);
    }


    public function isKordinator()
    {
        return $this->role === 'kordinator';
    }

    public function isKader()
    {
        return $this->role === 'kader';
    }

    public function isOrangTua()
    {
        return $this->role === 'orang_tua';
    }
}
