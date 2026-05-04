<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLandingPage'])->name('public.home');
Route::get('/auth', [AuthController::class, 'showAuthForm'])->name('auth');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
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

        $user->load('instansi');

        return view('dashboard.admin', [
            'instansi' => $user->instansi,
        ]);
    })->name('dashboard.admin');

    Route::get('/dashboard/superadmin', [AuthController::class, 'showSuperAdminDashboard'])
        ->name('dashboard.superadmin');

    Route::post('/dashboard/superadmin/approve/{user}', [AuthController::class, 'approveAdminInstansi'])
        ->name('superadmin.approve');
    Route::post('/dashboard/superadmin/reject/{user}', [AuthController::class, 'rejectAdminInstansi'])
        ->name('superadmin.reject');

    require __DIR__.'/admin/profil-instansi.php';
    require __DIR__.'/admin/kategori-dana.php';
    require __DIR__.'/admin/pemasukan.php';
    require __DIR__.'/admin/mustahik.php';
    require __DIR__.'/admin/program-penyaluran.php';
    require __DIR__.'/admin/pengaturan-distribusi.php';
    require __DIR__.'/admin/penyaluran.php';
    require __DIR__.'/admin/laporan.php';

    require __DIR__.'/superadmin/approval-admin-instansi.php';
    require __DIR__.'/superadmin/instansi.php';
    require __DIR__.'/superadmin/pengguna.php';
    require __DIR__.'/superadmin/harga-beras.php';
    require __DIR__.'/superadmin/nishab.php';
    require __DIR__.'/superadmin/approval-program-penyaluran.php';
    require __DIR__.'/superadmin/monitoring.php';
});
