<?php

use App\Http\Controllers\Mustahik\MustahikController;
use Illuminate\Support\Facades\Route;

Route::middleware('admin.instansi')->group(function () {
    Route::resource('mustahik', MustahikController::class)
        ->names('mustahik');
});
