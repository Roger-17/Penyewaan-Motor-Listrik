<?php

namespace App\Http\Controllers;

use App\Models\Pricelist;
use App\Http\Requests\StorePricelistRequest;
use App\Http\Requests\UpdatePricelistRequest;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Validator;

class PricelistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         //
         $pricelist = Pricelist::all();
         // var_dump($pricelist);
         // dd;
         // mengirim data pricelist ke view pricelist
         
         return view('pricelist/view', 
                         [
                             'pricelist' => $pricelist,
                         ]
                     );
    }

    public function fetchpricelist()
    {
        $pricelist = Pricelist::all();
        return response()->json([
            'pricelist'=>$pricelist,
        ]);
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
    public function store(StorePricelistRequest $request)
    {
        //
        //digunakan untuk validasi kemudian kalau ok tidak ada masalah baru disimpan ke db
        $validator = Validator::make(
            $request->all(),
            [
                'kode_pricelist' => 'required|min:6',
                'nama_pricelist' => 'required',
                'harga' => 'required',
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
                // simpan ke db
                Pricelist::create($request->all());
                return response()->json(
                    [
                        'status' => 200,
                        'message' => 'Sukses Input Data',
                    ]
                );
            }else{
                // update ke db
                $pricelist = pricelist::find($request->input('idpricelisthidden'));
            
                // proses update dari inputan form data
                $pricelist->kode_pricelist = $request->input('kode_pricelist');
                $pricelist->nama_pricelist = $request->input('nama_pricelist');
                $pricelist->harga = $request->input('harga');
                $pricelist->update(); //proses update ke db

                return response()->json(
                    [
                        'status' => 200,
                        'message' => 'Sukses Update Data',
                    ]
                );
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pricelist $pricelist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pricelist = Pricelist::find($id);
        if($pricelist)
        {
            return response()->json([
                'status'=>200,
                'pricelist'=> $pricelist,
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
     * Update the specified resource in storage.
     */
    public function update(UpdatePricelistRequest $request, Pricelist $pricelist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //hapus dari database
        $pricelist = Pricelist::findOrFail($id);
        $pricelist->delete();
        return view('pricelist/view',
            [
                'pricelist' => $pricelist,
                'status_hapus' => 'Sukses Hapus'
            ]
        );
    }
}
