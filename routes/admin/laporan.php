<?php

use App\Http\Controllers\Laporan\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('laporan/pemasukan', [LaporanController::class, 'pemasukan'])
    ->name('laporan.pemasukan');

Route::get('laporan/pemasukan/{id}/detail', [LaporanController::class, 'pemasukanDetail'])
    ->name('laporan.pemasukan.detail')
    ->whereNumber('id');

Route::get('laporan/mustahik', [LaporanController::class, 'mustahik'])
    ->name('laporan.mustahik');

Route::get('laporan/mustahik/{id}/detail', [LaporanController::class, 'mustahikDetail'])
    ->name('laporan.mustahik.detail')
    ->whereNumber('id');

Route::get('laporan/penyaluran', [LaporanController::class, 'penyaluran'])
    ->name('laporan.penyaluran');

Route::get('laporan/penyaluran/{id}/detail', [LaporanController::class, 'penyaluranDetail'])
    ->name('laporan.penyaluran.detail')
    ->whereNumber('id');

Route::get('laporan/keuangan', [LaporanController::class, 'keuangan'])
    ->name('laporan.keuangan');

Route::resource('laporan', LaporanController::class)
    ->names('laporan');
