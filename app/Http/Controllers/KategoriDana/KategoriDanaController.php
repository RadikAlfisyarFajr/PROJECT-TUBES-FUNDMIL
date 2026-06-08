<?php

namespace App\Http\Controllers\KategoriDana;

use App\Http\Controllers\Controller;
use App\Models\Instansi;
use App\Models\KategoriDana;
use App\Models\ProfilInstansiNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriDanaController extends Controller
{
    public function index()
    {
        $instansi = $this->resolveInstansi();
        $categories = $this->syncDefaultCategories($instansi);
        $categoryCards = $this->categoryCards($categories);
        $notifications = $instansi->profilNotifications()
            ->where('type', 'kategori_dana')
            ->latest()
            ->limit(10)
            ->get();
        $unreadNotifications = $instansi->profilNotifications()
            ->where('type', 'kategori_dana')
            ->whereNull('read_at')
            ->count();

        return view('admin.kategori-dana.kategori-dana-index', compact(
            'categoryCards',
            'instansi',
            'notifications',
            'unreadNotifications'
        ));
    }

    public function create()
    {
        return view('admin.kategori-dana.kategori-dana-create');
    }

    public function store(Request $request)
    {
        // TODO: Validasi dan simpan data kategori dana.
    }

    public function show(string $id)
    {
        return view('admin.kategori-dana.kategori-dana-show', compact('id'));
    }

    public function edit(string $id)
    {
        return view('admin.kategori-dana.kategori-dana-edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        $instansi = $this->resolveInstansi();
        $categories = $this->syncDefaultCategories($instansi);
        $activeParentIds = collect($request->input('categories', []))
            ->map(fn ($value) => (int) $value)
            ->all();

        $categories->each(function (KategoriDana $category) use ($activeParentIds) {
            $isActive = in_array($category->id, $activeParentIds, true);

            $category->update(['is_active' => $isActive]);
            $category->children()->update(['is_active' => $isActive]);
        });
        $activeNames = $categories
            ->filter(fn (KategoriDana $category) => in_array($category->id, $activeParentIds, true))
            ->pluck('nama')
            ->implode(', ');

        ProfilInstansiNotification::query()->create([
            'instansi_id' => $instansi->id,
            'title' => 'Konfigurasi kategori dana diperbarui',
            'message' => $activeNames
                ? "Kategori aktif saat ini: {$activeNames}."
                : 'Semua kategori utama sedang dinonaktifkan.',
            'type' => 'kategori_dana',
        ]);

        return redirect()
            ->route('kategori-dana.index')
            ->with('success', 'Konfigurasi kategori dana berhasil disimpan.');
    }

    public function destroy(string $id)
    {
        // TODO: Hapus data kategori dana.
    }

    public function markNotificationsRead()
    {
        $instansi = $this->resolveInstansi();

        $instansi->profilNotifications()
            ->where('type', 'kategori_dana')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->noContent();
    }

    private function resolveInstansi(): Instansi
    {
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

        return Instansi::query()->firstOrFail();
    }

    private function syncDefaultCategories(Instansi $instansi)
    {
        return collect($this->defaultCategoryData())->map(function (array $data) use ($instansi) {
            $parent = KategoriDana::query()->firstOrCreate([
                'instansi_id' => $instansi->id,
                'parent_id' => null,
                'nama' => $data['nama'],
            ], [
                'is_active' => true,
            ]);

            foreach ($data['children'] as $childName) {
                KategoriDana::query()->firstOrCreate([
                    'instansi_id' => $instansi->id,
                    'parent_id' => $parent->id,
                    'nama' => $childName,
                ], [
                    'is_active' => $parent->is_active,
                ]);
            }

            return $parent->load(['children' => fn ($query) => $query->orderBy('nama')]);
        });
    }

    private function categoryCards($categories): array
    {
        $meta = collect($this->defaultCategoryData())->keyBy('nama');

        return $categories->map(function (KategoriDana $category) use ($meta) {
            return array_merge($meta[$category->nama], [
                'id' => $category->id,
                'is_active' => $category->is_active,
                'children' => $category->children,
            ]);
        })->all();
    }

    private function defaultCategoryData(): array
    {
        return [
            [
                'nama' => 'Zakat Fitrah',
                'description' => 'Fokus: Pengelolaan beras atau uang per jiwa untuk menyucikan diri di bulan Ramadhan.',
                'icon' => 'bi-flower1',
                'color' => 'green',
                'tags' => ['Ramadhan 2026', 'Wajib Per Jiwa'],
                'children' => ['Beras', 'Uang'],
            ],
            [
                'nama' => 'Zakat Maal',
                'description' => 'Fokus: Pengelolaan harta benda yang telah mencapai batas nishab dan masa haul.',
                'icon' => 'bi-wallet2',
                'color' => 'gray',
                'tags' => ['Sepanjang Tahun', 'Nilai, Profesi & Tabungan'],
                'children' => ['Tabungan', 'Profesi', 'Perdagangan', 'EMAS/LM', 'Pertanian', 'Peternakan', 'Investasi', 'Lainnya'],
            ],
            [
                'nama' => 'Infaq & Sedekah',
                'description' => 'Fokus: Pemberian sukarela untuk kemaslahatan umat tanpa batasan nishab tertentu.',
                'icon' => 'bi-heart-fill',
                'color' => 'pink',
                'tags' => ['Sukarela', 'Terbuka Umum'],
                'children' => ['Infaq', 'Sedekah', 'Wakaf Tunai'],
            ],
            [
                'nama' => 'Fidyah / Kaffarah',
                'description' => 'Fokus: Pembayaran denda atau tebusan atas kewajiban ibadah yang tertinggal.',
                'icon' => 'bi-cup-hot-fill',
                'color' => 'gray',
                'tags' => ['Denda / Tebusan', 'Konversi Makanan'],
                'children' => ['Fidyah', 'Kaffarah'],
            ],
        ];
    }
}
