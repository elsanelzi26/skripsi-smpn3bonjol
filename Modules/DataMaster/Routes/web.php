<?php

use Modules\DataMaster\Http\Controllers\AuthController;
use Modules\DataMaster\Http\Controllers\AgamaController;
use Modules\DataMaster\Http\Controllers\GrafikController;
use Modules\DataMaster\Http\Controllers\RegisterController;
use Modules\DataMaster\Http\Controllers\DashboardController;
use Modules\DataMaster\Http\Controllers\DetailUserController;
use Modules\DataMaster\Http\Controllers\PendidikanController;
use Modules\DataMaster\Http\Controllers\JenisKelaminController;
use Modules\DataMaster\Http\Controllers\LaporanTableController;
use Modules\DataMaster\Http\Controllers\ManajemenUserController;
use Modules\DataMaster\Http\Controllers\AjukanPermohonanController;
use Modules\DataMaster\Http\Controllers\DependantDropdownController;




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

     //  Indoregion
     Route::post('/getkabupaten', [RegisterController::class, 'getkabupaten'])->name('getkabupaten');
     Route::post('/getkecamatan', [RegisterController::class, 'getkecamatan'])->name('getkecamatan');
     Route::post('/getkelurahan', [RegisterController::class, 'getkelurahan'])->name('getkelurahan');

Route::group(['middleware' => ['guest']],function () {
      // Login
      Route::get('/', [AuthController::class, 'index'])->name('login');
      Route::post('/proses-login', [AuthController::class, 'proseslogin'])->name('proses_login');


     // Masyarakat
        // Register
            Route::resource('register','RegisterController');
   

});

// Domain Data Indonesia
Route::get('provinces', [DependantDropdownController::class, 'provinces'])->name('provinces');
Route::get('cities', [DependantDropdownController::class, 'cities'])->name('cities');
Route::get('districts', [DependantDropdownController::class, 'districts'])->name('districts');
Route::get('villages', [DependantDropdownController::class, 'villages'])->name('villages');

Route::group(['middleware' => ['auth']], function() {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    
});

Route::group(['middleware' => ['auth','CekLevel:1']],function () {
        Route::prefix('datamaster')->group(function() {
            Route::get('/index', 'DataMasterController@index');

            // Jenis Kelamin
            Route::resource('jeniskelamin','JenisKelaminController');
            Route::post('jeniskelamin/jeniskelamin-delete', [JenisKelaminController::class,'delete']);

            // Pendidikan
            Route::resource('pendidikan','PendidikanController');
            Route::post('pendidikan/pendidikan-delete', [PendidikanController::class,'delete']);

             // Agama
            Route::resource('agama','AgamaController');
            Route::post('agama/agama-delete', [AgamaController::class,'delete']);

            // Detail User
            Route::resource('detailuser','DetailUserController');
            Route::post('detail-user/detail-user-delete', [DetailUserController::class,'delete'])->name('delete_user');

            // Validasi Permohonan
            Route::get('validasi_permohonan', [AjukanPermohonanController::class, 'validasipermohonanadmin'])->name('validasipermohonanadmin.index');
            Route::post('validasi_permohonan/prosesvalidasi', [AjukanPermohonanController::class,'prosesvalidasipermohonan'])->name('proses_validasi_permohonan');
            Route::post('teruskan_permohonan/prosesteruskan', [AjukanPermohonanController::class,'prosesteruskanpermohonan'])->name('proses_teruskan_permohonan');
        });

});

Route::group(['middleware' => ['auth','CekLevel:2']],function () {
    Route::prefix('datamaster')->group(function() {

        // Kasie Disposisi Permohonan
        Route::get('disposisi_permohonank1', [AjukanPermohonanController::class, 'disposisipermohonankasie'])->name('disposisipermohonankasie.index');
        Route::post('disposisi_permohonank1/prosesdisposisi', [AjukanPermohonanController::class,'prosesdisposisipermohonankasie'])->name('proses_disposisi_permohonan_kasie');
    });

});

