<?php

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

use Modules\Penilaian\Http\Controllers\PenilaianController;
use Modules\Penilaian\Http\Controllers\PrestasiController;
use Modules\Penilaian\Http\Controllers\SiswaBermasalahController;
use Modules\Penilaian\Http\Controllers\MonitoringOrangTuaController;

Route::group(['middleware' => ['auth']], function () {

    // Penilaian
    Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::get('/penilaian/get-siswa', [PenilaianController::class, 'getSiswa'])
        ->name('penilaian.getSiswa');
    Route::post('/penilaian/store', [PenilaianController::class, 'store'])->name('penilaian.store');
    Route::get('/penilaian/{id}/edit', [PenilaianController::class, 'edit'])->name('penilaian.edit');
    Route::post('penilaian/penilaian-delete', [PenilaianController::class, 'delete']);

    // Rekap Penilaian
    Route::get('/penilaian/rekap', [PenilaianController::class, 'rekap'])->name('penilaian.rekap');
    Route::get('/penilaian/get-rekap', [PenilaianController::class, 'getRekap'])->name('penilaian.getRekap');
    Route::get('/penilaian/rekap/pdf', [PenilaianController::class, 'exportPdf'])->name('penilaian.exportPdf');

    // Kelola Prestasi
    Route::get('/prestasi', [PrestasiController::class, 'index'])->name('prestasi.index');
    Route::post('/prestasi/store', [PrestasiController::class, 'store'])->name('prestasi.store');
    Route::get('/prestasi/{id}/edit', [PrestasiController::class, 'edit'])->name('prestasi.edit');
    Route::post('/prestasi/update', [PrestasiController::class, 'update'])->name('prestasi.update');
    Route::post('/prestasi/delete', [PrestasiController::class, 'destroy'])->name('prestasi.destroy');
    Route::get('/prestasi/cetak-pdf', [PrestasiController::class, 'cetakPdf'])->name('prestasi.cetakPdf');

    // Siswa Bermasalah
    Route::get('/penilaian/siswa-bermasalah', [SiswaBermasalahController::class, 'index'])->name('siswabermasalah.index');
    Route::get('/penilaian/siswa-bermasalah/cetak', [SiswaBermasalahController::class, 'cetakPdf'])->name('siswabermasalah.cetakPdf');
    Route::post('/siswa-bermasalah/update-status', [SiswaBermasalahController::class, 'updateStatus'])->name('siswabermasalah.updateStatus');

    // monitoring Orang Tua

    Route::prefix('orangtua/monitoring')->middleware(['auth'])->group(function() {
        // Halaman utama monitoring (pilihan kategori & load data via ajax/submit)
        Route::get('/', [MonitoringOrangTuaController::class, 'index'])->name('ortu.monitoring.index');
        
        // API/Endpoint internal untuk mengambil data masing-masing kategori
        Route::get('/absensi', [MonitoringOrangTuaController::class, 'getAbsensi'])->name('ortu.monitoring.absensi');
        Route::get('/nilai', [MonitoringOrangTuaController::class, 'getNilai'])->name('ortu.monitoring.nilai');
        Route::get('/prestasi', [MonitoringOrangTuaController::class, 'getPrestasi'])->name('ortu.monitoring.prestasi');
    });

    // Rekap Perangkingan
    Route::get('/penilaian/rekap-perangkingan', [PenilaianController::class, 'rekapPerangkingan'])->name('penilaian.rekap-perangkingan');
    Route::get('/penilaian/rekap-perangkingan/pdf', [PenilaianController::class, 'rekapPerangkinganExportPdf'])->name('penilaian.rekapPerangkinganExportPdf');
});
