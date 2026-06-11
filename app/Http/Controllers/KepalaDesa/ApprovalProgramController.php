<?php

namespace App\Http\Controllers\KepalaDesa;

use App\Http\Controllers\Controller;
use App\Models\Instansi;
use App\Models\ProgramPenyaluran;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ApprovalProgramController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorizeUser();

        $status = $request->input('status', 'pending');
        $desa = $this->desa();
        $instansiIds = $this->instansiIds($desa);

        $query = ProgramPenyaluran::query()
            ->with(['instansi', 'approver'])
            ->whereIn('instansi_id', $instansiIds)
            ->latest();

        if ($status === 'pending') {
            $query->whereIn('approval_status', ['draft', 'pending']);
        } elseif ($status !== 'semua') {
            $query->where('approval_status', $status);
        }

        return view('kepala-desa.approval.index', [
            'desa' => $desa,
            'status' => $status,
            'programs' => $query->paginate(10)->withQueryString(),
            'counts' => [
                'pending' => ProgramPenyaluran::whereIn('instansi_id', $instansiIds)
                    ->whereIn('approval_status', ['draft', 'pending'])
                    ->count(),
                'approved' => ProgramPenyaluran::whereIn('instansi_id', $instansiIds)
                    ->where('approval_status', 'approved')
                    ->count(),
                'rejected' => ProgramPenyaluran::whereIn('instansi_id', $instansiIds)
                    ->where('approval_status', 'rejected')
                    ->count(),
            ],
        ]);
    }

    public function approve(Request $request, ProgramPenyaluran $program): RedirectResponse
    {
        $this->authorizeUser();
        $this->authorizeProgram($program);
        abort_unless(in_array($program->approval_status, ['draft', 'pending'], true), 422, 'Program sudah diproses.');

        $validated = $request->validate([
            'approval_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $program->update([
            'approval_status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'approval_note' => $validated['approval_note'] ?? null,
        ]);

        return back()->with('success', 'Program berhasil di-accept oleh Admin Kepala Desa.');
    }

    public function reject(Request $request, ProgramPenyaluran $program): RedirectResponse
    {
        $this->authorizeUser();
        $this->authorizeProgram($program);
        abort_unless(in_array($program->approval_status, ['draft', 'pending'], true), 422, 'Program sudah diproses.');

        $validated = $request->validate([
            'approval_note' => ['required', 'string', 'max:1000'],
        ], [
            'approval_note.required' => 'Alasan rejected wajib diisi.',
        ]);

        $program->update([
            'approval_status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'approval_note' => $validated['approval_note'],
        ]);

        return back()->with('success', 'Program berhasil di-rejected oleh Admin Kepala Desa.');
    }

    private function authorizeProgram(ProgramPenyaluran $program): void
    {
        abort_unless(in_array($program->instansi_id, $this->instansiIds($this->desa())->all(), true), 403);
    }

    private function authorizeUser(): void
    {
        abort_unless(Auth::user()?->role === User::ROLE_ADMIN_KEPALA_DESA, 403);
    }

    private function desa(): string
    {
        $user = Auth::user();

        return (string) ($user->desa ?: $user->instansi?->kelurahan);
    }

    private function instansiIds(string $desa)
    {
        return Instansi::query()
            ->where('kelurahan', $desa)
            ->where('status', 'aktif')
            ->pluck('id');
    }
}
