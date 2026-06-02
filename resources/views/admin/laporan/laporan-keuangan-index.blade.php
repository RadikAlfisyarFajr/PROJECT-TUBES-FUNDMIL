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

        .account-profile {
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
        }

        .account-dropdown {
        position: relative;
        }

        .account-dropdown summary {
        cursor: pointer;
        list-style: none;
        }

        .account-dropdown summary::-webkit-details-marker {
        display: none;
        }

        .admin-avatar {
        width: 42px; height: 42px; border-radius: 50%;
        background: var(--green); color: #fff;
        display: grid; place-items: center;
        font-weight: 900; font-size: .95rem;
        cursor: pointer;
        }

        .account-dropdown-menu {
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        width: 190px;
        padding: 8px;
        border: 1px solid #e2ebe4;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 18px 38px rgba(20, 47, 27, .13);
        z-index: 30;
        }

        .account-dropdown-item {
        width: 100%;
        min-height: 40px;
        padding: 0 10px;
        border: 0;
        border-radius: 10px;
        background: transparent;
        color: #26352b;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: .84rem;
        font-weight: 800;
        text-decoration: none;
        text-align: left;
        }

        .account-dropdown-item:hover {
        background: #eaf3eb;
        color: #0f722b;
        }   

        .account-dropdown-item.logout {
        color: #b42318;
        }

        .account-dropdown-item.logout:hover {
        background: #fff0ee;
        color: #9f1f14;
        }   

        /* ══ MODAL DETAIL ══ */
        .modal-overlay {
            display: none; position: fixed; inset: 0; z-index: 1050;
            background: rgba(10, 30, 15, .45);
            align-items: center; justify-content: center; padding: 24px;
        }
        .modal-overlay.show { display: flex; }

        .modal-box {
            background: #fff; border-radius: 22px;
            width: 100%; max-width: 680px; max-height: 88vh;
            display: flex; flex-direction: column;
            box-shadow: 0 28px 60px rgba(8, 40, 18, .22);
            animation: modalIn .2s ease; overflow: hidden;
        }
        @keyframes modalIn {
            from { transform: translateY(18px) scale(.97); opacity: 0; }
            to   { transform: translateY(0) scale(1); opacity: 1; }
        }

        .modal-head {
            padding: 22px 26px 18px; border-bottom: 1px solid var(--line);
            display: flex; align-items: flex-start; justify-content: space-between; gap: 16px;
            flex: 0 0 auto;
        }
        .modal-head-left { display: flex; align-items: center; gap: 14px; }
        .modal-icon-wrap {
            width: 44px; height: 44px; border-radius: 14px;
            background: var(--green-soft); color: var(--green);
            display: grid; place-items: center; font-size: 1.2rem; flex: 0 0 auto;
        }
        .modal-title  { margin: 0 0 3px; font-size: 1rem; font-weight: 900; color: var(--ink); }
        .modal-subtitle { margin: 0; color: var(--muted); font-size: .78rem; }

        .modal-close {
            width: 34px; height: 34px; border: 0; border-radius: 50%;
            background: var(--surface); color: var(--muted);
            display: grid; place-items: center; cursor: pointer; flex: 0 0 auto;
            transition: background .15s;
        }
        .modal-close:hover { background: #fde8e8; color: #c0392b; }

        .modal-body { padding: 22px 26px; overflow-y: auto; flex: 1 1 auto; }

        .detail-section-label {
            margin: 0 0 12px; color: var(--muted);
            font-size: .65rem; font-weight: 900;
            text-transform: uppercase; letter-spacing: .1em;
            display: flex; align-items: center; gap: 8px;
        }
        .detail-section-label::after {
            content: ''; flex: 1; height: 1px; background: var(--line);
        }

        .detail-grid {
            display: grid; grid-template-columns: repeat(2, 1fr);
            gap: 14px 20px; margin-bottom: 22px;
        }
        .detail-field { display: flex; flex-direction: column; gap: 3px; }
        .detail-field-label {
            color: var(--muted); font-size: .68rem; font-weight: 800;
            text-transform: uppercase; letter-spacing: .04em;
        }
        .detail-field-value { color: var(--ink); font-size: .9rem; font-weight: 700; }

        .item-table { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        .item-table thead th {
            background: var(--surface); color: var(--muted);
            font-size: .65rem; font-weight: 900;
            text-transform: uppercase; letter-spacing: .04em;
            padding: 8px 12px; border-bottom: 1px solid var(--line); text-align: left;
        }
        .item-table thead th.text-end { text-align: right; }
        .item-table tbody td {
            padding: 10px 12px; border-bottom: 1px solid var(--line);
            font-size: .84rem; color: var(--ink); vertical-align: middle;
        }
        .item-table tbody tr:last-child td { border-bottom: 0; }
        .item-table tbody tr:hover td { background: var(--green-pale); }

        .detail-totals {
            display: flex; gap: 16px; padding: 14px 16px;
            border-radius: 14px; background: var(--green-soft); margin-bottom: 4px;
        }
        .detail-total-item { flex: 1; }
        .detail-total-label {
            color: var(--green-dark); font-size: .65rem; font-weight: 900;
            text-transform: uppercase; letter-spacing: .06em; margin-bottom: 4px;
        }
        .detail-total-value { color: var(--green); font-size: 1.05rem; font-weight: 900; }

        .modal-foot {
            padding: 16px 26px; border-top: 1px solid var(--line);
            display: flex; align-items: center; justify-content: space-between; gap: 12px;
            flex: 0 0 auto;
        }
        .modal-receipt-tag { font-size: .72rem; color: var(--muted); font-weight: 700; }
        .modal-receipt-tag strong { color: var(--ink); }

        .btn-detail {
            min-height: 30px; padding: 0 12px;
            border: 1px solid var(--line); border-radius: 8px;
            background: #fff; color: var(--green-dark);
            font-size: .72rem; font-weight: 800;
            display: inline-flex; align-items: center; gap: 5px;
            cursor: pointer; transition: background .18s ease, border-color .18s ease;
            white-space: nowrap;
        }
        .btn-detail:hover { background: var(--green-soft); border-color: #a3d4b0; }
        .btn-detail i { font-size: .8rem; }

        .skeleton-line {
            height: 14px; border-radius: 6px;
            background: linear-gradient(90deg, #eef3ee 25%, #dce8dc 50%, #eef3ee 75%);
            background-size: 200% 100%;
            animation: shimmer 1.3s infinite; margin-bottom: 10px;
        }
        @keyframes shimmer { from { background-position: 200% 0; } to { background-position: -200% 0; } }

        @media (max-width: 991px) {
            .admin-layout { grid-template-columns: 1fr; }
            .main-content { padding: 18px 16px 34px; }
            .topbar { margin: -18px -16px 28px; padding: 16px; flex-direction: column; align-items: flex-start; }
            .page-intro { flex-direction: column; }
            .detail-grid { grid-template-columns: 1fr; }
            .modal-overlay { padding: 12px; }
        }
    </style>
</head>

<body class="sidebar-expanded">
<div class="admin-layout">

    @include('admin.partials.sidebar', ['active' => 'laporan'])

    <main class="main-content">
        <header class="topbar">
            <h1 class="page-title">Laporan Keuangan</h1>
            <div style="display:flex; align-items:center; gap:12px;">
                <a href="{{ route('laporan.keuangan', array_merge(request()->except(['page', 'print']), ['print' => 1])) }}" target="_blank" rel="noopener" class="btn-print">
                    <i class="bi bi-printer"></i> Cetak PDF
                </a>
                <div class="account-profile">
                    <div style="text-align:right;">
                        <strong style="display:block; font-size:.9rem;">{{ auth()->user()?->name ?? 'Admin' }}</strong>
                        <div style="font-size:.75rem; color:var(--muted);">Admin Instansi</div>
                    </div>
                    <details class="account-dropdown">
                        <summary class="admin-avatar" aria-label="Buka menu profil">
                            {{ strtoupper(substr(auth()->user()?->name ?? 'A', 0, 1)) }}{{ strtoupper(substr(explode(' ', auth()->user()?->name ?? 'A')[1] ?? '', 0, 1)) }}
                        </summary>
                        <div class="account-dropdown-menu">
                            <a class="account-dropdown-item" href="{{ route('profil-instansi.index') }}">
                                <i class="bi bi-person-circle"></i>
                                <span>Lihat Profile</span>
                            </a>
                            <form action="{{ route('logout') }}" method="POST" style="display: contents;">
                                @csrf
                                <button class="account-dropdown-item logout" type="submit">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Logout Akun</span>
                                </button>
                            </form>
                        </div>
                    </details>
                </div>
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
                                        <th style="width:80px; text-align:center;">Detail</th>
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
                                            <td style="text-align:center;">
                                                <button
                                                    class="btn-detail"
                                                    type="button"
                                                    data-detail-id="{{ $trx->id }}"
                                                    aria-label="Lihat detail transaksi"
                                                >
                                                    <i class="bi bi-eye"></i> Detail
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4" style="color:var(--muted);">Belum ada data pemasukan.</td>
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
                                        <th style="width:80px; text-align:center;">Detail</th>
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
                                            <td style="text-align:center;">
                                                <button
                                                    class="btn-detail btn-penyaluran-detail"
                                                    type="button"
                                                    data-penyaluran-id="{{ $item->id }}"
                                                    aria-label="Lihat detail penyaluran"
                                                >
                                                    <i class="bi bi-eye"></i> Detail
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4" style="color:var(--muted);">Belum ada data penyaluran.</td>
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

{{-- ═══════════════════════════════════════════
     MODAL DETAIL TRANSAKSI
═══════════════════════════════════════════ --}}
<div class="modal-overlay" id="detailModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal-box">

        {{-- Header --}}
        <div class="modal-head">
            <div class="modal-head-left">
                <div class="modal-icon-wrap">
                    <i class="bi bi-receipt-cutoff"></i>
                </div>
                <div>
                    <h2 class="modal-title" id="modalTitle">Detail Transaksi</h2>
                    <p class="modal-subtitle" id="modalSubtitle">Memuat data…</p>
                </div>
            </div>
            <button class="modal-close" onclick="closeDetail()" aria-label="Tutup">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        {{-- Body --}}
        <div class="modal-body" id="modalBody">
            <div id="modalSkeleton">
                <div class="skeleton-line" style="width:40%; margin-bottom:18px;"></div>
                <div class="skeleton-line" style="width:100%;"></div>
                <div class="skeleton-line" style="width:80%;"></div>
                <div class="skeleton-line" style="width:90%; margin-bottom:18px;"></div>
                <div class="skeleton-line" style="width:60%;"></div>
                <div class="skeleton-line" style="width:100%;"></div>
                <div class="skeleton-line" style="width:75%;"></div>
            </div>
            <div id="modalContent" style="display:none;"></div>
            <div id="modalError" style="display:none; color:#c0392b; font-size:.88rem; font-weight:700; padding:12px 0;">
                <i class="bi bi-exclamation-circle"></i> Gagal memuat data. Silakan coba lagi.
            </div>
        </div>

        {{-- Footer --}}
        <div class="modal-foot">
            <div class="modal-receipt-tag">
                No. Kuitansi: <strong id="modalReceiptNo">—</strong>
            </div>
            <div style="display:flex; gap:10px;">
                <button class="btn-export" onclick="closeDetail()">
                    <i class="bi bi-x"></i> Tutup
                </button>
                <a id="modalPrintBtn" href="#" target="_blank" class="btn-print">
                    <i class="bi bi-printer"></i> Cetak Struk
                </a>
            </div>
        </div>

    </div>
</div>

<script>
    /* ── Sidebar ── */
    const sidebarToggle = document.getElementById('sidebarToggle');
    sidebarToggle?.addEventListener('click', () => {
        document.body.classList.toggle('sidebar-expanded');
    });

    /* ── Backdrop & Escape ── */
    document.getElementById('detailModal').addEventListener('click', function (e) {
        if (e.target === this) closeDetail();
    });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeDetail(); });
    
    /* Attach event listeners untuk pemasukan detail */
    document.querySelectorAll('[data-detail-id]').forEach((button) => {
        button.addEventListener('click', () => openDetail(button.dataset.detailId));
    });

    /* ════════════════════════════════
       openDetail — fetch & render
    ════════════════════════════════ */
    function openDetail(id) {
        const modal   = document.getElementById('detailModal');
        const skel    = document.getElementById('modalSkeleton');
        const content = document.getElementById('modalContent');
        const errBox  = document.getElementById('modalError');

        /* Reset */
        skel.style.display    = 'block';
        content.style.display = 'none';
        errBox.style.display  = 'none';
        document.getElementById('modalSubtitle').textContent  = 'Memuat data…';
        document.getElementById('modalReceiptNo').textContent = '—';
        document.getElementById('modalPrintBtn').href         = '#';

        modal.classList.add('show');
        document.body.style.overflow = 'hidden';

        fetch(`{{ url('laporan/pemasukan') }}/${id}/detail`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(r => { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); })
        .then(data => {
            renderDetail(data);
            skel.style.display    = 'none';
            content.style.display = 'block';
        })
        .catch(() => {
            skel.style.display   = 'none';
            errBox.style.display = 'block';
        });
    }

    function closeDetail() {
        document.getElementById('detailModal').classList.remove('show');
        document.body.style.overflow = '';
    }

    /* ── Helpers ── */
    const fRp  = v => new Intl.NumberFormat('id-ID', { style:'currency', currency:'IDR', maximumFractionDigits:0 }).format(v || 0);
    const fKg  = v => `${parseFloat(v || 0).toLocaleString('id-ID')} Kg`;
    const safe = s => String(s || '—').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[c]));

    /* ── Badge kategori ── */
    function katBadge(k, label) {
        const map = { infaq_sedekah:'infaq', fidyah:'fidyah', zakat_maal:'maal' };
        const cls = 'badge-kategori ' + (map[k] || '');
        return `<span class="${cls}">${safe(label)}</span>`;
    }

    /* ── Badge metode ── */
    function metodeBadge(m) {
        const styles = {
            tunai:    'background:#e6f4ea; color:#06451f;',
            transfer: 'background:#e0eeff; color:#1a4f8a;',
            qris:     'background:#f3e8ff; color:#5b1e99;',
        };
        const style = styles[m] || 'background:#f0f0f0; color:#555;';
        return `<span style="padding:4px 10px; border-radius:999px; ${style} font-size:.68rem; font-weight:900; text-transform:uppercase;">${safe(m)}</span>`;
    }

    /* ════════════════════════════════
       renderDetail — isi modal
    ════════════════════════════════ */
    function renderDetail(d) {
        document.getElementById('modalSubtitle').textContent  = d.tanggal ?? '';
        document.getElementById('modalReceiptNo').textContent = d.nomor_kuitansi ?? '—';
        document.getElementById('modalPrintBtn').href         = `{{ route('laporan.pemasukan.struk', ['id' => '__ID__']) }}`.replace('__ID__', d.id);

        /* Baris item pembayaran */
        const itemRows = (d.items && d.items.length)
            ? d.items.map(item => `
                <tr>
                    <td>${katBadge(item.kategori_utama, item.label_kategori)}</td>
                    <td style="color:var(--muted); font-size:.82rem;">${safe(item.sub)}</td>
                    <td>${safe(item.jumlah_input)}</td>
                    <td class="text-end" style="font-weight:800; color:#0b7a36;">${fRp(item.subtotal)}</td>
                    <td style="color:var(--muted); font-size:.8rem;">${safe(item.keterangan)}</td>
                </tr>`).join('')
            : `<tr><td colspan="5" style="text-align:center; color:var(--muted); padding:18px;">
                   Tidak ada item pembayaran.
               </td></tr>`;

        document.getElementById('modalContent').innerHTML = `

            <!-- Identitas Muzaki -->
            <p class="detail-section-label">
                <i class="bi bi-person-fill" style="color:var(--green);"></i>
                Identitas Muzaki
            </p>
            <div class="detail-grid">
                <div class="detail-field">
                    <span class="detail-field-label">Nama Lengkap</span>
                    <span class="detail-field-value">${safe(d.nama_muzakki)}</span>
                </div>
                <div class="detail-field">
                    <span class="detail-field-label">No. Telepon / WhatsApp</span>
                    <span class="detail-field-value">${safe(d.nomor_wa)}</span>
                </div>
                <div class="detail-field">
                    <span class="detail-field-label">Desa / Kelurahan</span>
                    <span class="detail-field-value">${safe(d.desa)}</span>
                </div>
                <div class="detail-field">
                    <span class="detail-field-label">RW / RT</span>
                    <span class="detail-field-value">${safe(d.alamat_detail)}</span>
                </div>
                <div class="detail-field">
                    <span class="detail-field-label">Tanggal Transaksi</span>
                    <span class="detail-field-value">${safe(d.tanggal)}</span>
                </div>
                <div class="detail-field">
                    <span class="detail-field-label">Metode Pembayaran</span>
                    <span class="detail-field-value">${metodeBadge(d.jenis_pembayaran)}</span>
                </div>
            </div>

            <!-- Item Pembayaran -->
            <p class="detail-section-label">
                <i class="bi bi-list-ul" style="color:var(--green);"></i>
                Item Pembayaran
            </p>
            <div style="overflow-x:auto; margin-bottom:18px;">
                <table class="item-table">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Tipe / Sub</th>
                            <th>Nilai Input</th>
                            <th class="text-end">Subtotal</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>${itemRows}</tbody>
                </table>
            </div>

            <!-- Ringkasan -->
            <p class="detail-section-label">
                <i class="bi bi-calculator" style="color:var(--green);"></i>
                Ringkasan
            </p>
            <div class="detail-totals">
                <div class="detail-total-item">
                    <div class="detail-total-label">Total Nominal Uang</div>
                    <div class="detail-total-value">${fRp(d.total_uang)}</div>
                </div>
                <div class="detail-total-item">
                    <div class="detail-total-label">Total Berat Beras</div>
                    <div class="detail-total-value">${fKg(d.total_beras_kg)}</div>
                </div>
            </div>
        `;
    }
</script>
</body>
</html>
