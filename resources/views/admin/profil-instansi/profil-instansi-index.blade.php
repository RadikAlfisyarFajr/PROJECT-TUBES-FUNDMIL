<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Instansi | FundMil Soreang</title>
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
        .sidebar-collapsed .sidebar__brand,
        .sidebar-collapsed .nav-link,
        .sidebar-collapsed .sidebar-toggle {
            justify-content: center;
        }
        .sidebar-collapsed .nav-link,
        .sidebar-collapsed .sidebar-toggle {
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
            min-height: 100vh;
            background: #edf6ee;
        }
        .sidebar-toggle {
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
        .topbar {
            align-items: center;
            gap: 1rem;
        }
        .action-button {
            border-radius: 18px;
            padding: .8rem 1.35rem;
            box-shadow: 0 14px 28px rgba(31, 122, 59, 0.18);
        }
        .profile-card {
            background: var(--surface-strong);
            border-radius: 24px;
            border: 1px solid rgba(23, 36, 26, 0.06);
            box-shadow: var(--shadow-soft);
        }
        .profile-card .card-body {
            padding: 1.75rem;
        }
        .section-title {
            display: flex;
            align-items: center;
            gap: .8rem;
            margin-bottom: 1.75rem;
            font-weight: 700;
        }
        .section-title::before {
            content: '';
            display: inline-block;
            width: 4px;
            height: 28px;
            border-radius: 999px;
            background: var(--primary);
        }
        .field-label {
            color: #28362f;
            font-size: .78rem;
            font-weight: 800;
            letter-spacing: .14em;
            margin-bottom: .65rem;
            text-transform: uppercase;
        }
        .profile-field {
            background: #f1f4f1;
            border-radius: 18px;
            color: #101814;
            min-height: 58px;
            padding: 1rem 1.1rem;
        }
        .profile-field--textarea {
            min-height: 130px;
            line-height: 1.65;
        }
        .logo-placeholder {
            min-height: 130px;
            overflow: hidden;
            border-radius: 18px;
            background: linear-gradient(135deg, #60121d 0%, #741c27 52%, #4a0e16 100%);
            position: relative;
        }
        .logo-placeholder::before {
            content: '';
            position: absolute;
            inset: auto -10% -22% -10%;
            height: 92px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 50% 50% 0 0;
        }
        .logo-placeholder .bi {
            position: relative;
            color: #fff7d6;
            font-size: 5.6rem;
            line-height: 1;
            text-shadow: 0 12px 26px rgba(0,0,0,.22);
        }
        .upload-box {
            border: 2px dashed var(--border);
            border-radius: 20px;
            min-height: 140px;
            color: #90b89b;
        }
        .bank-table {
            background: #f1f4f1;
            border-radius: 22px;
            overflow: hidden;
        }
        .bank-table table {
            margin-bottom: 0;
        }
        .bank-table th {
            color: #28362f;
            font-size: .78rem;
            letter-spacing: .14em;
            padding: 1.1rem 1.5rem;
            text-transform: uppercase;
        }
        .bank-table td {
            border-color: rgba(23, 36, 26, 0.04);
            padding: 1.35rem 1.5rem;
            vertical-align: middle;
        }
        .bank-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #fff;
            color: var(--primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
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
            .sidebar-collapsed .nav-link,
            .sidebar-collapsed .sidebar-toggle {
                justify-content: flex-start;
                padding: 0.95rem 1rem;
            }
            .sidebar__footer {
                position: static;
            }
            .content {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid dashboard-layout">
        <div class="row g-0 flex-nowrap w-100">
            <aside class="sidebar position-relative">
                <div class="mb-5">
                    <div class="sidebar__brand d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-shield-lock-fill fs-4"></i>
                        <span>FUNDMIL SOREANG</span>
                    </div>
                    <div class="sidebar__subtitle text-uppercase fw-semibold" style="letter-spacing:.28em;">Sistem Amanah Digital</div>
                </div>

                <nav class="nav flex-column gap-1">
                    <button id="sidebarToggle" class="sidebar-toggle d-flex align-items-center">
                        <i class="bi bi-list"></i>
                        <span class="nav-text ms-3">Menu</span>
                    </button>
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('dashboard.admin') ? 'active' : '' }}" href="{{ route('dashboard.admin') }}">
                        <i class="bi bi-grid-fill"></i>
                        <span class="nav-text">Beranda</span>
                    </a>
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('profil-instansi.*') ? 'active' : '' }}" href="{{ route('profil-instansi.index') }}">
                        <i class="bi bi-bank2"></i>
                        <span class="nav-text">Profil Instansi</span>
                    </a>
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('kategori-dana.*') ? 'active' : '' }}" href="{{ route('kategori-dana.index') }}">
                        <i class="bi bi-tags-fill"></i>
                        <span class="nav-text">Kategori Dana</span>
                    </a>
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('pemasukan.*') ? 'active' : '' }}" href="{{ route('pemasukan.index') }}">
                        <i class="bi bi-cash-stack"></i>
                        <span class="nav-text">Pemasukan Zakat</span>
                    </a>
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('mustahik.*') ? 'active' : '' }}" href="{{ route('mustahik.index') }}">
                        <i class="bi bi-people-fill"></i>
                        <span class="nav-text">Data Mustahik</span>
                    </a>
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('program-penyaluran.*') ? 'active' : '' }}" href="{{ route('program-penyaluran.index') }}">
                        <i class="bi bi-stars"></i>
                        <span class="nav-text">Program Penyaluran</span>
                    </a>
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('pengaturan-distribusi.*') ? 'active' : '' }}" href="{{ route('pengaturan-distribusi.index') }}">
                        <i class="bi bi-sliders2-vertical"></i>
                        <span class="nav-text">Pengaturan Distribusi</span>
                    </a>
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('laporan.*') ? 'active' : '' }}" href="{{ route('laporan.index') }}">
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
                        <i class="bi bi-question-circle-fill"></i>
                        Bantuan
                    </a>
                </div>
            </aside>
            <div class="sidebar-overlay"></div>

            <main class="content">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4 topbar">
                    <div>
                        <h2 class="mb-1 fw-bold">Profil Instansi</h2>
                        <p class="mb-0 text-muted">Kelola informasi identitas, legalitas, dan kontak Masjid/Lembaga Anda</p>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('profil-instansi.edit', 1) }}" class="btn btn-success action-button fw-semibold d-inline-flex align-items-center gap-2">
                            <i class="bi bi-save-fill"></i>
                            Update Profil
                        </a>
                        <button class="btn btn-white border rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width:52px; height:52px;">
                            <i class="bi bi-bell-fill text-muted"></i>
                        </button>
                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center border border-3 border-success-subtle" style="width:52px; height:52px;">AM</div>
                    </div>
                </div>

                <div class="profile-card card mb-4">
                    <div class="card-body">
                        <h4 class="section-title">Informasi Masjid/Lembaga</h4>
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="field-label">Nama Instansi</div>
                                <div class="profile-field">Masjid Jami Al-Ghozali</div>
                            </div>
                            <div class="col-lg-6">
                                <div class="field-label">Whatsapp Admin</div>
                                <div class="profile-field d-flex gap-4">
                                    <span>+62</span>
                                    <span>81234567890</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="field-label">Tipe Instansi</div>
                                <div class="profile-field d-flex justify-content-between align-items-center">
                                    <span>Masjid</span>
                                    <i class="bi bi-chevron-down text-muted"></i>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="field-label">Email Resmi</div>
                                <div class="profile-field">info@alghozalisoreang.org</div>
                            </div>
                            <div class="col-lg-6">
                                <div class="field-label">Alamat Lengkap</div>
                                <div class="profile-field profile-field--textarea">Jl. Raya Soreang No. 123, Kabupaten Bandung,<br>Jawa Barat 40911</div>
                            </div>
                            <div class="col-lg-6">
                                <div class="field-label">Logo / Avatar</div>
                                <div class="logo-placeholder d-flex align-items-end justify-content-center">
                                    <i class="bi bi-bank2"></i>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="field-label">Deskripsi</div>
                                <div class="profile-field profile-field--textarea">Masjid Jami Al-Ghozali Soreang mengelola penghimpunan dan penyaluran zakat, infak, dan sedekah untuk masyarakat sekitar secara amanah, transparan, dan terukur.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-lg-6">
                        <div class="profile-card card h-100">
                            <div class="card-body">
                                <h4 class="section-title">Legalitas</h4>
                                <div class="mb-4">
                                    <div class="field-label">Nomor SK/Izin Operasional</div>
                                    <div class="profile-field">SK-BAZNAS/X/2023/004</div>
                                </div>
                                <div>
                                    <div class="field-label">Masa Berlaku</div>
                                    <div class="profile-field d-flex justify-content-between align-items-center">
                                        <span>31 Desember 2028</span>
                                        <i class="bi bi-calendar-event-fill text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="profile-card card h-100">
                            <div class="card-body">
                                <h4 class="section-title">Pimpinan</h4>
                                <div class="mb-4">
                                    <div class="field-label">Nama Ketua/DKM</div>
                                    <div class="profile-field">Ust. H. Ahmad Fauzi, Lc.</div>
                                </div>
                                <div>
                                    <div class="field-label">Tanda Tangan Digital</div>
                                    <div class="upload-box d-flex flex-column align-items-center justify-content-center text-center p-4">
                                        <i class="bi bi-vector-pen fs-3 mb-2"></i>
                                        <div class="text-dark">Upload Tanda Tangan Digital</div>
                                        <small class="text-muted mt-2">Format PNG Transparan (Max 2MB)</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="profile-card card mb-4">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
                            <h4 class="section-title mb-0">Rekening Operasional</h4>
                            <a href="#" class="text-success text-decoration-none fw-semibold d-inline-flex align-items-center gap-2">
                                <i class="bi bi-plus-circle-fill"></i>
                                Tambah Rekening
                            </a>
                        </div>

                        <div class="bank-table table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Nama Bank</th>
                                        <th>Nomor Rekening</th>
                                        <th>Nama Pemilik</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3 fw-semibold">
                                                <span class="bank-icon"><i class="bi bi-wallet2"></i></span>
                                                BSI (Bank Syariah Indonesia)
                                            </div>
                                        </td>
                                        <td>7001020304</td>
                                        <td>DKM AL-GHOZALI SOREANG</td>
                                        <td class="text-end">
                                            <a href="#" class="text-success me-3"><i class="bi bi-pencil-fill"></i></a>
                                            <a href="#" class="text-danger"><i class="bi bi-trash-fill"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3 fw-semibold">
                                                <span class="bank-icon"><i class="bi bi-wallet2"></i></span>
                                                Bank Muamalat
                                            </div>
                                        </td>
                                        <td>123-00-4567-89</td>
                                        <td>OPERASIONAL MASJID</td>
                                        <td class="text-end">
                                            <a href="#" class="text-success me-3"><i class="bi bi-pencil-fill"></i></a>
                                            <a href="#" class="text-danger"><i class="bi bi-trash-fill"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
