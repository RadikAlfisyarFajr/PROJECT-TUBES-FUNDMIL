{{-- Laporan Data Mustahik - UI seragam dengan laporan-pemasukan-index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Mustahik | Admin Instansi</title>
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

        * { letter-spacing: 0; box-sizing: border-box; }

        body {
            margin: 0; min-height: 100vh; overflow-x: hidden;
            background: var(--surface); color: var(--ink);
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .admin-layout {
            min-height: 100vh; display: grid;
            grid-template-columns: 88px minmax(0, 1fr);
            transition: grid-template-columns .25s ease;
        }
        body.sidebar-expanded .admin-layout { grid-template-columns: 280px minmax(0, 1fr); }

        .main-content { min-width: 0; padding: 18px 24px 38px; background: var(--surface); }

        .topbar {
            min-height: 56px; margin: -18px -24px 34px; padding: 16px 24px;
            background: #fff; border-bottom: 1px solid rgba(226,235,228,.8);
            display: flex; align-items: center; justify-content: space-between; gap: 24px;
        }
        .page-title { margin: 0; font-size: 1.12rem; font-weight: 900; }
        .top-actions { display: flex; align-items: center; gap: 14px; }
        .content-wrap { max-width: 1180px; margin: 0 auto; }

        /* ── Account Profile Dropdown ── */
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

        /* ── Page intro ── */
        .page-intro { margin-bottom: 24px; display: flex; align-items: flex-start; justify-content: space-between; gap: 24px; }
        .page-intro h2 { margin: 0 0 4px; font-size: 1.35rem; font-weight: 900; color: var(--ink); }
        .page-desc { margin: 0; color: var(--muted); font-size: .92rem; line-height: 1.65; }

        /* ── Summary cards ── */
        .summary-card {
            padding: 22px 24px;
            border: 1px solid var(--line); border-radius: 18px;
            background: #fff; box-shadow: var(--shadow); min-height: 110px;
        }
        .summary-card small { color: var(--muted); font-size: .75rem; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; }
        .summary-card h4 { margin: 6px 0 0; font-size: 1.25rem; font-weight: 900; color: var(--ink); }
        .summary-card.green-card { background: var(--green); border-color: transparent; }
        .summary-card.green-card small,
        .summary-card.green-card h4,
        .summary-card.green-card span { color: #fff; }

        .stat-icon {
            width: 42px; height: 42px; border-radius: 12px;
            display: grid; place-items: center; font-size: 1.1rem;
            margin-bottom: 14px; flex: 0 0 auto;
        }

        /* ── Filter card ── */
        .filter-card {
            padding: 16px 20px;
            border: 1px solid var(--line); border-radius: 18px;
            background: #fff; box-shadow: var(--shadow);
            display: flex; gap: 10px; align-items: center;
            margin-bottom: 18px; flex-wrap: wrap;
        }

        /* ── Table card ── */
        .table-card {
            padding: 24px;
            border: 1px solid var(--line); border-radius: 18px;
            background: #fff; box-shadow: var(--shadow);
        }
        .table-card-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 16px;
        }
        .table-card-header h5 { margin: 0; font-size: 1rem; font-weight: 900; color: var(--ink); }

        .audit-badge {
            padding: 5px 12px; border-radius: 999px;
            background: var(--green-soft); color: var(--green-dark);
            font-size: .62rem; font-weight: 900; text-transform: uppercase; letter-spacing: .06em;
        }

        .table thead th {
            background: var(--surface); color: var(--muted);
            font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .04em;
            border-bottom: 1px solid var(--line); padding: 10px 14px;
        }
        .table tbody td {
            padding: 12px 14px; border-bottom: 1px solid var(--line);
            font-size: .87rem; color: var(--ink); vertical-align: middle;
        }
        .table tbody tr:last-child td { border-bottom: 0; }
        .table tbody tr:hover td { background: var(--green-pale); }

        /* ── Avatar inisial ── */
        .mustahik-avatar {
            width: 38px; height: 38px; border-radius: 50%;
            background: var(--green-soft); color: var(--green-dark);
            display: grid; place-items: center;
            font-size: .8rem; font-weight: 900; flex: 0 0 auto;
        }

        /* ── Badge asnaf & status ── */
        .badge-asnaf {
            padding: 4px 10px; border-radius: 999px;
            font-size: .62rem; font-weight: 900; text-transform: uppercase;
        }
        .badge-asnaf.fakir        { background: #fee2e2; color: #b91c1c; }
        .badge-asnaf.miskin       { background: #ffedd5; color: #c2410c; }
        .badge-asnaf.amil         { background: var(--green-soft); color: var(--green-dark); }
        .badge-asnaf.riqab        { background: #dbeafe; color: #1e40af; }
        .badge-asnaf.gharim       { background: #ede9fe; color: #6d28d9; }
        .badge-asnaf.fisabilillah { background: #fce7f3; color: #9d174d; }
        .badge-asnaf.ibnu_sabil   { background: #f3f4f6; color: #374151; }

        .badge-status {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: .7rem; font-weight: 900; text-transform: uppercase;
        }
        .badge-status .dot {
            width: 7px; height: 7px; border-radius: 50%; flex: 0 0 auto;
        }
        .badge-status.aktif    { color: var(--green); }
        .badge-status.aktif .dot    { background: var(--green); }
        .badge-status.nonaktif { color: #c0392b; }
        .badge-status.nonaktif .dot { background: #c0392b; }

        /* ── Tombol detail ── */
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

        /* ── Pagination ── */
        .paging-row {
            display: flex; align-items: center; justify-content: space-between;
            padding-top: 14px; margin-top: 4px; border-top: 1px solid var(--line);
        }
        .paging-row small { color: var(--muted); font-size: .78rem; }

        /* ── Buttons ── */
        .btn-export {
            min-height: 34px; padding: 0 16px; border: 1px solid var(--line); border-radius: 10px;
            background: #fff; color: var(--ink); font-size: .78rem; font-weight: 800;
            display: inline-flex; align-items: center; gap: 6px;
            cursor: pointer; transition: background .2s ease; text-decoration: none;
        }
        .btn-export:hover { background: var(--green-soft); color: var(--green-dark); }

        .btn-print {
            min-height: 34px; padding: 0 16px; border: 0; border-radius: 10px;
            background: var(--green); color: #fff; font-size: .78rem; font-weight: 800;
            display: inline-flex; align-items: center; gap: 6px;
            cursor: pointer; transition: background .2s ease; text-decoration: none;
        }
        .btn-print:hover { background: var(--green-dark); color: #fff; }

        /* ══ MODAL ══ */
        .modal-overlay {
            display: none; position: fixed; inset: 0; z-index: 1050;
            background: rgba(10, 30, 15, .45);
            align-items: center; justify-content: center; padding: 24px;
        }
        .modal-overlay.show { display: flex; }

        .modal-box {
            background: #fff; border-radius: 22px;
            width: 100%; max-width: 620px; max-height: 88vh;
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
        .modal-title   { margin: 0 0 3px; font-size: 1rem; font-weight: 900; color: var(--ink); }
        .modal-subtitle { margin: 0; color: var(--muted); font-size: .78rem; }

        .modal-close {
            width: 34px; height: 34px; border: 0; border-radius: 50%;
            background: var(--surface); color: var(--muted);
            display: grid; place-items: center; cursor: pointer; flex: 0 0 auto;
            transition: background .15s;
        }
        .modal-close:hover { background: #fde8e8; color: #c0392b; }

        .modal-body { padding: 22px 26px; overflow-y: auto; flex: 1 1 auto; }
        .modal-foot {
            padding: 16px 26px; border-top: 1px solid var(--line);
            display: flex; align-items: center; justify-content: flex-end; gap: 10px;
            flex: 0 0 auto;
        }

        /* ── Section label ── */
        .detail-section-label {
            margin: 0 0 12px; color: var(--muted);
            font-size: .65rem; font-weight: 900;
            text-transform: uppercase; letter-spacing: .1em;
            display: flex; align-items: center; gap: 8px;
        }
        .detail-section-label::after { content: ''; flex: 1; height: 1px; background: var(--line); }

        /* ── Detail grid ── */
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

        .alamat-clamp {
            display: block;
            line-height: 1.6;
            max-height: 3.2em;
            overflow: hidden;
        }

        /* ── Keterangan box ── */
        .keterangan-box {
            padding: 14px 16px; border-radius: 12px;
            background: var(--surface); border: 1px solid var(--line);
            font-size: .86rem; color: var(--ink); line-height: 1.6;
        }

        /* Skeleton */
        .skeleton-line {
            height: 14px; border-radius: 6px;
            background: linear-gradient(90deg, #eef3ee 25%, #dce8dc 50%, #eef3ee 75%);
            background-size: 200% 100%;
            animation: shimmer 1.3s infinite; margin-bottom: 10px;
        }
        @keyframes shimmer { from { background-position: 200% 0; } to { background-position: -200% 0; } }

        /* ── NIK mask ── */
        .nik-mono { font-family: monospace; font-size: .85rem; letter-spacing: .03em; }

        @media (max-width: 991px) {
            .admin-layout { grid-template-columns: 1fr; }
            .main-content { padding: 18px 16px 34px; }
            .topbar { margin: -18px -16px 28px; padding: 16px; flex-direction: column; align-items: flex-start; }
            .top-actions { width: 100%; }
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
            <h1 class="page-title">Laporan Data Mustahik</h1>
            <div class="top-actions">
                <a href="{{ route('laporan.mustahik', array_merge(request()->except(['page', 'print']), ['print' => 1])) }}" target="_blank" rel="noopener" class="btn-print">
                    <i class="bi bi-printer"></i> Cetak PDF
                </a>
                <div class="account-profile">
                    <div style="text-align: right;">
                        <strong style="display: block; font-size: .9rem; color: var(--ink);">{{ auth()->user()?->name ?? 'Admin' }}</strong>
                        <div style="font-size: .75rem; color: var(--muted);">Admin Instansi</div>
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

            {{-- PAGE INTRO --}}
            <div class="page-intro">
                <div>
                    <h2>Laporan Data Mustahik</h2>
                    <p class="page-desc">Daftar lengkap penerima manfaat beserta status kelayakan dan riwayat penerimaan bantuan.</p>
                </div>
            </div>

            {{-- SUMMARY CARDS --}}
            <div class="row g-3 mb-3">
                <div class="col-6 col-md-3">
                    <div class="summary-card">
                        <div class="stat-icon" style="background:#e8f5e9; color:var(--green);">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <small>Total Mustahik</small>
                        <h4>{{ number_format($totalMustahik, 0, ',', '.') }}</h4>
                        <span style="color:var(--muted); font-size:.76rem;">Terdata</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="summary-card">
                        <div class="stat-icon" style="background:#d4f1d4; color:#0b7a36;">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <small>Aktif</small>
                        <h4>{{ number_format($aktifMustahik, 0, ',', '.') }}</h4>
                        <span style="color:var(--muted); font-size:.76rem;">Siap disalurkan</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="summary-card">
                        <div class="stat-icon" style="background:#fdecea; color:#c0392b;">
                            <i class="bi bi-x-circle-fill"></i>
                        </div>
                        <small>Tidak Aktif</small>
                        <h4>{{ number_format($tidakAktifMustahik, 0, ',', '.') }}</h4>
                        <span style="color:var(--muted); font-size:.76rem;">Perlu pembaruan</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="summary-card green-card">
                        <div class="stat-icon" style="background:rgba(255,255,255,.2); color:#fff;">
                            <i class="bi bi-bar-chart-fill"></i>
                        </div>
                        <small>Kategori Terbanyak</small>
                        <h4 style="font-size:1rem; margin-top:8px;">{{ $kategoriTerbanyak }}</h4>
                        <span style="font-size:.76rem; opacity:.85;">Asnaf dominan</span>
                    </div>
                </div>
            </div>

            {{-- FILTER --}}
            <form action="{{ route('laporan.mustahik') }}" method="GET" class="filter-card">
                <div class="input-group input-group-sm" style="width:220px;">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search" style="color:var(--muted);"></i>
                    </span>
                    <input
                        type="text" name="search"
                        value="{{ request('search') }}"
                        class="form-control border-start-0"
                        placeholder="Cari nama atau alamat…"
                        style="font-size:.82rem;"
                    >
                </div>

                <select name="kategori" class="form-select form-select-sm w-auto" style="font-size:.82rem;">
                    <option value="semua">Semua Kategori</option>
                    @foreach($kategoriAsnaf as $value => $label)
                        <option value="{{ $value }}" @selected(request('kategori') === $value)>{{ $label }}</option>
                    @endforeach
                </select>

                <select name="status" class="form-select form-select-sm w-auto" style="font-size:.82rem;">
                    <option value="semua">Semua Status</option>
                    <option value="aktif"       @selected(request('status') === 'aktif')>Aktif</option>
                    <option value="tidak_aktif" @selected(request('status') === 'tidak_aktif')>Tidak Aktif</option>
                </select>

                <button type="submit" class="btn-print ms-auto" style="border-radius:10px;">
                    Terapkan Filter
                </button>

                @if(request()->hasAny(['search','kategori','status']))
                    <a href="{{ route('laporan.mustahik') }}" class="btn-export" style="border-radius:10px;">
                        <i class="bi bi-x"></i> Reset
                    </a>
                @endif
            </form>

            {{-- TABLE --}}
            <div class="table-card">
                <div class="table-card-header">
                    <h5>Daftar Mustahik <span style="color:var(--muted); font-weight:400; font-size:.85rem;">({{ number_format($mustahik->total(), 0, ',', '.') }} data)</span></h5>
                    <span class="audit-badge">Point in Time</span>
                </div>

                <div style="overflow-x:auto;">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Kategori Asnaf</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th style="width:80px; text-align:center;">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mustahik as $row)
                                @php
                                    $initials = collect(explode(' ', $row->nama))
                                        ->filter()->take(2)
                                        ->map(fn($p) => strtoupper(substr($p, 0, 1)))
                                        ->join('');
                                    $asnafClass = str_replace(' ', '_', strtolower($row->kategori_asnaf));
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="mustahik-avatar">{{ $initials ?: 'M' }}</div>
                                            <div>
                                                <div style="font-weight:800; font-size:.9rem;">{{ $row->nama }}</div>
                                                <div style="color:var(--muted); font-size:.75rem;">{{ $row->kontak ?: 'Kontak belum diisi' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($row->nik)
                                            <span class="nik-mono">
                                                {{ substr($row->nik, 0, 6) }}******{{ substr($row->nik, -4) }}
                                            </span>
                                        @else
                                            <span style="color:var(--muted);">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge-asnaf {{ $asnafClass }}">
                                            {{ $row->kategori_label ?? ($kategoriAsnaf[$row->kategori_asnaf] ?? $row->kategori_asnaf) }}
                                        </span>
                                    </td>
                                    <td style="font-size:.84rem; max-width:200px;">
                                        <span class="alamat-clamp">
                                            {{ $row->alamat }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-status {{ $row->status === 'aktif' ? 'aktif' : 'nonaktif' }}">
                                            <span class="dot"></span>
                                            {{ $row->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                    <td style="text-align:center;">
                                        <button
                                            class="btn-detail"
                                            type="button"
                                            data-detail-id="{{ $row->id }}"
                                            aria-label="Lihat detail mustahik"
                                        >
                                            <i class="bi bi-eye"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4" style="color:var(--muted);">
                                        Tidak ada data mustahik
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="paging-row">
                    <small>
                        {{ $mustahik->firstItem() ?? 0 }} – {{ $mustahik->lastItem() ?? 0 }}
                        dari {{ number_format($mustahik->total(), 0, ',', '.') }} mustahik
                    </small>
                    {{ $mustahik->links() }}
                </div>
            </div>

        </div>
    </main>
</div>


{{-- ═══════════════════════════════════════════
     MODAL DETAIL MUSTAHIK
═══════════════════════════════════════════ --}}
<div class="modal-overlay" id="detailModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal-box">

        {{-- Header --}}
        <div class="modal-head">
            <div class="modal-head-left">
                <div class="modal-icon-wrap">
                    <i class="bi bi-person-vcard"></i>
                </div>
                <div>
                    <h2 class="modal-title" id="modalTitle">Detail Mustahik</h2>
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
            </div>
            <div id="modalContent" style="display:none;"></div>
            <div id="modalError" style="display:none; color:#c0392b; font-size:.88rem; font-weight:700; padding:12px 0;">
                <i class="bi bi-exclamation-circle"></i> Gagal memuat data. Silakan coba lagi.
            </div>
        </div>

        {{-- Footer --}}
        <div class="modal-foot">
            <button class="btn-export" onclick="closeDetail()">
                <i class="bi bi-x"></i> Tutup
            </button>
            <a id="modalEditBtn" href="#" class="btn-print">
                <i class="bi bi-pencil"></i> Edit Data
            </a>
        </div>

    </div>
</div>


<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', () =>
        document.body.classList.toggle('sidebar-expanded')
    );

    document.getElementById('detailModal').addEventListener('click', function (e) {
        if (e.target === this) closeDetail();
    });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDetail(); });
    document.querySelectorAll('[data-detail-id]').forEach((button) => {
        button.addEventListener('click', () => openDetail(button.dataset.detailId));
    });

    /* ════════════ openDetail ════════════ */
    function openDetail(id) {
        const modal   = document.getElementById('detailModal');
        const skel    = document.getElementById('modalSkeleton');
        const content = document.getElementById('modalContent');
        const errBox  = document.getElementById('modalError');

        skel.style.display    = 'block';
        content.style.display = 'none';
        errBox.style.display  = 'none';
        document.getElementById('modalSubtitle').textContent = 'Memuat data…';
        document.getElementById('modalEditBtn').href         = '#';

        modal.classList.add('show');
        document.body.style.overflow = 'hidden';

        fetch(`{{ url('laporan/mustahik') }}/${id}/detail`, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
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
    const safe = s => String(s || '—').replace(/[&<>"']/g, c =>
        ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[c])
    );

    const asnafBadge = (key, label) => {
        const colorMap = {
            fakir:        'background:#fee2e2; color:#b91c1c;',
            miskin:       'background:#ffedd5; color:#c2410c;',
            amil:         'background:#dff3e4; color:#06451f;',
            riqab:        'background:#dbeafe; color:#1e40af;',
            gharim:       'background:#ede9fe; color:#6d28d9;',
            fisabilillah: 'background:#fce7f3; color:#9d174d;',
            ibnu_sabil:   'background:#f3f4f6; color:#374151;',
        };
        const style = colorMap[key] || 'background:#f0f0f0; color:#555;';
        return `<span style="padding:4px 10px; border-radius:999px; ${style} font-size:.65rem; font-weight:900; text-transform:uppercase;">${safe(label)}</span>`;
    };

    const statusBadge = s => {
        const aktif = s === 'aktif';
        const style = aktif
            ? 'color:#06451f;'
            : 'color:#c0392b;';
        const dot = aktif ? '#06451f' : '#c0392b';
        return `<span style="display:inline-flex; align-items:center; gap:6px; font-size:.72rem; font-weight:900; text-transform:uppercase; ${style}">
                    <span style="width:7px; height:7px; border-radius:50%; background:${dot}; display:inline-block;"></span>
                    ${aktif ? 'Aktif' : 'Tidak Aktif'}
                </span>`;
    };

    /* ════════════ renderDetail ════════════ */
    function renderDetail(d) {
        document.getElementById('modalSubtitle').textContent = d.nama ?? '';
        document.getElementById('modalEditBtn').href         = `{{ url('mustahik') }}/${d.id}/edit`;

        document.getElementById('modalContent').innerHTML = `

            <!-- Identitas -->
            <p class="detail-section-label">
                <i class="bi bi-person-fill" style="color:var(--green);"></i>
                Identitas
            </p>
            <div class="detail-grid">
                <div class="detail-field">
                    <span class="detail-field-label">Nama Lengkap</span>
                    <span class="detail-field-value">${safe(d.nama)}</span>
                </div>
                <div class="detail-field">
                    <span class="detail-field-label">NIK</span>
                    <span class="detail-field-value" style="font-family:monospace;">${safe(d.nik_display)}</span>
                </div>
                <div class="detail-field">
                    <span class="detail-field-label">Kontak / WhatsApp</span>
                    <span class="detail-field-value">${safe(d.kontak)}</span>
                </div>
                <div class="detail-field">
                    <span class="detail-field-label">Tanggal Verifikasi</span>
                    <span class="detail-field-value">${safe(d.tanggal_verifikasi)}</span>
                </div>
            </div>

            <!-- Kelayakan -->
            <p class="detail-section-label">
                <i class="bi bi-shield-check" style="color:var(--green);"></i>
                Kelayakan
            </p>
            <div class="detail-grid" style="margin-bottom:18px;">
                <div class="detail-field">
                    <span class="detail-field-label">Kategori Asnaf</span>
                    <span class="detail-field-value">${asnafBadge(d.kategori_asnaf, d.kategori_label)}</span>
                </div>
                <div class="detail-field">
                    <span class="detail-field-label">Status</span>
                    <span class="detail-field-value">${statusBadge(d.status)}</span>
                </div>
                <div class="detail-field" style="grid-column:1/-1;">
                    <span class="detail-field-label">Alamat Lengkap</span>
                    <span class="detail-field-value">${safe(d.alamat)}</span>
                </div>
            </div>

            <!-- Keterangan -->
            ${d.keterangan ? `
            <p class="detail-section-label">
                <i class="bi bi-chat-left-text" style="color:var(--green);"></i>
                Keterangan
            </p>
            <div class="keterangan-box">${safe(d.keterangan)}</div>
            ` : ''}
        `;
    }
</script>
</body>
</html>
