<?php

use App\Http\Controllers\AuthController;
use App\Models\Mustahik;
use App\Models\PenyaluranDetail;
use App\Models\TransaksiZakat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLandingPage'])->name('public.home');
Route::get('/auth', [AuthController::class, 'showAuthForm'])->name('auth');

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(403, 'Unauthorized');
        }

        return $user->role === 'super_admin'
            ? redirect()->route('dashboard.superadmin')
            : redirect()->route('dashboard.admin');
    })->name('dashboard');

    Route::get('/dashboard/admin', function () {
        $user = Auth::user();

        if (! $user instanceof User || $user->role !== 'admin_instansi') {
            abort(403, 'Unauthorized');
        }

        $user->load('instansi');
        $instansiId = $user->instansi_id;
        $hargaBeras = (float) (DB::table('harga_beras')
            ->where('tanggal_berlaku', '<=', now()->toDateString())
            ->orderByDesc('tanggal_berlaku')
            ->value('harga_per_kg') ?? 0);
        $nishabMaal = (float) (DB::table('nishab')
            ->whereIn('jenis_zakat', ['zakat_maal', 'zakat mal', 'zakat maal', 'maal', 'mal'])
            ->where('tanggal_berlaku', '<=', now()->toDateString())
            ->orderByDesc('tanggal_berlaku')
            ->value('nishab_rupiah') ?? 0);
        $totalPengumpulan = $instansiId
            ? (float) TransaksiZakat::where('instansi_id', $instansiId)->sum('jumlah')
            : 0;
        $totalTersalurkan = $instansiId
            ? (float) PenyaluranDetail::whereHas('penyaluran', fn ($query) => $query
                ->where('instansi_id', $instansiId)
                ->where('status', 'selesai'))
                ->sum('jumlah_diterima')
            : 0;

        return view('dashboard.admin', [
            'instansi' => $user->instansi,
            'dashboardStats' => [
                'hargaBeras' => $hargaBeras,
                'nishabMaal' => $nishabMaal,
                'totalPengumpulan' => $totalPengumpulan,
                'totalTersalurkan' => $totalTersalurkan,
                'saldoSiapDisalurkan' => max(0, $totalPengumpulan - $totalTersalurkan),
                'totalMuzakki' => $instansiId
                    ? TransaksiZakat::where('instansi_id', $instansiId)->distinct('nama_muzakki')->count('nama_muzakki')
                    : 0,
                'mustahikTersalurkan' => $instansiId
                    ? PenyaluranDetail::whereHas('penyaluran', fn ($query) => $query
                        ->where('instansi_id', $instansiId)
                        ->where('status', 'selesai'))
                        ->where('status_penerimaan', '!=', 'ditolak')
                        ->count()
                    : 0,
                'totalMustahik' => $instansiId
                    ? Mustahik::where('instansi_id', $instansiId)->count()
                    : 0,
            ],
            'recentTransactions' => $instansiId
                ? TransaksiZakat::with('kategori')
                    ->where('instansi_id', $instansiId)
                    ->latest('tanggal')
                    ->latest('id')
                    ->limit(5)
                    ->get()
                : collect(),
            'topWilayah' => $instansiId
                ? TransaksiZakat::query()
                    ->where('instansi_id', $instansiId)
                    ->whereNotNull('desa')
                    ->where('desa', '<>', '')
                    ->select('desa')
                    ->selectRaw('SUM(jumlah) as total')
                    ->selectRaw('COUNT(*) as total_transaksi')
                    ->groupBy('desa')
                    ->orderByDesc('total')
                    ->limit(3)
                    ->get()
                : collect(),
        ]);
    })->name('dashboard.admin');

    Route::get('/dashboard/superadmin', [AuthController::class, 'showSuperAdminDashboard'])
        ->name('dashboard.superadmin');

    Route::post('/dashboard/superadmin/approve/{user}', [AuthController::class, 'approveAdminInstansi'])
        ->name('superadmin.approve');
    Route::post('/dashboard/superadmin/reject/{user}', [AuthController::class, 'rejectAdminInstansi'])
        ->name('superadmin.reject');

    require __DIR__ . '/admin/profil-instansi.php';
    require __DIR__ . '/admin/kategori-dana.php';
    require __DIR__ . '/admin/pemasukan.php';
    require __DIR__ . '/admin/mustahik.php';
    require __DIR__ . '/admin/program-penyaluran.php';
    require __DIR__ . '/admin/pengaturan-distribusi.php';
    require __DIR__ . '/admin/penyaluran.php';
    require __DIR__ . '/admin/laporan.php';

    require __DIR__ . '/superadmin/approval-admin-instansi.php';
    require __DIR__ . '/superadmin/instansi.php';
    require __DIR__ . '/superadmin/pengguna.php';
    require __DIR__ . '/superadmin/harga-beras.php';
    require __DIR__ . '/superadmin/nishab.php';
    require __DIR__ . '/superadmin/approval-program-penyaluran.php';
    require __DIR__ . '/superadmin/monitoring.php';
});
