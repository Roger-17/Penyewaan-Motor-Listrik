<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customer';
    // untuk melist kolom yang dapat diisi
    protected $fillable = [
        'kode_customer',
        'nama_customer',
        'alamat_customer',
        'no_telp_customer',
    ];
}
