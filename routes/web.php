<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\RekamedisController;
use App\Http\Controllers\SatuSehatController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'index']);
Route::get('/login', [AuthController::class, 'index'])->middleware('guest')->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/login', [AuthController::class, 'authenticate']);

Route::get('/dashboard', [DashboardController::class, 'index']);


Route::get('/indexdatauser', [MasterController::class, 'indexdatauser'])->name('indexdatauser');
Route::get('/indexdataunit', [MasterController::class, 'indexdataunit'])->name('indexdataunit');
Route::get('/indexdatapegawai', [MasterController::class, 'indexdatapegawai'])->name('indexdatapegawai');
Route::get('/indexdatalokasi', [MasterController::class, 'indexdatalokasi'])->name('indexdatalokasi');
Route::post('/ambildetailuser', [MasterController::class, 'ambildetailuser'])->name('ambildetailuser');
Route::post('/ambildetailunit', [MasterController::class, 'ambildetailunit'])->name('ambildetailunit');
Route::post('/ambildetailpegawai', [MasterController::class, 'ambildetailpegawai'])->name('ambildetailpegawai');
Route::post('/simpanunit', [MasterController::class, 'simpanunit'])->name('simpanunit');
Route::post('/simpanpegawai', [MasterController::class, 'simpanpegawai'])->name('simpanpegawai');


Route::get('/get_pasien', [SatuSehatController::class, 'search_pasien'])->name('get_pasien');
Route::get('/get_provinsi', [SatuSehatController::class, 'get_provinsi'])->name('get_provinsi');
Route::post('/downloadkabupaten', [SatuSehatController::class, 'downloadkabupaten'])->name('downloadkabupaten');
Route::post('/ambilformaddkecamatan', [SatuSehatController::class, 'ambilformaddkecamatan'])->name('ambilformaddkecamatan');
Route::post('/ambil_form_desa', [SatuSehatController::class, 'ambil_form_desa'])->name('ambil_form_desa');
Route::post('/ambil_kecamatan', [SatuSehatController::class, 'ambil_kecamatan'])->name('ambil_kecamatan');
Route::post('/downloadkecamatan', [SatuSehatController::class, 'downloadkecamatan'])->name('downloadkecamatan');
Route::post('/downloaddesa', [SatuSehatController::class, 'downloaddesa'])->name('downloaddesa');


// indexpendaftaran
Route::get('/indexpendaftaran', [RekamedisController::class, 'indexpendaftaran'])->name('indexpendaftaran');
Route::post('/ambil_kabupaten_rekamedis', [RekamedisController::class, 'ambil_kabupaten_rekamedis'])->name('ambil_kabupaten_rekamedis');
Route::post('/ambil_kecamatan_rekamedis', [RekamedisController::class, 'ambil_kecamatan_rekamedis'])->name('ambil_kecamatan_rekamedis');
Route::post('/ambil_desa_rekamedis', [RekamedisController::class, 'ambil_desa_rekamedis'])->name('ambil_desa_rekamedis');
Route::post('/simpandatapasienbaru', [RekamedisController::class, 'simpandatapasienbaru'])->name('simpandatapasienbaru');
