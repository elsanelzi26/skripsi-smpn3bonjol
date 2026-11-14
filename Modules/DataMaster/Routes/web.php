<?php

use Modules\Auth\Http\Controllers\AuthController;
use Modules\DataMaster\Http\Controllers\DashboardController;
use Modules\DataMaster\Http\Controllers\RolesController;
use Modules\DataMaster\Http\Controllers\TahunAjaranController;
use Modules\DataMaster\Http\Controllers\JenisLombaController;
use Modules\DataMaster\Http\Controllers\KelasController;
use Modules\DataMaster\Http\Controllers\MataPelajaranController;
use Modules\DataMaster\Http\Controllers\GuruMapelController;
use Modules\DataMaster\Http\Controllers\SiswaController;
use Modules\DataMaster\Http\Controllers\OrtuController;
use Modules\DataMaster\Http\Controllers\PegawaiController;


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

Route::prefix('datamaster')->group(function() {
    Route::get('/', 'DataMasterController@index');
});

Route::group(['middleware' => ['guest']], function () {

  // Home
  //  Route::get('/', [HomeFrontendController::class, 'index'])->name('home');
  //  Route::get('/kontak', [HomeFrontendController::class, 'kontak'])->name('kontak');
  //  Route::get('/galeri', [HomeFrontendController::class, 'galeri'])->name('galeri');
  //  Route::get('/video', [HomeFrontendController::class, 'video'])->name('video');
  //  Route::get('/struktur_organisasi', [HomeFrontendController::class, 'struktur_organisasi'])->name('struktur_organisasi');
  //  Route::get('/berita', [HomeFrontendController::class, 'berita'])->name('berita');
  //  Route::get('/view_berita/{id}', [HomeFrontendController::class, 'view_berita'])->name('view_berita');
  //  Route::get('/ekstrakurikuler', [HomeFrontendController::class, 'ekstrakurikuler'])->name('ekstrakurikuler');
  //  Route::get('/pengumuman', [HomeFrontendController::class, 'pengumuman'])->name('pengumuman');
  //  Route::get('/view_pengumuman/{id}', [HomeFrontendController::class, 'view_pengumuman'])->name('view_pengumuman');
  //  Route::get('/profil_sekolah', [HomeFrontendController::class, 'profil_sekolah'])->name('profil_sekolah');

  //  Route::get('/get_footer_kontak', [HomeFrontendController::class, 'get_footer_kontak'])->name('get_footer_kontak');


  // Login
  Route::get('/', [AuthController::class, 'index'])->name('login');
  Route::post('/proses-login', [AuthController::class, 'proseslogin'])->name('proses_login');


});

Route::group(['middleware' => ['auth']], function () {
  // Dashboard
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

  // Role
  Route::get('/role', [RolesController::class, 'index'])->name('role.index');
  Route::post('/role/store', [RolesController::class, 'store'])->name('role.store');
  Route::get('/role/{id}/edit', [RolesController::class, 'edit'])->name('role.edit');
  Route::post('role/role-delete', [RolesController::class,'delete']);

   // Tahun AJaran
  Route::get('/tahun_ajaran', [TahunAjaranController::class, 'index'])->name('tahun_ajaran.index');
  Route::post('/tahun_ajaran/store', [TahunAjaranController::class, 'store'])->name('tahun_ajaran.store');
  Route::get('/tahun_ajaran/{id}/edit', [TahunAjaranController::class, 'edit'])->name('tahun_ajaran.edit');
  Route::post('tahun_ajaran/tahun_ajaran-delete', [TahunAjaranController::class,'delete']);
  Route::post('tahun_ajaran/update-status/{id}', [TahunAjaranController::class, 'updateStatus'])->name('tahun_ajaran.updateStatus');

  // Pegawai
  Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
  Route::post('/pegawai/store', [PegawaiController::class, 'store'])->name('pegawai.store');
  Route::get('/pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
  Route::post('pegawai/pegawai-delete', [PegawaiController::class,'delete']);
  Route::post('pegawai/update-status/{id}', [PegawaiController::class, 'updateStatus'])->name('pegawai.updateStatus');

  
  // Kelas
  Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
  Route::post('/kelas/store', [KelasController::class, 'store'])->name('kelas.store');
  Route::get('/kelas/{id}/edit', [KelasController::class, 'edit'])->name('kelas.edit');
  Route::post('kelas/kelas-delete', [KelasController::class,'delete']);
  Route::post('kelas/update-status/{id}', [KelasController::class, 'updateStatus'])->name('kelas.updateStatus');

  // Mapel
  Route::get('/mapel', [MataPelajaranController::class, 'index'])->name('mapel.index');
  Route::post('/mapel/store', [MataPelajaranController::class, 'store'])->name('mapel.store');
  Route::get('/mapel/{id}/edit', [MataPelajaranController::class, 'edit'])->name('mapel.edit');
  Route::post('mapel/mapel-delete', [MataPelajaranController::class,'delete']);
  Route::post('/mapel/update-status/{id}', [MataPelajaranController::class, 'updateStatus'])->name('mapel.updateStatus');

  // Guru Mapel
  Route::get('/guru_mapel', [GuruMapelController::class, 'index'])->name('guru_mapel.index');
  Route::post('/guru_mapel/store', [GuruMapelController::class, 'store'])->name('guru_mapel.store');
  Route::get('/guru_mapel/{id}/edit', [GuruMapelController::class, 'edit'])->name('guru_mapel.edit');
  Route::post('guru_mapel/guru_mapel-delete', [GuruMapelController::class,'delete']);

  // Siswa
  Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
  Route::post('/siswa/store', [SiswaController::class, 'store'])->name('siswa.store');
  Route::get('/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
  Route::post('siswa/siswa-delete', [SiswaController::class,'delete']);
  Route::post('siswa/update-status/{id}', [SiswaController::class, 'updateStatus']);

  // Ortu
  Route::get('/ortu', [OrtuController::class, 'index'])->name('ortu.index');
  Route::post('/ortu/store', [OrtuController::class, 'store'])->name('ortu.store');
  Route::get('/ortu/{id}/edit', [OrtuController::class, 'edit'])->name('ortu.edit');
  Route::post('ortu/ortu-delete', [OrtuController::class,'delete']);

  // Jenis Lomba
  Route::get('/jenislomba', [JenisLombaController::class, 'index'])->name('jenislomba.index');
  Route::post('/jenislomba/store', [JenisLombaController::class, 'store'])->name('jenislomba.store');
  Route::get('/jenislomba/{id}/edit', [JenisLombaController::class, 'edit'])->name('jenislomba.edit');
  Route::post('jenislomba/jenislomba-delete', [JenisLombaController::class,'delete']);

  // Logout
  Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

});
