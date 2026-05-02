<?php

use App\Http\Controllers\SuperAdmin\Instansi\InstansiController;
use Illuminate\Support\Facades\Route;

Route::resource('superadmin/instansi', InstansiController::class)
    ->names('superadmin.instansi');
