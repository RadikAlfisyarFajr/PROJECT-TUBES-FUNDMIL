<?php

use App\Http\Controllers\Laporan\LaporanController;
use Illuminate\Support\Facades\Route;

// ── Route spesifik harus di ATAS resource ──
Route::get('laporan/pemasukan', [LaporanController::class, 'pemasukan'])
    ->name('laporan.pemasukan');

Route::get('laporan/pemasukan/{id}/detail', [LaporanController::class, 'pemasukanDetail'])
    ->name('laporan.pemasukan.detail')
    ->whereNumber('id');

// ── Resource di BAWAH ──
Route::resource('laporan', LaporanController::class)
    ->names('laporan');