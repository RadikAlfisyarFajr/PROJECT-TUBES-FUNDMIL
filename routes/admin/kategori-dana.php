<?php

use App\Http\Controllers\KategoriDana\KategoriDanaController;
use Illuminate\Support\Facades\Route;

Route::resource('kategori-dana', KategoriDanaController::class)
    ->names('kategori-dana');
