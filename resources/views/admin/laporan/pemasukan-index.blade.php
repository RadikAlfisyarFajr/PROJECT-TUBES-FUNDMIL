{{-- Laporan Pemasukan — dengan tombol Detail & modal popup rincian transaksi --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pemasukan | Admin Instansi</title>
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

        .page-intro {
            margin-bottom: 24px;
            display: flex; align-items: flex-start; justify-content: space-between; gap: 24px;
        }
        .page-intro h2 { margin: 0 0 4px; font-size: 1.35rem; font-weight: 900; color: var(--ink); }
        .page-desc { margin: 0; color: var(--muted); font-size: .92rem; line-height: 1.65; }

        .filter-card {
            padding: 16px 20px;
            border: 1px solid var(--line); border-radius: 18px;
            background: #fff; box-shadow: var(--shadow);
            display: flex; gap: 10px; align-items: center;
            margin-bottom: 18px; flex-wrap: wrap;
        }

        .summary-card {
            padding: 22px 24px;
            border: 1px solid var(--line); border-radius: 18px;
            background: #fff; box-shadow: var(--shadow);
            min-height: 110px;
        }
        .summary-card small { color: var(--muted); font-size: .75rem; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; }
        .summary-card h4 { margin: 6px 0 0; font-size: 1.25rem; font-weight: 900; color: var(--ink); }
        .summary-card.saldo-akhir { background: var(--green); border-color: transparent; }
        .summary-card.saldo-akhir small,
        .summary-card.saldo-akhir h4,
        .summary-card.saldo-akhir span { color: #fff; }

        .mutasi-row { display: flex; gap: 28px; margin-top: 10px; }
        .mutasi-label { color: var(--muted); font-size: .72rem; font-weight: 700; text-transform: uppercase; }
        .mutasi-debet { color: #0b7a36; font-size: 1.05rem; font-weight: 900; }
        .mutasi-kredit { color: #c0392b; font-size: 1.05rem; font-weight: 900; }

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
            background: var(--surface);
            color: var(--muted);
            font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .04em;
            border-bottom: 1px solid var(--line);
            padding: 10px 14px;
        }
        .table tbody td {
            padding: 12px 14px;
            border-bottom: 1px solid var(--line);
            font-size: .87rem; color: var(--ink);
            vertical-align: middle;
        }
        .table tbody tr:last-child td { border-bottom: 0; }
        .table tbody tr:hover td { background: var(--green-pale); }

        .badge-jenis {
            padding: 5px 10px; border-radius: 999px;
            background: var(--green-soft); color: var(--green-dark);
            font-size: .65rem; font-weight: 900; text-transform: uppercase;
        }

        /* ── TOMBOL DETAIL ── */
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

        /* ── PAGINATION ── */
        .paging-row {
            display: flex; align-items: center; justify-content: space-between;
            padding-top: 14px; margin-top: 4px; border-top: 1px solid var(--line);
        }
        .paging-row small { color: var(--muted); font-size: .78rem; }

        .btn-export {
            min-height: 34px; padding: 0 16px; border: 1px solid var(--line); border-radius: 10px;
            background: #fff; color: var(--ink);
            font-size: .78rem; font-weight: 800;
            display: inline-flex; align-items: center; gap: 6px;
            cursor: pointer; transition: background .2s ease; text-decoration: none;
        }
        .btn-export:hover { background: var(--green-soft); color: var(--green-dark); }

        .btn-print {
            min-height: 34px; padding: 0 16px; border: 0; border-radius: 10px;
            background: var(--green); color: #fff;
            font-size: .78rem; font-weight: 800;
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

        /* ── Section label ── */
        .detail-section-label {
            margin: 0 0 12px; color: var(--muted);
            font-size: .65rem; font-weight: 900;
            text-transform: uppercase; letter-spacing: .1em;
            display: flex; align-items: center; gap: 8px;
        }
        .detail-section-label::after {
            content: ''; flex: 1; height: 1px; background: var(--line);
        }

        /* ── Grid muzaki ── */
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

        /* ── Tabel item ── */
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

        .badge-kategori {
            padding: 4px 9px; border-radius: 999px;
            background: var(--green-soft); color: var(--green-dark);
            font-size: .62rem; font-weight: 900; text-transform: uppercase;
        }
        .badge-kategori.infaq  { background: #e0eeff; color: #1a4f8a; }
        .badge-kategori.fidyah { background: #ffefd5; color: #7a4800; }
        .badge-kategori.maal   { background: #f3e8ff; color: #5b1e99; }

        /* ── Totals strip ── */
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

        /* Skeleton */
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
            <h1 class="page-title">Laporan Pemasukan</h1>
            <div class="top-actions">
            </div>
        </header>

        <div class="content-wrap">

            {{-- PAGE INTRO --}}
            <div class="page-intro">
                <div>
                    <h2>Laporan Pemasukan</h2>
                    <p class="page-desc">Laporan resmi pemasukan dana untuk keperluan monitoring dan arsip instansi.</p>
                </div>
            </div>

            {{-- FILTER --}}
            <div class="filter-card">
                <select name="year" class="form-select form-select-sm w-auto">
                    @foreach([2026,2025,2024] as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                </select>

                <select name="month" class="form-select form-select-sm w-auto">
                    <option value="">Semua Bulan</option>
                    @foreach(range(1,12) as $m)
                        <option value="{{ $m }}">{{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
                    @endforeach
                </select>

                <select class="form-select form-select-sm w-auto">
                    <option>Periode Khusus</option>
                    <option>Ramadhan</option>
                </select>

                <button class="btn-print ms-auto" style="border-radius:10px;">Terapkan Filter</button>
            </div>

            {{-- SUMMARY --}}
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <div class="summary-card">
                        <small>Saldo Awal</small>
                        <h4>Rp {{ number_format(0, 0, ',', '.') }}</h4>
                        <span style="color:var(--muted); font-size:.76rem;">Per 1 April 2026</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card">
                        <small>Total Mutasi</small>
                        <div class="mutasi-row">
                            <div>
                                <div class="mutasi-label">Debet (+)</div>
                                <div class="mutasi-debet">Rp {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}</div>
                            </div>
                            <div>
                                <div class="mutasi-label">Kredit (−)</div>
                                <div class="mutasi-kredit">Rp 0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card saldo-akhir">
                        <small>Saldo Akhir</small>
                        <h4>Rp {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}</h4>
                        <span style="font-size:.76rem; opacity:.85;">Status: Aman / Stabil</span>
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="table-card">
                <div class="table-card-header">
                    <h5>Rincian Transaksi</h5>
                    <span class="audit-badge">Audit Internal</span>
                </div>

                <div style="overflow-x:auto;">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Jenis</th>
                                <th>Satuan</th>
                                <th class="text-end">Debet</th>
                                <th class="text-end">Kredit</th>
                                <th class="text-end">Saldo</th>
                                <th style="width:80px; text-align:center;">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $running = 0; @endphp

                            @forelse($pemasukan as $trx)
                                @php
                                    $debet = $trx->jumlah ?? 0;
                                    $running += $debet;
                                @endphp
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($trx->tanggal)->format('d/m/Y') }}</td>
                                    <td>{{ $trx->keterangan }}</td>
                                    <td>
                                        <span class="badge-jenis">
                                            {{ strtoupper($trx->jenis ?? 'Masuk') }}
                                        </span>
                                    </td>
                                    <td style="color:var(--muted);">Rp</td>
                                    <td class="text-end fw-bold" style="color:#0b7a36;">
                                        {{ number_format($debet, 0, ',', '.') }}
                                    </td>
                                    <td class="text-end" style="color:var(--muted);">—</td>
                                    <td class="text-end fw-bold">
                                        {{ number_format($running, 0, ',', '.') }}
                                    </td>
                                    {{-- TOMBOL DETAIL --}}
                                    <td style="text-align:center;">
                                        <button
                                            class="btn-detail"
                                            type="button"
                                            onclick="openDetail({{ $trx->id }})"
                                            aria-label="Lihat detail transaksi"
                                        >
                                            <i class="bi bi-eye"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4" style="color:var(--muted);">
                                        Tidak ada data pemasukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="paging-row">
                    <small>
                        {{ $pemasukan->firstItem() ?? 0 }} – {{ $pemasukan->lastItem() ?? 0 }}
                        dari {{ $pemasukan->total() ?? 0 }} transaksi
                    </small>
                    {{ $pemasukan->links() }}
                </div>
            </div>

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
    document.getElementById('sidebarToggle')?.addEventListener('click', () =>
        document.body.classList.toggle('sidebar-expanded')
    );

    /* ── Backdrop & Escape ── */
    document.getElementById('detailModal').addEventListener('click', function (e) {
        if (e.target === this) closeDetail();
    });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeDetail(); });

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
        document.getElementById('modalPrintBtn').href         = `{{ url('pemasukan') }}/${d.id}/struk`;

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
