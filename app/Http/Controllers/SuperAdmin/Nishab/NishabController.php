<?php

namespace App\Http\Controllers\SuperAdmin\Nishab;

use App\Http\Controllers\Controller;
use App\Models\Nishab;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NishabController extends Controller
{
    public function index()
    {
        return view('superadmin.nishab.nishab-index', [
            'nishabs' => Nishab::query()->orderByDesc('tanggal_berlaku')->paginate(10),
            'latestMaal' => Nishab::query()
                ->where('jenis_zakat', 'zakat_maal')
                ->where('tanggal_berlaku', '<=', now()->toDateString())
                ->where(fn ($query) => $query
                    ->whereNull('tanggal_berakhir')
                    ->orWhere('tanggal_berakhir', '>=', now()->toDateString()))
                ->orderByDesc('tanggal_berlaku')
                ->first(),
        ]);
    }

    public function create()
    {
        return view('superadmin.nishab.nishab-create');
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        Nishab::query()->create($validated);

        return redirect()
            ->route('superadmin.nishab.index')
            ->with('success', 'Parameter nishab berhasil disimpan.');
    }

    public function edit(Nishab $nishab)
    {
        return view('superadmin.nishab.nishab-edit', compact('nishab'));
    }

    public function update(Request $request, Nishab $nishab)
    {
        $nishab->update($this->validated($request));

        return redirect()
            ->route('superadmin.nishab.index')
            ->with('success', 'Parameter nishab berhasil diperbarui.');
    }

    public function destroy(Nishab $nishab)
    {
        $nishab->delete();

        return redirect()
            ->route('superadmin.nishab.index')
            ->with('success', 'Parameter nishab berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'jenis_zakat' => ['required', Rule::in(['zakat_maal', 'zakat_fitrah'])],
            'nishab_kg' => 'nullable|numeric|min:0|max:999999',
            'nishab_rupiah' => 'nullable|numeric|min:0|max:999999999999',
            'tarif_fitrah_kg' => 'nullable|numeric|min:0|max:999999',
            'tanggal_berlaku' => 'required|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_berlaku',
            'keterangan' => 'nullable|string|max:1000',
        ], [
            'tanggal_berakhir.after_or_equal' => 'Berlaku sampai tanggal tidak boleh lebih awal dari berlaku mulai tanggal.',
        ]);
    }
}
