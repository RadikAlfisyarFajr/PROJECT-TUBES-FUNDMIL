<?php

use App\Http\Controllers\SuperAdmin\ApprovalAdminInstansi\ApprovalAdminInstansiController;
use Illuminate\Support\Facades\Route;

Route::prefix('superadmin/approval-admin-instansi')
    ->name('superadmin.approval-admin-instansi.')
    ->controller(ApprovalAdminInstansiController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/{id}/approve', 'approve')->name('approve');
        Route::post('/{id}/reject', 'reject')->name('reject');
    });
