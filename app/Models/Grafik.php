<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// tambahan
use Illuminate\Support\Facades\DB;

class Grafik extends Model
{
    use HasFactory;

    // untuk mendapatkan view grafik per bulan berjalan
    public static function viewBulanBerjalan()
    {
        // query kode perusahaan
        $sql = "
                SELECT a.waktu,ifnull(b.total,0) as total FROM 
                v_waktu a 
                LEFT OUTER JOIN
                (
                SELECT DATE_FORMAT(tgl_transaksi,'%Y-%m') as waktu,
                SUM(total_harga) as total
                FROM penyewaan
                WHERE status = 'selesai'
                GROUP BY DATE_FORMAT(tgl_transaksi,'%Y-%m')
                ) b
                ON (a.waktu=b.waktu)";
        $hasil = DB::select($sql);

        return $hasil;

    }

    // untuk mendapatkan view grafik status penyewaan
    public static function viewStatusPenyewaan()
    {
        $sql = "SELECT status,count(*) as jml_penyewaan
                FROM penyewaan 
                GROUP BY status";
        $hasil = DB::select($sql);

        return $hasil;

    }

    // untuk mendapatkan view grafik jml barang terjual
    public static function viewJmlBarangTersewa()
    {
        $sql = "
            SELECT  ax.waktu,
                (SELECT ifnull(SUM(jml_barang),0) 
                FROM penyewaan a 
                    JOIN penyewaan_detail b
                    ON (a.no_transaksi=b.no_transaksi)
                    JOIN barang c
                    ON (b.id_barang=c.id)
                    WHERE a.status = 'selesai' 
                    AND c.id = 1
                    AND DATE_FORMAT(a.tgl_transaksi,'%Y-%m') = ax.waktu
                ) as jml_gesits,
                (SELECT ifnull(SUM(jml_barang),0) 
                FROM penyewaan a 
                    JOIN penyewaan_detail b
                    ON (a.no_transaksi=b.no_transaksi)
                    JOIN barang c
                    ON (b.id_barang=c.id)
                    WHERE a.status = 'selesai' 
                    AND c.id = 2
                    AND DATE_FORMAT(a.tgl_transaksi,'%Y-%m') = ax.waktu
                ) as jml_volta,
                (SELECT ifnull(SUM(jml_barang),0) 
                FROM penyewaan a 
                    JOIN penyewaan_detail b
                    ON (a.no_transaksi=b.no_transaksi)
                    JOIN barang c
                    ON (b.id_barang=c.id)
                    WHERE a.status = 'selesai' 
                    AND c.id = 3
                    AND DATE_FORMAT(a.tgl_transaksi,'%Y-%m') = ax.waktu
                ) as jml_selis,
                (SELECT ifnull(SUM(jml_barang),0) 
                FROM penyewaan a 
                    JOIN penyewaan_detail b
                    ON (a.no_transaksi=b.no_transaksi)
                    JOIN barang c
                    ON (b.id_barang=c.id)
                    WHERE a.status = 'selesai' 
                    AND c.id = 4
                    AND DATE_FORMAT(a.tgl_transaksi,'%Y-%m') = ax.waktu
                ) as jml_alva_one
            FROM 
            v_waktu ax 
                ";
        $hasil = DB::select($sql);

        return $hasil;

    }

    // untuk mendapatkan view grafik per bulan berjalan
    public static function viewPenyewaan()
    {
        // query kode perusahaan
        $sql = "
                    SELECT DATE_FORMAT(tgl_transaksi, '%Y-%m-%d') as tgl, SUM(total_harga) as total
                    FROM penyewaan
                    GROUP BY DATE_FORMAT(tgl_transaksi, '%Y-%m-%d')
                    ORDER BY 1
               ";
        $hasil = DB::select($sql);

        return $hasil;

    }
}