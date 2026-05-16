<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return view('public.landing');
    }

    public function showAuthForm()
    {
        return redirect()->route('login');
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
            'desa' => ['required', 'string', 'max:100', Rule::in($this->desaOptions())],
            'email' => 'required|email|max:255|unique:users,email',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['nama_instansi'],
            'nama_instansi' => $validated['nama_instansi'],
            'desa' => $validated['desa'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin_instansi',
            'status' => 'pending',
        ]);

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

        return redirect()->route('dashboard.admin');
    }

    public function showSuperAdminDashboard()
    {
        $pendingUsers = User::where('role', 'admin_instansi')
            ->where('status', 'pending')
            ->orderByDesc('created_at')
            ->get();

        return view('superadmin.approval-admin-instansi.approval-admin-instansi-index', compact('pendingUsers'));
    }

    public function approveAdminInstansi(User $user)
    {
        if ($user->role !== 'admin_instansi' || $user->status !== 'pending') {
            abort(404);
        }

        $instansi = $user->instansi;

        if (! $instansi) {
            $instansi = Instansi::query()->create([
                'nama' => $user->nama_instansi ?: $user->name,
                'kelurahan' => $user->desa,
                'email' => $user->email,
                'status' => 'aktif',
            ]);
        }

        $user->update([
            'instansi_id' => $instansi->id,
            'status' => 'active',
        ]);

        return redirect()->route('dashboard.superadmin')->with('success', 'Akun instansi berhasil disetujui.');
    }

    public function rejectAdminInstansi(User $user)
    {
        if ($user->role !== 'admin_instansi' || $user->status !== 'pending') {
            abort(404);
        }

        $user->update(['status' => 'blocked']);

        return redirect()->route('dashboard.superadmin')->with('success', 'Akun instansi berhasil ditolak.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('public.home');
    }
}
