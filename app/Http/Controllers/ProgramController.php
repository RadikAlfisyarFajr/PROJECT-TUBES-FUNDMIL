<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\KategoriDana;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function index(Request $request): View
    {
        $instansi = $this->instansi();
        $query = Program::with('programDana.kategoriDana')
            ->where('instansi_id', $instansi->id)
            ->latest();

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($builder) use ($search) {
                $builder->where('nama_program', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->whereHas('programDana.kategoriDana', function ($builder) use ($request) {
                $builder->where('nama', $request->kategori);
            });
        }

        $programs = $query->paginate(9)->withQueryString();

        return view('admin.program.index', [
            'programs' => $programs,
            'totalDana' => Program::where('instansi_id', $instansi->id)->sum('total_dana') ?: 850000000,
            'alokasiAktif' => Program::where('instansi_id', $instansi->id)->where('status', 'aktif')->sum('total_dana') ?: 425000000,
            'kategoriDana' => $this->kategoriDanaOptions(),
        ]);
    }

    public function create(): View
    {
        return view('admin.program.create', [
            'kategoriDana' => $this->kategoriDanaOptions(),
            'saldoTersedia' => 850000000,
            'kategoriProgram' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_program' => ['required', 'string', 'max:255'],
            'kategori_program' => ['nullable', 'in:Pendidikan,Kesehatan,Ekonomi,Sosial'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'kategori_dana_ids' => ['required', 'array', 'min:1'],
            'kategori_dana_ids.*' => ['exists:kategori_dana,id'],
            'deskripsi' => ['nullable', 'string'],
            'total_dana' => ['required', 'numeric', 'min:0'],
            'target_mustahik' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:draft,aktif,selesai'],
        ]);

        DB::transaction(function () use ($validated) {
            $program = Program::create([
                'instansi_id' => $this->instansi()->id,
                'nama_program' => $validated['nama_program'],
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'total_dana' => $validated['total_dana'],
                'target_mustahik' => $validated['target_mustahik'],
                'status' => $validated['status'],
            ]);

            foreach ($validated['kategori_dana_ids'] as $kategoriId) {
                $program->programDana()->create([
                    'kategori_dana_id' => $kategoriId,
                    'alokasi_dana' => round($validated['total_dana'] / count($validated['kategori_dana_ids']), 2),
                ]);
            }
        });

        return redirect()->route('program-penyaluran.index')->with('success', 'Program penyaluran berhasil dibuat.');
    }

    public function edit(Program $programPenyaluran): View
    {
        $programPenyaluran->load('programDana.kategoriDana');
        $kategoriProgram = $programPenyaluran->programDana
            ->pluck('kategoriDana.nama')
            ->first(fn ($nama) => in_array($nama, ['Pendidikan', 'Kesehatan', 'Ekonomi', 'Sosial'], true));

        return view('admin.program.edit', [
            'program' => $programPenyaluran,
            'kategoriDana' => $this->kategoriDanaOptions(),
            'selectedKategori' => $programPenyaluran->programDana->pluck('kategori_dana_id')->all(),
            'saldoTersedia' => 850000000,
            'kategoriProgram' => $kategoriProgram,
        ]);
    }

    public function update(Request $request, Program $programPenyaluran): RedirectResponse
    {
        $validated = $request->validate([
            'nama_program' => ['required', 'string', 'max:255'],
            'kategori_program' => ['nullable', 'in:Pendidikan,Kesehatan,Ekonomi,Sosial'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'kategori_dana_ids' => ['required', 'array', 'min:1'],
            'kategori_dana_ids.*' => ['exists:kategori_dana,id'],
            'deskripsi' => ['nullable', 'string'],
            'total_dana' => ['required', 'numeric', 'min:0'],
            'target_mustahik' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:draft,aktif,selesai'],
        ]);

        DB::transaction(function () use ($programPenyaluran, $validated) {
            $programPenyaluran->update([
                'nama_program' => $validated['nama_program'],
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'total_dana' => $validated['total_dana'],
                'target_mustahik' => $validated['target_mustahik'],
                'status' => $validated['status'],
            ]);

            $programPenyaluran->programDana()->delete();

            foreach ($validated['kategori_dana_ids'] as $kategoriId) {
                $programPenyaluran->programDana()->create([
                    'kategori_dana_id' => $kategoriId,
                    'alokasi_dana' => round($validated['total_dana'] / count($validated['kategori_dana_ids']), 2),
                ]);
            }
        });

        return redirect()->route('program-penyaluran.index')->with('success', 'Program penyaluran berhasil diperbarui.');
    }

    public function destroy(Program $programPenyaluran): RedirectResponse
    {
        $programPenyaluran->delete();

        return redirect()->route('program-penyaluran.index')->with('success', 'Program penyaluran berhasil dihapus.');
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
}
