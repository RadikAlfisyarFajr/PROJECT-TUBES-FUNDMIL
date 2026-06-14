<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiZakat;
use App\Models\Mustahik;
use App\Models\Penyaluran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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

        if ($request->boolean('print')) {
            $pemasukanPrint = (clone $query)->get();
            $breakdownPemasukan = $pemasukanPrint
                ->groupBy(fn (TransaksiZakat $item) => $item->kategori?->nama ?: ucfirst(str_replace('_', ' ', $item->jenis ?? 'Lainnya')))
                ->map(function ($items, $label) {
                    return [
                        'label' => $label,
                        'totalTransaksi' => $items->count(),
                        'totalDana' => (float) $items->sum('jumlah'),
                    ];
                })
                ->sortByDesc('totalDana')
                ->values();

            return view('admin.laporan.cetak-pdf', [
                'pemasukan' => $pemasukanPrint,
                'totalPemasukan' => $pemasukanPrint->sum('jumlah'),
                'totalTransaksi' => $pemasukanPrint->count(),
                'breakdownPemasukan' => $breakdownPemasukan,
                'search' => $request->query('q'),
                'generatedAt' => now(),
                'report' => 'pemasukan',
            ]);
        }

        $pemasukan      = $query->paginate(25)->withQueryString();
        $totalPemasukan = TransaksiZakat::sum('jumlah');

        return view('admin.laporan.laporan-pemasukan-index', compact('pemasukan', 'totalPemasukan'));
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

    public function pemasukanStruk(int $id)
    {
        // Redirect ke halaman struk premium di pemasukan.show
        return redirect()->route('pemasukan.show', $id);
    }

    /**
     * Laporan Data Mustahik
     */
    public function mustahik(Request $request)
    {
        $user = Auth::user();
        $instansiId = $user->instansi_id ?? 1;
        
        $query = Mustahik::with('instansi')->where('instansi_id', $instansiId)->latest();

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($builder) use ($search) {
                $builder->where('nama', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->where('kategori_asnaf', $request->kategori);
        }

        if ($request->boolean('print')) {
            $mustahikPrint = (clone $query)->get();
            $breakdownStatus = $mustahikPrint->groupBy('status')->map(function ($items, $status) {
                return [
                    'label' => ucfirst(str_replace('_', ' ', $status ?: '-')),
                    'total' => $items->count(),
                ];
            })->values();
            $breakdownKategori = $mustahikPrint->groupBy('kategori_asnaf')->map(function ($items, $kategori) use ($instansiId) {
                return [
                    'label' => Mustahik::KATEGORI[$kategori] ?? ($kategori ?: '-'),
                    'total' => $items->count(),
                ];
            })->sortByDesc('total')->values();

            return view('admin.laporan.cetak-pdf', [
                'mustahik' => $mustahikPrint,
                'totalMustahik' => Mustahik::where('instansi_id', $instansiId)->count(),
                'aktifMustahik' => Mustahik::where('instansi_id', $instansiId)->where('status', 'aktif')->count(),
                'tidakAktifMustahik' => Mustahik::where('instansi_id', $instansiId)->where('status', 'tidak_aktif')->count(),
                'kategoriTerbanyak' => $this->kategoriTerbanyak($instansiId),
                'kategoriAsnaf' => Mustahik::KATEGORI,
                'breakdownStatus' => $breakdownStatus,
                'breakdownKategori' => $breakdownKategori,
                'filters' => [
                    'search' => $request->query('search'),
                    'status' => $request->query('status', 'semua'),
                    'kategori' => $request->query('kategori', 'semua'),
                ],
                'generatedAt' => now(),
                'report' => 'mustahik',
            ]);
        }

        $mustahik = $query->paginate(10)->withQueryString();

        return view('admin.laporan.laporan-mustahik-index', [
            'mustahik' => $mustahik,
            'totalMustahik' => Mustahik::where('instansi_id', $instansiId)->count(),
            'aktifMustahik' => Mustahik::where('instansi_id', $instansiId)->where('status', 'aktif')->count(),
            'tidakAktifMustahik' => Mustahik::where('instansi_id', $instansiId)->where('status', 'tidak_aktif')->count(),
            'kategoriTerbanyak' => $this->kategoriTerbanyak($instansiId),
            'kategoriAsnaf' => Mustahik::KATEGORI,
        ]);
    }

    /**
     * Detail Mustahik untuk modal (AJAX)
     */
    public function mustahikDetail(int $id)
    {
        $user = Auth::user();
        $instansiId = $user->instansi_id ?? 1;
        
        $mustahik = Mustahik::findOrFail($id);
        
        abort_if($mustahik->instansi_id !== $instansiId, 403);

        return response()->json([
            'id'                   => $mustahik->id,
            'nama'                 => $mustahik->nama,
            'nik_display'          => $mustahik->nik ? substr($mustahik->nik, 0, 6) . '******' . substr($mustahik->nik, -4) : '—',
            'kontak'               => $mustahik->kontak ?? '—',
            'tanggal_verifikasi'   => $mustahik->tanggal_verifikasi ? Carbon::parse($mustahik->tanggal_verifikasi)->isoFormat('D MMMM YYYY') : '—',
            'kategori_asnaf'       => str_replace(' ', '_', strtolower($mustahik->kategori_asnaf)),
            'kategori_label'       => Mustahik::KATEGORI[$mustahik->kategori_asnaf] ?? $mustahik->kategori_asnaf,
            'status'               => $mustahik->status,
            'alamat'               => $mustahik->alamat ?? '—',
            'keterangan'           => $mustahik->keterangan ?? '',
        ]);
    }

    private function kategoriTerbanyak($instansiId): string
    {
        $top = Mustahik::where('instansi_id', $instansiId)
            ->selectRaw('kategori_asnaf, count(*) as total')
            ->groupBy('kategori_asnaf')
            ->orderByDesc('total')
            ->first();

        return $top ? (Mustahik::KATEGORI[$top->kategori_asnaf] ?? 'Fakir Miskin') : 'Fakir Miskin';
    }

    /**
     * Laporan Penyaluran
     */
    public function penyaluran(Request $request)
    {
        $user = Auth::user();
        $instansiId = $user->instansi_id ?? 1;
        
        $query = Penyaluran::where('instansi_id', $instansiId)
            ->with(['programPenyaluran', 'penyaluranDetail'])
            ->latest();

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->whereHas('programPenyaluran', function ($q) use ($search) {
                $q->where('nama_program', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        if ($request->boolean('print')) {
            $penyaluranPrint = (clone $query)->get();
            $breakdownProgram = $penyaluranPrint->map(function (Penyaluran $item) {
                return [
                    'label' => $item->programPenyaluran?->nama_program ?? '—',
                    'totalPenerima' => (int) $item->penyaluranDetail->count(),
                    'totalDana' => (float) $item->penyaluranDetail->sum('jumlah_diterima'),
                ];
            })->sortByDesc('totalDana')->values();

            return view('admin.laporan.cetak-pdf', [
                'penyaluran' => $penyaluranPrint,
                'totalPenyaluran' => Penyaluran::where('instansi_id', $instansiId)->count(),
                'berhasilPenyaluran' => Penyaluran::where('instansi_id', $instansiId)->where('status', 'selesai')->count(),
                'prosesPenyaluran' => Penyaluran::where('instansi_id', $instansiId)->where('status', 'proses')->count(),
                'totalDanaPenyaluran' => (float) $penyaluranPrint->sum(fn (Penyaluran $item) => (float) $item->penyaluranDetail->sum('jumlah_diterima')),
                'totalPenerimaPenyaluran' => (int) $penyaluranPrint->sum(fn (Penyaluran $item) => $item->penyaluranDetail->count()),
                'breakdownProgram' => $breakdownProgram,
                'filters' => [
                    'search' => $request->query('search'),
                    'status' => $request->query('status', 'semua'),
                ],
                'generatedAt' => now(),
                'report' => 'penyaluran',
            ]);
        }

        $penyaluran = $query->paginate(10)->withQueryString();

        return view('admin.laporan.laporan-penyaluran-index', [
            'penyaluran' => $penyaluran,
            'totalPenyaluran' => Penyaluran::where('instansi_id', $instansiId)->count(),
            'berhasilPenyaluran' => Penyaluran::where('instansi_id', $instansiId)->where('status', 'selesai')->count(),
            'prosesPenyaluran' => Penyaluran::where('instansi_id', $instansiId)->where('status', 'proses')->count(),
        ]);
    }

    /**
     * Detail Penyaluran untuk modal (AJAX)
     */
    public function penyaluranDetail(int $id)
    {
        $user = Auth::user();
        $instansiId = $user->instansi_id ?? 1;
        
        $penyaluran = Penyaluran::with(['programPenyaluran', 'penyaluranDetail.mustahik'])->findOrFail($id);
        
        abort_if($penyaluran->instansi_id !== $instansiId, 403);

        $detail_items = $penyaluran->penyaluranDetail->map(function ($item) {
            return [
                'nama_penerima' => $item->nama_penerima,
                'jenis_penerima' => $item->jenis_penerima,
                'jumlah_diterima' => $item->jumlah_diterima,
                'status_penerimaan' => $item->status_penerimaan,
                'tanggal_diterima' => $item->tanggal_diterima ? Carbon::parse($item->tanggal_diterima)->isoFormat('D MMMM YYYY') : '—',
                'keterangan' => $item->keterangan,
            ];
        });

        return response()->json([
            'id'                   => $penyaluran->id,
            'program_nama'         => $penyaluran->programPenyaluran?->nama_program ?? '—',
            'tanggal_penyaluran'   => Carbon::parse($penyaluran->tanggal_penyaluran)->isoFormat('D MMMM YYYY'),
            'status'               => $penyaluran->status,
            'keterangan'           => $penyaluran->keterangan ?? '',
            'detail_items'         => $detail_items,
            'total_penerima'       => $penyaluran->penyaluranDetail->count(),
            'total_jumlah'         => $penyaluran->penyaluranDetail->sum('jumlah_diterima'),
        ]);
    }

    /**
     * Laporan Keuangan
     */
    public function keuangan(Request $request)
    {
        $user = Auth::user();
        $instansiId = $user->instansi_id ?? 1;

        $pemasukanQuery = TransaksiZakat::where('instansi_id', $instansiId)
            ->with('kategori')
            ->orderByDesc('tanggal');

        if ($request->filled('search')) {
            $search = $request->string('search');

            $pemasukanQuery->where(function ($builder) use ($search) {
                $builder->where('nama_muzakki', 'like', "%{$search}%")
                    ->orWhere('nomor_kuitansi', 'like', "%{$search}%");
            });
        }

        $pemasukan = $pemasukanQuery->limit(12)->get();
        $totalPemasukan = TransaksiZakat::where('instansi_id', $instansiId)->sum('jumlah');

        $penyaluranQuery = Penyaluran::where('instansi_id', $instansiId)
            ->with(['programPenyaluran', 'penyaluranDetail'])
            ->orderByDesc('tanggal_penyaluran');

        if ($request->filled('search')) {
            $search = $request->string('search');
            $penyaluranQuery->whereHas('programPenyaluran', function ($builder) use ($search) {
                $builder->where('nama_program', 'like', "%{$search}%");
            });
        }

        if ($request->boolean('print')) {
            $pemasukanPrint = (clone $pemasukanQuery)->get();
            $penyaluranPrint = (clone $penyaluranQuery)->get();
            $totalPemasukanPrint = (float) $pemasukanPrint->sum('jumlah');
            $totalPenyaluranPrint = (float) $penyaluranPrint->sum(function (Penyaluran $item) {
                return (float) $item->penyaluranDetail->sum('jumlah_diterima');
            });
            $saldoAwal = 0;
            $breakdownPemasukan = $pemasukanPrint
                ->groupBy(fn (TransaksiZakat $item) => $item->kategori?->nama ?: ucfirst(str_replace('_', ' ', $item->jenis ?? 'Lainnya')))
                ->map(function ($items, $label) {
                    return [
                        'label' => $label,
                        'totalTransaksi' => $items->count(),
                        'totalDana' => (float) $items->sum('jumlah'),
                    ];
                })
                ->sortByDesc('totalDana')
                ->values();
            $breakdownPenyaluran = $penyaluranPrint->map(function (Penyaluran $item) {
                return [
                    'label' => $item->programPenyaluran?->nama_program ?? '—',
                    'totalPenerima' => (int) $item->penyaluranDetail->count(),
                    'totalTransaksi' => 1,
                    'totalDana' => (float) $item->penyaluranDetail->sum('jumlah_diterima'),
                ];
            })->sortByDesc('totalDana')->values();

            return view('admin.laporan.cetak-pdf', [
                'pemasukan' => $pemasukanPrint,
                'penyaluran' => $penyaluranPrint,
                'totalPemasukan' => $totalPemasukanPrint,
                'totalPenyaluran' => $totalPenyaluranPrint,
                'saldoAwal' => $saldoAwal,
                'saldoBersih' => $saldoAwal + $totalPemasukanPrint - $totalPenyaluranPrint,
                'totalTransaksiPemasukan' => $pemasukanPrint->count(),
                'totalTransaksiPenyaluran' => $penyaluranPrint->count(),
                'totalMustahik' => Mustahik::where('instansi_id', $instansiId)->count(),
                'breakdownPemasukan' => $breakdownPemasukan,
                'breakdownPenyaluran' => $breakdownPenyaluran,
                'filters' => [
                    'search' => $request->query('search'),
                ],
                'generatedAt' => now(),
                'report' => 'keuangan',
            ]);
        }

        $penyaluran = $penyaluranQuery->limit(12)->get();
        $totalPenyaluran = Penyaluran::where('instansi_id', $instansiId)
            ->with('penyaluranDetail')
            ->get()
            ->sum(fn (Penyaluran $item) => (float) $item->penyaluranDetail->sum('jumlah_diterima'));

        $saldoBersih = $totalPemasukan - $totalPenyaluran;

        return view('admin.laporan.laporan-keuangan-index', [
            'pemasukan' => $pemasukan,
            'penyaluran' => $penyaluran,
            'totalPemasukan' => $totalPemasukan,
            'totalPenyaluran' => $totalPenyaluran,
            'saldoBersih' => $saldoBersih,
            'totalTransaksiPemasukan' => TransaksiZakat::where('instansi_id', $instansiId)->count(),
            'totalTransaksiPenyaluran' => Penyaluran::where('instansi_id', $instansiId)->count(),
            'totalMustahik' => Mustahik::where('instansi_id', $instansiId)->count(),
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
