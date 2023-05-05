<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;

Route::resource('mahasiswas', MahasiswaController::class);
Route::post('cari', [MahasiswaController::class, 'cari'])->name('cari');
Route::get('mahasiswa/nilai/{nim}', [MahasiswaController::class, 'nilai'])->name('nilai');

Route::resource('articles', ArticleController::class);

Route::get('/', function () {
    return view('welcome');
});
