<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QRCodeController;

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


Route::get('/', [QrCodeController::class, 'showQrCodeForm']);
Route::post('/generate-qr-code', [QrCodeController::class, 'generateQrCode'])->name('generate.qr.code');
Route::post('/download-qr-code', [QrCodeController::class, 'downloadQrCode'])->name('download.qr.code');
