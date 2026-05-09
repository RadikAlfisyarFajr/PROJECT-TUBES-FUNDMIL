<?php

namespace App\Http\Controllers\PengaturanDistribusi;

use App\Http\Controllers\Controller;
use App\Models\Instansi;
use App\Models\ProgramPenyaluran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengaturanDistribusiController extends Controller
{
    public function index(): View
    {
        $instansi = $this->instansi();
        $programs = ProgramPenyaluran::with('kategoriDana')
            ->where('instansi_id', $instansi->id)
            ->latest()
            ->get();

        return view('admin.pengaturan-distribusi.pengaturan-distribusi-index', [
            'programs' => $programs,
            'selectedProgram' => null,
            'methods' => $this->distributionMethods(),
        ]);
    }

    public function create()
    {
        return redirect()->route('pengaturan-distribusi.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('pengaturan-distribusi.index');
    }

    public function show(ProgramPenyaluran $programPenyaluran): View
    {
        $this->authorizeProgram($programPenyaluran);

        $instansi = $this->instansi();
        $programs = ProgramPenyaluran::with('kategoriDana')
            ->where('instansi_id', $instansi->id)
            ->latest()
            ->get();

        return view('admin.pengaturan-distribusi.pengaturan-distribusi-index', [
            'programs' => $programs,
            'selectedProgram' => $programPenyaluran,
            'methods' => $this->distributionMethods(),
        ]);
    }

    public function edit(string $id)
    {
        return redirect()->route('pengaturan-distribusi.index');
    }

    public function update(Request $request, ProgramPenyaluran $programPenyaluran): RedirectResponse
    {
        $this->authorizeProgram($programPenyaluran);

        $validated = $request->validate([
            'metode_distribusi' => 'nullable|string|in:rata-pembagian,kebutuhan,kelompok,manual',
        ]);

        $programPenyaluran->update([
            'metode_distribusi' => $validated['metode_distribusi'] ?? null,
        ]);

        return redirect()
            ->route('pengaturan-distribusi.show', $programPenyaluran)
            ->with('success', 'Pengaturan distribusi berhasil disimpan.');
    }

    public function destroy(string $id)
    {
        return redirect()->route('pengaturan-distribusi.index');
    }

    private function authorizeProgram(ProgramPenyaluran $program): void
    {
        abort_unless($program->instansi_id === $this->instansi()->id, 403);
    }

    private function instansi(): Instansi
    {
        $user = auth()->guard()->user();

        if ($user?->instansi) {
            return $user->instansi;
        }

        return Instansi::firstOrCreate(
            ['nama' => $user?->nama_instansi ?: 'FUNDMIL SOREANG'],
            [
                'kelurahan' => $user?->desa,
                'email' => $user?->email,
                'status' => 'aktif',
            ]
        );
    }

    private function distributionMethods(): array
    {
        return [
            'rata-pembagian' => 'Rata Pembagian',
            'kebutuhan' => 'Berdasarkan Kebutuhan',
            'kelompok' => 'Kelompok Asnaf',
            'manual' => 'Manual',
        ];
    }
}
