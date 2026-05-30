<?php

namespace App\Http\Controllers\SuperAdmin\Instansi;

use App\Http\Controllers\Controller;
use App\Models\Instansi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class InstansiController extends Controller
{
    private const OFFICIAL_TYPE = 'Akun Resmi Desa';

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

    public function index()
    {
        $officialAccounts = Instansi::with('users')
            ->where('tipe', self::OFFICIAL_TYPE)
            ->orderBy('kelurahan')
            ->get();

        $verifiedInstansi = Instansi::with('users')
            ->where('status', 'aktif')
            ->where(function ($query) {
                $query->whereNull('tipe')->orWhere('tipe', '<>', self::OFFICIAL_TYPE);
            })
            ->orderBy('kelurahan')
            ->orderBy('nama')
            ->get();

        return view('superadmin.instansi.instansi-index', [
            'officialAccounts' => $officialAccounts,
            'verifiedInstansi' => $verifiedInstansi,
            'desaOptions' => $this->desaOptions(),
        ]);
    }

    public function create()
    {
        return view('superadmin.instansi.instansi-create', [
            'desaOptions' => $this->desaOptions(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'desa' => ['required', Rule::in($this->desaOptions())],
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:1000',
            'kontak' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+\-\s()]+$/'],
            'email' => 'required|email|max:255|unique:users,email|unique:instansi,email',
            'username' => 'required|string|max:50|alpha_dash|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
            'nama_pimpinan' => 'required|string|max:255',
        ], [
            'kontak.regex' => 'Kontak hanya boleh berisi angka, spasi, tanda +, tanda -, dan kurung.',
        ]);

        $exists = Instansi::query()
            ->where('tipe', self::OFFICIAL_TYPE)
            ->where('kelurahan', $validated['desa'])
            ->whereIn('status', ['pending', 'aktif'])
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['desa' => 'Desa ini sudah memiliki akun resmi aktif atau pending.'])
                ->withInput();
        }

        DB::transaction(function () use ($validated) {
            $instansi = Instansi::query()->create([
                'nama' => $validated['nama'],
                'tipe' => self::OFFICIAL_TYPE,
                'kelurahan' => $validated['desa'],
                'alamat' => $validated['alamat'] ?? null,
                'status' => 'aktif',
                'kontak' => $validated['kontak'] ?? null,
                'email' => $validated['email'],
                'nama_pimpinan' => $validated['nama_pimpinan'],
                'verified_by' => auth()->id(),
                'verified_at' => now(),
                'verification_note' => 'Akun resmi desa dibuat terpusat oleh Super Admin.',
            ]);

            User::query()->create([
                'name' => $validated['nama_pimpinan'],
                'nama_instansi' => $validated['nama'],
                'desa' => $validated['desa'],
                'email' => $validated['email'],
                'username' => $validated['username'],
                'password' => Hash::make($validated['password']),
                'instansi_id' => $instansi->id,
                'role' => User::ROLE_ADMIN_KEPALA_DESA,
                'status' => 'active',
            ]);
        });

        return redirect()
            ->route('superadmin.instansi.index')
            ->with('success', 'Akun Kepala Desa berhasil dibuat.');
    }

    public function edit(Instansi $instansi)
    {
        $instansi->load('users');

        return view('superadmin.instansi.instansi-edit', [
            'instansi' => $instansi,
            'admin' => $instansi->users->firstWhere('role', User::ROLE_ADMIN_KEPALA_DESA),
            'desaOptions' => $this->desaOptions(),
        ]);
    }

    public function update(Request $request, Instansi $instansi)
    {
        $admin = $instansi->users()->where('role', User::ROLE_ADMIN_KEPALA_DESA)->first();

        $validated = $request->validate([
            'desa' => ['required', Rule::in($this->desaOptions())],
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:1000',
            'kontak' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+\-\s()]+$/'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('instansi', 'email')->ignore($instansi->id),
                Rule::unique('users', 'email')->ignore($admin?->id),
            ],
            'username' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique('users', 'username')->ignore($admin?->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'nama_pimpinan' => 'required|string|max:255',
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ], [
            'kontak.regex' => 'Kontak hanya boleh berisi angka, spasi, tanda +, tanda -, dan kurung.',
        ]);

        $exists = Instansi::query()
            ->whereKeyNot($instansi->id)
            ->where('tipe', self::OFFICIAL_TYPE)
            ->where('kelurahan', $validated['desa'])
            ->whereIn('status', ['pending', 'aktif'])
            ->exists();

        if ($instansi->tipe === self::OFFICIAL_TYPE && $exists) {
            return back()
                ->withErrors(['desa' => 'Desa ini sudah memiliki akun resmi aktif atau pending.'])
                ->withInput();
        }

        DB::transaction(function () use ($instansi, $admin, $validated) {
            $instansi->update([
                'nama' => $validated['nama'],
                'kelurahan' => $validated['desa'],
                'alamat' => $validated['alamat'] ?? null,
                'status' => $validated['status'],
                'kontak' => $validated['kontak'] ?? null,
                'email' => $validated['email'],
                'nama_pimpinan' => $validated['nama_pimpinan'],
            ]);

            if ($admin) {
                $payload = [
                    'name' => $validated['nama_pimpinan'],
                    'nama_instansi' => $validated['nama'],
                    'desa' => $validated['desa'],
                    'email' => $validated['email'],
                    'username' => $validated['username'],
                    'status' => $validated['status'] === 'aktif' ? 'active' : 'blocked',
                ];

                if (! empty($validated['password'])) {
                    $payload['password'] = Hash::make($validated['password']);
                }

                $admin->update($payload);
            }
        });

        return redirect()
            ->route('superadmin.instansi.index')
            ->with('success', 'Akun Kepala Desa berhasil diperbarui.');
    }

    public function destroy(Instansi $instansi)
    {
        DB::transaction(function () use ($instansi) {
            $instansi->update(['status' => 'nonaktif']);
            $instansi->users()->where('role', User::ROLE_ADMIN_KEPALA_DESA)->update(['status' => 'blocked']);
        });

        return redirect()
            ->route('superadmin.instansi.index')
            ->with('success', 'Akun desa berhasil dinonaktifkan.');
    }
}
