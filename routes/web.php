<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showAuthForm'])->name('auth');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        return $user->role === 'super_admin'
            ? redirect()->route('dashboard.superadmin')
            : redirect()->route('dashboard.admin');
    })->name('dashboard.home');

    Route::get('/dashboard/admin', function () {
        $user = Auth::user();
        if ($user->role !== 'admin_instansi') {
            abort(403, 'Unauthorized');
        }
        return view('dashboard.admin');
    })->name('dashboard.admin');

    Route::get('/dashboard/superadmin', [AuthController::class, 'showSuperAdminDashboard'])
        ->name('dashboard.superadmin');

    Route::post('/dashboard/superadmin/approve/{user}', [AuthController::class, 'approveAdminInstansi'])
        ->name('superadmin.approve');
    Route::post('/dashboard/superadmin/reject/{user}', [AuthController::class, 'rejectAdminInstansi'])
        ->name('superadmin.reject');
});
