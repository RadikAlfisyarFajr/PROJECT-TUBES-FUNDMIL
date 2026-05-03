<?php

use App\Http\Controllers\MustahikController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('mustahik.index');
});

Route::resource('mustahik', MustahikController::class);
