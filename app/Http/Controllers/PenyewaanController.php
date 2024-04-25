<?php

namespace App\Http\Controllers;

use App\Models\Penyewaan;
use App\Http\Requests\StorePenyewaanRequest;
use App\Http\Requests\UpdatePenyewaanRequest;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;

class PenyewaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // getViewBarang()
        $barang = Penyewaan::getViewBarang();
        $id_customer = Auth::id();
        return view('penyewaan/view',
                [
                    'barang' => $barang,
                    'jml' => Penyewaan::getJmlBarang($id_customer),
                    'jml_invoice' => Penyewaan::getJmlInvoice($id_customer),
                ]
        );
    }

    // dapatkan data barang berdasarkan id barang
    public function getDataBarang($id){
        $barang = Penyewaan::getViewBarangId($id);
        if($barang)
        {
            return response()->json([
                'status'=>200,
                'barang'=> $barang,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Tidak ada data ditemukan.'
            ]);
        }
    }

    // dapatkan data barang all
    public function getDataBarangAll(){
        $barang = Penyewaan::getViewBarang();
        if($barang)
        {
            return response()->json([
                'status'=>200,
                'barang'=> $barang,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Tidak ada data ditemukan.'
            ]);
        }
    }

    // dapatkan jumlah barang untuk keranjang
    public function getJumlahBarang(){
        $id_customer = Auth::id();
        $jml_barang = Penyewaan::getJmlBarang($id_customer);
        if($jml_barang)
        {
            return response()->json([
                'status'=>200,
                'jumlah'=> $jml_barang,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Tidak ada data ditemukan.'
            ]);
        }
    }

    // dapatkan jumlah barang untuk keranjang
    public function getInvoice(){
        $id_customer = Auth::id();
        $jml_barang = Penyewaan::getJmlInvoice($id_customer);
        if($jml_barang)
        {
            return response()->json([
                'status'=>200,
                'jmlinvoice'=> $jml_barang,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Tidak ada data ditemukan.'
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePenyewaanRequest $request)
    {
        //digunakan untuk validasi kemudian kalau ok tidak ada masalah baru disimpan ke db
        $validator = Validator::make(
            $request->all(),
            [
                'jumlah' => 'required',
            ]
        );
        
        if($validator->fails()){
            // gagal
            return response()->json(
                [
                    'status' => 400,
                    'errors' => $validator->messages(),
                ]
            );
        }else{
            // berhasil

            // cek apakah tipenya input atau update
            // input => tipeproses isinya adalah tambah
            // update => tipeproses isinya adalah ubah
            
            if($request->input('tipeproses')=='tambah'){

                $id_customer = Auth::id();
                $jml_barang = $request->input('jumlah');
                $id_barang = $request->input('idbaranghidden');

                $brg = Penyewaan::getViewBarangId($id_barang);
                foreach($brg as $b):
                    $harga_barang = $b->harga;
                endforeach;

                $total_harga = $harga_barang*$jml_barang;
                Penyewaan::inputPenyewaan($id_customer,$total_harga,$id_barang,$jml_barang,$harga_barang,$total_harga);

                return response()->json(
                    [
                        'status' => 200,
                        'message' => 'Sukses Input Data',
                    ]
                );
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Penyewaan $penyewaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penyewaan $penyewaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePenyewaanRequest $request, Penyewaan $penyewaan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penyewaan $penyewaan)
    {
        //
    }

    // view keranjang
    public function keranjang(){
        $id_customer = Auth::id();
        $keranjang = Penyewaan::viewKeranjang($id_customer);
        return view('penyewaan/viewkeranjang',
                [
                    'keranjang' => $keranjang
                ]
        );
    }

    // view keranjang
    public function keranjangjson(){
        $id_customer = Auth::id();
        $keranjang = Penyewaan::viewKeranjang($id_customer);
        if($keranjang)
        {
            return response()->json([
                'status'=>200,
                'keranjang'=> $keranjang,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Tidak ada data ditemukan.'
            ]);
        }
    }

    // view keranjang
    public function checkout(){
        $id_customer = Auth::id();
        Penyewaan::checkout($id_customer); //proses cekout
        $barang = Penyewaan::getViewBarang();

        return redirect('/pembayaran/viewstatus');
        // return view('penyewaan/view',
        //         [
        //             'barang' => $barang,
        //             'jml' => Penyewaan::getJmlBarang($id_customer),
        //             'status_siap_bayar' => 'siap bayar'
        //         ]
        // );
    }

    // invoice
    public function invoice(){
        $id_customer = Auth::id();
        $invoice = Penyewaan::getListInvoice($id_customer);
        if($invoice)
        {
            return response()->json([
                'status'=>200,
                'invoice'=> $invoice,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Tidak ada data ditemukan.'
            ]);
        }
    }

    // delete penyewaan detail
    public function destroypenyewaandetail($id_penyewaan_detail){
        // kembalikan stok ke semula
        Penyewaan::kembalikanstok($id_penyewaan_detail);

        //hapus dari database
        Penyewaan::hapuspenyewaandetail($id_penyewaan_detail);

        $id_customer = Auth::id();
        $keranjang = Penyewaan::viewKeranjang($id_customer);

        return view('penyewaan/viewkeranjang',
            [
                'keranjang' => $keranjang,
                'status_hapus' => 'Sukses Hapus'
            ]
        );
    }   
}
