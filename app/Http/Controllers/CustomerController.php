<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $customer = Customer::all();
        // var_dump($customer);
        // dd;
    	// mengirim data pegawai ke view pegawai
        
    	return view('customer/view', 
                        [
                            'customer' => $customer,
                        ]
                    );
    }

    public function fetchcustomer()
    {
        $customer = customer::all();
        return response()->json([
            'customer'=>$customer,
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
    public function store(StoreCustomerRequest $request)
    {
        //
        //digunakan untuk validasi kemudian kalau ok tidak ada masalah baru disimpan ke db
        $validator = Validator::make(
            $request->all(),
            [
                'kode_customer' => 'required|min:3',
                'nama_customer' => 'required',
                'alamat_customer' => 'required',
                'no_telp_customer' => 'required',
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
                Customer::create($request->all());
                return response()->json(
                    [
                        'status' => 200,
                        'message' => 'Sukses Input Data',
                    ]
                );
            }else{
                // update ke db
                $customer = Customer::find($request->input('idcustomerhidden'));
            
                // proses update dari inputan form data
                $customer->kode_customer = $request->input('kode_customer');
                $customer->nama_customer = $request->input('nama_customer');
                $customer->alamat_customer = $request->input('alamat_customer');
                $customer->no_telp_customer = $request->input('no_telp_customer');
                $customer->update(); //proses update ke db

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
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        if($customer)
        {
            return response()->json([
                'status'=>200,
                'customer'=> $customer,
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
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //hapus dari database
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return view('customer/view',
            [
                'customer' => $customer,
                'status_hapus' => 'Sukses Hapus'
            ]
        );
    }
}
