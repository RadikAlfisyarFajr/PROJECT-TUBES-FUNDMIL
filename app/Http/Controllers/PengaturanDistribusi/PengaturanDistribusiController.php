<?php

namespace App\Http\Controllers\PengaturanDistribusi;

use App\Http\Controllers\Controller;
use App\Models\Instansi;
use App\Models\Mustahik;
use App\Models\PengaturanDistribusi;
use App\Models\ProgramPenyaluran;
use App\Models\TransaksiZakat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PengaturanDistribusiController extends Controller
{
    public function index(): View
    {
        return view('admin.pengaturan-distribusi.pengaturan-distribusi-index', $this->viewData());
    }

    public function create()
    {
        return redirect()->route('pengaturan-distribusi.index');
    }

    public function store(Request $request): RedirectResponse
    {
        $instansi = $this->instansi();
        $sources = array_keys($this->sourceLabels());

        $validated = $request->validate([
            'program_id' => [
                'required',
                'integer',
                Rule::exists('program_penyaluran', 'id')->where(fn ($query) => $query->where('instansi_id', $instansi->id)),
            ],
            'nominal_per_penerima' => ['nullable', 'numeric', 'min:0'],
            'tipe_penerima' => ['required', Rule::in(['database_mustahik', 'manual_mitra'])],
            'sumber_dana' => ['required', 'array', 'min:1'],
            'sumber_dana.*' => ['required', Rule::in($sources)],
            'tujuan_penggunaan' => ['nullable', 'string', 'max:255'],
            'mustahik_ids' => ['nullable', 'array'],
            'mustahik_ids.*' => ['integer'],
            'manual_recipients' => ['nullable', 'string'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        $program = ProgramPenyaluran::query()
            ->where('instansi_id', $instansi->id)
            ->findOrFail($validated['program_id']);

        $recipients = $this->recipients($validated, $program, $instansi, 0);
        $recipientCount = count($recipients);

        if ($recipientCount === 0) {
            return back()
                ->withErrors(['penerima' => 'pilih minimal satu penerima untuk membuat rencana distribusi.'])
                ->withInput();
        }

        $saldo = $this->saldoRekap($instansi);
        $saldoAwal = collect($validated['sumber_dana'])->sum(fn (string $source) => $saldo['source_balances'][$source] ?? 0);
        $bookingAktif = $this->bookedForSources($instansi, $validated['sumber_dana']);
        $saldoTersedia = max(0, $saldoAwal - $bookingAktif);
        $nominal = $validated['tipe_penerima'] === 'database_mustahik'
            ? $this->autoNominalPerRecipient($saldoTersedia, $recipientCount)
            : (float) ($validated['nominal_per_penerima'] ?? 0);

        if ($validated['tipe_penerima'] === 'manual_mitra' && $nominal < 1) {
            return back()
                ->withErrors(['nominal_per_penerima' => 'nominal per penerima harus diisi untuk penerima manual.'])
                ->withInput();
        }

        if ($validated['tipe_penerima'] === 'database_mustahik' && $nominal < 1) {
            return back()
                ->withErrors(['saldo' => 'saldo sumber dana belum cukup untuk dibagi rata ke mustahik terpilih.'])
                ->withInput();
        }

        if ($validated['tipe_penerima'] === 'database_mustahik') {
            $recipients = $this->recipients($validated, $program, $instansi, $nominal);
        }

        $totalAlokasi = $nominal * count($recipients);
        $estimasiSisaSaldo = $saldoTersedia - $totalAlokasi;

        if ($estimasiSisaSaldo < 0) {
            return back()
                ->withErrors(['saldo' => 'saldo sumber dana tidak cukup untuk rencana ini. kurangi nominal atau antrean penerima.'])
                ->withInput();
        }

        PengaturanDistribusi::create([
            'instansi_id' => $instansi->id,
            'program_penyaluran_id' => $program->id,
            'kode_rencana' => $this->generatePlanCode(),
            'tipe_penerima' => $validated['tipe_penerima'],
            'nominal_per_penerima' => $nominal,
            'jumlah_penerima' => count($recipients),
            'total_alokasi' => $totalAlokasi,
            'saldo_awal' => $saldoTersedia,
            'estimasi_sisa_saldo' => $estimasiSisaSaldo,
            'sumber_dana' => collect($validated['sumber_dana'])
                ->map(fn (string $source) => [
                    'key' => $source,
                    'label' => $this->sourceLabels()[$source],
                    'saldo' => $saldo['source_balances'][$source] ?? 0,
                ])
                ->values()
                ->all(),
            'penerima' => $recipients,
            'status' => 'siap',
            'catatan' => $validated['catatan'] ?? null,
        ]);

        return redirect()
            ->route('pengaturan-distribusi.show', $program)
            ->with('success', 'rencana distribusi berhasil disimpan dengan status siap.');
    }

    public function show(ProgramPenyaluran $programPenyaluran): View
    {
        $this->authorizeProgram($programPenyaluran);

        return view('admin.pengaturan-distribusi.pengaturan-distribusi-index', $this->viewData($programPenyaluran));
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

    public function searchMustahik(Request $request): JsonResponse
    {
        $instansi = $this->instansi();
        $term = trim((string) $request->query('q', ''));
        $program = $this->selectedProgramForRequest($request, $instansi);
        $allowedAsnaf = $program?->target_asnaf ?? [];

        $mustahik = Mustahik::query()
            ->where('instansi_id', $instansi->id)
            ->where('status', 'aktif')
            ->when(! empty($allowedAsnaf), function ($query) use ($allowedAsnaf) {
                $query->whereIn('kategori_asnaf', $allowedAsnaf);
            })
            ->when($term !== '', function ($query) use ($term) {
                $query->where(function ($search) use ($term) {
                    $search
                        ->where('nama', 'like', "%{$term}%")
                        ->orWhere('nik', 'like', "%{$term}%")
                        ->orWhere('alamat', 'like', "%{$term}%")
                        ->orWhere('kategori_asnaf', 'like', "%{$term}%");
                });
            })
            ->orderBy('nama')
            ->when($term !== '', fn ($query) => $query->limit(12))
            ->get()
            ->map(fn (Mustahik $item) => [
                'id' => $item->id,
                'nama' => $item->nama,
                'kategori' => $item->kategori_label,
                'alamat' => $item->alamat,
            ]);

        return response()->json(['data' => $mustahik]);
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
            'rata-pembagian' => 'rata pembagian',
            'kebutuhan' => 'berdasarkan kebutuhan',
            'kelompok' => 'kelompok asnaf',
            'manual' => 'manual',
        ];
    }

    private function viewData(?ProgramPenyaluran $selectedProgram = null): array
    {
        $instansi = $this->instansi();
        $programs = ProgramPenyaluran::with('kategoriDana')
            ->where('instansi_id', $instansi->id)
            ->latest()
            ->get();

        $saldo = $this->saldoRekap($instansi);
        $allowedAsnaf = $selectedProgram?->target_asnaf ?? [];

        return [
            'programs' => $programs,
            'selectedProgram' => $selectedProgram,
            'methods' => $this->distributionMethods(),
            'sourceLabels' => $this->sourceLabels(),
            'saldo' => $saldo,
            'mustahikOptions' => Mustahik::query()
                ->where('instansi_id', $instansi->id)
                ->where('status', 'aktif')
                ->when(! empty($allowedAsnaf), function ($query) use ($allowedAsnaf) {
                    $query->whereIn('kategori_asnaf', $allowedAsnaf);
                })
                ->orderBy('nama')
                ->get(),
            'plans' => PengaturanDistribusi::with('programPenyaluran')
                ->where('instansi_id', $instansi->id)
                ->latest()
                ->limit(5)
                ->get(),
        ];
    }

    private function sourceLabels(): array
    {
        return [
            'zakat_fitrah' => 'zakat fitrah',
            'zakat_maal' => 'zakat maal',
            'infaq_sedekah' => 'infaq & sedekah',
            'fidyah_kaffarah' => 'fidyah / kaffarah',
        ];
    }

    private function saldoRekap(Instansi $instansi): array
    {
        $transaksi = TransaksiZakat::query()
            ->where('instansi_id', $instansi->id)
            ->get(['jenis', 'sub_jenis', 'jumlah']);

        $fitrahUang = (float) $transaksi
            ->filter(fn (TransaksiZakat $row) => $row->jenis === 'zakat_fitrah' && $row->sub_jenis !== 'beras')
            ->sum(fn (TransaksiZakat $row) => (float) $row->jumlah);

        $fitrahBerasSetara = (float) $transaksi
            ->filter(fn (TransaksiZakat $row) => $row->jenis === 'zakat_fitrah' && $row->sub_jenis === 'beras')
            ->sum(fn (TransaksiZakat $row) => (float) $row->jumlah);

        $fitrahBerasKg = $fitrahBerasSetara > 0
            ? ($fitrahBerasSetara / 45000) * 2.5
            : 0;

        $maalRows = $transaksi->filter(fn (TransaksiZakat $row) => $row->jenis === 'zakat_maal');
        $maalTotal = (float) $maalRows->sum(fn (TransaksiZakat $row) => (float) $row->jumlah);

        $maalBreakdown = $maalRows
            ->groupBy(fn (TransaksiZakat $row) => (string) str($row->sub_jenis ?: 'lainnya')->lower())
            ->map(fn ($rows, string $name) => [
                'nama' => $name,
                'total' => (float) $rows->sum(fn (TransaksiZakat $row) => (float) $row->jumlah),
            ])
            ->values();

        $infaqSedekah = (float) $transaksi
            ->filter(fn (TransaksiZakat $row) => in_array($row->jenis, ['infaq_sedekah', 'infaq', 'sedekah'], true))
            ->sum(fn (TransaksiZakat $row) => (float) $row->jumlah);

        $fidyahKaffarah = (float) $transaksi
            ->filter(fn (TransaksiZakat $row) => in_array($row->jenis, ['fidyah', 'kaffarah', 'fidyah_kaffarah'], true))
            ->sum(fn (TransaksiZakat $row) => (float) $row->jumlah);

        $kasTotal = $fitrahUang + $maalTotal + $infaqSedekah + $fidyahKaffarah;
        $bookedTotal = (float) PengaturanDistribusi::query()
            ->where('instansi_id', $instansi->id)
            ->where('status', 'siap')
            ->sum('total_alokasi');

        return [
            'fitrah_uang' => $fitrahUang,
            'fitrah_beras_kg' => $fitrahBerasKg,
            'fitrah_beras_setara' => $fitrahBerasSetara,
            'maal_total' => $maalTotal,
            'maal_breakdown' => $maalBreakdown,
            'infaq_sedekah' => $infaqSedekah,
            'fidyah_kaffarah' => $fidyahKaffarah,
            'kas_total' => $kasTotal,
            'booked_total' => $bookedTotal,
            'saldo_tersedia' => max(0, $kasTotal - $bookedTotal),
            'source_balances' => [
                'zakat_fitrah' => $fitrahUang,
                'zakat_maal' => $maalTotal,
                'infaq_sedekah' => $infaqSedekah,
                'fidyah_kaffarah' => $fidyahKaffarah,
            ],
        ];
    }

    private function recipients(array $validated, ProgramPenyaluran $program, Instansi $instansi, float $nominal): array
    {
        $tujuan = ($validated['tujuan_penggunaan'] ?? null) ?: 'alokasi program '.$program->nama_program;
        $allowedAsnaf = $program->target_asnaf ?? [];

        if ($validated['tipe_penerima'] === 'manual_mitra') {
            return $this->manualRecipients($validated['manual_recipients'] ?? '[]', $program, $tujuan, $nominal);
        }

        $ids = array_values(array_unique($validated['mustahik_ids'] ?? []));

        if ($ids === []) {
            return [];
        }

        $mustahik = Mustahik::query()
            ->where('instansi_id', $instansi->id)
            ->where('status', 'aktif')
            ->whereIn('id', $ids)
            ->when(! empty($allowedAsnaf), function ($query) use ($allowedAsnaf) {
                $query->whereIn('kategori_asnaf', $allowedAsnaf);
            })
            ->orderBy('nama')
            ->get();

        if ($mustahik->count() !== count($ids)) {
            return [];
        }

        return $mustahik
            ->map(fn (Mustahik $item) => [
                'jenis' => 'database_mustahik',
                'mustahik_id' => $item->id,
                'nama' => $item->nama,
                'program' => $program->nama_program,
                'tujuan_penggunaan' => $tujuan,
                'nominal_alokasi' => $nominal,
            ])
            ->values()
            ->all();
    }

    private function autoNominalPerRecipient(float $saldoTersedia, int $jumlahPenerima): float
    {
        if ($jumlahPenerima <= 0) {
            return 0;
        }

        return (float) floor($saldoTersedia / $jumlahPenerima);
    }

    private function selectedProgramForRequest(Request $request, Instansi $instansi): ?ProgramPenyaluran
    {
        $programId = (int) $request->query('program_id');

        if ($programId <= 0) {
            return null;
        }

        return ProgramPenyaluran::query()
            ->where('instansi_id', $instansi->id)
            ->find($programId);
    }

    private function manualRecipients(string $json, ProgramPenyaluran $program, string $tujuan, float $nominal): array
    {
        $decoded = json_decode($json, true);

        if (! is_array($decoded)) {
            return [];
        }

        return collect($decoded)
            ->filter(fn ($row) => is_array($row) && filled($row['nama'] ?? null))
            ->map(fn (array $row) => [
                'jenis' => 'manual_mitra',
                'mustahik_id' => null,
                'nama' => (string) str($row['nama'])->trim()->limit(120, ''),
                'program' => $program->nama_program,
                'tujuan_penggunaan' => (string) str($row['tujuan'] ?? $tujuan)->trim()->limit(180, ''),
                'nominal_alokasi' => $nominal,
            ])
            ->values()
            ->all();
    }

    private function bookedForSources(Instansi $instansi, array $sources): float
    {
        return (float) PengaturanDistribusi::query()
            ->where('instansi_id', $instansi->id)
            ->where('status', 'siap')
            ->get(['sumber_dana', 'total_alokasi'])
            ->filter(function (PengaturanDistribusi $plan) use ($sources) {
                $storedSources = collect($plan->sumber_dana ?? [])
                    ->map(fn ($source) => is_array($source) ? ($source['key'] ?? null) : $source)
                    ->filter()
                    ->all();

                return count(array_intersect($sources, $storedSources)) > 0;
            })
            ->sum(fn (PengaturanDistribusi $plan) => (float) $plan->total_alokasi);
    }

    private function generatePlanCode(): string
    {
        do {
            $code = 'pd-'.now()->format('ymdhis').'-'.Str::lower(Str::random(4));
        } while (PengaturanDistribusi::query()->where('kode_rencana', $code)->exists());

        return $code;
    }
}
