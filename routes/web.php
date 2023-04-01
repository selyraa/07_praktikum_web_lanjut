<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Http\Request;

Route::resource('mahasiswas', MahasiswaController::class);
Route::post('cari', [MahasiswaController::class, 'cari'])->name('cari');

Route::get('/', function () {
    return view('welcome');
});
