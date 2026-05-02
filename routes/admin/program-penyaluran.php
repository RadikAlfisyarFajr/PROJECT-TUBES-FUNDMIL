<?php

use App\Http\Controllers\ProgramPenyaluran\ProgramPenyaluranController;
use Illuminate\Support\Facades\Route;

Route::resource('program-penyaluran', ProgramPenyaluranController::class)
    ->names('program-penyaluran');
