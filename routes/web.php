<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\HighChartController;
use App\Http\Controllers\UserChartController;
use App\Http\Controllers\KodeJabatanController;


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

Route::get('/index', function () {
    return view('index');
});

Route::get('/chart', [HighChartController::class, 'handleChart']);

Route::get('/barchart', [HighChartController::class, 'barchart']);

Route::get('/chart-js', [HighChartController::class, 'chart']);


// Barcode
Route::get('/barcode', [BarcodeController::class, 'index'])->name('barcode.index');

// QR Code
Route::get('/qr-code-g', [QrCodeController::class, 'index'])->name('qrcode.index');
// Route::get('qr-code-g', function () {
  
//     // QrCode::size(500)
//     //         ->format('png')
//     //         ->generate('raviyatechnical', public_path('images/qrcode.png'));
    
//   return view('pages.qrCode');
    
// });


// Get kode jabatansimpeg
Route::get('/get-kode-jabatan', [KodeJabatanController::class, 'index'])->name('kodejabatan.index');



