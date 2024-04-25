<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $table = 'pegawai';
    // untuk melist kolom yang dapat diisi
    protected $fillable = [
        'kode_pegawai',
        'nama_pegawai',
        'alamat_pegawai',
        'no_telp_pegawai',
    ];
}
