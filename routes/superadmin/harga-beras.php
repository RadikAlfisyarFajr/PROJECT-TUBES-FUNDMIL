<?php

use App\Http\Controllers\SuperAdmin\HargaBeras\HargaBerasController;
use Illuminate\Support\Facades\Route;

Route::resource('superadmin/harga-beras', HargaBerasController::class)
    ->names('superadmin.harga-beras');
