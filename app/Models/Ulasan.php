<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $table='ulasans';
    protected $fillable= [
        'nama',
        'id_mobil',
        'rate',
        'ulasan'
    ];
}
