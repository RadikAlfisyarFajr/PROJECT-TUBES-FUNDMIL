<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Mustahik;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MustahikController extends Controller
{
    private const KATEGORI_ASNAF = [
        'Fakir',
        'Miskin',
        'Amil',
        'Muallaf',
        'Gharimin',
        'Fisabilillah',
        'Ibnu Sabil',
    ];

    public function index(Request $request): View
    {
        $query = Mustahik::query()->latest();

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($builder) use ($search) {
                $builder->where('nama', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_asnaf', $request->string('kategori'));
        }

        if ($request->filled('rw')) {
            $query->where('rw', $request->string('rw'));
        }

        $mustahik = $query->paginate(10)->withQueryString();

        $totalMustahik = Mustahik::count();
        $kategoriTerbanyak = Mustahik::selectRaw('kategori_asnaf, COUNT(*) as total')
            ->groupBy('kategori_asnaf')
            ->orderByDesc('total')
            ->value('kategori_asnaf') ?? 'Fakir Miskin';
        $menungguVerifikasi = Mustahik::where('status', 'pending')->count();
        $rwOptions = Mustahik::whereNotNull('rw')->distinct()->orderBy('rw')->pluck('rw');

        return view('admin.mustahik.index', [
            'mustahik' => $mustahik,
            'kategoriAsnaf' => self::KATEGORI_ASNAF,
            'kategoriTerbanyak' => $kategoriTerbanyak,
            'menungguVerifikasi' => $menungguVerifikasi,
            'rwOptions' => $rwOptions,
            'totalMustahik' => $totalMustahik,
        ]);
    }

    public function create(): View
    {
        return view('admin.mustahik.create', [
            'kategoriAsnaf' => self::KATEGORI_ASNAF,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'digits:16'],
            'no_kk' => ['required', 'digits:16'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'kategori_asnaf' => ['required', 'in:' . implode(',', self::KATEGORI_ASNAF)],
            'desa_kelurahan' => ['required', 'string', 'max:255'],
            'rw' => ['required', 'digits_between:1,3'],
            'rt' => ['required', 'digits_between:1,3'],
            'alamat' => ['required', 'string'],
            'foto_ktp' => ['nullable', 'image', 'max:2048'],
            'foto_kk' => ['nullable', 'image', 'max:2048'],
        ]);

        $instansi = Instansi::firstOrCreate(
            ['nama' => 'FUNDMIL SOREANG'],
            [
                'kelurahan' => 'Soreang',
                'alamat' => 'Kelurahan Soreang',
                'status' => 'aktif',
            ]
        );

        $validated['instansi_id'] = $instansi->id;
        $validated['status'] = 'pending';
        $validated['rw'] = str_pad($validated['rw'], 2, '0', STR_PAD_LEFT);
        $validated['rt'] = str_pad($validated['rt'], 2, '0', STR_PAD_LEFT);

        if ($request->hasFile('foto_ktp')) {
            $validated['foto_ktp'] = $request->file('foto_ktp')->store('mustahik/ktp', 'public');
        }

        if ($request->hasFile('foto_kk')) {
            $validated['foto_kk'] = $request->file('foto_kk')->store('mustahik/kk', 'public');
        }

        Mustahik::create($validated);

        return redirect()
            ->route('mustahik.index')
            ->with('success', 'Data mustahik berhasil disimpan.');
    }

    public function show(Mustahik $mustahik): View
    {
        return view('admin.mustahik.show', compact('mustahik'));
    }

    public function edit(Mustahik $mustahik): View
    {
        return view('admin.mustahik.edit', [
            'mustahik' => $mustahik,
            'kategoriAsnaf' => self::KATEGORI_ASNAF,
        ]);
    }

    public function update(Request $request, Mustahik $mustahik): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'digits:16'],
            'no_kk' => ['nullable', 'digits:16'],
            'tempat_lahir' => ['nullable', 'string', 'max:255'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['nullable', 'in:Laki-laki,Perempuan'],
            'kategori_asnaf' => ['required', 'in:' . implode(',', self::KATEGORI_ASNAF)],
            'desa_kelurahan' => ['nullable', 'string', 'max:255'],
            'rw' => ['nullable', 'digits_between:1,3'],
            'rt' => ['nullable', 'digits_between:1,3'],
            'alamat' => ['nullable', 'string'],
            'status' => ['required', 'in:pending,verified,rejected'],
            'foto_ktp' => ['nullable', 'image', 'max:2048'],
            'foto_kk' => ['nullable', 'image', 'max:2048'],
        ]);

        if (isset($validated['rw'])) {
            $validated['rw'] = str_pad($validated['rw'], 2, '0', STR_PAD_LEFT);
        }

        if (isset($validated['rt'])) {
            $validated['rt'] = str_pad($validated['rt'], 2, '0', STR_PAD_LEFT);
        }

        if ($request->hasFile('foto_ktp')) {
            if ($mustahik->foto_ktp) {
                Storage::disk('public')->delete($mustahik->foto_ktp);
            }
            $validated['foto_ktp'] = $request->file('foto_ktp')->store('mustahik/ktp', 'public');
        }

        if ($request->hasFile('foto_kk')) {
            if ($mustahik->foto_kk) {
                Storage::disk('public')->delete($mustahik->foto_kk);
            }
            $validated['foto_kk'] = $request->file('foto_kk')->store('mustahik/kk', 'public');
        }

        $mustahik->update($validated);

        return redirect()
            ->route('mustahik.index')
            ->with('success', 'Data mustahik berhasil diperbarui.');
    }

    public function destroy(Mustahik $mustahik): RedirectResponse
    {
        if ($mustahik->foto_ktp) {
            Storage::disk('public')->delete($mustahik->foto_ktp);
        }

        if ($mustahik->foto_kk) {
            Storage::disk('public')->delete($mustahik->foto_kk);
        }

        $mustahik->delete();

        return redirect()
            ->route('mustahik.index')
            ->with('success', 'Data mustahik berhasil dihapus.');
    }
}
