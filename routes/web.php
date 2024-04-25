<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboardbootstrap', function () {
    return view('dashboardbootstrap');
})->middleware(['auth'])->name('dashboardbootstrap');

// untuk master data perusahaan
Route::resource('perusahaan', App\Http\Controllers\PerusahaanController::class)->middleware(['auth']);
Route::get('/perusahaan/destroy/{id}', [App\Http\Controllers\PerusahaanController::class,'destroy'])->middleware(['auth']);
require __DIR__.'/auth.php';

Route::get('/customer/fetchcustomer', [App\Http\Controllers\CustomerController::class,'fetchcustomer'])->middleware(['auth']);
Route::get('/customer/edit/{id}', [App\Http\Controllers\CustomerController::class,'edit'])->middleware(['auth']);
Route::get('/customer/destroy/{id}', [App\Http\Controllers\CustomerController::class,'destroy'])->middleware(['auth']);
Route::resource('customer', App\Http\Controllers\CustomerController::class)->middleware(['auth']);

Route::get('/motor/fetchmotor', [App\Http\Controllers\MotorController::class,'fetchmotor'])->middleware(['auth']);
Route::get('/motor/edit/{id}', [App\Http\Controllers\MotorController::class,'edit'])->middleware(['auth']);
Route::get('/motor/destroy/{id}', [App\Http\Controllers\MotorController::class,'destroy'])->middleware(['auth']);
Route::resource('motor', App\Http\Controllers\MotorController::class)->middleware(['auth']);

Route::get('/pegawai/fetchpegawai', [App\Http\Controllers\PegawaiController::class,'fetchpegawai'])->middleware(['auth']);
Route::get('/pegawai/edit/{id}', [App\Http\Controllers\PegawaiController::class,'edit'])->middleware(['auth']);
Route::get('/pegawai/destroy/{id}', [App\Http\Controllers\PegawaiController::class,'destroy'])->middleware(['auth']);
Route::resource('pegawai', App\Http\Controllers\PegawaiController::class)->middleware(['auth']);

Route::get('/pricelist/fetchpricelist', [App\Http\Controllers\PricelistController::class,'fetchpricelist'])->middleware(['auth']);
Route::get('/pricelist/edit/{id}', [App\Http\Controllers\PricelistController::class,'edit'])->middleware(['auth']);
Route::get('/pricelist/destroy/{id}', [App\Http\Controllers\PricelistController::class,'destroy'])->middleware(['auth']);
Route::resource('pricelist', App\Http\Controllers\PricelistController::class)->middleware(['auth']);

Route::get('/coa/fetchcoa', [App\Http\Controllers\CoaController::class,'fetchcoa'])->middleware(['auth']);
Route::get('/coa/edit/{id}', [App\Http\Controllers\CoaController::class,'edit'])->middleware(['auth']);
Route::get('/coa/destroy/{id}', [App\Http\Controllers\CoaController::class,'destroy'])->middleware(['auth']);
Route::resource('coa', App\Http\Controllers\CoaController::class)->middleware(['auth']);

// untuk transaksi penyewaan
Route::get('/penyewaan/barang/{id}', [App\Http\Controllers\penyewaanController::class,'getDataBarang'])->middleware(['auth']);
Route::get('/penyewaan/keranjang', [App\Http\Controllers\penyewaanController::class,'keranjang'])->middleware(['auth']);
Route::get('/penyewaan/destroypenyewaandetail/{id}', [App\Http\Controllers\penyewaanController::class,'destroypenyewaandetail'])->middleware(['auth']);
Route::get('/penyewaan/barang', [App\Http\Controllers\penyewaanController::class,'getDataBarangAll'])->middleware(['auth']);
Route::get('/penyewaan/jmlbarang', [App\Http\Controllers\penyewaanController::class,'getJumlahBarang'])->middleware(['auth']);
Route::get('/penyewaan/keranjangjson', [App\Http\Controllers\penyewaanController::class,'keranjangjson'])->middleware(['auth']);
Route::get('/penyewaan/checkout', [App\Http\Controllers\penyewaanController::class,'checkout'])->middleware(['auth']);
Route::get('penyewaan/invoice', [App\Http\Controllers\penyewaanController::class,'invoice'])->middleware(['auth']);
Route::get('penyewaan/jmlinvoice', [App\Http\Controllers\penyewaanController::class,'getInvoice'])->middleware(['auth']);
Route::resource('penyewaan', App\Http\Controllers\penyewaanController::class)->middleware(['auth']);

// transaksi pembayaran viewkeranjang
Route::get('pembayaran/viewkeranjang', [App\Http\Controllers\PembayaranController::class,'viewkeranjang'])->middleware(['auth']);
Route::get('pembayaran/viewstatus', [App\Http\Controllers\PembayaranController::class,'viewstatus'])->middleware(['auth']); 
Route::get('pembayaran/viewapprovalstatus', [App\Http\Controllers\PembayaranController::class,'viewapprovalstatus'])->middleware(['auth']);
Route::get('pembayaran/approve/{no_transaksi}', [App\Http\Controllers\PembayaranController::class,'approve'])->middleware(['auth']);
Route::get('pembayaran/unapprove/{no_transaksi}', [App\Http\Controllers\PembayaranController::class,'unapprove'])->middleware(['auth']);
Route::resource('pembayaran', App\Http\Controllers\PembayaranController::class)->middleware(['auth']);

// laporan
Route::get('jurnal/umum', [App\Http\Controllers\JurnalController::class,'jurnalumum'])->middleware(['auth']);
Route::get('jurnal/viewdatajurnalumum/{periode}', [App\Http\Controllers\JurnalController::class,'viewdatajurnalumum'])->middleware(['auth']);
Route::get('jurnal/bukubesar', [App\Http\Controllers\JurnalController::class,'bukubesar'])->middleware(['auth']);
Route::get('jurnal/viewdatabukubesar/{periode}/{akun}', [App\Http\Controllers\JurnalController::class,'viewdatabukubesar'])->middleware(['auth']);

// grafik
Route::get('grafik/viewPenyewaanBlnBerjalan', [App\Http\Controllers\GrafikController::class,'viewPenyewaanBlnBerjalan'])->middleware(['auth']);
Route::get('grafik/viewStatusPenyewaan', [App\Http\Controllers\GrafikController::class,'viewStatusPenyewaan'])->middleware(['auth']);
Route::get('grafik/viewJmlBarangTersewa', [App\Http\Controllers\GrafikController::class,'viewJmlBarangTersewa'])->middleware(['auth']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
 