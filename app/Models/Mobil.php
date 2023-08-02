<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    protected $table ='mobils';
    protected $fillable = [
        'nama',
        'jenis',
        'harga',
        'status',
        'bahan_bakar',
        'jumlah_kursi',
        'gambar'
    ];
}
