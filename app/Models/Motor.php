<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    use HasFactory;
    protected $table = 'motor';
    // untuk melist kolom yang dapat diisi
    protected $fillable = [
        'kode_motor',
        'jenis_motor',
        'nama_motor',
    ];
}
