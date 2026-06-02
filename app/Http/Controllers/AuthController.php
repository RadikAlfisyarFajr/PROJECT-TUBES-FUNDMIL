<?php

namespace App\Http\Controllers;

use App\Models\Mustahik;
use App\Models\PenyaluranDetail;
use App\Models\TransaksiZakat;
use App\Models\Instansi;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    private function desaOptions(): array
    {
        return [
            'Desa Cingcin',
            'Desa Soreang',
            'Desa Pamekaran',
            'Desa Sekarwangi',
            'Desa Parungserab',
            'Desa Karamatmulya',
            'Desa Sukapura',
            'Desa Sadu',
            'Desa Buninagara',
            'Desa Cahaya Maju',
        ];
    }

    public function showLandingPage()
    {
        $payload = $this->publicZisPayload();

        if (request()->filled('nik') && (request()->boolean('lookup') || request()->expectsJson())) {
            return response()->json($this->publicNikPayload((string) request()->string('nik')))
                ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        }

        if (request()->expectsJson() || request()->boolean('stats')) {
            return response()->json($payload)
                ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        }

        return view('public.landing', $payload);
    }

    public function publicZisStats(): JsonResponse
    {
        return response()->json($this->publicZisPayload())
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    public function showAuthForm()
    {
        return redirect()->route('login');
    }

    public function showAdminDashboard()
    {
        $user = Auth::user();

        if ($user instanceof User && $user->role === User::ROLE_ADMIN_KEPALA_DESA) {
            return redirect()->route('kepala-desa.dashboard');
        }

        if (! $user instanceof User || $user->role !== 'admin_instansi') {
            abort(403, 'Unauthorized');
        }

        $user->load('instansi');
        $instansiId = $user->instansi_id;
        $hargaBeras = (float) (DB::table('harga_beras')
            ->where('tanggal_berlaku', '<=', now()->toDateString())
            ->where(fn ($query) => $query
                ->whereNull('tanggal_berakhir')
                ->orWhere('tanggal_berakhir', '>=', now()->toDateString()))
            ->orderByDesc('tanggal_berlaku')
            ->value('harga_per_kg') ?? 0);
        $nishabMaal = (float) (DB::table('nishab')
            ->whereIn('jenis_zakat', ['zakat_maal', 'zakat mal', 'zakat maal', 'maal', 'mal'])
            ->where('tanggal_berlaku', '<=', now()->toDateString())
            ->where(fn ($query) => $query
                ->whereNull('tanggal_berakhir')
                ->orWhere('tanggal_berakhir', '>=', now()->toDateString()))
            ->orderByDesc('tanggal_berlaku')
            ->value('nishab_rupiah') ?? 0);
        $totalPengumpulan = $instansiId
            ? (float) TransaksiZakat::where('instansi_id', $instansiId)->sum('jumlah')
            : 0;
        $totalTersalurkan = $instansiId
            ? (float) PenyaluranDetail::whereHas('penyaluran', fn($query) => $query
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
                    ? PenyaluranDetail::whereHas('penyaluran', fn($query) => $query
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
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetPasswordLink(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'Email tidak ditemukan pada sistem.',
        ]);

        try {
            $status = Password::sendResetLink($validated);
        } catch (\Throwable $exception) {
            Log::error('Gagal mengirim email reset password.', [
                'email' => $validated['email'],
                'exception' => $exception::class,
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);

            $debugMessage = app()->environment('local')
                ? ' Detail SMTP: ' . $exception->getMessage()
                : '';

            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email reset password gagal dikirim. Periksa konfigurasi SMTP.' . $debugMessage]);
        }

        if ($status !== Password::RESET_LINK_SENT) {
            Log::warning('Password reset link tidak terkirim.', [
                'email' => $validated['email'],
                'status' => $status,
            ]);

            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
        }

        return back()->with('success', 'Link reset password sudah dikirim ke email Anda.');
    }

    public function showResetPasswordForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'token' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.exists' => 'Email tidak ditemukan pada sistem.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $status = Password::reset($validated, function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($user));
        });

        if ($status !== Password::PASSWORD_RESET) {
            return back()
                ->withErrors(['email' => 'Link reset password tidak valid atau sudah kedaluwarsa.'])
                ->withInput($request->only('email'));
        }

        return redirect()
            ->route('login')
            ->with('success', 'Password berhasil direset. Silakan login dengan password baru.');
    }

    public function showRegisterForm()
    {
        return view('auth.register', [
            'desaOptions' => $this->desaOptions(),
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'tipe' => ['required', 'string', Rule::in(['Masjid', 'UPZ', 'Lembaga Amil Zakat'])],
            'desa' => ['required', 'string', 'max:100', Rule::in($this->desaOptions())],
            'alamat' => 'required|string|min:10|max:1000',
            'kontak' => ['required', 'string', 'max:30', 'regex:/^[0-9+\-\s()]+$/'],
            'nomor_sk' => 'required|string|min:5|max:100',
            'masa_berlaku' => 'required|date|after_or_equal:today',
            'nama_pimpinan' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email|unique:instansi,email',
            'username' => 'required|string|max:50|alpha_dash|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'kontak.regex' => 'Kontak hanya boleh berisi angka, spasi, tanda +, tanda -, dan kurung.',
            'masa_berlaku.after_or_equal' => 'Masa berlaku SK tidak boleh sudah kedaluwarsa.',
        ]);

        DB::transaction(function () use ($validated) {
            $instansi = Instansi::query()->create([
                'nama' => $validated['nama_instansi'],
                'tipe' => $validated['tipe'],
                'kelurahan' => $validated['desa'],
                'alamat' => $validated['alamat'],
                'status' => 'pending',
                'kontak' => $validated['kontak'],
                'email' => $validated['email'],
                'nomor_sk' => $validated['nomor_sk'],
                'masa_berlaku' => $validated['masa_berlaku'],
                'nama_pimpinan' => $validated['nama_pimpinan'],
            ]);

            User::create([
                'name' => $validated['nama_pimpinan'],
                'nama_instansi' => $validated['nama_instansi'],
                'desa' => $validated['desa'],
                'email' => $validated['email'],
                'username' => $validated['username'],
                'password' => Hash::make($validated['password']),
                'instansi_id' => $instansi->id,
                'role' => 'admin_instansi',
                'status' => 'pending',
            ]);
        });

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Akun Anda menunggu persetujuan super admin.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string|max:50',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('username', $credentials['username'])->first();

        if (! $user) {
            return back()->withErrors(['username' => 'Username tidak ditemukan.'])->withInput();
        }

        if (! Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['username' => 'Username atau password salah.'])->withInput();
        }

        if ($user->status === 'pending') {
            return back()->withErrors(['username' => 'Akun Anda menunggu persetujuan super admin.'])->withInput();
        }

        if ($user->status === 'blocked') {
            return back()->withErrors(['username' => 'Akun Anda tidak aktif atau ditolak.'])->withInput();
        }

        Auth::login($user, $request->boolean('remember'));

        if ($user->role === 'super_admin') {
            return redirect()->route('dashboard.superadmin');
        }

        if ($user->role === User::ROLE_ADMIN_KEPALA_DESA) {
            return redirect()->route('kepala-desa.dashboard');
        }

        return redirect()->route('dashboard.admin');
    }

    public function showSuperAdminDashboard()
    {
        $user = Auth::user();

        if (! $user instanceof User || $user->role !== 'super_admin') {
            abort(403, 'Unauthorized');
        }

        $instansi = Instansi::query()
            ->where('status', 'aktif')
            ->where(function ($query) {
                $query->whereNull('tipe')
                    ->orWhere('tipe', '<>', 'Akun Resmi Desa');
            })
            ->orderBy('kelurahan')
            ->orderBy('nama')
            ->get();

        $pengumpulan = TransaksiZakat::query()
            ->select('instansi_id')
            ->selectRaw('SUM(jumlah) as total')
            ->selectRaw('COUNT(*) as transaksi')
            ->groupBy('instansi_id')
            ->get()
            ->keyBy('instansi_id');

        $penyaluran = PenyaluranDetail::query()
            ->join('penyaluran', 'penyaluran.id', '=', 'penyaluran_detail.penyaluran_id')
            ->where('penyaluran.status', 'selesai')
            ->select('penyaluran.instansi_id')
            ->selectRaw('SUM(penyaluran_detail.jumlah_diterima) as total')
            ->groupBy('penyaluran.instansi_id')
            ->get()
            ->keyBy('instansi_id');

        $rows = $instansi->map(function (Instansi $item) use ($pengumpulan, $penyaluran) {
            $totalPengumpulan = (float) ($pengumpulan[$item->id]->total ?? 0);
            $totalPenyaluran = (float) ($penyaluran[$item->id]->total ?? 0);

            return [
                'id' => $item->id,
                'nama' => $item->nama,
                'desa' => $item->kelurahan ?: '-',
                'tipe' => $item->tipe ?: '-',
                'pengumpulan' => $totalPengumpulan,
                'penyaluran' => $totalPenyaluran,
                'saldo' => max(0, $totalPengumpulan - $totalPenyaluran),
                'transaksi' => (int) ($pengumpulan[$item->id]->transaksi ?? 0),
            ];
        })->sortByDesc('pengumpulan')->values();

        $latestHargaBeras = DB::table('harga_beras')
            ->where('tanggal_berlaku', '<=', now()->toDateString())
            ->where(fn ($query) => $query
                ->whereNull('tanggal_berakhir')
                ->orWhere('tanggal_berakhir', '>=', now()->toDateString()))
            ->orderByDesc('tanggal_berlaku')
            ->first();

        $latestNishab = DB::table('nishab')
            ->whereIn('jenis_zakat', ['zakat_maal', 'zakat mal', 'zakat maal', 'maal', 'mal'])
            ->where('tanggal_berlaku', '<=', now()->toDateString())
            ->where(fn ($query) => $query
                ->whereNull('tanggal_berakhir')
                ->orWhere('tanggal_berakhir', '>=', now()->toDateString()))
            ->orderByDesc('tanggal_berlaku')
            ->first();

        return view('dashboard.superadmin', [
            'summary' => [
                'instansiAktif' => $instansi->count(),
                'pendingApproval' => User::where('role', 'admin_instansi')->where('status', 'pending')->count(),
                'totalPengumpulan' => $rows->sum('pengumpulan'),
                'totalPenyaluran' => $rows->sum('penyaluran'),
                'totalSaldo' => $rows->sum('saldo'),
                'hargaBeras' => (float) ($latestHargaBeras->harga_per_kg ?? 0),
                'nishabMaal' => (float) ($latestNishab->nishab_rupiah ?? 0),
            ],
            'rows' => $rows,
            'chartRows' => $rows->take(8)->values(),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('public.home');
    }

    private function publicZisPayload(): array
    {
        $totalDanaMasuk = (float) TransaksiZakat::sum('jumlah');
        $totalTransaksi = TransaksiZakat::count();
        $totalInstansiAktif = Instansi::where('status', 'aktif')->count();
        $totalPenerima = (int) PenyaluranDetail::whereHas('penyaluran', fn ($query) => $query->where('status', 'selesai'))
            ->where('status_penerimaan', '!=', 'ditolak')
            ->count();
        $totalDanaTersalur = (float) PenyaluranDetail::whereHas('penyaluran', fn ($query) => $query->where('status', 'selesai'))
            ->sum('jumlah_diterima');
        $saldoTersedia = max(0, $totalDanaMasuk - $totalDanaTersalur);
        $instansiComparison = Instansi::query()
            ->where('instansi.status', 'aktif')
            ->leftJoinSub(
                TransaksiZakat::query()
                    ->join('users', 'transaksi_zakat.admin_id', '=', 'users.id')
                    ->select('transaksi_zakat.instansi_id')
                    ->selectRaw('COALESCE(SUM(jumlah), 0) as total_dana')
                    ->selectRaw('COUNT(*) as total_transaksi')
                    ->where('users.role', User::ROLE_ADMIN_INSTANSI)
                    ->groupBy('transaksi_zakat.instansi_id'),
                'rekap_zakat',
                'instansi.id',
                '=',
                'rekap_zakat.instansi_id'
            )
            ->select('instansi.id', 'instansi.nama', 'instansi.kelurahan')
            ->selectRaw('COALESCE(rekap_zakat.total_dana, 0) as total_dana')
            ->selectRaw('COALESCE(rekap_zakat.total_transaksi, 0) as total_transaksi')
            ->orderByDesc('total_dana')
            ->orderBy('instansi.nama')
            ->get()
            ->map(function ($instansi) {
                return [
                    'id' => $instansi->id,
                    'nama' => $instansi->nama,
                    'desa' => $instansi->kelurahan ?: '-',
                    'totalDana' => (float) $instansi->total_dana,
                    'totalTransaksi' => (int) $instansi->total_transaksi,
                ];
            })
            ->values();

        $desaHeatmap = Instansi::query()
            ->where('instansi.status', 'aktif')
            ->whereNotNull('instansi.kelurahan')
            ->where('instansi.kelurahan', '<>', '')
            ->leftJoinSub(
                TransaksiZakat::query()
                    ->join('users', 'transaksi_zakat.admin_id', '=', 'users.id')
                    ->select('transaksi_zakat.instansi_id')
                    ->selectRaw('COALESCE(SUM(jumlah), 0) as total_dana')
                    ->selectRaw('COUNT(*) as total_transaksi')
                    ->where('users.role', User::ROLE_ADMIN_INSTANSI)
                    ->groupBy('transaksi_zakat.instansi_id'),
                'rekap_zakat',
                'instansi.id',
                '=',
                'rekap_zakat.instansi_id'
            )
            ->selectRaw('instansi.kelurahan as desa')
            ->selectRaw('COALESCE(SUM(rekap_zakat.total_dana), 0) as total_dana')
            ->selectRaw('COALESCE(SUM(rekap_zakat.total_transaksi), 0) as total_transaksi')
            ->selectRaw('COUNT(DISTINCT instansi.id) as total_instansi')
            ->groupBy('instansi.kelurahan')
            ->orderByDesc('total_dana')
            ->orderBy('instansi.kelurahan')
            ->get()
            ->map(function ($desa) {
                return [
                    'desa' => $desa->desa,
                    'totalDana' => (float) $desa->total_dana,
                    'totalTransaksi' => (int) $desa->total_transaksi,
                    'totalInstansi' => (int) $desa->total_instansi,
                ];
            })
            ->values();

        return [
            'summary' => [
                'totalDanaMasuk' => $totalDanaMasuk,
                'totalTransaksi' => $totalTransaksi,
                'totalInstansiAktif' => $totalInstansiAktif,
                'totalPenerima' => $totalPenerima,
                'totalDanaTersalur' => $totalDanaTersalur,
                'saldoTersedia' => $saldoTersedia,
                'lastUpdated' => now()->format('d M Y H:i:s'),
            ],
            'instansiComparison' => $instansiComparison,
            'desaHeatmap' => $desaHeatmap,
        ];
    }

    private function publicNikPayload(string $nik): array
    {
        $normalizedNik = preg_replace('/\D+/', '', $nik) ?? '';
        $mustahik = Mustahik::query()
            ->with('instansi')
            ->where('nik', $normalizedNik)
            ->first();

        if (! $mustahik) {
            return [
                'found' => false,
                'message' => 'NIK tidak ditemukan pada data mustahik publik.',
            ];
        }

        $statusLabel = $mustahik->status === 'aktif' ? 'Aktif' : 'Tidak Aktif';
        $historyDate = $mustahik->tanggal_verifikasi
            ?? $mustahik->created_at
            ?? now();
        $historyYears = max(0, (int) floor($historyDate->diffInDays(now()) / 365));
        $historyText = $mustahik->status === 'aktif'
            ? ($historyYears > 0
                ? "Telah aktif menerima bantuan selama kurang lebih {$historyYears} tahun."
                : 'Telah aktif menerima bantuan dan tercatat di sistem.')
            : 'Belum aktif menerima bantuan saat ini.';

        return [
            'found' => true,
            'status' => $mustahik->status,
            'status_label' => $statusLabel,
            'nama' => $mustahik->nama,
            'nik' => $mustahik->nik,
            'alamat' => $mustahik->alamat,
            'kategori' => $mustahik->kategori_label,
            'instansi' => $mustahik->instansi?->nama ?: '-',
            'desa' => $mustahik->instansi?->kelurahan ?: '-',
            'history' => $historyText,
            'tanggal_verifikasi' => optional($mustahik->tanggal_verifikasi)->format('d M Y') ?: '-',
        ];
    }
}
