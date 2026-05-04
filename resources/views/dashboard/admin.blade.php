<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda | Dashboard Admin Instansi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            overflow-x: hidden;
        }

        .dashboard-content {
            min-width: 0;
            padding: 28px 42px 48px;
            background: var(--surface);
        }

        .dashboard-topbar {
            margin: -28px -42px 42px;
            padding: 28px 42px;
            background: #fff;
            border-bottom: 1px solid rgba(233, 238, 234, .7);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .page-title {
            margin: 0 0 4px;
            font-size: 1.9rem;
            font-weight: 900;
        }

        .page-desc {
            margin: 0;
            color: #1d271f;
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .search-box {
            width: min(330px, 34vw);
            height: 38px;
            padding: 0 13px;
            border-radius: 10px;
            background: #f0f2f1;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .search-box input {
            width: 100%;
            border: 0;
            outline: 0;
            background: transparent;
            font-size: .82rem;
        }

        .icon-btn {
            width: 38px;
            height: 38px;
            border: 0;
            border-radius: 50%;
            background: transparent;
            color: #64706a;
            display: grid;
            place-items: center;
            position: relative;
        }

        .icon-btn:hover {
            background: var(--green-soft);
            color: var(--green);
        }

        .icon-btn.has-dot::after {
            content: "";
            position: absolute;
            top: 8px;
            right: 9px;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #d82132;
        }

        .admin-name {
            font-size: .78rem;
            line-height: 1.15;
            text-align: right;
        }

        .admin-role {
            color: var(--muted);
            font-size: .68rem;
            margin-top: 3px;
        }

        .avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--green-soft);
            border: 3px solid #5ab879;
            color: var(--green);
            display: grid;
            place-items: center;
            font-weight: 900;
            overflow: hidden;
            flex: 0 0 auto;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .content-wrap {
            max-width: 1180px;
            margin: 0 auto;
        }

        .welcome-panel {
            margin-bottom: 26px;
            padding: 30px 34px;
            border: 1px solid var(--line);
            border-radius: 18px;
            background: #fff;
            box-shadow: var(--shadow);
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 24px;
        }

        .welcome-title {
            margin: 0 0 10px;
            font-size: 1.55rem;
            font-weight: 900;
        }

        .welcome-text {
            max-width: 680px;
            margin: 0;
            color: #506057;
            line-height: 1.65;
        }

        .quick-action {
            min-height: 48px;
            padding: 0 22px;
            border: 0;
            border-radius: 16px;
            background: var(--green);
            color: #fff;
            box-shadow: 0 12px 24px rgba(7, 101, 31, .2);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            text-decoration: none;
            white-space: nowrap;
        }

        .metric-card,
        .panel-card {
            border: 1px solid var(--line);
            border-radius: 18px;
            background: #fff;
            box-shadow: var(--shadow);
        }

        .metric-card {
            min-height: 150px;
            padding: 24px;
        }

        .metric-icon {
            width: 42px;
            height: 42px;
            margin-bottom: 18px;
            border-radius: 14px;
            background: var(--green-soft);
            color: var(--green);
            display: grid;
            place-items: center;
            font-size: 1.22rem;
        }

        .metric-label {
            margin-bottom: 10px;
            color: #263026;
            font-size: .72rem;
            font-weight: 900;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .metric-value {
            margin: 0;
            font-size: 1.58rem;
            font-weight: 900;
        }

        .metric-note {
            margin: 6px 0 0;
            color: var(--muted);
            font-size: .82rem;
        }

        .panel-card {
            padding: 28px;
            height: 100%;
        }

        .section-heading {
            margin: 0 0 6px;
            font-size: 1.2rem;
            font-weight: 900;
        }

        .section-subtitle {
            margin: 0;
            color: #536058;
            font-size: .9rem;
        }

        .map-shell {
            min-height: 330px;
            margin-top: 24px;
            border: 1px solid #dce9df;
            border-radius: 18px;
            background:
                linear-gradient(135deg, rgba(7, 101, 31, .08), transparent 42%),
                linear-gradient(225deg, rgba(90, 184, 121, .12), transparent 45%),
                #f2f6f3;
            position: relative;
            overflow: hidden;
        }

        .map-shell::before {
            content: "";
            position: absolute;
            inset: 22px;
            border: 1px dashed rgba(7, 101, 31, .18);
            border-radius: 16px;
        }

        .map-line {
            position: absolute;
            height: 2px;
            border-radius: 999px;
            background: rgba(7, 101, 31, .16);
            transform-origin: left center;
        }

        .map-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 10px 20px rgba(20, 47, 27, .16);
            position: absolute;
            z-index: 2;
        }

        .map-dot.muzakki {
            background: #2d88f0;
        }

        .map-dot.mustahik {
            background: #d82132;
        }

        .legend {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
        }

        .legend-item {
            color: #536058;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: .84rem;
            font-weight: 700;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }

        .ranking-list,
        .activity-list {
            margin: 24px 0 0;
            display: grid;
            gap: 16px;
        }

        .ranking-item,
        .activity-item {
            padding: 16px;
            border-radius: 16px;
            background: #f3f6f4;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .item-title {
            margin-bottom: 4px;
            font-weight: 850;
        }

        .item-meta {
            color: var(--muted);
            font-size: .78rem;
        }

        .amount {
            color: var(--green);
            font-weight: 900;
            white-space: nowrap;
        }

        .badge-soft {
            border-radius: 999px;
            background: var(--green-soft);
            color: var(--green);
            padding: 7px 10px;
            font-size: .72rem;
            font-weight: 900;
        }

        .table-card {
            border: 1px solid var(--line);
            border-radius: 18px;
            background: #fff;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .table-card-header {
            padding: 24px 28px;
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .table-card table {
            min-width: 760px;
            margin: 0;
        }

        .table-card thead th {
            background: #ebeeec;
            border: 0;
            color: #243024;
            font-size: .78rem;
            font-weight: 900;
            letter-spacing: .14em;
            padding: 18px 24px;
            text-transform: uppercase;
        }

        .table-card tbody td {
            border-color: #e5ebe6;
            padding: 20px 24px;
            vertical-align: middle;
        }

        .receipt-btn {
            border: 0;
            border-radius: 12px;
            background: var(--green);
            color: #fff;
            padding: 9px 14px;
            font-size: .78rem;
            font-weight: 800;
        }

        @media (max-width: 991px) {
            .dashboard-content {
                padding: 24px 18px 36px;
            }

            .dashboard-topbar {
                margin: -24px -18px 30px;
                padding: 24px 18px;
                flex-direction: column;
                align-items: flex-start;
            }

            .top-actions,
            .search-box {
                width: 100%;
            }

            .top-actions {
                justify-content: space-between;
                flex-wrap: wrap;
            }

            .welcome-panel {
                padding: 24px;
                flex-direction: column;
            }
        }
    </style>
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>
<body class="sidebar-expanded">
    @php
        $user = auth()->user();
        $dashboardInstansi = $instansi ?? $user?->instansi;
        $instansiName = $dashboardInstansi?->nama ?: ($user?->nama_instansi ?: $user?->name ?: 'Admin Instansi');
        $instansiRole = $dashboardInstansi?->tipe ?: 'Admin Instansi';
        $instansiLogo = $dashboardInstansi?->logo;
        $initials = collect(preg_split('/\s+/', trim($instansiName)))
            ->filter()
            ->take(2)
            ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
            ->implode('');
        $initials = $initials ?: 'A';
    @endphp

    <div class="admin-layout">
        @include('admin.partials.sidebar', ['active' => 'dashboard'])

        <main class="dashboard-content">
            <header class="dashboard-topbar">
                <div>
                    <h1 class="page-title">Beranda</h1>
                    <p class="page-desc">Ringkasan operasional zakat dan penyaluran {{ $instansiName }}.</p>
                </div>
                <div class="top-actions">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="search" placeholder="Cari data muzakki...">
                    </div>
                    <button class="icon-btn has-dot" type="button" aria-label="Notifikasi">
                        <i class="bi bi-bell-fill"></i>
                    </button>
                    <div class="admin-name">
                        <strong>{{ $instansiName }}</strong>
                        <div class="admin-role">{{ $instansiRole }}</div>
                    </div>
                    <div class="avatar">
                        @if ($instansiLogo)
                            <img src="{{ asset('storage/'.$instansiLogo) }}" alt="Logo {{ $instansiName }}">
                        @else
                            {{ $initials }}
                        @endif
                    </div>
                </div>
            </header>

            <div class="content-wrap">
                <section class="welcome-panel">
                    <div>
                        <h2 class="welcome-title">Selamat Datang, Admin {{ $instansiName }}</h2>
                        <p class="welcome-text">Pantau pengumpulan, saldo siap salur, wilayah prioritas, dan aktivitas transaksi terbaru dalam satu tampilan yang konsisten dengan halaman admin lainnya.</p>
                    </div>
                    <a class="quick-action" href="{{ route('pemasukan.index') }}">
                        <i class="bi bi-plus-circle-fill"></i>
                        Input Pemasukan
                    </a>
                </section>

                <div class="row g-4 mb-4">
                    <div class="col-md-6 col-xl-3">
                        <section class="metric-card">
                            <div class="metric-icon"><i class="bi bi-basket2-fill"></i></div>
                            <div class="metric-label">Harga Beras Harian</div>
                            <h2 class="metric-value">Rp 15.200/kg</h2>
                            <p class="metric-note">Acuan zakat fitrah hari ini</p>
                        </section>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <section class="metric-card">
                            <div class="metric-icon"><i class="bi bi-gem"></i></div>
                            <div class="metric-label">Nishab Maal</div>
                            <h2 class="metric-value">Rp 102.000.000</h2>
                            <p class="metric-note">Batas nishab tahun berjalan</p>
                        </section>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <section class="metric-card">
                            <div class="metric-icon"><i class="bi bi-cash-stack"></i></div>
                            <div class="metric-label">Total Pengumpulan</div>
                            <h2 class="metric-value">Rp 428.5M</h2>
                            <p class="metric-note">1.240 muzakki aktif</p>
                        </section>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <section class="metric-card">
                            <div class="metric-icon"><i class="bi bi-send-check-fill"></i></div>
                            <div class="metric-label">Tersalurkan</div>
                            <h2 class="metric-value">Rp 312.8M</h2>
                            <p class="metric-note">856 mustahik terbantu</p>
                        </section>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-lg-8">
                        <section class="panel-card">
                            <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                                <div>
                                    <h2 class="section-heading">Peta Sebaran Lokal</h2>
                                    <p class="section-subtitle">Titik muzakki dan mustahik di wilayah operasional.</p>
                                </div>
                                <div class="legend">
                                    <span class="legend-item"><span class="legend-dot" style="background:#2d88f0"></span>Muzakki</span>
                                    <span class="legend-item"><span class="legend-dot" style="background:#d82132"></span>Mustahik</span>
                                </div>
                            </div>
                            <div class="map-shell">
                                <span class="map-line" style="top: 37%; left: 23%; width: 34%; transform: rotate(12deg);"></span>
                                <span class="map-line" style="top: 62%; left: 31%; width: 48%; transform: rotate(-10deg);"></span>
                                <span class="map-dot muzakki" style="top: 34%; left: 22%;"></span>
                                <span class="map-dot mustahik" style="top: 70%; left: 30%;"></span>
                                <span class="map-dot muzakki" style="top: 45%; left: 58%;"></span>
                                <span class="map-dot mustahik" style="top: 26%; left: 72%;"></span>
                                <span class="map-dot muzakki" style="top: 62%; left: 80%;"></span>
                            </div>
                        </section>
                    </div>
                    <div class="col-lg-4">
                        <section class="panel-card">
                            <div class="d-flex justify-content-between align-items-start gap-3">
                                <div>
                                    <h2 class="section-heading">Insight Wilayah</h2>
                                    <p class="section-subtitle">Peringkat pengumpulan pekan ini.</p>
                                </div>
                                <span class="badge-soft">Stabil</span>
                            </div>
                            <div class="ranking-list">
                                <div class="ranking-item">
                                    <div>
                                        <div class="item-title">RW 04 Soreang Indah</div>
                                        <div class="item-meta">Peringkat 1</div>
                                    </div>
                                    <div class="amount">Rp 45.2jt</div>
                                </div>
                                <div class="ranking-item">
                                    <div>
                                        <div class="item-title">RW 07 Cingcin</div>
                                        <div class="item-meta">Peringkat 2</div>
                                    </div>
                                    <div class="amount">Rp 38.9jt</div>
                                </div>
                                <div class="ranking-item">
                                    <div>
                                        <div class="item-title">RW 02 Soreang Kota</div>
                                        <div class="item-meta">Peringkat 3</div>
                                    </div>
                                    <div class="amount">Rp 32.1jt</div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <section class="table-card mb-4">
                    <div class="table-card-header">
                        <div>
                            <h2 class="section-heading">Aktivitas Transaksi Terbaru</h2>
                            <p class="section-subtitle">Transaksi masuk dan aksi cetak struk terbaru.</p>
                        </div>
                        <a class="text-success fw-bold text-decoration-none" href="{{ route('pemasukan.index') }}">Lihat Semua</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Nominal</th>
                                    <th>Waktu</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Achmad R.</strong></td>
                                    <td><span class="badge-soft">Zakat Maal</span></td>
                                    <td>Rp 2.500.000</td>
                                    <td>Hari ini, 14:20</td>
                                    <td class="text-end"><button class="receipt-btn" type="button">Cetak Struk</button></td>
                                </tr>
                                <tr>
                                    <td><strong>Siti Hajar</strong></td>
                                    <td><span class="badge-soft">Infak/Sedekah</span></td>
                                    <td>Rp 500.000</td>
                                    <td>Hari ini, 12:45</td>
                                    <td class="text-end"><button class="receipt-btn" type="button">Cetak Struk</button></td>
                                </tr>
                                <tr>
                                    <td><strong>Bambang M.</strong></td>
                                    <td><span class="badge-soft">Zakat Fitrah</span></td>
                                    <td>Rp 450.000</td>
                                    <td>Kemarin, 21:10</td>
                                    <td class="text-end"><button class="receipt-btn" type="button">Cetak Struk</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <div class="row g-4">
                    <div class="col-lg-6">
                        <section class="panel-card">
                            <h2 class="section-heading">Saldo Siap Disalurkan</h2>
                            <p class="section-subtitle mb-4">Sisa dana yang belum masuk jadwal distribusi.</p>
                            <div class="d-flex align-items-end justify-content-between gap-3">
                                <div>
                                    <div class="metric-label">Sisa Saldo</div>
                                    <h3 class="metric-value">Rp 115.7M</h3>
                                </div>
                                <span class="badge-soft">Siap Salur</span>
                            </div>
                        </section>
                    </div>
                    <div class="col-lg-6">
                        <section class="panel-card">
                            <h2 class="section-heading">Ringkasan Operasional</h2>
                            <p class="section-subtitle mb-4">Rasio penerima manfaat dan pembayar aktif.</p>
                            <div class="activity-list">
                                <div class="activity-item">
                                    <div>
                                        <div class="item-title">Muzakki Aktif</div>
                                        <div class="item-meta">Terdata sepanjang periode berjalan</div>
                                    </div>
                                    <div class="amount">1.240</div>
                                </div>
                                <div class="activity-item">
                                    <div>
                                        <div class="item-title">Mustahik Tersalurkan</div>
                                        <div class="item-meta">Menerima bantuan dari program aktif</div>
                                    </div>
                                    <div class="amount">856</div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');

        sidebarToggle.addEventListener('click', () => {
            document.body.classList.toggle('sidebar-expanded');
        });
    </script>
</body>
</html>
