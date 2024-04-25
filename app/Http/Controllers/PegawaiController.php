<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Http\Requests\StorePegawaiRequest;
use App\Http\Requests\UpdatePegawaiRequest;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Validator;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $pegawai = Pegawai::all();
        // var_dump($pegawai);
        // dd;
    	// mengirim data pegawai ke view pegawai
        
    	return view('pegawai/view', 
                        [
                            'pegawai' => $pegawai,
                        ]
                    );
    }

    public function fetchpegawai()
    {
        $pegawai = Pegawai::all();
        return response()->json([
            'pegawai'=>$pegawai,
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
    public function store(StorePegawaiRequest $request)
    {
        //
        //digunakan untuk validasi kemudian kalau ok tidak ada masalah baru disimpan ke db
        $validator = Validator::make(
            $request->all(),
            [
                'kode_pegawai' => 'required|min:3',
                'nama_pegawai' => 'required',
                'alamat_pegawai' => 'required',
                'no_telp_pegawai' => 'required',
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
                Pegawai::create($request->all());
                return response()->json(
                    [
                        'status' => 200,
                        'message' => 'Sukses Input Data',
                    ]
                );
            }else{
                // update ke db
                $pegawai = Pegawai::find($request->input('idpegawaihidden'));
            
                // proses update dari inputan form data
                $pegawai->kode_pegawai = $request->input('kode_pegawai');
                $pegawai->nama_pegawai = $request->input('nama_pegawai');
                $pegawai->alamat_pegawai = $request->input('alamat_pegawai');
                $pegawai->no_telp_pegawai = $request->input('no_telp_pegawai');
                $pegawai->update(); //proses update ke db

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
    public function show(Pegawai $pegawai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pegawai = Pegawai::find($id);
        if($pegawai)
        {
            return response()->json([
                'status'=>200,
                'pegawai'=> $pegawai,
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
    public function update(UpdatePegawaiRequest $request, Pegawai $pegawai)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //hapus dari database
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();
        return view('pegawai/view',
            [
                'pegawai' => $pegawai,
                'status_hapus' => 'Sukses Hapus'
            ]
        );
    }
}
