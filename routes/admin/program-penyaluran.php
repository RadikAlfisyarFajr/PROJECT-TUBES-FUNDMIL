<?php

use App\Http\Controllers\ProgramPenyaluran\ProgramPenyaluranController;
use Illuminate\Support\Facades\Route;

Route::middleware('admin.instansi')->group(function () {
    Route::resource('program-penyaluran', ProgramPenyaluranController::class)
        ->parameters(['program-penyaluran' => 'program_penyaluran'])
        ->names('program-penyaluran')
        ->except(['show']);
});
