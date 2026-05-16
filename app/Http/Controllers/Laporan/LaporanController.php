<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiZakat;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        $pemasukan      = TransaksiZakat::with('kategori')->orderBy('tanggal', 'desc')->limit(200)->get();
        $totalPemasukan = TransaksiZakat::sum('jumlah');

        return view('admin.laporan.laporan-index', compact('pemasukan', 'totalPemasukan'));
    }

    /**
     * Halaman daftar pemasukan (laporan pemasukan).
     */
    public function pemasukan(Request $request)
    {
        $query = TransaksiZakat::with('kategori')->orderBy('tanggal', 'desc');

        if ($q = $request->query('q')) {
            $query->where(function ($w) use ($q) {
                $w->where('nama_muzakki', 'like', "%{$q}%")
                  ->orWhere('nomor_kuitansi', 'like', "%{$q}%");
            });
        }

        $pemasukan      = $query->paginate(25)->withQueryString();
        $totalPemasukan = TransaksiZakat::sum('jumlah');

        return view('admin.laporan.pemasukan-index', compact('pemasukan', 'totalPemasukan'));
    }

    /**Mengembalikan seluruh data satu transaksi beserta item-itemnya
     * untuk ditampilkan di modal detail pada halaman laporan pemasukan.
     */
    public function pemasukanDetail(int $id)
{
    $trx = TransaksiZakat::with(['kategori'])->findOrFail($id);

    // Bangun satu item dari kolom yang ada di transaksi itu sendiri
    $labelMap = [
        'zakat_fitrah'  => 'Zakat Fitrah',
        'zakat_maal'    => 'Zakat Maal',
        'infaq_sedekah' => 'Infaq & Sedekah',
        'fidyah'        => 'Fidyah',
    ];

    $kategoriKey = $trx->kategori?->slug ?? $trx->jenis ?? '';

    $items = [[
        'kategori_utama' => $kategoriKey,
        'label_kategori' => $labelMap[$kategoriKey] ?? ($trx->kategori?->nama ?? $trx->jenis ?? '—'),
        'sub'            => null,
        'jumlah_input'   => $trx->jumlah ?? 0,
        'subtotal'       => $trx->jumlah ?? 0,
        'keterangan'     => $trx->keterangan ?? '',
    ]];

    return response()->json([
        'id'               => $trx->id,
        'nomor_kuitansi'   => $trx->nomor_kuitansi ?? '—',
        'tanggal'          => Carbon::parse($trx->tanggal)->isoFormat('D MMMM YYYY'),
        'nama_muzakki'     => $trx->nama_muzakki   ?? '—',
        'nomor_wa'         => $trx->nomor_wa        ?? '—',
        'desa'             => $trx->desa            ?? '—',
        'alamat_detail'    => $trx->alamat_detail   ?? '—',
        'jenis_pembayaran' => $trx->jenis_pembayaran ?? 'tunai',
        'items'            => $items,
        'total_uang'       => $trx->jumlah ?? 0,
        'total_beras_kg'   => 0,
    ]);
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

        return redirect()->route('laporan.index')
            ->with('success', 'Konfigurasi laporan berhasil disimpan.');
    }

    public function show(string $id)
    {
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

        return redirect()->route('laporan.index')
            ->with('success', 'Konfigurasi laporan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        return redirect()->route('laporan.index')
            ->with('success', 'Konfigurasi laporan berhasil dihapus.');
    }
}