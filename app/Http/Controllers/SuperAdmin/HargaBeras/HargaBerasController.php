<?php

namespace App\Http\Controllers\SuperAdmin\HargaBeras;

use App\Http\Controllers\Controller;
use App\Models\HargaBeras;
use Illuminate\Http\Request;

class HargaBerasController extends Controller
{
    public function index()
    {
        return view('superadmin.harga-beras.harga-beras-index', [
            'hargaBeras' => HargaBeras::query()->orderByDesc('tanggal_berlaku')->paginate(10),
            'latest' => HargaBeras::query()
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
        return view('superadmin.harga-beras.harga-beras-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'harga_per_kg' => 'required|numeric|min:1000|max:999999',
            'tanggal_berlaku' => 'required|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_berlaku',
            'keterangan' => 'nullable|string|max:1000',
        ], [
            'tanggal_berakhir.after_or_equal' => 'Berlaku sampai tanggal tidak boleh lebih awal dari berlaku mulai tanggal.',
        ]);

        HargaBeras::query()->create($validated);

        return redirect()
            ->route('superadmin.harga-beras.index')
            ->with('success', 'Harga beras acuan berhasil disimpan.');
    }

    public function edit(HargaBeras $harga_bera)
    {
        return view('superadmin.harga-beras.harga-beras-edit', [
            'hargaBeras' => $harga_bera,
        ]);
    }

    public function update(Request $request, HargaBeras $harga_bera)
    {
        $validated = $request->validate([
            'harga_per_kg' => 'required|numeric|min:1000|max:999999',
            'tanggal_berlaku' => 'required|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_berlaku',
            'keterangan' => 'nullable|string|max:1000',
        ], [
            'tanggal_berakhir.after_or_equal' => 'Berlaku sampai tanggal tidak boleh lebih awal dari berlaku mulai tanggal.',
        ]);

        $harga_bera->update($validated);

        return redirect()
            ->route('superadmin.harga-beras.index')
            ->with('success', 'Harga beras acuan berhasil diperbarui.');
    }

    public function destroy(HargaBeras $harga_bera)
    {
        $harga_bera->delete();

        return redirect()
            ->route('superadmin.harga-beras.index')
            ->with('success', 'Harga beras acuan berhasil dihapus.');
    }
}
