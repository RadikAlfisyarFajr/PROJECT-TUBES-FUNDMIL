<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.laporan-index');
    }

    public function create()
    {
        return view('admin.laporan.laporan-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string|max:255',
            'tipe'    => 'required|in:pemasukan,penyaluran,mustahik,keuangan',
            'periode' => 'required|in:bulanan,triwulan,tahunan,fleksibel',
        ]);

        // TODO: Simpan konfigurasi laporan ke database.

        return redirect()->route('laporan.index')
            ->with('success', 'Konfigurasi laporan berhasil disimpan.');
    }

    public function show(string $id)
    {
        // Laporan detail belum tersedia — redirect ke index dengan notifikasi.
        return redirect()->route('laporan.index')
            ->with('info', 'Fitur laporan ini akan segera tersedia.');
    }

    public function edit(string $id)
    {
        return view('admin.laporan.laporan-edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama'    => 'required|string|max:255',
            'tipe'    => 'required|in:pemasukan,penyaluran,mustahik,keuangan',
            'periode' => 'required|in:bulanan,triwulan,tahunan,fleksibel',
        ]);

        // TODO: Perbarui konfigurasi laporan di database.

        return redirect()->route('laporan.index')
            ->with('success', 'Konfigurasi laporan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        // TODO: Hapus konfigurasi laporan dari database.

        return redirect()->route('laporan.index')
            ->with('success', 'Konfigurasi laporan berhasil dihapus.');
    }
}
