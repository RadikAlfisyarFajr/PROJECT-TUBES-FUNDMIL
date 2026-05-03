<?php

use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('program-penyaluran.index');
});

Route::middleware('admin.instansi')->group(function () {
    Route::get('program-penyaluran/{program_penyaluran}/distribusi', [ProgramController::class, 'distribusi'])
        ->name('program-penyaluran.distribusi');

    Route::resource('program-penyaluran', ProgramController::class)
        ->parameters(['program-penyaluran' => 'program_penyaluran'])
        ->except(['show']);
});
