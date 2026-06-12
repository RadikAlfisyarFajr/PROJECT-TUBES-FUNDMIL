<?php

namespace App\Http\Controllers\ProfilInstansi;

use App\Models\Instansi;
use App\Models\ProfilInstansiNotification;
use App\Models\RekeningInstansi;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Support\OfficialVillageAccount;
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
            'nama' => ['nullable', 'string', 'max:255', 'regex:/\pL/u'],
            'tipe' => ['nullable', 'string', 'max:100', Rule::in(['Masjid', 'Mushola', 'Lembaga Amil', 'Yayasan', 'Lainnya'])],
            'kontak' => ['nullable', 'string', 'max:30', 'regex:/^(?:\+62|62|0)8[1-9][0-9]{6,10}$/'],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],
            'kelurahan' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'nomor_sk' => ['nullable', 'string', 'max:255'],
            'masa_berlaku' => ['nullable', 'date'],
            'nama_pimpinan' => ['nullable', 'string', 'max:255', 'regex:/\pL/u'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'tanda_tangan' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ], [
            'nama.regex' => 'Nama instansi harus menggunakan abjad, tidak boleh hanya angka.',
            'kontak.regex' => 'Nomor WhatsApp harus valid, diawali 08, 62, atau +62, dan tidak boleh berisi huruf.',
            'nama_pimpinan.regex' => 'Nama Ketua/DKM harus menggunakan abjad, tidak boleh hanya angka.',
        ]);

        $validated = $this->onlyFilledProfileFields($request, $validated);
        $this->replaceUploadedFile($request, $validated, $instansi, 'logo', 'profil-instansi/logo');
        $this->replaceUploadedFile($request, $validated, $instansi, 'tanda_tangan', 'profil-instansi/tanda-tangan');

        if (array_key_exists('kelurahan', $validated)) {
            $validated['kelurahan'] = OfficialVillageAccount::normalizeVillageName($validated['kelurahan']);
        }

        if ($validated !== []) {
            $instansi->update($validated);
        }

        $this->syncAuthenticatedUserProfile($instansi, $validated['email'] ?? null, $validated['kelurahan'] ?? null);
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
                    'kelurahan' => OfficialVillageAccount::normalizeVillageName($user->desa),
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
            'nama_bank' => ['required', 'string', 'max:255', 'regex:/\pL/u'],
            'nomor_rekening' => ['required', 'string', 'regex:/^[0-9]{6,30}$/'],
            'nama_pemilik' => ['required', 'string', 'max:255', 'regex:/\pL/u'],
        ], [
            'nama_bank.regex' => 'Nama rekening harus menggunakan abjad, tidak boleh hanya angka.',
            'nomor_rekening.regex' => 'Nomor rekening harus hanya berisi angka sebanyak 6 sampai 30 digit.',
            'nama_pemilik.regex' => 'Nama pemilik harus menggunakan abjad, tidak boleh hanya angka.',
        ]);
    }

    private function onlyFilledProfileFields(Request $request, array $validated): array
    {
        foreach ([
            'nama',
            'tipe',
            'kontak',
            'email',
            'kelurahan',
            'alamat',
            'nomor_sk',
            'masa_berlaku',
            'nama_pimpinan',
        ] as $field) {
            if (! $request->filled($field)) {
                unset($validated[$field]);
            }
        }

        return $validated;
    }

    private function syncAuthenticatedUserProfile(Instansi $instansi, ?string $email, ?string $desa): void
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (! $user?->isAdminInstansi() || $user->instansi_id !== $instansi->id) {
            return;
        }

        $payload = [];

        if ($email && $user->email !== $email) {
            $payload['email'] = $email;
        }

        if ($desa && $user->desa !== $desa) {
            $payload['desa'] = $desa;
        }

        if ($payload === []) {
            return;
        }

        $user->forceFill($payload)->save();
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
