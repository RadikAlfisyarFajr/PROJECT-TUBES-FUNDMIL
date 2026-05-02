<?php

use App\Http\Controllers\PengaturanDistribusi\PengaturanDistribusiController;
use Illuminate\Support\Facades\Route;

Route::resource('pengaturan-distribusi', PengaturanDistribusiController::class)
    ->names('pengaturan-distribusi');
