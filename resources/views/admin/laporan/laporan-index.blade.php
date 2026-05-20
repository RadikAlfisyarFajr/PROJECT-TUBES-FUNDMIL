{{-- Halaman daftar laporan. --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan | Admin Instansi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --green: #087026;
            --green-dark: #06451f;
            --green-soft: #dff3e4;
            --green-pale: #eef9f1;
            --ink: #17211b;
            --muted: #748077;
            --surface: #f5f8f5;
            --sidebar: #f4f8f2;
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

        .sidebar {
            min-height: 100vh; padding: 20px 12px 24px;
            background: var(--sidebar); border-right: 1px solid var(--line);
            display: flex; flex-direction: column;
            overflow-x: hidden; transition: padding .25s ease;
        }

        body.sidebar-expanded .sidebar { padding: 38px 18px 28px; }

        .brand { min-height: 52px; display: flex; align-items: center; justify-content: center; gap: 10px; overflow: hidden; }
        body.sidebar-expanded .brand { justify-content: flex-start; padding: 0 18px; }

        .brand-icon { width: 28px; height: 28px; border-radius: 10px; background: var(--green); color: #fff; display: grid; place-items: center; flex: 0 0 auto; }
        .brand-copy { display: none; white-space: nowrap; }
        body.sidebar-expanded .brand-copy { display: block; }
        .brand-title { margin-bottom: 8px; color: var(--green-dark); font-size: 1.25rem; font-weight: 900; }
        .brand-subtitle { color: #9ba49e; font-size: .68rem; font-weight: 800; letter-spacing: .32em; }

        .sidebar-nav { margin-top: 52px; display: grid; gap: 10px; }
        body.sidebar-expanded .sidebar-nav { margin-top: 66px; }

        .sidebar-toggle, .nav-item-link {
            width: 58px; height: 58px; min-height: 58px;
            margin-left: auto; margin-right: auto;
            border: 0; border-radius: 16px;
            background: transparent; color: #294158;
            display: flex; align-items: center; justify-content: center;
            gap: 16px; font-weight: 700;
            text-decoration: none; white-space: nowrap; overflow: hidden;
            transition: background .2s ease, color .2s ease, width .25s ease, padding .25s ease;
            cursor: pointer;
        }

        body.sidebar-expanded .sidebar-toggle,
        body.sidebar-expanded .nav-item-link { width: 100%; padding: 0 18px; justify-content: flex-start; }

        .nav-item-link:hover, .nav-item-link.active, .sidebar-toggle:hover { background: #fff; color: var(--green); }
        .nav-item-link.active { background: #dceee2; }

        .sidebar-toggle i, .nav-item-link i { width: 24px; color: var(--green-dark); font-size: 1.25rem; text-align: center; flex: 0 0 auto; }
        .nav-item-link span, .sidebar-toggle span { display: none; }
        body.sidebar-expanded .nav-item-link span,
        body.sidebar-expanded .sidebar-toggle span { display: inline; }

        .sidebar-footer { margin-top: auto; padding-top: 18px; border-top: 1px solid var(--line); }

        .main-content { min-width: 0; padding: 18px 24px 38px; background: var(--surface); }

        .topbar {
            min-height: 56px; margin: -18px -24px 34px; padding: 16px 24px;
            background: #fff; border-bottom: 1px solid rgba(226,235,228,.8);
            display: flex; align-items: center; justify-content: space-between; gap: 24px;
        }

        .page-title { margin: 0; font-size: 1.12rem; font-weight: 900; }
        .top-actions { display: flex; align-items: center; gap: 14px; }

        .search-box {
            width: min(330px, 34vw); height: 34px; padding: 0 12px;
            border-radius: 8px; background: #f2f5f3; color: var(--muted);
            display: flex; align-items: center; gap: 8px;
        }
        .search-box input { width: 100%; border: 0; outline: 0; background: transparent; font-size: .78rem; }

        .icon-btn { width: 28px; height: 28px; border: 0; border-radius: 50%; background: transparent; color: #334255; display: grid; place-items: center; position: relative; cursor: pointer; }
        .icon-btn.has-dot::after { content: ""; position: absolute; top: 5px; right: 6px; width: 6px; height: 6px; border-radius: 50%; background: #e23d4d; }

        .admin-name { font-size: .72rem; line-height: 1.1; text-align: right; }
        .admin-role { color: var(--muted); font-size: .62rem; }
        .avatar { width: 28px; height: 28px; border-radius: 50%; background: #10384a; color: #fff; display: grid; place-items: center; font-size: .72rem; font-weight: 800; }

        .content-wrap { max-width: 1180px; margin: 0 auto; }

        .page-intro { margin-bottom: 28px; display: flex; align-items: flex-start; justify-content: space-between; gap: 24px; }
        .page-desc { max-width: 600px; margin: 0; color: #506057; font-size: .92rem; line-height: 1.65; }

        /* ── LAPORAN CARDS ── */
        .laporan-card {
            min-height: 190px; padding: 26px;
            border: 1px solid var(--line); border-radius: 18px;
            background: #fff; box-shadow: var(--shadow); position: relative;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .laporan-card:hover { transform: translateY(-3px); box-shadow: 0 20px 40px rgba(18,55,28,.12); }

        .laporan-card-icon {
            width: 48px; height: 48px; margin-bottom: 18px;
            border-radius: 16px; display: grid; place-items: center; font-size: 1.35rem;
        }

        .laporan-card-icon.green { background: #a7edb6; color: var(--green); }
        .laporan-card-icon.gray  { background: #dfe9e2; color: #4d6c57; }
        .laporan-card-icon.blue  { background: #d0e8ff; color: #1a6bbf; }
        .laporan-card-icon.pink  { background: #ffcfe0; color: #c84770; }

        .laporan-card-title { margin: 0 0 8px; font-size: 1.08rem; font-weight: 900; }
        .laporan-card-desc { margin: 0 0 20px; color: #45554b; font-size: .82rem; line-height: 1.55; min-height: 42px; }

        .laporan-card-footer {
            display: flex; align-items: center; justify-content: space-between;
            padding-top: 16px; border-top: 1px solid var(--line);
        }

        .periode-tag {
            padding: 5px 10px; border-radius: 999px;
            background: #eef4ee; color: #58705e;
            font-size: .62rem; font-weight: 900; text-transform: uppercase;
        }

        .lihat-btn {
            min-height: 34px; padding: 0 16px; border: 0; border-radius: 10px;
            background: var(--green-soft); color: var(--green-dark);
            font-size: .78rem; font-weight: 800;
            display: inline-flex; align-items: center; gap: 6px;
            cursor: pointer; transition: background .2s ease, color .2s ease;
        }

        .lihat-btn:hover { background: var(--green); color: #fff; }

        /* ── INFO PANEL ── */
        .info-panel {
            margin-top: 28px; padding: 24px 28px;
            border: 1px solid #b8dfc3; border-radius: 18px; background: #eaf8ee;
            display: flex; align-items: flex-start; gap: 18px;
        }

        .info-icon { width: 34px; height: 34px; border-radius: 50%; background: #c6ecd0; color: var(--green); display: grid; place-items: center; flex: 0 0 auto; }
        .info-title { margin: 0 0 8px; color: var(--green-dark); font-size: .96rem; font-weight: 900; }
        .info-text  { margin: 0; color: #42524a; font-size: .82rem; line-height: 1.7; }

        /* ── MODAL ── */
        .modal-backdrop-custom {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.35); z-index: 1000;
            align-items: center; justify-content: center;
        }
        .modal-backdrop-custom.show { display: flex; }

        .modal-box {
            background: #fff; border-radius: 20px; padding: 36px 32px 28px;
            max-width: 400px; width: 90%; text-align: center;
            box-shadow: 0 24px 60px rgba(0,0,0,.18);
            animation: modalIn .2s ease;
        }

        @keyframes modalIn { from { transform: scale(.92); opacity: 0; } to { transform: scale(1); opacity: 1; } }

        .modal-icon { width: 64px; height: 64px; border-radius: 50%; background: var(--green-soft); color: var(--green); font-size: 2rem; display: grid; place-items: center; margin: 0 auto 18px; }
        .modal-title { font-size: 1.1rem; font-weight: 900; margin-bottom: 8px; color: var(--ink); }
        .modal-desc  { font-size: .85rem; color: var(--muted); line-height: 1.6; margin-bottom: 24px; }
        .modal-close-btn { padding: 10px 28px; border: 0; border-radius: 12px; background: var(--green); color: #fff; font-size: .88rem; font-weight: 800; cursor: pointer; transition: background .2s; }
        .modal-close-btn:hover { background: var(--green-dark); }

        @media (max-width: 991px) {
            .admin-layout { grid-template-columns: 1fr; }
            .sidebar { min-height: auto; }
            .main-content { padding: 18px 16px 34px; }
            .topbar { margin: -18px -16px 28px; padding: 16px; flex-direction: column; align-items: flex-start; }
            .top-actions, .search-box { width: 100%; }
            .page-intro { flex-direction: column; }
        }
    </style>
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>

<body class="sidebar-expanded">
<div class="admin-layout">

    @include('admin.partials.sidebar', ['active' => 'laporan'])

    <main class="main-content">
        <header class="topbar">
            <h1 class="page-title">Laporan</h1>
            <div class="top-actions">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="search" placeholder="Cari laporan...">
                </div>
                <button class="icon-btn has-dot" type="button" aria-label="Notifikasi">
                    <i class="bi bi-bell-fill"></i>
                </button>
                <button class="icon-btn" type="button" aria-label="Bantuan">
                    <i class="bi bi-question-circle-fill"></i>
                </button>
                @include('admin.partials.account-identity', [
                    'nameClass' => 'admin-name',
                    'roleClass' => 'admin-role',
                    'avatarClass' => 'admin-avatar',
                ])
            </div>
        </header>

        <div class="content-wrap">
            <div class="page-intro">
                <p class="page-desc">Akses dan pantau laporan keuangan, pemasukan, penyaluran, dan data mustahik instansi.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="laporan-card">
                        <div class="laporan-card-icon green"><i class="bi bi-graph-up-arrow"></i></div>
                        <h2 class="laporan-card-title">Laporan Pemasukan</h2>
                        <p class="laporan-card-desc">Daftar transaksi pemasukan dana zakat, infaq, dan sedekah beserta detail muzaki per periode.</p>
                        <div class="laporan-card-footer">
                            <span class="periode-tag">Fleksibel</span>
                            <a href="{{ route('laporan.pemasukan') }}" class="lihat-btn"><i class="bi bi-eye"></i> Lihat</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="laporan-card">
                        <div class="laporan-card-icon gray"><i class="bi bi-arrow-down-circle"></i></div>
                        <h2 class="laporan-card-title">Laporan Penyaluran</h2>
                        <p class="laporan-card-desc">Daftar distribusi dana kepada mustahik dan program sosial kemanusiaan per periode.</p>
                        <div class="laporan-card-footer">
                            <span class="periode-tag">Fleksibel</span>
                            <a href="{{ route('laporan.penyaluran') }}" class="lihat-btn"><i class="bi bi-eye"></i> Lihat</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="laporan-card">
                        <div class="laporan-card-icon blue"><i class="bi bi-people-fill"></i></div>
                        <h2 class="laporan-card-title">Laporan Data Mustahik</h2>
                        <p class="laporan-card-desc">Daftar lengkap penerima manfaat beserta status kelayakan dan riwayat penerimaan bantuan.</p>
                        <div class="laporan-card-footer">
                            <span class="periode-tag">Point in Time</span>
                            <a href="{{ route('laporan.mustahik') }}" class="lihat-btn"><i class="bi bi-eye"></i> Lihat</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="laporan-card">
                        <div class="laporan-card-icon pink"><i class="bi bi-cash-stack"></i></div>
                        <h2 class="laporan-card-title">Laporan Keuangan</h2>
                        <p class="laporan-card-desc">Ringkasan neraca periode: saldo awal, total pemasukan, total pengeluaran, dan saldo akhir instansi.</p>
                        <div class="laporan-card-footer">
                            <span class="periode-tag">Bulanan</span>
                            <a href="{{ route('laporan.keuangan') }}" class="lihat-btn"><i class="bi bi-eye"></i> Lihat</a>
                        </div>
                    </div>
                </div>
            </div>

            <section class="info-panel">
                <div class="info-icon"><i class="bi bi-info-circle-fill"></i></div>
                <div>
                    <h2 class="info-title">Informasi Laporan</h2>
                    <p class="info-text">
                        Seluruh laporan sedang dalam proses pengembangan dan akan segera tersedia.
                        Laporan <strong>Pemasukan</strong> dan <strong>Penyaluran</strong> menampilkan detail transaksi per periode,
                        <strong>Data Mustahik</strong> menampilkan daftar penerima manfaat,
                        sedangkan <strong>Keuangan</strong> menyajikan ringkasan neraca saldo instansi.
                    </p>
                </div>
            </section>
        </div>
    </main>
</div>

{{-- Modal Coming Soon --}}
<div class="modal-backdrop-custom" id="comingSoonModal">
    <div class="modal-box">
        <div class="modal-icon"><i class="bi bi-tools"></i></div>
        <div class="modal-title" id="modalTitle">Laporan Segera Hadir</div>
        <p class="modal-desc" id="modalDesc">Fitur ini sedang dalam pengembangan dan akan segera tersedia.</p>
        <button class="modal-close-btn" onclick="closeModal()">Mengerti</button>
    </div>
</div>

{{-- Modal Pemasukan (menampilkan data pemasukan dari TransaksiZakat) --}}
<div class="modal-backdrop-custom" id="pemasukanModal">
    <div class="modal-box" style="max-width:900px; width:95%; padding:18px;">
        <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:12px;">
            <div>
                <h3 style="margin:0; font-size:1.05rem; font-weight:900;">Laporan Pemasukan</h3>
                <p style="margin:0; color:#465650; font-size:.86rem;">Menampilkan daftar transaksi pemasukan zakat, infaq, dan sedekah.</p>
            </div>
            <div style="text-align:right">
                <div style="font-size:.9rem; color:#2f5a3f; font-weight:900">Total Pemasukan</div>
                <div style="font-size:1.05rem; font-weight:900">Rp {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}</div>
            </div>
        </div>

        <div style="max-height:60vh; overflow:auto;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>No. Kuitansi</th>
                        <th>Muzakki</th>
                        <th>Kategori</th>
                        <th>Jenis</th>
                        <th class="text-end">Jumlah</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($pemasukan) && $pemasukan->count())
                        @foreach($pemasukan as $trx)
                            <tr>
                                <td>{{ \Illuminate\Support\Carbon::parse($trx->tanggal)->format('d M Y') }}</td>
                                <td>{{ $trx->nomor_kuitansi ?? '-' }}</td>
                                <td>{{ $trx->nama_muzakki ?? '-' }}</td>
                                <td>{{ optional($trx->kategori)->nama ?? '-' }}</td>
                                <td>{{ $trx->jenis ?? '-' }}</td>
                                <td class="text-end">Rp {{ number_format($trx->jumlah ?? 0, 0, ',', '.') }}</td>
                                <td>{{ $trx->keterangan ?? '' }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="7" class="text-center">Belum ada data pemasukan.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:12px;">
            <button class="modal-close-btn" onclick="closePemasukan()">Tutup</button>
        </div>
    </div>
</div>

<script>
    const sidebarToggle = document.getElementById('sidebarToggle');
    if (sidebarToggle) sidebarToggle.addEventListener('click', () => document.body.classList.toggle('sidebar-expanded'));

    function showComingSoon(type) {
        document.getElementById('modalTitle').textContent = `Laporan ${type}`;
        document.getElementById('modalDesc').textContent = `Laporan ${type} sedang dalam pengembangan dan akan segera tersedia.`;
        document.getElementById('comingSoonModal').classList.add('show');
    }

    function closeModal() { document.getElementById('comingSoonModal').classList.remove('show'); }

    document.getElementById('comingSoonModal').addEventListener('click', function(e) { if (e.target === this) closeModal(); });
    
    function showPemasukan() { document.getElementById('pemasukanModal').classList.add('show'); }
    function closePemasukan() { document.getElementById('pemasukanModal').classList.remove('show'); }
    document.getElementById('pemasukanModal').addEventListener('click', function(e) { if (e.target === this) closePemasukan(); });
</script>
</body>
</html>
