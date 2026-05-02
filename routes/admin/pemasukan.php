<?php

use App\Http\Controllers\Pemasukan\PemasukanController;
use Illuminate\Support\Facades\Route;

Route::resource('pemasukan', PemasukanController::class)
    ->names('pemasukan');
