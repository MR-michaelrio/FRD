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
use App\Http\Controllers\ApprovalController;
use App\Models\Anggota;
use App\Models\Laporan;
use Carbon\Carbon;

Route::get('/', function () {
    return view('home');
})->name('index');

Route::get('/daftar2', function () {
    return view('daftar2');
})->name('daftar2');

Route::middleware(['auth'])->group(function () {
    Route::resource('absen', AbsenController::class);
    Route::get('absen/edit/{id_anggota}/{id_absen}', [AbsenController::class , 'edit'])->name('absen.edit');
    Route::put('absen/update/{id_anggota}/{id_absen}', [AbsenController::class , 'update'])->name('absen.update');

    Route::resource('lpr', LaporanController::class);
    Route::get('/search/lpr', [LaporanController::class , 'search'])->name('search');
    Route::get('/search/rekap', [LaporanController::class , 'searchrekap'])->name('searchrekap');

    Route::get('/home', [HomeController::class , 'index'])->name('home');

    Route::put('/lpr/selesai/{id}', [LaporanController::class , 'selesai'])->name('lpr.selesai');
    Route::resource('anggota', AnggotaController::class);
    Route::get('/rekap', [LaporanController::class , 'rekap'])->name('lpr.rekap');

    Route::middleware('checkRole:admin')->group(function () {
            Route::get('/index2', [AnggotaController::class , 'index2'])->name('agt.index2');
            Route::resource('regu', ReguController::class);
            Route::resource('laporan', LaporanFinalController::class);
        }
        );

        Route::resource('wilayah', WilayahController::class);

        Route::resource('lembaga', LembagasController::class);

        Route::get('/ganti-password', [AnggotaController::class , 'GantiPassword'])->name('ganti.password');
        Route::post('/ganti-password', [AnggotaController::class , 'UpdatePassword'])->name('update.password');


    });

Route::get('/damkar', [LaporanController::class , 'damkar65'])->name('damkar');

Auth::routes();

Route::get('/pdf/{id}', [AbsenController::class , 'generatePDF'])->name('absen.pdf');
Route::get('/absenshow/{id}', [AbsenController::class , 'show'])->name('absen.show');

Route::get('/laporan1', [LaporanFinalController::class , 'laporanfinal'])->name('laporan.final');
Route::post('/laporan1', [LaporanFinalController::class , 'store'])->name('laporan.store');

Route::get('/absenbywilayah/{wilayah}', [AbsenController::class , 'indexByWilayah'])->name('absen.indexbywilayah');
Route::get('/absen1', [AbsenController::class , 'index2'])->name('absen.index2');
Route::post('/absen1', [AbsenController::class , 'store2'])->name('absen.store2');

Route::get('/absen3', [AbsenController::class , 'index3'])->name('absen.index3');
Route::post('/anggota/daftar', [AnggotaController::class , 'daftar'])->name('anggota.daftar');
Route::get('/daftar-anggota', [AnggotaController::class , 'indexdaftar'])->name('anggota.indexdaftar');

Route::get('/daftar-lembaga', [LembagasController::class , 'create'])->name('lembaga.create');
Route::get('/daftar-wilayah', [WilayahController::class , 'create'])->name('wilayah.create');
Route::post('/lembaga', [LembagasController::class , 'store'])->name('lembaga.store');
Route::post('/wilayah', [WilayahController::class , 'store'])->name('wilayah.store');

Route::post('/approve-user/{userId}', [ApprovalController::class , 'approveUser'])->name('approveUser');
Route::post('/delete-approve-user/{userId}', [ApprovalController::class , 'deleteapproveUser'])->name('deleteapproveUser');
Route::get('/approve-user/index', [ApprovalController::class , 'index'])->name('approve.index');
Route::get('/qr', function () {
    return view('qr'); // Blade file dari contoh di atas
});

Route::post('/save-fcm-token', [HomeController::class , 'saveToken']);