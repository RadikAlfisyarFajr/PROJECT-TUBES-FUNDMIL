<?php

use App\Http\Controllers\PengaturanDistribusi\PengaturanDistribusiController;
use Illuminate\Support\Facades\Route;

Route::get('pengaturan-distribusi/mustahik-search', [PengaturanDistribusiController::class, 'searchMustahik'])
    ->name('pengaturan-distribusi.mustahik-search');

Route::resource('pengaturan-distribusi', PengaturanDistribusiController::class)
    ->parameters(['pengaturan-distribusi' => 'program_penyaluran'])
    ->names('pengaturan-distribusi');
