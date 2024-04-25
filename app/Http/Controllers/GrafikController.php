<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// tambahan
use App\Models\Grafik;

class GrafikController extends Controller
{
    // view bulan berjalan
    public function viewPenyewaanBlnBerjalan(){
        $grafik = Grafik::viewBulanBerjalan();
        return view('grafik/bulanberjalan',
                        [
                            'grafik' => $grafik
                        ]
                    );
    }

    // view status penyewaan
    public function viewStatusPenyewaan(){
        $grafik = Grafik::viewStatusPenyewaan();
        return view('grafik/statuspenyewaan',
                        [
                            'grafik' => $grafik
                        ]
                    );
    }

    // view jml barang tersewa
    public function viewJmlBarangTersewa(){
        $grafik = Grafik::viewJmlBarangTersewa();
        return view('grafik/jmlbarangtersewa',
                        [
                            'grafik' => $grafik
                        ]
                    );
    }
}
