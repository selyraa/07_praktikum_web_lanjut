<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;

Route::resource('mahasiswas', MahasiswaController::class);
Route::post('cari', [MahasiswaController::class, 'cari'])->name('cari');
Route::get('mahasiswa/nilai/{nim}', [MahasiswaController::class, 'nilai'])->name('nilai');
Route::get('/article/cetak_pdf', [ArticleController::class, 'cetak_pdf']);
Route::get('/mahasiswas/{nim}/exportPDF', [MahasiswaController::class, 'exportPDF'])->name('mahasiswas.exportPDF');


Route::resource('articles', ArticleController::class);

Route::get('/', function () {
    return view('welcome');
});
