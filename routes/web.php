<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\KasirController;
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
Route::get('/indexdatatarif', [MasterController::class, 'indexdatatarif'])->name('indexdatatarif');
Route::get('/indexdataunit', [MasterController::class, 'indexdataunit'])->name('indexdataunit');
Route::get('/indexdatapegawai', [MasterController::class, 'indexdatapegawai'])->name('indexdatapegawai');
Route::get('/indexdatalokasi', [MasterController::class, 'indexdatalokasi'])->name('indexdatalokasi');
Route::post('/ambildetailuser', [MasterController::class, 'ambildetailuser'])->name('ambildetailuser');
Route::post('/ambildetailunit', [MasterController::class, 'ambildetailunit'])->name('ambildetailunit');
Route::post('/ambildetailpegawai', [MasterController::class, 'ambildetailpegawai'])->name('ambildetailpegawai');
Route::post('/simpanunit', [MasterController::class, 'simpanunit'])->name('simpanunit');
Route::post('/simpanpegawai', [MasterController::class, 'simpanpegawai'])->name('simpanpegawai');
Route::post('/simpantarif', [MasterController::class, 'simpantarif'])->name('simpantarif');


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
Route::get('/indexdatakunjunganrekamedis', [RekamedisController::class, 'indexdatakunjunganrekamedis'])->name('indexdatakunjunganrekamedis');
Route::get('/cariunit', [RekamedisController::class, 'cariunit'])->name('cariunit');
Route::get('/caridokter', [RekamedisController::class, 'caridokter'])->name('caridokter');
Route::get('/cariprovinsi', [RekamedisController::class, 'cariprovinsi'])->name('cariprovinsi');
Route::get('/carikabupaten', [RekamedisController::class, 'carikabupaten'])->name('carikabupaten');
Route::get('/carikecamatan', [RekamedisController::class, 'carikecamatan'])->name('carikecamatan');
Route::get('/caridesa', [RekamedisController::class, 'caridesa'])->name('caridesa');
Route::post('/simpandatapasienbaru', [RekamedisController::class, 'simpandatapasienbaru'])->name('simpandatapasienbaru');
Route::post('/caripasien', [RekamedisController::class, 'caripasien'])->name('caripasien');
Route::post('/ambilformpendaftaran', [RekamedisController::class, 'ambilformpendaftaran'])->name('ambilformpendaftaran');
Route::post('/simpanpendaftaranpasien', [RekamedisController::class, 'simpanpendaftaranpasien'])->name('simpanpendaftaranpasien');
Route::post('/ambilriwayatkunjungan', [RekamedisController::class, 'ambilriwayatkunjungan'])->name('ambilriwayatkunjungan');
Route::post('/batalkunjungan', [RekamedisController::class, 'batalkunjungan'])->name('batalkunjungan');
Route::post('/riwayatpendaftaran', [RekamedisController::class, 'riwayatpendaftaran'])->name('riwayatpendaftaran');
Route::post('/carikunjunganrekamedis', [RekamedisController::class, 'carikunjunganrekamedis'])->name('carikunjunganrekamedis');
Route::post('/ambildetailkunjungan', [RekamedisController::class, 'ambildetailkunjungan'])->name('ambildetailkunjungan');


//dokter
Route::get('/caridiagnosa', [DokterController::class, 'caridiagnosa'])->name('caridiagnosa');
Route::get('/indexdatakunjungandokter', [DokterController::class, 'indexdatakunjungandokter'])->name('indexdatakunjungandokter');
Route::post('/caripasiendokter', [DokterController::class, 'caripasiendokter'])->name('caripasiendokter');
Route::post('/ambildetailpasiendokter', [DokterController::class, 'ambildetailpasiendokter'])->name('ambildetailpasiendokter');
Route::post('/simpanpemeriksaandokter', [DokterController::class, 'simpanpemeriksaandokter'])->name('simpanpemeriksaandokter');
Route::post('/ambilriwayatbilling', [DokterController::class, 'ambilriwayatbilling'])->name('ambilriwayatbilling');



Route::get('/indexdatakunjungankasir', [KasirController::class, 'indexdatakunjungankasir'])->name('indexdatakunjungankasir');
Route::post('/carilayananheader', [KasirController::class, 'carilayananheader'])->name('carilayananheader');
Route::post('/ambildatabilling', [KasirController::class, 'ambildatabilling'])->name('ambildatabilling');
Route::post('/detailbilling2', [KasirController::class, 'detailbilling2'])->name('detailbilling2');
Route::post('/hitungpembayaran', [KasirController::class, 'hitungpembayaran'])->name('hitungpembayaran');

