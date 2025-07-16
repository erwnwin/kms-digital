<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactInfo extends Model
{
    //
    use HasFactory;

    protected $table = 'contact_info';

    protected $fillable = ['address', 'phone', 'email', 'opening_hours'];
}
