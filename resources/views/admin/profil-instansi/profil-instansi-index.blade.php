<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Instansi | Admin Instansi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --green: #07651f;
            --green-dark: #053f24;
            --green-soft: #e8f4ec;
            --ink: #101411;
            --muted: #6c756f;
            --nav: #263b52;
            --surface: #f6f8f6;
            --panel: #ffffff;
            --input: #f0f2f1;
            --line: #e9eeea;
            --shadow: 0 14px 34px rgba(20, 47, 27, .06);
        }

        * {
            letter-spacing: 0;
        }

        body {
            min-height: 100vh;
            margin: 0;
            background: var(--surface);
            color: var(--ink);
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .app-layout {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 280px minmax(0, 1fr);
        }

        .sidebar {
            background: #f0f3f1;
            border-right: 1px solid var(--line);
            padding: 38px 18px 28px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .brand {
            padding: 0 18px;
        }

        .brand-title {
            color: var(--green-dark);
            font-size: 1.45rem;
            font-weight: 900;
            margin-bottom: 8px;
        }

        .brand-subtitle {
            color: #a0a8a2;
            font-size: .78rem;
            font-weight: 800;
            letter-spacing: .35em;
        }

        .sidebar-nav {
            margin-top: 66px;
            display: grid;
            gap: 10px;
        }

        .nav-item-link {
            display: flex;
            align-items: center;
            gap: 16px;
            min-height: 54px;
            padding: 0 18px;
            border-radius: 20px;
            color: var(--nav);
            font-weight: 600;
            text-decoration: none;
        }

        .nav-item-link:hover,
        .nav-item-link.active {
            background: #fff;
            color: var(--green);
        }

        .nav-item-link.active {
            box-shadow: inset 4px 0 0 var(--green);
        }

        .nav-item-link i {
            width: 24px;
            color: #3f5164;
            font-size: 1.25rem;
            text-align: center;
        }

        .nav-item-link.active i {
            color: var(--green);
        }

        .sidebar-footer {
            margin-top: auto;
            border-top: 1px solid var(--line);
            padding-top: 26px;
            display: grid;
            gap: 8px;
        }

        .logout-button {
            border: 0;
            background: transparent;
            width: 100%;
            text-align: left;
        }

        .content {
            padding: 28px 42px 48px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
            background: #fff;
            margin: -28px -42px 42px;
            padding: 28px 42px;
            border-bottom: 1px solid rgba(233, 238, 234, .7);
        }

        .page-title {
            font-size: 1.9rem;
            font-weight: 900;
            margin: 0 0 4px;
        }

        .page-desc {
            margin: 0;
            color: #1d271f;
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .btn-update {
            background: var(--green);
            border: 0;
            border-radius: 22px;
            color: #fff;
            font-weight: 800;
            padding: 13px 26px;
            box-shadow: 0 12px 24px rgba(7, 101, 31, .2);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            white-space: nowrap;
        }

        .avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--green-soft);
            border: 3px solid #5ab879;
            display: grid;
            place-items: center;
            color: var(--green);
            font-weight: 900;
        }

        .profile-card {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: var(--shadow);
            padding: 34px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 1.5rem;
            font-weight: 900;
            margin-bottom: 30px;
        }

        .section-title::before {
            content: "";
            width: 4px;
            height: 26px;
            border-radius: 999px;
            background: var(--green);
            display: inline-block;
        }

        .field-label {
            color: #263026;
            font-size: .78rem;
            font-weight: 900;
            letter-spacing: .18em;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .field-box {
            min-height: 62px;
            border-radius: 20px;
            background: var(--input);
            display: flex;
            align-items: center;
            padding: 17px 18px;
            color: #111711;
            font-size: 1.06rem;
        }

        .field-box.tall {
            min-height: 138px;
            align-items: flex-start;
            line-height: 1.7;
        }

        .hero-visual {
            min-height: 138px;
            border-radius: 20px;
            overflow: hidden;
            background:
                radial-gradient(circle at 50% 90%, #f6edcf 0 12%, transparent 13%),
                linear-gradient(135deg, #53121c, #741926);
            position: relative;
            display: grid;
            place-items: end center;
        }

        .hero-visual i {
            color: #fff5d6;
            font-size: 5.4rem;
            transform: translateY(22px);
            filter: drop-shadow(0 14px 18px rgba(0,0,0,.18));
        }

        .upload-box {
            border: 2px dashed #e0e9e1;
            border-radius: 20px;
            min-height: 152px;
            display: grid;
            place-items: center;
            text-align: center;
            color: #151915;
        }

        .upload-box i {
            color: #8dbb9b;
            font-size: 2rem;
            margin-bottom: 12px;
        }

        .bank-table {
            overflow: hidden;
            border-radius: 20px;
            background: #f1f3f2;
        }

        .bank-table table {
            margin: 0;
        }

        .bank-table thead th {
            background: #ebeeec;
            border: 0;
            color: #243024;
            font-size: .78rem;
            font-weight: 900;
            letter-spacing: .17em;
            padding: 22px 26px;
            text-transform: uppercase;
        }

        .bank-table tbody td {
            border-color: #e5ebe6;
            padding: 24px 26px;
            vertical-align: middle;
        }

        .bank-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #fff;
            color: var(--green);
            display: grid;
            place-items: center;
            box-shadow: inset 0 0 0 1px #e0e9e2;
        }

        .action-link {
            border: 0;
            background: transparent;
            color: var(--green);
            padding: 6px;
        }

        .action-link.text-danger {
            color: #c51f2f !important;
        }

        @media (max-width: 991px) {
            .app-layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                min-height: auto;
            }

            .content {
                padding: 24px 18px 36px;
            }

            .topbar {
                margin: -24px -18px 30px;
                padding: 24px 18px;
                flex-direction: column;
                align-items: flex-start;
            }

            .top-actions {
                width: 100%;
                justify-content: space-between;
            }

            .profile-card {
                padding: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="app-layout">
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-title">FUNDMIL SOREANG</div>
                <div class="brand-subtitle">SISTEM AMANAH DIGITAL</div>
            </div>

            <nav class="sidebar-nav" aria-label="Navigasi Admin Instansi">
                <a class="nav-item-link" href="{{ route('dashboard.admin') }}">
                    <i class="bi bi-grid-fill"></i>
                    <span>Beranda</span>
                </a>
                <a class="nav-item-link active" href="{{ route('profil-instansi.index') }}">
                    <i class="bi bi-bank2"></i>
                    <span>Profil Instansi</span>
                </a>
                <a class="nav-item-link" href="{{ route('kategori-dana.index') }}">
                    <i class="bi bi-tags-fill"></i>
                    <span>Kategori Dana</span>
                </a>
                <a class="nav-item-link" href="{{ route('pemasukan.index') }}">
                    <i class="bi bi-cash-stack"></i>
                    <span>Pemasukan Zakat</span>
                </a>
                <a class="nav-item-link" href="{{ route('mustahik.index') }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Data Mustahik</span>
                </a>
                <a class="nav-item-link" href="{{ route('program-penyaluran.index') }}">
                    <i class="bi bi-stars"></i>
                    <span>Program Penyaluran</span>
                </a>
                <a class="nav-item-link" href="{{ route('pengaturan-distribusi.index') }}">
                    <i class="bi bi-sliders2"></i>
                    <span>Pengaturan Distribusi</span>
                </a>
                <a class="nav-item-link" href="{{ route('laporan.index') }}">
                    <i class="bi bi-bar-chart-fill"></i>
                    <span>Laporan</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <a class="nav-item-link" href="#">
                    <i class="bi bi-question-circle-fill"></i>
                    <span>Bantuan</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="nav-item-link logout-button" type="submit">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="content">
            <header class="topbar">
                <div>
                    <h1 class="page-title">Profil Instansi</h1>
                    <p class="page-desc">Kelola informasi identitas, legalitas, dan kontak Masjid/Lembaga Anda</p>
                </div>
                <div class="top-actions">
                    <a class="btn-update" href="{{ route('profil-instansi.edit', 1) }}">
                        <i class="bi bi-floppy-fill"></i>
                        <span>Update Profil</span>
                    </a>
                    <i class="bi bi-bell-fill text-muted fs-5"></i>
                    <div class="avatar">AI</div>
                </div>
            </header>

            <section class="profile-card mb-4">
                <h2 class="section-title">Informasi Masjid/Lembaga</h2>
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="field-label">Nama Instansi</div>
                        <div class="field-box">Masjid Jami Al-Ghozali</div>
                    </div>
                    <div class="col-lg-6">
                        <div class="field-label">WhatsApp Admin</div>
                        <div class="field-box"><span class="me-4">+62</span> 81234567890</div>
                    </div>
                    <div class="col-lg-6">
                        <div class="field-label">Tipe Instansi</div>
                        <div class="field-box justify-content-between">
                            <span>Masjid</span>
                            <i class="bi bi-chevron-down text-muted"></i>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="field-label">Email Resmi</div>
                        <div class="field-box">info@alghozalisoreang.org</div>
                    </div>
                    <div class="col-lg-6">
                        <div class="field-label">Alamat Lengkap</div>
                        <div class="field-box tall">Jl. Raya Soreang No. 123, Kabupaten Bandung, Jawa Barat 40911</div>
                    </div>
                    <div class="col-lg-6">
                        <div class="field-label invisible">Foto Instansi</div>
                        <div class="hero-visual">
                            <i class="bi bi-bank2"></i>
                        </div>
                    </div>
                </div>
            </section>

            <div class="row g-4 mb-4">
                <div class="col-lg-6">
                    <section class="profile-card h-100">
                        <h2 class="section-title">Legalitas</h2>
                        <div class="mb-4">
                            <div class="field-label">Nomor SK/Izin Operasional</div>
                            <div class="field-box">SK-BAZNAS/X/2023/004</div>
                        </div>
                        <div>
                            <div class="field-label">Masa Berlaku</div>
                            <div class="field-box justify-content-between">
                                <span>31 Desember 2028</span>
                                <i class="bi bi-calendar-event-fill text-muted"></i>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="col-lg-6">
                    <section class="profile-card h-100">
                        <h2 class="section-title">Pimpinan</h2>
                        <div class="mb-4">
                            <div class="field-label">Nama Ketua/DKM</div>
                            <div class="field-box">Ust. H. Ahmad Fauzi, Lc.</div>
                        </div>
                        <div>
                            <div class="field-label">Tanda Tangan Digital</div>
                            <div class="upload-box">
                                <div>
                                    <i class="bi bi-vector-pen"></i>
                                    <div class="fw-semibold mb-2">Upload Tanda Tangan Digital</div>
                                    <small class="text-muted">Format PNG Transparan (Max 2MB)</small>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <section class="profile-card">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                    <h2 class="section-title mb-0">Rekening Operasional</h2>
                    <button class="btn btn-link text-success fw-bold text-decoration-none px-0">
                        <i class="bi bi-plus-circle-fill me-2"></i>Tambah Rekening
                    </button>
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
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="bank-icon"><i class="bi bi-wallet2"></i></span>
                                        <strong>BSI (Bank Syariah Indonesia)</strong>
                                    </div>
                                </td>
                                <td>7001020304</td>
                                <td>DKM AL-GHOZALI SOREANG</td>
                                <td class="text-end">
                                    <button class="action-link"><i class="bi bi-pencil-fill"></i></button>
                                    <button class="action-link text-danger"><i class="bi bi-trash-fill"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="bank-icon"><i class="bi bi-wallet2"></i></span>
                                        <strong>Bank Muamalat</strong>
                                    </div>
                                </td>
                                <td>123-00-4567-89</td>
                                <td>OPERASIONAL MASJID</td>
                                <td class="text-end">
                                    <button class="action-link"><i class="bi bi-pencil-fill"></i></button>
                                    <button class="action-link text-danger"><i class="bi bi-trash-fill"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
