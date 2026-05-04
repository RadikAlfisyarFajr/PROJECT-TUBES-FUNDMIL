<?php

use App\Http\Controllers\Mustahik\MustahikController;
use Illuminate\Support\Facades\Route;

Route::resource('mustahik', MustahikController::class)
    ->names('mustahik');
