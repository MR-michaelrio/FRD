<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\ReguController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\LaporanFinalController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\LembagasController;
use App\Models\anggota;
use App\Models\Laporan;
use Carbon\Carbon;

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
// Route::prefix('laporan')->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('index');

    Route::get('/daftar2', function () {
        return view('daftar2');
    })->name('daftar2');

    Route::middleware(['auth'])->group(function () {
        Route::resource('absen', AbsenController::class);
        Route::get('absen/edit/{id_anggota}/{id_absen}', [AbsenController::class, 'edit'])->name('absen.edit');
        Route::put('absen/update/{id_anggota}/{id_absen}', [AbsenController::class, 'update'])->name('absen.update');

        Route::resource('lpr', LaporanController::class);
        Route::get('/search/lpr', [LaporanController::class, 'search'])->name('search');
        Route::get('/search/rekap', [LaporanController::class, 'searchrekap'])->name('searchrekap');

        Route::get('/home', [HomeController::class, 'index'])->name('home');

        Route::put('/lpr/selesai/{id}',[LaporanController::class, 'selesai'])->name('lpr.selesai');
        Route::resource('anggota', AnggotaController::class);
        Route::get('/rekap',[LaporanController::class, 'rekap'])->name('lpr.rekap');

        Route::middleware('checkRole:admin')->group(function () {
            Route::get('/index2',[AnggotaController::class, 'index2'])->name('agt.index2');
            Route::resource('regu', ReguController::class);
            Route::resource('laporan', LaporanFinalController::class);
        });
    });

    Route::get('/damkar', [LaporanController::class, 'damkar65'])->name('damkar');

    Auth::routes();

    Route::get('/pdf/{id}',[AbsenController::class, 'generatePDF'])->name('absen.pdf');
    Route::get('/absenshow/{id}',[AbsenController::class, 'show'])->name('absen.show');

    Route::get('/laporan1',[LaporanFinalController::class, 'laporanfinal'])->name('laporan.final');
    Route::post('/laporan1',[LaporanFinalController::class, 'store'])->name('laporan.store');

    Route::get('/absen1',[AbsenController::class, 'index2'])->name('absen.index2');
    Route::post('/absen1',[AbsenController::class, 'store2'])->name('absen.store2');

    Route::get('/absen3',[AbsenController::class, 'index3'])->name('absen.index3');
    Route::post('/anggota/daftar', [AnggotaController::class, 'daftar'])->name('anggota.daftar');
    Route::get('/form_reg', [AnggotaController::class, 'indexdaftar'])->name('anggota.indexdaftar');

    Route::resource('wilayah', WilayahController::class);

    Route::resource('lembaga', LembagasController::class);
    Route::get('/daftar-lembaga', [LembagasController::class, 'indexdaftar'])->name('lembaga.indexdaftar');

// });

