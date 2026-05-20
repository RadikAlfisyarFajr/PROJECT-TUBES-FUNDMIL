<?php

namespace App\Http\Controllers\Mustahik;

use App\Http\Controllers\Controller;
use App\Http\Requests\MustahikRequest;
use App\Models\Instansi;
use App\Models\Mustahik;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MustahikController extends Controller
{
    public function index(Request $request): View
    {
        $query = Mustahik::where('instansi_id', $this->instansi()->id)->latest();

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($builder) use ($search) {
                $builder->where('nama', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->where('kategori_asnaf', $request->kategori);
        }

        $mustahik = $query->paginate(10)->withQueryString();

        return view('admin.mustahik.mustahik-index', [
            'mustahik' => $mustahik,
            'totalMustahik' => Mustahik::where('instansi_id', $this->instansi()->id)->count(),
            'aktifMustahik' => Mustahik::where('instansi_id', $this->instansi()->id)->where('status', 'aktif')->count(),
            'tidakAktifMustahik' => Mustahik::where('instansi_id', $this->instansi()->id)->where('status', 'tidak_aktif')->count(),
            'kategoriTerbanyak' => $this->kategoriTerbanyak(),
            'kategoriAsnaf' => $this->kategoriAsnaf(),
        ]);
    }

    public function create(): View
    {
        return view('admin.mustahik.mustahik-create', [
            'mustahik' => null,
            'kategoriAsnaf' => $this->kategoriAsnaf(),
        ]);
    }

    public function store(MustahikRequest $request): RedirectResponse
    {
        $validated = $this->payload($request);

        Mustahik::create($validated + [
            'instansi_id' => $this->instansi()->id,
            'tanggal_verifikasi' => $validated['status'] === 'aktif' ? now() : null,
        ]);

        return redirect()->route('mustahik.index')->with('success', 'Data mustahik berhasil ditambahkan.');
    }

    public function show(Mustahik $mustahik): View
    {
        $this->authorizeInstansi($mustahik);

        return view('admin.mustahik.mustahik-show', compact('mustahik'));
    }

    public function edit(Mustahik $mustahik): View
    {
        $this->authorizeInstansi($mustahik);

        return view('admin.mustahik.mustahik-edit', [
            'mustahik' => $mustahik,
            'kategoriAsnaf' => $this->kategoriAsnaf(),
        ]);
    }

    public function update(MustahikRequest $request, Mustahik $mustahik): RedirectResponse
    {
        $this->authorizeInstansi($mustahik);

        $validated = $this->payload($request);
        $wasActive = $mustahik->status === 'aktif';

        $mustahik->update($validated + [
            'tanggal_verifikasi' => $validated['status'] === 'aktif'
                ? ($wasActive ? $mustahik->tanggal_verifikasi : now())
                : null,
        ]);

        return redirect()->route('mustahik.index')->with('success', 'Data mustahik berhasil diperbarui.');
    }

    public function destroy(Mustahik $mustahik): RedirectResponse
    {
        $this->authorizeInstansi($mustahik);
        $mustahik->delete();

        return redirect()->route('mustahik.index')->with('success', 'Data mustahik berhasil dihapus.');
    }

    private function payload(MustahikRequest $request): array
    {
        $validated = $request->validated();

        return [
            'nama' => $validated['nama_lengkap'],
            'nik' => $validated['nik'] ?? null,
            'alamat' => $validated['alamat'],
            'kategori_asnaf' => $validated['kategori'],
            'kontak' => $validated['kontak'] ?? null,
            'keterangan' => $validated['keterangan'] ?? null,
            'status' => $validated['status'] ?? 'tidak_aktif',
        ];
    }

    private function instansi(): Instansi
    {

        $user = Auth::user();
        if ($user && $user->instansi_id) {
            return $user->instansi;
        }


        return Instansi::firstOrCreate(
            ['nama' => 'FUNDMIL SOREANG'],
            ['kelurahan' => 'Soreang', 'alamat' => 'Kelurahan Soreang', 'status' => 'aktif']
        );
    }

    private function authorizeInstansi(Mustahik $mustahik): void
    {
        abort_if($mustahik->instansi_id !== $this->instansi()->id, 403);
    }

    private function kategoriAsnaf(): array
    {
        return Mustahik::KATEGORI;
    }

    private function kategoriTerbanyak(): string
    {
        $top = Mustahik::where('instansi_id', $this->instansi()->id)
            ->selectRaw('kategori_asnaf, count(*) as total')
            ->groupBy('kategori_asnaf')
            ->orderByDesc('total')
            ->first();

        return $top ? ($this->kategoriAsnaf()[$top->kategori_asnaf] ?? 'Fakir Miskin') : 'Fakir Miskin';
    }
}
