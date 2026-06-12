<?php

namespace App\Http\Controllers\KepalaDesa;

use App\Http\Controllers\Controller;
use App\Models\Instansi;
use App\Models\PenyaluranDetail;
use App\Models\ProgramPenyaluran;
use App\Models\TransaksiZakat;
use App\Support\OfficialVillageAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class KepalaDesaController extends Controller
{
    public function dashboard(): View
    {
        $desa = $this->desa();
        $instansi = $this->activeInstansi();
        $instansiIds = $instansi->pluck('id');

        $pengumpulan = TransaksiZakat::query()
            ->whereIn('instansi_id', $instansiIds)
            ->select('instansi_id')
            ->selectRaw('SUM(jumlah) as total')
            ->selectRaw('COUNT(*) as transaksi')
            ->groupBy('instansi_id')
            ->get()
            ->keyBy('instansi_id');

        $penyaluran = PenyaluranDetail::query()
            ->join('penyaluran', 'penyaluran.id', '=', 'penyaluran_detail.penyaluran_id')
            ->whereIn('penyaluran.instansi_id', $instansiIds)
            ->where('penyaluran.status', 'selesai')
            ->where('penyaluran_detail.status_penerimaan', '!=', 'ditolak')
            ->select('penyaluran.instansi_id')
            ->selectRaw('SUM(penyaluran_detail.jumlah_diterima) as total')
            ->groupBy('penyaluran.instansi_id')
            ->get()
            ->keyBy('instansi_id');

        $rows = $instansi->map(function (Instansi $item) use ($pengumpulan, $penyaluran) {
            $kasMasuk = (float) ($pengumpulan[$item->id]->total ?? 0);
            $kasKeluar = (float) ($penyaluran[$item->id]->total ?? 0);

            return [
                'nama' => $item->nama,
                'tipe' => $item->tipe ?: '-',
                'kas_masuk' => $kasMasuk,
                'kas_keluar' => $kasKeluar,
                'saldo' => max(0, $kasMasuk - $kasKeluar),
                'transaksi' => (int) ($pengumpulan[$item->id]->transaksi ?? 0),
            ];
        })->sortByDesc('kas_masuk')->values();

        $monthlyRows = $this->monthlyCirculation($instansiIds);

        return view('kepala-desa.dashboard-kepala-desa', [
            'desa' => $desa,
            'summary' => [
                'instansiAktif' => $instansi->count(),
                'pendingProgram' => ProgramPenyaluran::query()
                    ->whereIn('instansi_id', $instansiIds)
                    ->whereIn('approval_status', ['pending', 'draft'])
                    ->count(),
                'totalMasuk' => $rows->sum('kas_masuk'),
                'totalKeluar' => $rows->sum('kas_keluar'),
                'saldo' => $rows->sum('saldo'),
            ],
            'rows' => $rows,
            'monthlyRows' => $monthlyRows,
            'chartMax' => max(1, $monthlyRows->max(fn ($row) => max($row['masuk'], $row['keluar']))),
        ]);
    }

    public function approvalIndex(Request $request): View
    {
        $status = $request->input('status', 'pending');
        $instansiIds = $this->activeInstansi()->pluck('id');

        $query = ProgramPenyaluran::query()
            ->with('instansi')
            ->whereIn('instansi_id', $instansiIds)
            ->latest();

        if ($status === 'pending') {
            $query->whereIn('approval_status', ['pending', 'draft']);
        } elseif ($status !== 'semua') {
            $query->where('approval_status', $status);
        }

        return view('kepala-desa.approval.index', [
            'programs' => $query->paginate(10)->withQueryString(),
            'status' => $status,
            'pendingCount' => ProgramPenyaluran::query()
                ->whereIn('instansi_id', $instansiIds)
                ->whereIn('approval_status', ['pending', 'draft'])
                ->count(),
        ]);
    }

    public function approvalShow(ProgramPenyaluran $program): View
    {
        $this->authorizeProgram($program);

        return view('kepala-desa.approval.show', [
            'program' => $program->load(['instansi', 'kategoriDana', 'approver']),
        ]);
    }

    public function approve(Request $request, ProgramPenyaluran $program): RedirectResponse
    {
        $this->authorizeProgram($program);
        abort_unless(in_array($program->approval_status, ['pending', 'draft'], true), 422, 'Program ini sudah diproses.');

        $validated = $request->validate([
            'approval_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $program->update([
            'approval_status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'approval_note' => $validated['approval_note'] ?? null,
        ]);

        return redirect()
            ->route('kepala-desa.approval.index')
            ->with('success', 'Program disetujui.');
    }

    public function reject(Request $request, ProgramPenyaluran $program): RedirectResponse
    {
        $this->authorizeProgram($program);
        abort_unless(in_array($program->approval_status, ['pending', 'draft'], true), 422, 'Program ini sudah diproses.');

        $validated = $request->validate([
            'approval_note' => ['required', 'string', 'max:1000'],
        ], [
            'approval_note.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $program->update([
            'approval_status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'approval_note' => $validated['approval_note'],
        ]);

        return redirect()
            ->route('kepala-desa.approval.index')
            ->with('success', 'Program ditolak di level desa.');
    }

    private function desa(): string
    {
        return OfficialVillageAccount::normalizeVillageName(Auth::user()->desa);
    }

    private function activeInstansi(): Collection
    {
        $desa = $this->desa();

        return Instansi::query()
            ->where('status', 'aktif')
            ->orderBy('nama')
            ->get()
            ->filter(fn (Instansi $instansi) => $this->sameVillage($instansi->kelurahan, $desa))
            ->values();
    }

    private function monthlyCirculation(Collection $instansiIds): Collection
    {
        $start = now()->startOfMonth()->subMonths(5);

        return collect(range(0, 5))->map(function (int $offset) use ($start, $instansiIds) {
            $monthStart = $start->copy()->addMonths($offset);
            $monthEnd = $monthStart->copy()->endOfMonth();

            $masuk = (float) TransaksiZakat::query()
                ->whereIn('instansi_id', $instansiIds)
                ->whereBetween('tanggal', [$monthStart->toDateString(), $monthEnd->toDateString()])
                ->sum('jumlah');

            $keluar = (float) PenyaluranDetail::query()
                ->join('penyaluran', 'penyaluran.id', '=', 'penyaluran_detail.penyaluran_id')
                ->whereIn('penyaluran.instansi_id', $instansiIds)
                ->where('penyaluran.status', 'selesai')
                ->where('penyaluran_detail.status_penerimaan', '!=', 'ditolak')
                ->whereBetween('penyaluran.tanggal_penyaluran', [$monthStart->toDateString(), $monthEnd->toDateString()])
                ->sum('penyaluran_detail.jumlah_diterima');

            return [
                'label' => $monthStart->translatedFormat('M Y'),
                'masuk' => $masuk,
                'keluar' => $keluar,
            ];
        });
    }

    private function authorizeProgram(ProgramPenyaluran $program): void
    {
        abort_unless(
            $program->instansi?->status === 'aktif'
            && $this->sameVillage($program->instansi?->kelurahan, $this->desa()),
            403
        );
    }

    private function sameVillage(?string $left, ?string $right): bool
    {
        $left = $this->normalizeVillage($left);
        $right = $this->normalizeVillage($right);

        return $left !== '' && $left === $right;
    }

    private function normalizeVillage(?string $value): string
    {
        return strtolower(OfficialVillageAccount::normalizeVillageName($value));
    }
}
