<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObatController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/list_obat', [ObatController::class, 'index'])->name('obat.index');
Route::post('/obat', [ObatController::class, 'storeinsert_obat'])->name('obat.storeinsert_obat');

Route::get('/signa', [ObatController::class, 'signa'])->name('signa.index');
Route::post('/signa', [ObatController::class, 'storeSigna'])->name('signa.store');
Route::put('/signa/{id}', [ObatController::class, 'updateSigna'])->name('signa.update');
Route::put('/signa/{id}/update', [ObatController::class, 'updateSigna'])->name('signa.update');
Route::delete('/signa/{id}', [ObatController::class, 'deleteSigna'])->name('signa.delete');


Route::post('/obat/{id}/tambah', [ObatController::class, 'tambahStok'])->name('obat.tambahStok');
Route::post('/obat/{id}/kurang', [ObatController::class, 'kurangStok'])->name('obat.kurangStok');
Route::post('/obat/{id}/update-stok', [ObatController::class, 'updateStok'])->name('obat.updateStok');
Route::post('/obat/racikan/checkout', [ObatController::class, 'checkoutRacikan'])->name('obat.racikan.checkout');
Route::post('/obat/racikan/checkout-multiple', [ObatController::class, 'checkoutMultiple'])->name('obat.racikan.checkoutMultiple');
Route::get('/obat/checkout/print/{nama}', [ObatController::class, 'printCheckout'])->name('checkout.racikan.print');
Route::get('/obat/checkout/history', [ObatController::class, 'checkoutHistory'])->name('checkout.racikan.history');
Route::get('/obat/non-racikan', [ObatController::class, 'listNonRacikan'])->name('obat.nonRacikan');
Route::post('/obat/non-racikan/checkout', [ObatController::class, 'checkoutNonRacikan'])->name('obat.nonRacikan.checkout');
Route::get('/obat/non-racikan/print/{checkout_id}', [ObatController::class, 'printNonRacikan'])->name('obat.nonRacikan.print');
Route::post('/obat/nonracikan/checkout', [ObatController::class, 'checkoutNonRacikan'])->name('obat.nonracikan.checkout');
Route::get('/obat/nonracikan/print/{id}', [ObatController::class, 'printNonRacikan'])->name('obat.nonracikan.print');

Route::post('/checkout-non-racikan', [ObatController::class, 'checkoutNonRacikan'])->name('obat.checkoutNonRacikan');
Route::get('/obat/checkout-non-racikan/print/{id}', [ObatController::class, 'printNonRacikan'])->name('obat.printNonRacikan');
Route::get('/checkout/nonracikan/history', [ObatController::class, 'riwayatNonRacikan'])->name('checkout.nonracikan.history');


Route::get('/pilih-obat', [ObatController::class, 'formPilih'])->name('obat.formPilih');
Route::post('/pilih-obat', [ObatController::class, 'prosesPilih'])->name('obat.prosesPilih');

Route::get('/beri-obat', [ObatController::class, 'formNonRacikan'])->name('obat.formNonRacikan');
Route::post('/beri-obat', [ObatController::class, 'storeNonRacikan'])->name('obat.storeNonRacikan');

Route::post('/transaksi-obat/simpan', [ObatController::class, 'store'])->name('obat.store');
Route::get('/transaksi-obat', [ObatController::class, 'listTransaksi'])->name('obat.transaksi');

Route::get('/racikan/buat', [ObatController::class, 'createRacikan'])->name('obat.createRacikan');
Route::post('/racikan/simpan', [ObatController::class, 'storeRacikan'])->name('obat.storeRacikan');
Route::get('/racikan', [ObatController::class, 'listRacikan'])->name('obat.transaksi');
Route::get('/racikan/riwayat', [ObatController::class, 'checkoutHistory'])->name('checkout.nonracikan.history');
Route::delete('/racikan/delete/{nama}', [ObatController::class, 'deleteRacikan'])->name('obat.racikan.delete');
Route::get('/racikan/edit/{nama}', [ObatController::class, 'editRacikan'])->name('obat.racikan.edit');
Route::post('/racikan/update', [ObatController::class, 'updateRacikan'])->name('obat.racikan.update');


// ajax
Route::get('/ajax/obat-search', [ObatController::class, 'ajaxSearch'])->name('ajax.obat.search');
Route::post('/ajax/racikan/details', [ObatController::class, 'ajaxRacikanDetails'])->name('ajax.racikan.details');

