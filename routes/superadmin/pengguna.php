<?php

use App\Http\Controllers\SuperAdmin\Pengguna\PenggunaController;
use Illuminate\Support\Facades\Route;

Route::resource('superadmin/pengguna', PenggunaController::class)
    ->names('superadmin.pengguna');