Route::group(['middleware' => ['auth','CekLevel:3']],function () {
    Route::prefix('datamaster')->group(function() {

        // Kabid Disposisi Permohonan
        Route::get('disposisi_permohonank2', [AjukanPermohonanController::class, 'disposisipermohonankabid'])->name('disposisipermohonankabid.index');
        Route::post('disposisi_permohonank2/prosesdisposisi', [AjukanPermohonanController::class,'prosesdisposisipermohonankabid'])->name('proses_disposisi_permohonan_kabid');
    });

});

Route::group(['middleware' => ['auth','CekLevel:4']],function () {
    Route::prefix('datamaster')->group(function() {
        // Kadis Disposisi Permohonan
        Route::get('disposisi_permohonank3', [AjukanPermohonanController::class, 'disposisipermohonankadis'])->name('disposisipermohonankadis.index');
        Route::post('disposisi_permohonank3/prosesdisposisi', [AjukanPermohonanController::class,'prosesdisposisipermohonankadis'])->name('proses_disposisi_permohonan_kadis');

        // Terbitkan Permohonan
        Route::post('terbitkan_permohonan/prosesterbitkan', [AjukanPermohonanController::class,'prosesterbitkanpermohonan'])->name('proses_terbitkan_permohonan');
    
    });
});

Route::group(['middleware' => ['auth','CekLevel:5']],function () {
    Route::prefix('datamaster')->group(function() {
        // AjukanPermohonan
        // Route::resource('ajukanpermohonan','AjukanPermohonanController');
        Route::get('ajukanpermohonan', [AjukanPermohonanController::class, 'index'])->name('ajukanpermohonan.index');
        Route::get('ajukanpermohonan/create', [AjukanPermohonanController::class, 'create'])->name('ajukanpermohonan.create');
        Route::post('ajukanpermohonan/store', [AjukanPermohonanController::class, 'store'])->name('ajukanpermohonan.store');
        Route::get('ajukanpermohonan/getwilayah', [AjukanPermohonanController::class, 'getwilayah'])->name('getwilayahsamausers');

        Route::post('/getkabupatensamauser', [AjukanPermohonanController::class, 'getkabupatensamauser'])->name('getkabupatensamauser');
        Route::post('/getkecamatansamauser', [AjukanPermohonanController::class, 'getkecamatansamauser'])->name('getkecamatansamauser');
        Route::post('/getkelurahansamauser', [AjukanPermohonanController::class, 'getkelurahansamauser'])->name('getkelurahansamauser');
        Route::get('/getprovinsi', [AjukanPermohonanController::class, 'getprovinsi'])->name('getprovinsi');
    });

});

