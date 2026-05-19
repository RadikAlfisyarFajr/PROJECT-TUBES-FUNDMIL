<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan | Admin Instansi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
    <style>
        :root {
            --green: #087026;
            --green-dark: #06451f;
            --green-soft: #dff3e4;
            --green-pale: #eef9f1;
            --ink: #17211b;
            --muted: #748077;
            --surface: #f5f8f5;
            --line: #e2ebe4;
            --shadow: 0 16px 34px rgba(18, 55, 28, .07);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            overflow-x: hidden;
            background: var(--surface);
            color: var(--ink);
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .admin-layout {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 88px minmax(0, 1fr);
            transition: grid-template-columns .25s ease;
        }

        body.sidebar-expanded .admin-layout { grid-template-columns: 280px minmax(0, 1fr); }

        .main-content { min-width: 0; padding: 18px 24px 38px; }

        .topbar {
            min-height: 56px;
            margin: -18px -24px 34px;
            padding: 16px 24px;
            background: #fff;
            border-bottom: 1px solid rgba(226,235,228,.8);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .page-title { margin: 0; font-size: 1.12rem; font-weight: 900; }
        .content-wrap { max-width: 1180px; margin: 0 auto; }
        .page-intro { margin-bottom: 24px; display: flex; align-items: flex-start; justify-content: space-between; gap: 24px; }
        .page-intro h2 { margin: 0 0 4px; font-size: 1.35rem; font-weight: 900; }
        .page-desc { margin: 0; color: var(--muted); font-size: .92rem; line-height: 1.65; }

        .summary-card {
            padding: 22px 24px;
            border: 1px solid var(--line);
            border-radius: 18px;
            background: #fff;
            box-shadow: var(--shadow);
            min-height: 118px;
        }
        .summary-card small {
            color: var(--muted);
            font-size: .75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .04em;
        }
        .summary-card h4 {
            margin: 6px 0 0;
            font-size: 1.25rem;
            font-weight: 900;
            color: var(--ink);
        }
        .summary-card.green-card {
            background: var(--green);
            border-color: transparent;
        }
        .summary-card.green-card small,
        .summary-card.green-card h4,
        .summary-card.green-card span {
            color: #fff;
        }

        .quick-links {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 18px;
        }

        .quick-link {
            min-height: 38px;
            padding: 0 14px;
            border-radius: 999px;
            border: 1px solid var(--line);
            background: #fff;
            color: var(--green-dark);
            text-decoration: none;
            font-size: .82rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .quick-link:hover { background: var(--green-soft); }

        .panel {
            padding: 22px;
            border: 1px solid var(--line);
            border-radius: 18px;
            background: #fff;
            box-shadow: var(--shadow);
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
        }
        .panel-header h5 { margin: 0; font-size: 1rem; font-weight: 900; }
        .panel-header small { color: var(--muted); }

        .filter-card {
            padding: 14px 18px;
            border: 1px solid var(--line);
            border-radius: 18px;
            background: #fff;
            box-shadow: var(--shadow);
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .mini-table thead th {
            background: var(--surface);
            color: var(--muted);
            font-size: .72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .04em;
            border-bottom: 1px solid var(--line);
            padding: 10px 14px;
        }
        .mini-table tbody td {
            padding: 12px 14px;
            border-bottom: 1px solid var(--line);
            font-size: .87rem;
            color: var(--ink);
            vertical-align: middle;
        }
        .mini-table tbody tr:last-child td { border-bottom: 0; }
        .mini-table tbody tr:hover td { background: var(--green-pale); }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: .7rem;
            font-weight: 900;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 999px;
        }
        .badge-status .dot { width: 7px; height: 7px; border-radius: 50%; }
        .badge-status.selesai { background: var(--green-soft); color: var(--green-dark); }
        .badge-status.selesai .dot { background: var(--green-dark); }
        .badge-status.proses { background: #fef3c7; color: #b45309; }
        .badge-status.proses .dot { background: #b45309; }

        .footer-note {
            padding: 16px 18px;
            border-radius: 14px;
            background: #eef7ef;
            border: 1px solid #d8eadf;
            color: #41544a;
            font-size: .84rem;
            line-height: 1.65;
        }

        .audit-badge {
            padding: 5px 12px;
            border-radius: 999px;
            background: var(--green-soft);
            color: var(--green-dark);
            font-size: .62rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .btn-export,
        .btn-print {
            min-height: 36px;
            padding: 0 16px;
            border: 0;
            border-radius: 10px;
            font-size: .78rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            cursor: pointer;
            transition: background .2s ease, color .2s ease;
        }

        .btn-export {
            background: var(--green-soft);
            color: var(--green-dark);
        }
        .btn-export:hover { background: #d0e8d6; color: var(--green-dark); }

        .btn-print {
            background: var(--green);
            color: #fff;
        }
        .btn-print:hover { background: var(--green-dark); color: #fff; }

        @media (max-width: 991px) {
            .admin-layout { grid-template-columns: 1fr; }
            .main-content { padding: 18px 16px 34px; }
            .topbar { margin: -18px -16px 28px; padding: 16px; flex-direction: column; align-items: flex-start; }
            .page-intro { flex-direction: column; }
        }
    </style>
</head>

<body class="sidebar-expanded">
<div class="admin-layout">

    @include('admin.partials.sidebar', ['active' => 'laporan'])

    <main class="main-content">
        <header class="topbar">
            <h1 class="page-title">Laporan Keuangan</h1>
            <div style="text-align:right;">
                <strong style="display:block; font-size:.9rem;">{{ auth()->user()?->name ?? 'Admin' }}</strong>
                <div style="font-size:.75rem; color:var(--muted);">Admin Instansi</div>
            </div>
        </header>

        <div class="content-wrap">
            <div class="page-intro">
                <div>
                    <h2>Laporan Keuangan</h2>
                    <p class="page-desc">Rekap pemasukan dan penyaluran yang terhubung langsung dengan laporan pemasukan, penyaluran, dan data mustahik.</p>
                </div>
            </div>

            <div class="quick-links">
                <a href="{{ route('laporan.pemasukan') }}" class="quick-link"><i class="bi bi-arrow-up-right-circle"></i> Pemasukan</a>
                <a href="{{ route('laporan.penyaluran') }}" class="quick-link"><i class="bi bi-arrow-down-right-circle"></i> Penyaluran</a>
                <a href="{{ route('laporan.mustahik') }}" class="quick-link"><i class="bi bi-people"></i> Mustahik</a>
                <a href="{{ route('laporan.index') }}" class="quick-link"><i class="bi bi-grid-1x2"></i> Semua Laporan</a>
            </div>

            <form action="{{ route('laporan.keuangan') }}" method="GET" class="filter-card">
                <div class="input-group input-group-sm" style="width:220px;">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search" style="color:var(--muted);"></i>
                    </span>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control border-start-0"
                        placeholder="Cari muzaki / program..."
                        style="font-size:.82rem;"
                    >
                </div>

                <button type="submit" class="btn-print ms-auto" style="border-radius:10px;">
                    Terapkan Filter
                </button>

                @if(request()->filled('search'))
                    <a href="{{ route('laporan.keuangan') }}" class="btn-export" style="border-radius:10px;">
                        <i class="bi bi-x"></i> Reset
                    </a>
                @endif
            </form>

            <div class="row g-3 mb-3">
                <div class="col-12 col-md-3">
                    <div class="summary-card">
                        <small>Total Pemasukan</small>
                        <h4>Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h4>
                        <span style="color:var(--muted); font-size:.76rem;">{{ number_format($totalTransaksiPemasukan, 0, ',', '.') }} transaksi</span>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="summary-card">
                        <small>Total Penyaluran</small>
                        <h4>Rp {{ number_format($totalPenyaluran, 0, ',', '.') }}</h4>
                        <span style="color:var(--muted); font-size:.76rem;">{{ number_format($totalTransaksiPenyaluran, 0, ',', '.') }} realisasi</span>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="summary-card green-card">
                        <small>Saldo Bersih</small>
                        <h4>Rp {{ number_format($saldoBersih, 0, ',', '.') }}</h4>
                        <span style="font-size:.76rem; opacity:.85;">Pemasukan dikurangi penyaluran</span>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="summary-card">
                        <small>Mustahik Terdata</small>
                        <h4>{{ number_format($totalMustahik, 0, ',', '.') }}</h4>
                        <span style="color:var(--muted); font-size:.76rem;">Penerima manfaat aktif</span>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-header">
                            <div>
                                <h5>Ringkasan Pemasukan</h5>
                                <small>Transaksi terbaru yang masuk ke kas instansi</small>
                            </div>
                            <span class="audit-badge">{{ number_format($pemasukan->count(), 0, ',', '.') }} data</span>
                        </div>

                        <div style="overflow-x:auto;">
                            <table class="table mini-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Muzaki</th>
                                        <th>Kategori</th>
                                        <th class="text-end">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pemasukan as $trx)
                                        <tr>
                                            <td>{{ \Illuminate\Support\Carbon::parse($trx->tanggal)->format('d M Y') }}</td>
                                            <td>
                                                <strong>{{ $trx->nama_muzakki ?? '-' }}</strong><br>
                                                <span style="color:var(--muted); font-size:.75rem;">{{ $trx->nomor_kuitansi ?? '-' }}</span>
                                            </td>
                                            <td>{{ optional($trx->kategori)->nama ?? '-' }}</td>
                                            <td class="text-end">Rp {{ number_format($trx->jumlah ?? 0, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4" style="color:var(--muted);">Belum ada data pemasukan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-header">
                            <div>
                                <h5>Ringkasan Penyaluran</h5>
                                <small>Realisasi dana yang sudah tersalurkan</small>
                            </div>
                            <span class="audit-badge">{{ number_format($penyaluran->count(), 0, ',', '.') }} data</span>
                        </div>

                        <div style="overflow-x:auto;">
                            <table class="table mini-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Program</th>
                                        <th>Status</th>
                                        <th class="text-end">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($penyaluran as $item)
                                        <tr>
                                            <td>{{ $item->tanggal_penyaluran?->format('d M Y') ?? '-' }}</td>
                                            <td>
                                                <strong>{{ $item->programPenyaluran?->nama_program ?? '-' }}</strong><br>
                                                <span style="color:var(--muted); font-size:.75rem;">{{ $item->penyaluranDetail->count() }} penerima</span>
                                            </td>
                                            <td>
                                                <span class="badge-status {{ $item->status }}">
                                                    <span class="dot"></span>
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            </td>
                                            <td class="text-end">Rp {{ number_format($item->penyaluranDetail->sum('jumlah_diterima'), 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4" style="color:var(--muted);">Belum ada data penyaluran.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <section class="footer-note mt-4">
                <strong>Laporan Keuangan</strong> menjadi titik pusat untuk melihat aliran dana masuk dan keluar.
                Gunakan tautan cepat di atas untuk pindah ke laporan pemasukan, penyaluran, atau data mustahik tanpa keluar dari area laporan.
            </section>
        </div>
    </main>
</div>
</body>
</html>
