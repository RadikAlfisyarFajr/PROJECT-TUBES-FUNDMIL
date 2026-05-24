<?php

namespace App\Http\Controllers\Pemasukan;

use App\Http\Controllers\Controller;
use App\Models\Instansi;
use App\Models\KategoriDana;
use App\Models\TransaksiZakat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PemasukanZakatController extends Controller
{
    private const FITRAH_UANG_PER_JIWA = 45000;
    private const FITRAH_BERAS_KG_PER_JIWA = 2.5;
    private const DEFAULT_HARGA_BERAS_PER_KG = 18000;
    private const FIDYAH_PER_HARI = 45000;
    private const FIDYAH_BUKA_PUASA_PER_HARI = 25000;
    private const FIDYAH_SAHUR_PER_HARI = 20000;
    private const KONVERSI_PERTANIAN_PER_KG = 10000;
    private const KONVERSI_PETERNAKAN_PER_EKOR = 2500000;

    public function index(): View
    {
        return view('admin.pemasukan.pemasukan-create', $this->createViewData());
    }

    public function create(): View
    {
        return view('admin.pemasukan.pemasukan-create', $this->createViewData());
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $instansi = $this->instansi();

        $validated = $request->validate([
            'nomor_kuitansi' => ['nullable', 'string', 'max:50'],
            'nama_muzakki' => ['required', 'string', 'max:255'],
            'nomor_wa' => ['nullable', 'string', 'max:30'],
            'desa' => ['required', 'string', 'max:100'],
            'jenis_pembayaran' => ['required', Rule::in(['tunai', 'transfer', 'qris'])],
            'items' => ['required', 'array', 'min:1'],
            'items.*.kategori_utama' => ['required', Rule::in($this->activeKategoriKeys($instansi))],
            'items.*.fitrah_media' => ['nullable', Rule::in(['uang', 'beras'])],
            'items.*.sub_maal' => ['nullable', Rule::in(['Profesi', 'Simpanan', 'Perdagangan', 'Emas', 'Pertanian', 'Peternakan'])],
            'items.*.jumlah_input' => ['required', 'numeric', 'min:0.01'],
            'items.*.fidyah_buka_puasa' => ['nullable', 'numeric', 'min:0'],
            'items.*.fidyah_sahur' => ['nullable', 'numeric', 'min:0'],
            'items.*.keterangan' => ['nullable', 'string', 'max:1000'],
        ]);

        $user = $request->user();
        abort_unless($user, 403);

        $nomorKuitansi = $validated['nomor_kuitansi'] ?: $this->generateNomorKuitansi();
        $hargaBeras = $this->hargaBerasPerKg();
        $tanggal = now()->toDateString();
        $total = 0;

        DB::transaction(function () use ($validated, $user, $instansi, $nomorKuitansi, $hargaBeras, $tanggal, &$total) {
            foreach ($validated['items'] as $item) {
                $converted = $this->convertItem($item, $hargaBeras);
                $kategori = $this->kategoriDana($instansi, $converted['kategori_nama']);
                $total += $converted['jumlah'];

                TransaksiZakat::create([
                    'instansi_id' => $instansi->id,
                    'admin_id' => $user->id,
                    'kategori_id' => $kategori->id,
                    'nomor_kuitansi' => $nomorKuitansi,
                    'nama_muzakki' => $validated['nama_muzakki'],
                    'nomor_wa' => $validated['nomor_wa'] ?? null,
                    'desa' => $validated['desa'],
                    'jenis' => $converted['jenis'],
                    'sub_jenis' => $converted['sub_jenis'],
                    'jumlah' => $converted['jumlah'],
                    'harga_beras_snapshot' => $converted['harga_beras_snapshot'],
                    'jenis_pembayaran' => $validated['jenis_pembayaran'],
                    'keterangan' => trim($converted['detail_fisik'].' '.($item['keterangan'] ?? '')),
                    'tanggal' => $tanggal,
                ]);
            }
        });

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Pemasukan zakat berhasil disimpan.',
                'nomor_kuitansi' => $nomorKuitansi,
                'total' => $total,
                'next_nomor_kuitansi' => $this->generateNomorKuitansi(),
            ]);
        }

        return redirect()
            ->route('pemasukan.create')
            ->with('success', 'Pemasukan zakat berhasil disimpan.');
    }

    public function show(string $id): View
    {
        return view('admin.pemasukan.pemasukan-show', compact('id'));
    }

    public function edit(string $id): View
    {
        return view('admin.pemasukan.pemasukan-edit', [
            'id' => $id,
            'kategoriDropdown' => $this->kategoriDropdown($this->instansi()),
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        return redirect()
            ->route('pemasukan.index')
            ->with('success', 'Fitur ubah pemasukan belum tersedia.');
    }

    public function destroy(string $id): RedirectResponse
    {
        return redirect()
            ->route('pemasukan.index')
            ->with('success', 'Fitur hapus pemasukan belum tersedia.');
    }

    private function convertItem(array $item, float $hargaBeras): array
    {
        $kategoriUtama = $item['kategori_utama'];
        $jumlahInput = (float) $item['jumlah_input'];

        if ($kategoriUtama === 'zakat_fitrah') {
            $media = $item['fitrah_media'] ?? 'uang';
            $berasKg = $jumlahInput * self::FITRAH_BERAS_KG_PER_JIWA;

            return [
                'kategori_nama' => 'Zakat Fitrah',
                'jenis' => 'zakat_fitrah',
                'sub_jenis' => $media,
                'jumlah' => (int) round($jumlahInput * self::FITRAH_UANG_PER_JIWA),
                'harga_beras_snapshot' => $media === 'beras' ? $hargaBeras : null,
                'detail_fisik' => $media === 'beras'
                    ? sprintf('Zakat Fitrah Beras: %s jiwa x 2.5 Kg = %s Kg Beras.', $this->cleanNumber($jumlahInput), $this->cleanNumber($berasKg))
                    : sprintf('Zakat Fitrah Uang: %s jiwa x Rp 45.000.', $this->cleanNumber($jumlahInput)),
            ];
        }

        if ($kategoriUtama === 'zakat_maal') {
            $subMaal = $item['sub_maal'] ?? 'Profesi';
            $jumlah = match ($subMaal) {
                'Pertanian' => $jumlahInput * self::KONVERSI_PERTANIAN_PER_KG,
                'Peternakan' => $jumlahInput * self::KONVERSI_PETERNAKAN_PER_EKOR,
                default => $jumlahInput,
            };

            $detail = match ($subMaal) {
                'Pertanian' => sprintf('Zakat Maal Pertanian: %s Kg hasil panen.', $this->cleanNumber($jumlahInput)),
                'Peternakan' => sprintf('Zakat Maal Peternakan: %s Ekor hewan.', $this->cleanNumber($jumlahInput)),
                default => sprintf('Zakat Maal %s: nominal rupiah.', $subMaal),
            };

            return [
                'kategori_nama' => 'Zakat Maal',
                'jenis' => 'zakat_maal',
                'sub_jenis' => $subMaal,
                'jumlah' => (int) round($jumlah),
                'harga_beras_snapshot' => null,
                'detail_fisik' => $detail,
            ];
        }

        if ($kategoriUtama === 'fidyah') {
            $bukaPuasa = (float) ($item['fidyah_buka_puasa'] ?? self::FIDYAH_BUKA_PUASA_PER_HARI);
            $sahur = (float) ($item['fidyah_sahur'] ?? self::FIDYAH_SAHUR_PER_HARI);
            $fidyahPerHari = $bukaPuasa + $sahur;

            return [
                'kategori_nama' => 'Fidyah',
                'jenis' => 'fidyah',
                'sub_jenis' => 'hari_jiwa',
                'jumlah' => (int) round($jumlahInput * $fidyahPerHari),
                'harga_beras_snapshot' => null,
                'detail_fisik' => sprintf(
                    'Fidyah: %s hari/jiwa x Rp %s (buka puasa Rp %s + sahur Rp %s per hari).',
                    $this->cleanNumber($jumlahInput),
                    number_format($fidyahPerHari, 0, ',', '.'),
                    number_format($bukaPuasa, 0, ',', '.'),
                    number_format($sahur, 0, ',', '.')
                ),
            ];
        }

        return [
            'kategori_nama' => 'Infaq & Sedekah',
            'jenis' => 'infaq_sedekah',
            'sub_jenis' => 'uang',
            'jumlah' => (int) round($jumlahInput),
            'harga_beras_snapshot' => null,
            'detail_fisik' => 'Infaq & Sedekah: nominal uang.',
        ];
    }

    private function kategoriDana(Instansi $instansi, string $nama): KategoriDana
    {
        $kategori = KategoriDana::query()
            ->where('instansi_id', $instansi->id)
            ->where('nama', $nama)
            ->where('is_active', true)
            ->first();

        if ($kategori) {
            return $kategori;
        }

        throw ValidationException::withMessages([
            'items' => "Kategori dana {$nama} sedang tidak aktif. Aktifkan dulu di halaman Kategori Dana.",
        ]);
    }

    private function instansi(): Instansi
    {
        $user = auth()->user();

        if ($user?->instansi) {
            return $user->instansi;
        }

        return Instansi::firstOrCreate(
            ['nama' => $user?->nama_instansi ?: 'FUNDMIL SOREANG'],
            [
                'kelurahan' => $user?->desa ?: 'Soreang',
                'email' => $user?->email,
                'status' => 'aktif',
            ]
        );
    }

    private function hargaBerasPerKg(): float
    {
        return (float) (DB::table('harga_beras')
            ->latest('tanggal_berlaku')
            ->value('harga_per_kg') ?: self::DEFAULT_HARGA_BERAS_PER_KG);
    }

    private function rates(): array
    {
        return [
            'fitrahUangPerJiwa' => self::FITRAH_UANG_PER_JIWA,
            'fitrahBerasKgPerJiwa' => self::FITRAH_BERAS_KG_PER_JIWA,
            'hargaBerasPerKg' => $this->hargaBerasPerKg(),
            'fidyahPerHari' => self::FIDYAH_PER_HARI,
            'fidyahBukaPuasaPerHari' => self::FIDYAH_BUKA_PUASA_PER_HARI,
            'fidyahSahurPerHari' => self::FIDYAH_SAHUR_PER_HARI,
            'pertanianPerKg' => self::KONVERSI_PERTANIAN_PER_KG,
            'peternakanPerEkor' => self::KONVERSI_PETERNAKAN_PER_EKOR,
        ];
    }

    private function createViewData(): array
    {
        $instansi = $this->instansi();

        return [
            'nomorKuitansi' => $this->generateNomorKuitansi(),
            'desaOptions' => $this->desaOptions(),
            'rates' => $this->rates(),
            'kategoriDropdown' => $this->kategoriDropdown($instansi),
            'activeKategoriKeys' => $this->activeKategoriKeys($instansi),
        ];
    }

    private function kategoriDropdown(Instansi $instansi): array
    {
        return KategoriDana::query()
            ->where('instansi_id', $instansi->id)
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->with(['children' => fn ($query) => $query->where('is_active', true)->orderBy('nama')])
            ->orderBy('nama')
            ->get()
            ->map(fn (KategoriDana $category) => [
                'key' => $this->kategoriKeyFromName($category->nama),
                'label' => $category->nama,
                'children' => $category->children->map(fn (KategoriDana $child) => [
                    'id' => $child->id,
                    'nama' => $child->nama,
                ])->values()->all(),
            ])
            ->filter(fn (array $category) => $category['key'] !== null)
            ->values()
            ->all();
    }

    private function activeKategoriKeys(Instansi $instansi): array
    {
        return collect($this->kategoriDropdown($instansi))
            ->pluck('key')
            ->values()
            ->all();
    }

    private function kategoriKeyFromName(string $nama): ?string
    {
        return match (strtolower(trim($nama))) {
            'zakat fitrah' => 'zakat_fitrah',
            'zakat maal' => 'zakat_maal',
            'infaq & sedekah' => 'infaq_sedekah',
            'fidyah / kaffarah' => 'fidyah',
            default => null,
        };
    }

    private function generateNomorKuitansi(): string
    {
        return 'FR-'.now()->format('ymdHis').random_int(10, 99);
    }

    private function cleanNumber(float $number): string
    {
        return rtrim(rtrim(number_format($number, 2, '.', ''), '0'), '.');
    }

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
}
