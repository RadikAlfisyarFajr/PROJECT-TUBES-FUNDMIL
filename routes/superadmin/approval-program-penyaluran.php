<?php

use App\Http\Controllers\SuperAdmin\ApprovalProgramPenyaluran\ApprovalProgramPenyaluranController;
use Illuminate\Support\Facades\Route;

Route::prefix('superadmin/approval-program-penyaluran')
    ->name('superadmin.approval-program-penyaluran.')
    ->controller(ApprovalProgramPenyaluranController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/{id}/approve', 'approve')->name('approve');
        Route::post('/{id}/reject', 'reject')->name('reject');
    });
