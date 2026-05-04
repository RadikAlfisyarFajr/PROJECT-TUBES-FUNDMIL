<?php

use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;

Route::middleware('admin.instansi')->group(function () {
    Route::resource('program-penyaluran', ProgramController::class)
        ->parameters(['program-penyaluran' => 'program_penyaluran'])
        ->names('program-penyaluran')
        ->except(['show']);
});
