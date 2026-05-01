<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showAuthForm()
    {
        $desaOptions = [
            'Desa Soreang',
            'Desa Cangkuang',
            'Desa Cikeruh',
            'Desa Ciwidey',
            'Desa Margahayu',
        ];

        return view('auth', compact('desaOptions'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'desa' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users,email',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:8',
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

        return redirect()->route('auth')->with('success', 'Registrasi berhasil. Akun Anda menunggu persetujuan super admin.');
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

        return view('dashboard.superadmin', compact('pendingUsers'));
    }

    public function approveAdminInstansi(User $user)
    {
        if ($user->role !== 'admin_instansi' || $user->status !== 'pending') {
            abort(404);
        }

        $user->update(['status' => 'active']);

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

        return redirect()->route('auth');
    }
}
