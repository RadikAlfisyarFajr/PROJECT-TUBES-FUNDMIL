<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda | Dashboard Admin Instansi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary: #1f7a3b;
            --primary-soft: rgba(31,122,59,0.12);
            --surface: #f8fcf7;
            --surface-strong: #ffffff;
            --text-dark: #17241f;
            --text-muted: #61756b;
            --border: #e7efe8;
            --shadow-soft: 0 18px 45px rgba(20, 70, 32, 0.08);
        }
        body {
            background: #edf6ee;
            color: var(--text-dark);
            min-height: 100vh;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .dashboard-layout {
            min-height: 100vh;
            display: flex;
        }
        .sidebar {
            position: relative;
            top: auto;
            left: auto;
            bottom: auto;
            width: 260px;
            background: #fbfdf8;
            border-right: 1px solid rgba(17, 79, 34, 0.08);
            padding: 2rem 1.25rem;
            transition: width .3s ease, padding .3s ease;
            flex-shrink: 0;
            height: auto;
            overflow-y: visible;
            transform: translateX(0);
        }
        .sidebar__brand {
            font-weight: 700;
            letter-spacing: .03em;
            color: var(--primary);
        }
        .sidebar__subtitle {
            font-size: 0.9rem;
            color: var(--text-muted);
        }
        .nav-link {
            color: #33453a;
            border-radius: 16px;
            padding: 0.95rem 1rem;
            transition: background .2s ease, color .2s ease;
            white-space: nowrap;
        }
        .nav-link:hover,
        .nav-link.active {
            background: var(--primary-soft);
            color: var(--primary);
        }
        .sidebar .nav-link .bi {
            font-size: 1.1rem;
            margin-right: .85rem;
        }
        .sidebar__footer {
            position: absolute;
            bottom: 2rem;
            width: calc(100% - 2.5rem);
        }
        .sidebar-open .sidebar {
            transform: translateX(0);
        }
        .sidebar-collapsed .sidebar {
            width: 120px;
            padding: 2rem 1rem;
            transform: translateX(0);
        }
        .sidebar-collapsed .sidebar__brand span,
        .sidebar-collapsed .sidebar__subtitle,
        .sidebar-collapsed .nav-link .nav-text,
        .sidebar-collapsed .sidebar__footer a {
            display: none;
        }
        .sidebar-collapsed .sidebar__brand {
            justify-content: center;
        }
        .sidebar-collapsed .nav-link {
            justify-content: center;
            padding: 0.95rem .6rem;
        }
        .sidebar-collapsed .sidebar__footer {
            left: 50%;
            transform: translateX(-50%);
            width: auto;
            bottom: 1.5rem;
        }
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.35);
            opacity: 0;
            pointer-events: none;
            transition: opacity .3s ease;
            z-index: 1050;
        }
        .sidebar-open .sidebar-overlay {
            opacity: 1;
            pointer-events: auto;
        }
        .content {
            flex: 1;
            padding: 1.5rem;
            transition: none;
            min-height: 100vh;
            background: #edf6ee;
        }
        .sidebar-open .sidebar {
            transform: translateX(0);
        }
            background: transparent;
            border: none;
            color: #33453a;
            border-radius: 16px;
            padding: 0.95rem 1rem;
            transition: background .2s ease, color .2s ease;
            width: 100%;
            text-align: left;
        }
        .sidebar-toggle:hover {
            background: var(--primary-soft);
            color: var(--primary);
        }
        .sidebar-toggle .bi {
            font-size: 1.1rem;
            margin-right: .85rem;
        }
        .sidebar-collapsed .sidebar-toggle .nav-text {
            display: none;
        }
        .sidebar-collapsed .sidebar-toggle {
            justify-content: center;
            padding: 0.95rem .6rem;
        }
        @media (max-width: 991px) {
            .sidebar {
                position: fixed;
                transform: translateX(-100%);
                width: 260px;
                z-index: 1100;
                height: 100vh;
                overflow-y: auto;
            }
            .sidebar-collapsed .sidebar {
                width: 260px;
                padding: 2rem 1.25rem;
            }
            .sidebar-collapsed .sidebar__brand span,
            .sidebar-collapsed .sidebar__subtitle,
            .sidebar-collapsed .nav-link .nav-text,
            .sidebar-collapsed .sidebar__footer a {
                display: block;
            }
            .content {
                margin-left: 0;
            }
            .sidebar-open .content {
                margin-left: 0;
            }
        }
        .topbar {
            align-items: center;
            gap: 1rem;
        }
        .topbar .search-box {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid rgba(23, 36, 26, 0.08);
            height: 52px;
            padding: 0 1rem;
        }
        .topbar .search-box input {
            border: none;
            background: transparent;
            outline: none;
        }
        .status-card {
            background: var(--surface-strong);
            border-radius: 24px;
            border: 1px solid rgba(23, 36, 26, 0.06);
            box-shadow: var(--shadow-soft);
            min-height: 140px;
        }
        .status-card .card-body {
            padding: 1.5rem;
        }
        .status-card .label {
            letter-spacing: .03em;
            text-transform: uppercase;
            font-size: .78rem;
            font-weight: 700;
            color: #4c6e5d;
        }
        .map-card {
            background: linear-gradient(180deg, #f7fbf6 0%, #ebf6ef 100%);
            border-radius: 24px;
            border: 1px solid rgba(31, 122, 59, 0.12);
            box-shadow: var(--shadow-soft);
        }
        .map-placeholder {
            height: 350px;
            background: radial-gradient(circle at 20% 20%, rgba(31,122,59,0.12), transparent 12%),
                        radial-gradient(circle at 80% 25%, rgba(226,241,227,0.9), transparent 8%),
                        linear-gradient(180deg, #f8fdf8 0%, #eff7ee 100%);
            border-radius: 22px;
            position: relative;
            overflow: hidden;
        }
        .map-placeholder::before {
            content: '';
            position: absolute;
            inset: 16px;
            background: linear-gradient(135deg, rgba(31,122,59,0.08) 0%, transparent 45%),
                        linear-gradient(225deg, rgba(31,122,59,0.06) 0%, transparent 45%);
            pointer-events: none;
            border-radius: 18px;
        }
        .map-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            position: absolute;
            border: 3px solid #fff;
            box-shadow: 0 10px 25px rgba(31,122,59,0.12);
        }
        .map-dot--muzakki { background: #2d88f0; }
        .map-dot--mustahik { background: #ec4e4e; }
        .legend-bullet {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: .55rem;
        }
        .insight-card,
        .transactions-card {
            background: var(--surface-strong);
            border-radius: 24px;
            border: 1px solid rgba(23, 36, 26, 0.06);
            box-shadow: var(--shadow-soft);
        }
        .insight-card .card-body,
        .transactions-card .card-body {
            padding: 1.75rem;
        }
        .table thead th {
            border-bottom: 2px solid rgba(23, 36, 26, 0.08);
        }
        .badge-category {
            font-size: .75rem;
            border-radius: 999px;
            padding: .45rem .75rem;
            font-weight: 600;
        }
        @media (max-width: 991px) {
            .sidebar {
                min-height: auto;
                position: relative;
            }
            .sidebar__footer {
                position: static;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid dashboard-layout">
        <div class="row g-0">
            <aside class="col-12 col-xl-3 sidebar position-relative">
                <div class="mb-5">
                    <div class="sidebar__brand d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-shield-lock-fill fs-4"></i>
                        <span>FUNDMIL SOREANG</span>
                    </div>
                    <div class="sidebar__subtitle">Sistem Amanah Digital</div>
                </div>

                <nav class="nav flex-column gap-1">
                    <button id="sidebarToggle" class="nav-link d-flex align-items-center w-100 text-start border-0 bg-transparent">
                        <i class="bi bi-list"></i>
                        <span class="nav-text ms-3">Menu</span>
                    </button>
                    <a class="nav-link active d-flex align-items-center" href="#">
                        <i class="bi bi-house-door-fill"></i>
                        <span class="nav-text">Beranda</span>
                    </a>
                    <a class="nav-link d-flex align-items-center" href="#">
                        <i class="bi bi-person-badge-fill"></i>
                        <span class="nav-text">Profil Instansi</span>
                    </a>
                    <a class="nav-link d-flex align-items-center" href="#">
                        <i class="bi bi-tags-fill"></i>
                        <span class="nav-text">Kategori Dana</span>
                    </a>
                    <a class="nav-link d-flex align-items-center" href="#">
                        <i class="bi bi-cash-stack"></i>
                        <span class="nav-text">Pemasukan Zakat</span>
                    </a>
                    <a class="nav-link d-flex align-items-center" href="#">
                        <i class="bi bi-people-fill"></i>
                        <span class="nav-text">Data Mustahik</span>
                    </a>
                    <a class="nav-link d-flex align-items-center" href="#">
                        <i class="bi bi-box-seam"></i>
                        <span class="nav-text">Program Penyaluran</span>
                    </a>
                    <a class="nav-link d-flex align-items-center" href="#">
                        <i class="bi bi-sliders2-vertical"></i>
                        <span class="nav-text">Pengaturan Distribusi</span>
                    </a>
                    <a class="nav-link d-flex align-items-center" href="#">
                        <i class="bi bi-bar-chart-fill"></i>
                        <span class="nav-text">Laporan</span>
                    </a>
                    <a class="nav-link d-flex align-items-center" href="#">
                        <i class="bi bi-gear-fill"></i>
                        <span class="nav-text">Pengaturan</span>
                    </a>
                </nav>

                <div class="sidebar__footer mt-5 pt-4 border-top" style="color: var(--text-muted);">
                    <a href="#" class="d-flex align-items-center text-decoration-none text-muted gap-2">
                        <i class="bi bi-question-circle"></i>
                        Bantuan
                    </a>
                </div>
            </aside>
            <div class="sidebar-overlay"></div>
            <main class="col-12 col-xl-9 content">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4 topbar">
                    <div>
                        <span class="d-inline-flex align-items-center gap-2 text-uppercase fw-semibold text-success mb-2">Beranda</span>
                        <h2 class="mb-1">Masjid Alghozali Dashboard</h2>
                        <p class="mb-0 text-muted">Menyajikan data operasional zakat dan penyaluran secara real-time.</p>
                    </div>
                    <div class="d-flex align-items-center gap-3 w-100 w-md-auto">
                        <div class="search-box flex-grow-1">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-search text-muted"></i>
                                <input type="search" class="form-control form-control-sm" placeholder="Cari data muzakki...">
                            </div>
                        </div>
                        <button class="btn btn-white border rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width:52px; height:52px;">
                            <i class="bi bi-bell-fill text-muted"></i>
                        </button>
                        <div class="d-flex align-items-center gap-2">
                            <div class="text-end d-none d-md-block">
                                <div class="fw-semibold">Admin Masjid</div>
                                <div class="text-muted" style="font-size:.95rem;">Kelurahan Soreang</div>
                            </div>
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width:52px; height:52px;">AM</div>
                        </div>
                    </div>
                </div>

                <section class="mb-4 p-4 rounded-4" style="background: linear-gradient(135deg, #edf9ef 0%, #f7fdf7 100%); border: 1px solid rgba(31,122,59,0.12);">
                    <h3 class="fw-bold mb-2">Selamat Datang, Admin Masjid Alghozali!</h3>
                    <p class="mb-0 text-muted">Wilayah Operasional: Kelurahan Soreang, Bandung</p>
                </section>

                <div class="row g-4 mb-4">
                    <div class="col-md-6 col-xl-3">
                        <div class="status-card card p-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="label">Harga Beras Harian</span>
                                    <span class="badge bg-success bg-opacity-15 text-success">+2.4%</span>
                                </div>
                                <div class="h3 fw-bold">Rp 15.200/kg</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="status-card card p-3">
                            <div class="card-body">
                                <span class="label">Nishab Maal Tahun Ini</span>
                                <div class="h3 fw-bold mt-3">Rp 102.000.000</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="status-card card p-3">
                            <div class="card-body">
                                <div class="label mb-2">Total Pengumpulan</div>
                                <div class="h3 fw-bold">Rp 428.5M</div>
                                <small class="text-muted">1.240 Muzakki Aktif</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="status-card card p-3">
                            <div class="card-body">
                                <div class="label mb-2">Total Tersalurkan</div>
                                <div class="h3 fw-bold">Rp 312.8M</div>
                                <small class="text-muted">856 Mustahik Terbantu</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-lg-8">
                        <div class="map-card p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h5 class="mb-1">Peta Sebaran Lokal</h5>
                                    <p class="text-muted mb-0">Visualisasi titik muzakki dan mustahik di wilayah operasional.</p>
                                </div>
                                <div class="d-flex gap-3 align-items-center">
                                    <span class="d-flex align-items-center gap-2 text-muted"><span class="legend-bullet" style="background:#2d88f0"></span> Muzakki</span>
                                    <span class="d-flex align-items-center gap-2 text-muted"><span class="legend-bullet" style="background:#ec4e4e"></span> Mustahik</span>
                                </div>
                            </div>
                            <div class="map-placeholder">
                                <span class="map-dot map-dot--muzakki" style="top: 34%; left: 22%;"></span>
                                <span class="map-dot map-dot--mustahik" style="top: 70%; left: 30%;"></span>
                                <span class="map-dot map-dot--muzakki" style="top: 45%; left: 58%;"></span>
                                <span class="map-dot map-dot--mustahik" style="top: 26%; left: 72%;"></span>
                                <span class="map-dot map-dot--muzakki" style="top: 62%; left: 80%;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="insight-card card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-4">
                                    <div>
                                        <h5 class="mb-1">Insight Wilayah & Peringkat</h5>
                                        <p class="text-muted mb-0">Informasi performa wilayah terbaru.</p>
                                    </div>
                                    <span class="badge bg-success bg-opacity-15 text-success">Stabil</span>
                                </div>
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <div class="fw-semibold">RW 04 (Soreang Indah)</div>
                                            <small class="text-muted">Peringkat 1</small>
                                        </div>
                                        <div class="fw-bold text-success">Rp 45.2jt</div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <div class="fw-semibold">RW 07 (Cingcin)</div>
                                            <small class="text-muted">Peringkat 2</small>
                                        </div>
                                        <div class="fw-bold text-success">Rp 38.9jt</div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-semibold">RW 02 (Soreang Kota)</div>
                                            <small class="text-muted">Peringkat 3</small>
                                        </div>
                                        <div class="fw-bold text-success">Rp 32.1jt</div>
                                    </div>
                                </div>
                                <div class="p-3 rounded-4" style="background: rgba(31,122,59,0.06);">
                                    <h6 class="fw-semibold mb-2">Analitik Pekan Ini</h6>
                                    <p class="mb-0 text-muted" style="font-size:.95rem; line-height:1.7;">Penyaluran Zakat Fitrah telah mencapai 85% dari target wilayah. Sisa mustahik diprioritaskan untuk RW 02.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="transactions-card card mb-4">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                            <div>
                                <h5 class="mb-1">Aktivitas Transaksi Terbaru</h5>
                                <p class="text-muted mb-0">Transaksi masuk dan ringkasan aksi tagihan terbaru.</p>
                            </div>
                            <a href="#" class="text-success text-decoration-none">Lihat Semua →</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
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
                                        <td><span class="badge badge-category bg-success bg-opacity-15 text-success">Zakat Maal</span></td>
                                        <td>Rp 2.500.000</td>
                                        <td>Hari ini, 14:20</td>
                                        <td class="text-end"><button class="btn btn-sm btn-success">Cetak Struk</button></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Siti Hajar</strong></td>
                                        <td><span class="badge badge-category bg-danger bg-opacity-10 text-danger">Infak/Sedekah</span></td>
                                        <td>Rp 500.000</td>
                                        <td>Hari ini, 12:45</td>
                                        <td class="text-end"><button class="btn btn-sm btn-success">Cetak Struk</button></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Bambang M.</strong></td>
                                        <td><span class="badge badge-category bg-info bg-opacity-15 text-info">Zakat Fitrah</span></td>
                                        <td>Rp 450.000</td>
                                        <td>Kemarin, 21:10</td>
                                        <td class="text-end"><button class="btn btn-sm btn-success">Cetak Struk</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="status-card card p-3">
                            <div class="card-body">
                                <small class="label">Sisa Saldo</small>
                                <div class="h3 fw-bold mt-3">Rp 115.7M</div>
                                <p class="text-muted mb-0">Siap Disalurkan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="status-card card p-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="label">Ringkasan Operasional</span>
                                    <span class="badge bg-success bg-opacity-15 text-success">Realtime</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div>
                                        <div class="h4 fw-bold mb-1">1.240</div>
                                        <small class="text-muted d-block">Muzakki Aktif</small>
                                    </div>
                                    <div>
                                        <div class="h4 fw-bold mb-1">856</div>
                                        <small class="text-muted d-block">Mustahik Tersalurkan</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const body = document.body;
        const sidebarOverlay = document.querySelector('.sidebar-overlay');

        const toggleSidebar = () => {
            body.classList.toggle('sidebar-open');
            body.classList.toggle('sidebar-collapsed');
        };

        sidebarToggle.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);

        // Set initial collapsed state for desktop
        if (window.matchMedia('(min-width: 992px)').matches) {
            body.classList.add('sidebar-collapsed');
        }

        window.addEventListener('resize', () => {
            if (window.matchMedia('(min-width: 992px)').matches) {
                if (!body.classList.contains('sidebar-collapsed') && !body.classList.contains('sidebar-open')) {
                    body.classList.add('sidebar-collapsed');
                }
            } else {
                body.classList.remove('sidebar-collapsed');
            }
        });
    </script>
</body>
</html>
