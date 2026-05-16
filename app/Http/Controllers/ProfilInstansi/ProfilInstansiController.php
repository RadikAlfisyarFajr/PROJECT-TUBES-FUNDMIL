<?php

namespace App\Http\Controllers\ProfilInstansi;

use App\Models\Instansi;
use App\Models\ProfilInstansiNotification;
use App\Models\RekeningInstansi;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfilInstansiController extends Controller
{
    public function index()
    {
        $instansi = $this->resolveInstansi();
        $instansi->load('rekening');
        $notifications = $instansi->profilNotifications()
            ->latest()
            ->limit(10)
            ->get();
        $unreadNotifications = $instansi->profilNotifications()
            ->whereNull('read_at')
            ->count();

        return view('admin.profil-instansi.profil-instansi-index', compact(
            'instansi',
            'notifications',
            'unreadNotifications'
        ));
    }

    public function create()
    {
        return view('admin.profil-instansi.profil-instansi-create');
    }

    public function store(Request $request)
    {
        return $this->update($request, '0');
    }

    public function show(string $id)
    {
        return view('admin.profil-instansi.profil-instansi-show', compact('id'));
    }

    public function edit(string $id)
    {
        $instansi = $this->resolveInstansi($id);

        return view('admin.profil-instansi.profil-instansi-edit', compact('instansi'));
    }

    public function update(Request $request, string $id)
    {
        $instansi = $this->resolveInstansi($id);
        /** @var User|null $user */
        $user = Auth::user();
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'tipe' => ['nullable', 'string', 'max:100'],
            'kontak' => ['nullable', 'string', 'max:30'],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],
            'alamat' => ['nullable', 'string'],
            'nomor_sk' => ['nullable', 'string', 'max:255'],
            'masa_berlaku' => ['nullable', 'date'],
            'nama_pimpinan' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'tanda_tangan' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ]);

        $this->replaceUploadedFile($request, $validated, $instansi, 'logo', 'profil-instansi/logo');
        $this->replaceUploadedFile($request, $validated, $instansi, 'tanda_tangan', 'profil-instansi/tanda-tangan');

        $instansi->update($validated);
        $this->syncAuthenticatedUserEmail($instansi, $validated['email'] ?? null);
        $this->recordNotification(
            $instansi,
            'Profil instansi diperbarui',
            'Informasi profil, foto profil, atau tanda tangan digital baru saja diperbarui.',
            'profile'
        );

        return redirect()
            ->route('profil-instansi.index')
            ->with('success', 'Profil instansi berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $instansi = $this->resolveInstansi($id);
        $instansi->delete();

        return redirect()
            ->route('profil-instansi.index')
            ->with('success', 'Profil instansi berhasil dihapus.');
    }

    public function storeRekening(Request $request)
    {
        $instansi = $this->resolveInstansi();
        $validated = $this->validateRekening($request);

        $instansi->rekening()->create($validated);
        $this->recordNotification(
            $instansi,
            'Rekening ditambahkan',
            "Rekening {$validated['nama_bank']} berhasil ditambahkan.",
            'rekening'
        );

        return redirect()
            ->route('profil-instansi.index')
            ->with('success', 'Rekening berhasil ditambahkan.');
    }

    public function updateRekening(Request $request, RekeningInstansi $rekening)
    {
        $this->authorizeRekening($rekening);
        $validated = $this->validateRekening($request);
        $rekening->update($validated);
        $this->recordNotification(
            $rekening->instansi,
            'Rekening diperbarui',
            "Data rekening {$validated['nama_bank']} berhasil diperbarui.",
            'rekening'
        );

        return redirect()
            ->route('profil-instansi.index')
            ->with('success', 'Rekening berhasil diperbarui.');
    }

    public function destroyRekening(RekeningInstansi $rekening)
    {
        $this->authorizeRekening($rekening);
        $instansi = $rekening->instansi;
        $namaBank = $rekening->nama_bank;
        $rekening->delete();
        $this->recordNotification(
            $instansi,
            'Rekening dihapus',
            "Rekening {$namaBank} berhasil dihapus.",
            'rekening'
        );

        return redirect()
            ->route('profil-instansi.index')
            ->with('success', 'Rekening berhasil dihapus.');
    }

    public function markNotificationsRead()
    {
        $instansi = $this->resolveInstansi();

        $instansi->profilNotifications()
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->noContent();
    }

    private function resolveInstansi(?string $id = null): Instansi
    {
        /** @var User|null $user */
        $user = Auth::user();

        if ($user?->isAdminInstansi()) {
            if (! $user->instansi_id || ! Instansi::query()->whereKey($user->instansi_id)->exists()) {
                $instansi = Instansi::query()->create([
                    'nama' => $user->nama_instansi ?: $user->name,
                    'kelurahan' => $user->desa,
                    'email' => $user->email,
                    'status' => 'aktif',
                ]);

                $user->forceFill(['instansi_id' => $instansi->id])->save();

                return $instansi;
            }

            return Instansi::query()->findOrFail($user->instansi_id);
        }

        if ($id && $id !== '0') {
            return Instansi::query()->findOrFail($id);
        }

        return Instansi::query()->firstOrFail();
    }

    private function validateRekening(Request $request): array
    {
        return $request->validate([
            'nama_bank' => ['required', 'string', 'max:255'],
            'nomor_rekening' => ['required', 'string', 'max:100'],
            'nama_pemilik' => ['required', 'string', 'max:255'],
        ]);
    }

    private function syncAuthenticatedUserEmail(Instansi $instansi, ?string $email): void
    {
        if (! $email) {
            return;
        }

        /** @var User|null $user */
        $user = Auth::user();

        if (! $user?->isAdminInstansi() || $user->instansi_id !== $instansi->id) {
            return;
        }

        if ($user->email === $email) {
            return;
        }

        $user->forceFill(['email' => $email])->save();
    }

    private function authorizeRekening(RekeningInstansi $rekening): void
    {
        $instansi = $this->resolveInstansi();

        abort_unless($rekening->instansi_id === $instansi->id, 403);
    }

    private function replaceUploadedFile(
        Request $request,
        array &$validated,
        Instansi $instansi,
        string $field,
        string $directory
    ): void {
        if (! $request->hasFile($field)) {
            unset($validated[$field]);
            return;
        }

        if ($instansi->{$field}) {
            Storage::disk('public')->delete($instansi->{$field});
        }

        $validated[$field] = $request->file($field)->store($directory, 'public');
    }

    private function recordNotification(Instansi $instansi, string $title, string $message, string $type = 'info'): void
    {
        ProfilInstansiNotification::query()->create([
            'instansi_id' => $instansi->id,
            'title' => $title,
            'message' => $message,
            'type' => $type,
        ]);
    }
}
