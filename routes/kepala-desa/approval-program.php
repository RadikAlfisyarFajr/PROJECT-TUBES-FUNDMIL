<?php

use App\Http\Controllers\KepalaDesa\ApprovalProgramController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')
    ->prefix('kepala-desa/approval-program')
    ->name('kepala-desa.approval.')
    ->controller(ApprovalProgramController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/{program}/approve', 'approve')->name('approve');
        Route::post('/{program}/reject', 'reject')->name('reject');
    });
