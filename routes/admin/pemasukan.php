<?php

use App\Http\Controllers\Pemasukan\PemasukanZakatController;
use Illuminate\Support\Facades\Route;

Route::resource('pemasukan', PemasukanZakatController::class)
    ->names('pemasukan');
