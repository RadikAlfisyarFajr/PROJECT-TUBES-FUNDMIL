<?php

use App\Http\Controllers\Laporan\LaporanController;
use Illuminate\Support\Facades\Route;

Route::resource('laporan', LaporanController::class)
    ->names('laporan');
