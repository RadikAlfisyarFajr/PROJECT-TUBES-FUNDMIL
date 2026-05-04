<?php

namespace App\Http\Controllers\Mustahik;

use App\Http\Controllers\Controller;
use App\Models\Instansi;
use App\Models\Mustahik;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('kategori_asnaf', 'like', "%{$search}%");
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
            'verifiedMustahik' => Mustahik::where('instansi_id', $this->instansi()->id)->where('status', 'verified')->count(),
            'pendingMustahik' => Mustahik::where('instansi_id', $this->instansi()->id)->where('status', 'pending')->count(),
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

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);

        Mustahik::create($validated + [
            'instansi_id' => $this->instansi()->id,
            'tanggal_verifikasi' => $validated['status'] === 'verified' ? now() : null,
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

    public function update(Request $request, Mustahik $mustahik): RedirectResponse
    {
        $this->authorizeInstansi($mustahik);

        $validated = $this->validated($request, $mustahik);
        $wasVerified = $mustahik->status === 'verified';

        $mustahik->update($validated + [
            'tanggal_verifikasi' => $validated['status'] === 'verified'
                ? ($wasVerified ? $mustahik->tanggal_verifikasi : now())
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

    private function validated(Request $request, ?Mustahik $mustahik = null): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nik' => ['nullable', 'digits:16', 'unique:mustahik,nik,'.($mustahik?->id ?? 'NULL')],
            'alamat' => ['nullable', 'string'],
            'kategori_asnaf' => ['required', 'in:'.implode(',', array_keys($this->kategoriAsnaf()))],
            'status' => ['required', 'in:pending,verified,rejected'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);
    }

    private function instansi(): Instansi
    {
        if (auth()->check() && auth()->user()->instansi_id) {
            return auth()->user()->instansi;
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
        return [
            'fakir' => 'Fakir',
            'miskin' => 'Miskin',
            'amil' => 'Amil',
            'muallaf' => 'Muallaf',
            'riqab' => 'Riqab',
            'gharimin' => 'Gharimin',
            'fisabilillah' => 'Fisabilillah',
            'ibnu sabil' => 'Ibnu Sabil',
        ];
    }
}
