<?php

namespace App\Http\Controllers\Pemasukan;

use App\Http\Controllers\Controller;
use App\Models\Instansi;
use App\Models\KategoriDana;
use App\Models\User;
use App\Support\OfficialVillageAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemasukanController extends Controller
{
    public function index()
    {
        return view('admin.pemasukan.pemasukan-index');
    }

    public function create()
    {
        $kategoriDropdown = $this->kategoriDropdown();

        return view('admin.pemasukan.pemasukan-create', compact('kategoriDropdown'));
    }

    public function store(Request $request)
    {
        // TODO: Validasi dan simpan data pemasukan zakat.
    }

    public function show(string $id)
    {
        return view('admin.pemasukan.pemasukan-show', compact('id'));
    }

    public function edit(string $id)
    {
        $kategoriDropdown = $this->kategoriDropdown();

        return view('admin.pemasukan.pemasukan-edit', compact('id', 'kategoriDropdown'));
    }

    public function update(Request $request, string $id)
    {
        // TODO: Validasi dan perbarui data pemasukan zakat.
    }

    public function destroy(string $id)
    {
        // TODO: Hapus data pemasukan zakat.
    }

    private function kategoriDropdown()
    {
        $instansi = $this->resolveInstansi();
        $this->syncDefaultCategories($instansi);

        return KategoriDana::query()
            ->where('instansi_id', $instansi->id)
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->with(['children' => function ($query) {
                $query->where('is_active', true)->orderBy('nama');
            }])
            ->orderBy('nama')
            ->get()
            ->filter(fn(KategoriDana $category) => $category->children->isNotEmpty());
    }

    private function resolveInstansi(): Instansi
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (($user?->role ?? null) === User::ROLE_ADMIN_INSTANSI) {
            if (! $user->instansi_id || ! Instansi::query()->whereKey($user->instansi_id)->exists()) {
                $instansi = Instansi::query()->create([
                    'nama' => $user->nama_instansi ?: $user->name,
                    'kelurahan' => OfficialVillageAccount::normalizeVillageName($user->desa),
                    'email' => $user->email,
                    'status' => 'aktif',
                ]);

                $user->fill(['instansi_id' => $instansi->id])->save();

                return $instansi;
            }

            return Instansi::query()->findOrFail($user->instansi_id);
        }

        return Instansi::query()->firstOrFail();
    }

    private function syncDefaultCategories(Instansi $instansi): void
    {
        foreach ($this->defaultCategories() as $parentName => $children) {
            $parent = KategoriDana::query()->firstOrCreate([
                'instansi_id' => $instansi->id,
                'parent_id' => null,
                'nama' => $parentName,
            ], [
                'is_active' => true,
            ]);

            foreach ($children as $childName) {
                KategoriDana::query()->firstOrCreate([
                    'instansi_id' => $instansi->id,
                    'parent_id' => $parent->id,
                    'nama' => $childName,
                ], [
                    'is_active' => $parent->is_active,
                ]);
            }
        }
    }

    private function defaultCategories(): array
    {
        return [
            'Zakat Fitrah' => ['Beras', 'Uang'],
            'Zakat Maal' => ['Tabungan', 'Profesi', 'Perdagangan', 'EMAS/LM', 'Pertanian', 'Peternakan', 'Investasi', 'Lainnya'],
            'Infaq & Sedekah' => ['Infaq', 'Sedekah', 'Wakaf Tunai'],
            'Fidyah / Kaffarah' => ['Fidyah', 'Kaffarah'],
        ];
    }
}
