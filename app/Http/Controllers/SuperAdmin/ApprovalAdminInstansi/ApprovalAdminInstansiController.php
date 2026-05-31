<?php

namespace App\Http\Controllers\SuperAdmin\ApprovalAdminInstansi;

use App\Http\Controllers\Controller;
use App\Models\Instansi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalAdminInstansiController extends Controller
{
    public function index()
    {
        $pendingUsers = User::with('instansi')
            ->where('role', 'admin_instansi')
            ->where('status', 'pending')
            ->orderByDesc('created_at')
            ->get();

        return view('superadmin.approval-admin-instansi.approval-admin-instansi-index', compact('pendingUsers'));
    }

    public function show(User $user)
    {
        abort_if($user->role !== User::ROLE_ADMIN_INSTANSI || $user->status !== 'pending', 404);

        $user->load('instansi');

        return view('superadmin.approval-admin-instansi.approval-admin-instansi-show', [
            'user' => $user,
            'checklist' => $this->verificationChecklist($user),
        ]);
    }

    public function approve(Request $request, User $user)
    {
        abort_if($user->role !== User::ROLE_ADMIN_INSTANSI || $user->status !== 'pending', 404);

        $validated = $request->validate([
            'verified' => 'accepted',
            'verification_note' => 'nullable|string|max:1000',
        ], [
            'verified.accepted' => 'Centang konfirmasi verifikasi sebelum menyetujui akun.',
        ]);

        $missing = collect($this->verificationChecklist($user))
            ->where('ok', false)
            ->pluck('label')
            ->values();

        if ($missing->isNotEmpty()) {
            return back()
                ->withErrors(['verified' => 'Data verifikasi belum lengkap: ' . $missing->join(', ') . '.'])
                ->withInput();
        }

        DB::transaction(function () use ($user, $validated) {
            $instansi = $user->instansi;

            $instansi->update([
                'status' => 'aktif',
                'verified_by' => Auth::id(),
                'verified_at' => now(),
                'verification_note' => $validated['verification_note'] ?? null,
            ]);

            $user->update([
                'status' => 'active',
                'desa' => $instansi->kelurahan,
                'nama_instansi' => $instansi->nama,
            ]);
        });

        return redirect()
            ->route('superadmin.approval-admin-instansi.index')
            ->with('success', 'Akun instansi berhasil diverifikasi dan diaktifkan.');
    }

    public function reject(Request $request, User $user)
    {
        abort_if($user->role !== User::ROLE_ADMIN_INSTANSI || $user->status !== 'pending', 404);

        $validated = $request->validate([
            'verification_note' => 'required|string|min:8|max:1000',
        ], [
            'verification_note.required' => 'Catatan alasan penolakan wajib diisi.',
            'verification_note.min' => 'Catatan alasan penolakan minimal 8 karakter.',
        ]);

        DB::transaction(function () use ($user, $validated) {
            $user->load('instansi');

            $user->update(['status' => 'blocked']);

            if ($user->instansi) {
                $user->instansi->update([
                    'status' => 'nonaktif',
                    'verified_by' => Auth::id(),
                    'verified_at' => now(),
                    'verification_note' => $validated['verification_note'],
                ]);
            }
        });

        return redirect()
            ->route('superadmin.approval-admin-instansi.index')
            ->with('success', 'Pengajuan akun instansi ditolak.');
    }

    private function verificationChecklist(User $user): array
    {
        $user->loadMissing('instansi');

        /** @var Instansi|null $instansi */
        $instansi = $user->instansi;

        return [
            ['label' => 'Profil instansi terhubung', 'ok' => (bool) $instansi],
            ['label' => 'Nama instansi', 'ok' => filled($instansi?->nama)],
            ['label' => 'Tipe lembaga', 'ok' => filled($instansi?->tipe)],
            ['label' => 'Desa wilayah kerja', 'ok' => filled($instansi?->kelurahan)],
            ['label' => 'Alamat lengkap', 'ok' => filled($instansi?->alamat)],
            ['label' => 'Kontak aktif', 'ok' => filled($instansi?->kontak)],
            ['label' => 'Email resmi/admin', 'ok' => filled($instansi?->email) && $instansi?->email === $user->email],
            ['label' => 'Nomor SK/izin lembaga', 'ok' => filled($instansi?->nomor_sk)],
            ['label' => 'Masa berlaku SK masih aktif', 'ok' => $instansi?->masa_berlaku && $instansi->masa_berlaku->toDateString() >= now()->toDateString()],
            ['label' => 'Nama pimpinan/penanggung jawab', 'ok' => filled($instansi?->nama_pimpinan)],
        ];
    }
}
