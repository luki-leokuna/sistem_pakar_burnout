<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiagnoseController;

// Halaman Depan (Form Konsultasi)
Route::get('/', [DiagnoseController::class, 'index'])->name('home');

// Proses Diagnosa (Saat tombol diklik)
Route::post('/diagnose', [DiagnoseController::class, 'process'])->name('diagnose.process');
