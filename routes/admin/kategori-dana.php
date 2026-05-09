<?php

use App\Http\Controllers\KategoriDana\KategoriDanaController;
use Illuminate\Support\Facades\Route;

Route::post('kategori-dana/notifikasi/read', [KategoriDanaController::class, 'markNotificationsRead'])
    ->name('kategori-dana.notifications.read');

Route::resource('kategori-dana', KategoriDanaController::class)
    ->names('kategori-dana');
