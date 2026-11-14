<?php

use Modules\Auth\Http\Controllers\AuthController;
use Modules\Absensi\Http\Controllers\AbsensiController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(['middleware' => ['auth']], function () {

  // Absensi
  Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
  Route::get('/absensi/get-siswa', [AbsensiController::class, 'getSiswa'])
    ->name('absensi.getSiswa');
  Route::post('/absensi/store', [AbsensiController::class, 'store'])->name('absensi.store');
  Route::get('/absensi/{id}/edit', [AbsensiController::class, 'edit'])->name('absensi.edit');
  Route::post('absensi/absensi-delete', [AbsensiController::class,'delete']);

  // Rekap Absensi
    Route::get('/absensi/rekap', [AbsensiController::class, 'rekap'])->name('absensi.rekap');
    Route::get('/absensi/get-rekap', [AbsensiController::class, 'getRekap'])->name('absensi.getRekap');
    Route::get('absensi/rekap/pdf', [AbsensiController::class, 'exportPdf'])->name('absensi.exportPdf');

});
