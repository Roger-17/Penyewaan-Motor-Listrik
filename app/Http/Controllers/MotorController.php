<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Http\Requests\StoreMotorRequest;
use App\Http\Requests\UpdateMotorRequest;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Validator;

class MotorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         //
         $motor = Motor::all();
         // var_dump($motor);
         // dd;
         // mengirim data pegawai ke view pegawai
         
         return view('motor/view', 
                         [
                             'motor' => $motor,
                         ]
                     );
    }

    public function fetchmotor()
    {
        $motor = Motor::all();
        return response()->json([
            'motor'=>$motor,
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
    public function store(StoreMotorRequest $request)
    {
        //
        //digunakan untuk validasi kemudian kalau ok tidak ada masalah baru disimpan ke db
        $validator = Validator::make(
            $request->all(),
            [
                'kode_motor' => 'required|min:3',
                'jenis_motor' => 'required',
                'nama_motor' => 'required',
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
                Motor::create($request->all());
                return response()->json(
                    [
                        'status' => 200,
                        'message' => 'Sukses Input Data',
                    ]
                );
            }else{
                // update ke db
                $motor = Motor::find($request->input('idmotorhidden'));
            
                // proses update dari inputan form data
                $motor->kode_motor = $request->input('kode_motor');
                $motor->jenis_motor = $request->input('jenis_motor');
                $motor->nama_motor = $request->input('nama_motor');
                $motor->update(); //proses update ke db

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
    public function show(Motor $motor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $motor = Motor::find($id);
        if($motor)
        {
            return response()->json([
                'status'=>200,
                'motor'=> $motor,
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
    public function update(UpdateMotorRequest $request, Motor $motor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //hapus dari database
        $motor = Motor::findOrFail($id);
        $motor->delete();
        return view('motor/view',
            [
                'motor' => $motor,
                'status_hapus' => 'Sukses Hapus'
            ]
        );
    }
}
