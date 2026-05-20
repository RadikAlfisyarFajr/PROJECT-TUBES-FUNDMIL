<?php

namespace App\Http\Controllers\Penyaluran;

use App\Http\Controllers\Controller;
use App\Models\Instansi;
use App\Models\PengaturanDistribusi;
use App\Models\Penyaluran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PenyaluranController extends Controller
{
    public function index(): View
    {
        $instansi = $this->instansi();

        $penyaluran = Penyaluran::with(['programPenyaluran', 'penyaluranDetail'])
            ->where('instansi_id', $instansi->id)
            ->latest('tanggal_penyaluran')
            ->latest()
            ->get();

        return view('admin.penyaluran.penyaluran-index', [
            'penyaluran' => $penyaluran,
            'totalSelesai' => $penyaluran->where('status', 'selesai')->count(),
            'totalPenerima' => $penyaluran->sum(fn (Penyaluran $item) => $item->penyaluranDetail->count()),
            'totalDanaTersalur' => $penyaluran->sum(fn (Penyaluran $item) => $item->penyaluranDetail->sum('jumlah_diterima')),
        ]);
    }

    public function create(Request $request): View
    {
        $instansi = $this->instansi();
        $readyPlans = PengaturanDistribusi::with('programPenyaluran')
            ->where('instansi_id', $instansi->id)
            ->where('status', 'siap')
            ->latest()
            ->get();

        $selectedPlanId = (int) old('pengaturan_distribusi_id', $request->query('plan', 0));
        $selectedPlan = $readyPlans->firstWhere('id', $selectedPlanId) ?: $readyPlans->first();

        return view('admin.penyaluran.penyaluran-create', [
            'readyPlans' => $readyPlans,
            'selectedPlan' => $selectedPlan,
            'defaultRecipientNominal' => $selectedPlan ? $this->recipientNominal($selectedPlan) : 0,
            'totalReadyPlans' => $readyPlans->count(),
            'totalReadyRecipients' => $readyPlans->sum('jumlah_penerima'),
            'totalReadyAllocation' => $readyPlans->sum('total_alokasi'),
            'completedThisMonth' => Penyaluran::where('instansi_id', $instansi->id)
                ->where('status', 'selesai')
                ->whereMonth('tanggal_penyaluran', now()->month)
                ->whereYear('tanggal_penyaluran', now()->year)
                ->count(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $instansi = $this->instansi();

        $validated = $request->validate([
            'pengaturan_distribusi_id' => [
                'required',
                'integer',
                Rule::exists('pengaturan_distribusi', 'id')->where(fn ($query) => $query
                    ->where('instansi_id', $instansi->id)
                    ->where('status', 'siap')),
            ],
            'tanggal_penyaluran' => ['required', 'date'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
            'bukti_foto' => ['nullable', 'image', 'max:2048'],
        ]);

        $plan = PengaturanDistribusi::with('programPenyaluran')
            ->where('instansi_id', $instansi->id)
            ->where('status', 'siap')
            ->findOrFail($validated['pengaturan_distribusi_id']);

        $recipients = collect($plan->penerima ?? []);

        if ($recipients->isEmpty()) {
            return back()
                ->withErrors(['pengaturan_distribusi_id' => 'Rencana ini belum memiliki penerima.'])
                ->withInput();
        }

        $buktiPath = $request->file('bukti_foto')?->store('penyaluran-bukti', 'public');

        $penyaluran = DB::transaction(function () use ($plan, $instansi, $validated, $recipients, $buktiPath) {
            $keterangan = trim(implode("\n", array_filter([
                'Eksekusi dari rencana '.$plan->kode_rencana.'.',
                $validated['keterangan'] ?? null,
            ])));

            $penyaluran = Penyaluran::create([
                'instansi_id' => $instansi->id,
                'program_id' => $plan->program_penyaluran_id,
                'pengaturan_distribusi_id' => $plan->id,
                'tanggal_penyaluran' => $validated['tanggal_penyaluran'],
                'status' => 'selesai',
                'keterangan' => $keterangan ?: null,
                'bukti_foto' => $buktiPath,
            ]);

            $details = $recipients->map(fn (array $recipient) => [
                'jenis_penerima' => $recipient['jenis'] ?? $plan->tipe_penerima,
                'mustahik_id' => $recipient['mustahik_id'] ?? null,
                'nama_penerima' => $recipient['nama'] ?? null,
                'jumlah_diterima' => (float) (($recipient['nominal_alokasi'] ?? 0) > 0
                    ? $recipient['nominal_alokasi']
                    : $this->recipientNominal($plan)),
                'status_penerimaan' => 'diterima',
                'tanggal_diterima' => now(),
                'keterangan' => $recipient['tujuan_penggunaan'] ?? $plan->catatan,
            ])->all();

            $penyaluran->penyaluranDetail()->createMany($details);

            $plan->update(['status' => 'selesai']);

            return $penyaluran;
        });

        return redirect()
            ->route('penyaluran.show', $penyaluran)
            ->with('success', 'Penyaluran berhasil dieksekusi dan dicatat.');
    }

    public function show(Penyaluran $penyaluran): View
    {
        $this->authorizePenyaluran($penyaluran);

        $penyaluran->load(['programPenyaluran', 'pengaturanDistribusi.programPenyaluran', 'penyaluranDetail.mustahik']);

        return view('admin.penyaluran.penyaluran-show', compact('penyaluran'));
    }

    public function edit(string $id)
    {
        return view('admin.penyaluran.penyaluran-edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        // TODO: Validasi dan perbarui data penyaluran zakat.
    }

    public function destroy(Penyaluran $penyaluran): RedirectResponse
    {
        $this->authorizePenyaluran($penyaluran);
        $penyaluran->delete();

        return redirect()
            ->route('penyaluran.index')
            ->with('success', 'Data penyaluran berhasil dihapus.');
    }

    private function authorizePenyaluran(Penyaluran $penyaluran): void
    {
        abort_unless($penyaluran->instansi_id === $this->instansi()->id, 403);
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

    private function recipientNominal(PengaturanDistribusi $plan): float
    {
        $explicitNominal = (float) ($plan->nominal_per_penerima ?? 0);

        if ($explicitNominal > 0) {
            return $explicitNominal;
        }

        $recipientCount = (int) ($plan->jumlah_penerima ?? 0);

        if ($recipientCount <= 0) {
            return 0;
        }

        return (float) floor(((float) ($plan->total_alokasi ?? 0)) / $recipientCount);
    }
}
