<?php

namespace App\Http\Controllers\ProgramPenyaluran;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProgramPenyaluranRequest;
use App\Models\Instansi;
use App\Models\KategoriDana;
use App\Models\Mustahik;
use App\Models\ProgramPenyaluran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProgramPenyaluranController extends Controller
{
    public function index(Request $request): View
    {
        $instansi = $this->instansi();
        $query = ProgramPenyaluran::query()
            ->with('kategoriDana')
            ->where('instansi_id', $instansi->id)
            ->latest();

        if ($request->filled('search')) {
            $query->where('nama_program', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->whereHas('kategoriDana', function ($builder) use ($request) {
                $builder->where('nama', $request->kategori);
            });
        }

        $programs = $query->paginate(10)->withQueryString();

        return view('admin.program-penyaluran.program-penyaluran-index', [
            'programs' => $programs,
        ]);
    }

    public function create(): View
    {
        return view('admin.program-penyaluran.program-penyaluran-create', [
            'program' => new ProgramPenyaluran(['status' => 'aktif']),
            'selectedTargetAsnaf' => array_keys(Mustahik::KATEGORI),
        ]);
    }

    public function store(ProgramPenyaluranRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            $program = ProgramPenyaluran::create([
                'instansi_id' => $this->instansi()->id,
                'nama_program' => $validated['nama_program'],
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'total_dana' => $validated['total_dana'] ?? 0,
                'target_mustahik' => $validated['target_mustahik'] ?? 0,
                'target_asnaf' => array_values($validated['target_asnaf']),
                'status' => $validated['status'],
                'approval_status' => 'pending',
            ]);
        });

        return redirect()
            ->route('program-penyaluran.index')
            ->with('success', 'Program penyaluran berhasil dibuat.');
    }

    public function show(ProgramPenyaluran $programPenyaluran): View
    {
        $this->authorizeProgram($programPenyaluran);

        return view('admin.program-penyaluran.program-penyaluran-show', [
            'program' => $programPenyaluran,
            'kategoriDana' => $programPenyaluran->kategoriDana()->orderBy('nama')->get(),
        ]);
    }

    public function edit(ProgramPenyaluran $programPenyaluran): View
    {
        $this->authorizeProgram($programPenyaluran);

        return view('admin.program-penyaluran.program-penyaluran-edit', [
            'program' => $programPenyaluran,
            'selectedTargetAsnaf' => $programPenyaluran->target_asnaf ?? array_keys(Mustahik::KATEGORI),
        ]);
    }

    public function update(ProgramPenyaluranRequest $request, ProgramPenyaluran $programPenyaluran): RedirectResponse
    {
        $this->authorizeProgram($programPenyaluran);
        $validated = $request->validated();

        DB::transaction(function () use ($programPenyaluran, $validated) {
            $programPenyaluran->update([
                'nama_program' => $validated['nama_program'],
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'total_dana' => $validated['total_dana'] ?? 0,
                'target_mustahik' => $validated['target_mustahik'] ?? 0,
                'target_asnaf' => array_values($validated['target_asnaf']),
                'status' => $validated['status'],
                'approval_status' => 'pending',
                'approved_by' => null,
                'approved_at' => null,
                'approval_note' => null,
            ]);
        });

        return redirect()
            ->route('program-penyaluran.index')
            ->with('success', 'Program penyaluran berhasil diperbarui.');
    }

    public function destroy(ProgramPenyaluran $programPenyaluran): RedirectResponse
    {
        $this->authorizeProgram($programPenyaluran);
        $programPenyaluran->delete();

        return redirect()
            ->route('program-penyaluran.index')
            ->with('success', 'Program penyaluran berhasil dihapus.');
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

    private function kategoriDanaOptions()
    {
        $instansi = $this->instansi();

        foreach (['ZIS', 'Pendidikan', 'Kesehatan', 'Ekonomi', 'Sosial'] as $nama) {
            KategoriDana::firstOrCreate(
                ['instansi_id' => $instansi->id, 'nama' => $nama],
                ['is_active' => true]
            );
        }

        return KategoriDana::where('instansi_id', $instansi->id)
            ->where('is_active', true)
            ->orderBy('nama')
            ->get();
    }

    private function authorizeProgram(ProgramPenyaluran $program): void
    {
        abort_unless($program->instansi_id === $this->instansi()->id, 403);
    }
}
