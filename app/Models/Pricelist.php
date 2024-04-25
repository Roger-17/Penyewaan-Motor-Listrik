<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricelist extends Model
{
    use HasFactory;
    protected $table = 'pricelist';
    // untuk melist kolom yang dapat diisi
    protected $fillable = [
        'kode_pricelist',
        'nama_pricelist',
        'harga',
    ];
}
