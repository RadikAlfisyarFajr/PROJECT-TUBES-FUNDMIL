<?php

use App\Http\Controllers\Penyaluran\PenyaluranController;
use Illuminate\Support\Facades\Route;

Route::resource('penyaluran', PenyaluranController::class)
    ->names('penyaluran');
