<?php

use App\Http\Controllers\KategoriDana\KategoriDanaController;
use App\Http\Controllers\Laporan\LaporanController;
use App\Http\Controllers\Mustahik\MustahikController;
use App\Http\Controllers\Pemasukan\PemasukanZakatController;
use App\Http\Controllers\PengaturanDistribusi\PengaturanDistribusiController;
use App\Http\Controllers\Penyaluran\PenyaluranController;
use App\Http\Controllers\ProfilInstansi\ProfilInstansiController;
use App\Http\Controllers\ProgramPenyaluran\ProgramPenyaluranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KepalaDesa\KepalaDesaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SuperAdmin\ApprovalAdminInstansi\ApprovalAdminInstansiController;
use App\Http\Controllers\SuperAdmin\HargaBeras\HargaBerasController;
use App\Http\Controllers\SuperAdmin\Instansi\InstansiController;
use App\Http\Controllers\SuperAdmin\Nishab\NishabController;

// =====================
// PUBLIC ROUTES
// =====================

Route::get('/', [AuthController::class, 'showLandingPage'])->name('public.home');
Route::get('/auth', [AuthController::class, 'showAuthForm'])->name('auth');

require __DIR__ . '/auth.php';

// =====================
// AUTHENTICATED ROUTES
// =====================

Route::middleware('auth')->group(function () {
    // =====================
    // DASHBOARD ROUTES
    // =====================

    Route::get('/dashboard', function () {
        return match (Auth::user()?->role) {
            'super_admin' => redirect()->route('dashboard.superadmin'),
            'admin_kepala_desa' => redirect()->route('kepala-desa.dashboard'),
            default => redirect()->route('dashboard.admin'),
        };
    })->name('dashboard');

    Route::get('/dashboard/admin', [AuthController::class, 'showAdminDashboard'])
        ->name('dashboard.admin');

    // =====================
    // SUPERADMIN ROUTES
    // =====================

    Route::middleware('superadmin')->group(function () {
        Route::get('/dashboard/superadmin', [AuthController::class, 'showSuperAdminDashboard'])
            ->name('dashboard.superadmin');

        Route::prefix('superadmin')->name('superadmin.')->group(function () {
            Route::prefix('approval-admin-instansi')
                ->controller(ApprovalAdminInstansiController::class)
                ->name('approval-admin-instansi.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/{user}', 'show')->name('show');
                    Route::post('/{user}/approve', 'approve')->name('approve');
                    Route::post('/{user}/reject', 'reject')->name('reject');
                });

            Route::resource('instansi', InstansiController::class)->except(['show'])->names('instansi');
            Route::resource('harga-beras', HargaBerasController::class)->except(['show'])->names('harga-beras');
            Route::resource('nishab', NishabController::class)->except(['show'])->names('nishab');
        });
    });

    // =====================
    // ADMIN INSTANSI ROUTES
    // =====================

    Route::middleware('admin.instansi')->group(function () {
        Route::resource('mustahik', MustahikController::class)
            ->names('mustahik');

        Route::resource('program-penyaluran', ProgramPenyaluranController::class)
            ->parameters(['program-penyaluran' => 'program_penyaluran'])
            ->names('program-penyaluran');

        Route::resource('kategori-dana', KategoriDanaController::class)
            ->names('kategori-dana');

        Route::resource('pemasukan', PemasukanZakatController::class)
            ->names('pemasukan');

        Route::get('pengaturan-distribusi/mustahik-search', [PengaturanDistribusiController::class, 'searchMustahik'])
            ->name('pengaturan-distribusi.mustahik-search');

        Route::resource('pengaturan-distribusi', PengaturanDistribusiController::class)
            ->parameters(['pengaturan-distribusi' => 'program_penyaluran'])
            ->names('pengaturan-distribusi');

        Route::resource('penyaluran', PenyaluranController::class)
            ->names('penyaluran');
    });

    // =====================
    // ADMIN KEPALA DESA ROUTES
    // =====================

    Route::middleware('admin.kepala.desa')
        ->prefix('kepala-desa')
        ->name('kepala-desa.')
        ->controller(KepalaDesaController::class)
        ->group(function () {
            Route::get('dashboard', 'dashboard')->name('dashboard');
            Route::get('approval-program', 'approvalIndex')->name('approval.index');
            Route::get('approval-program/{program}', 'approvalShow')->name('approval.show');
            Route::post('approval-program/{program}/approve', 'approve')->name('approval.approve');
            Route::post('approval-program/{program}/reject', 'reject')->name('approval.reject');
        });

    // =====================
    // SHARED AUTH ROUTES
    // =====================

    Route::prefix('kategori-dana')
        ->controller(KategoriDanaController::class)
        ->name('kategori-dana.')
        ->group(function () {
            Route::post('notifikasi/read', 'markNotificationsRead')->name('notifications.read');
        });

    Route::prefix('profil-instansi')
        ->controller(ProfilInstansiController::class)
        ->name('profil-instansi.')
        ->group(function () {
            Route::post('rekening', 'storeRekening')->name('rekening.store');
            Route::put('rekening/{rekening}', 'updateRekening')->name('rekening.update');
            Route::delete('rekening/{rekening}', 'destroyRekening')->name('rekening.destroy');
            Route::post('notifikasi/read', 'markNotificationsRead')->name('notifications.read');
        });

    Route::resource('profil-instansi', ProfilInstansiController::class)
        ->names('profil-instansi');

    // =====================
    // LAPORAN ROUTES
    // =====================

    Route::prefix('laporan')
        ->controller(LaporanController::class)
        ->name('laporan.')
        ->group(function () {
            Route::get('pemasukan', 'pemasukan')->name('pemasukan');
            Route::get('pemasukan/{id}/detail', 'pemasukanDetail')->name('pemasukan.detail')->whereNumber('id');
            Route::get('cetak-pdf/pemasukan-struk/{id}', 'pemasukanStruk')->name('pemasukan.struk')->whereNumber('id');
            Route::get('mustahik', 'mustahik')->name('mustahik');
            Route::get('mustahik/{id}/detail', 'mustahikDetail')->name('mustahik.detail')->whereNumber('id');
            Route::get('penyaluran', 'penyaluran')->name('penyaluran');
            Route::get('penyaluran/{id}/detail', 'penyaluranDetail')->name('penyaluran.detail')->whereNumber('id');
            Route::get('keuangan', 'keuangan')->name('keuangan');
        });

    Route::resource('laporan', LaporanController::class)
        ->names('laporan');
});
