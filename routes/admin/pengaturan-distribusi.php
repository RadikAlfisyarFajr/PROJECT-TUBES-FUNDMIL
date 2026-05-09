<?php

use App\Http\Controllers\PengaturanDistribusi\PengaturanDistribusiController;
use Illuminate\Support\Facades\Route;

Route::resource('pengaturan-distribusi', PengaturanDistribusiController::class)
    ->parameters(['pengaturan-distribusi' => 'program_penyaluran'])
    ->names('pengaturan-distribusi');