Route::group(['middleware' => ['auth','CekLevel:1,4']],function () {
    Route::prefix('datamaster')->group(function() {
        // // Laporan Tabel DataTable Yajra
        // Data Permohonan Diajukan PerTanggal
        Route::get('datapermohonan_diajukan', [LaporanTableController::class, 'indexdatapermohonandiajukan'])->name('datapermohonandiajukan.index');
        Route::post('datapermohonan_diajukan_search_per_tanggal', [LaporanTableController::class, 'searchdatapermohonandiajukan'])->name('datapermohonandiajukan.search_per_tanggal');
        // Route::get('/cetak-data-permohonan-diajukan/{tanggalAwal}/{tanggalAkhir}', [LaporanTableController::class, 'cetakPermohonanDiajukan'])->name('cetak_permohonan_diajukan_pertanggal');
        Route::get('permohonan-diajukan/cetak/', [LaporanTableController::class, 'cetakPermohonanDiajukan'])->name('cetak_permohonan_diajukan_pertanggal');



          // Data Permohonan Diterbitkan PerTanggal
          Route::get('datapermohonan_diterbitkan', [LaporanTableController::class, 'indexdatapermohonanditerbitkan'])->name('datapermohonanditerbitkan.index');
          Route::post('datapermohonan_diterbitkan_search_per_tanggal', [LaporanTableController::class, 'searchdatapermohonanditerbitkan'])->name('datapermohonanditerbitkan.search_per_tanggal');

        //   Data Permohonan Jenis Skala Tingkat Resiko
        Route::get('datapermohonan_jenisskala_tingkatresiko', [LaporanTableController::class, 'indexdatapermohonanjenisskala_tingkatresiko'])->name('datapermohonanjenisskala_tingkatresiko.index');
        Route::post('datapermohonan_jenisskala_tingkatresiko_search_per_tanggal', [LaporanTableController::class, 'searchdatapermohonanjenisskala_tingkatresiko'])->name('datapermohonanjenisskala_tingkatresiko.search_per_tanggal');

        //   Data Permohonan Kecamatan dan Kelurahan
        Route::get('datapermohonan_kecamatan_kelurahan', [LaporanTableController::class, 'indexdatapermohonankecamatan_kelurahan'])->name('datapermohonankecamatan_kelurahan.index');
        Route::post('datapermohonan_kecamatan_kelurahan_search_per_tanggal', [LaporanTableController::class, 'searchdatapermohonankecamatan_kelurahan'])->name('datapermohonankecamatan_kelurahan.search_per_tanggal');

        // Grafik
         Route::get('jumlah-permohonan-diajukan', [GrafikController::class, 'indexdatapermohonandiajukan'])->name('jumlah_permohonan_diajukan.index');
         Route::get('jumlah-permohonan-diterbitkan', [GrafikController::class, 'indexdatapermohonanditerbitkan'])->name('jumlah_permohonan_diterbitkan.index');
         Route::get('jumlah-permohonan-perkecamatan', [GrafikController::class, 'indexdatapermohonanperkecamatan'])->name('jumlah_permohonan_perkecamatan.index');

        // Detail Data Permohonan Diajukan
        Route::get('/permohonandiajukan/detailshowdiajukan/{id}',[LaporanTableController::class, 'showdetaildatapermohonan'])->name('showdetaildatapermohonan');
        // Route::get('/dip_frame/{id_skpd}/{filename}','PpidController@frame')->name('dip_frame');


        // // Laporan Tabel DataTable Biasa
        // // Data Permohonan Diajukan PerTanggal
        // Route::get('datapermohonan_diajukan', [LaporanController::class, 'indexdatapermohonandiajukan'])->name('datapermohonandiajukan.index');
        // Route::post('datapermohonan_diajukan_search_per_tanggal', [LaporanController::class, 'searchdatapermohonandiajukan'])->name('datapermohonandiajukan.search_per_tanggal');

        //   // Data Permohonan Diterbitkan PerTanggal
        //   Route::get('datapermohonan_diterbitkan', [LaporanController::class, 'indexdatapermohonanditerbitkan'])->name('datapermohonanditerbitkan.index');
        //   Route::post('datapermohonan_diterbitkan_search_per_tanggal', [LaporanController::class, 'searchdatapermohonanditerbitkan'])->name('datapermohonanditerbitkan.search_per_tanggal');

        // //   Data Permohonan Jenis Skala Tingkat Resiko
        // Route::get('datapermohonan_jenisskala_tingkatresiko', [LaporanController::class, 'indexdatapermohonanjenisskala_tingkatresiko'])->name('datapermohonanjenisskala_tingkatresiko.index');
        // Route::post('datapermohonan_jenisskala_tingkatresiko_search_per_tanggal', [LaporanController::class, 'searchdatapermohonanjenisskala_tingkatresiko'])->name('datapermohonanjenisskala_tingkatresiko.search_per_tanggal');

        // //   Data Permohonan Kecamatan dan Kelurahan
        // Route::get('datapermohonan_kecamatan_kelurahan', [LaporanController::class, 'indexdatapermohonankecamatan_kelurahan'])->name('datapermohonankecamatan_kelurahan.index');
        // Route::post('datapermohonan_kecamatan_kelurahan_search_per_tanggal', [LaporanController::class, 'searchdatapermohonankecamatan_kelurahan'])->name('datapermohonankecamatan_kelurahan.search_per_tanggal');
    });

});




