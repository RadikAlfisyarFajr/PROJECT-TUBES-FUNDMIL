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
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            overflow-x: hidden;
            background: var(--surface);
            color: var(--ink);
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .app-layout {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 88px minmax(0, 1fr);
            transition: grid-template-columns .25s ease;
        }

        body.sidebar-expanded .app-layout {
            grid-template-columns: 280px minmax(0, 1fr);
        }

        .sidebar {
            background: #f0f3f1;
            border-right: 1px solid var(--line);
            padding: 20px 12px 24px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-x: hidden;
            transition: padding .25s ease;
        }

        body.sidebar-expanded .sidebar {
            padding: 34px 18px 28px;
        }

        .brand {
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 52px;
            overflow: hidden;
            transition: padding .25s ease;
        }

        body.sidebar-expanded .brand {
            justify-content: flex-start;
            padding: 0 18px;
        }

        .brand-icon {
            width: 28px;
            height: 28px;
            border-radius: 10px;
            background: var(--green);
            color: #fff;
            display: grid;
            place-items: center;
            flex: 0 0 auto;
        }

        .brand-copy {
            display: none;
            white-space: nowrap;
        }

        body.sidebar-expanded .brand-copy {
            display: block;
        }

        .brand-title {
            color: var(--green-dark);
            font-size: 1.28rem;
            font-weight: 900;
            margin-bottom: 6px;
            white-space: nowrap;
        }

        .brand-subtitle {
            color: #a0a8a2;
            font-size: .68rem;
            font-weight: 800;
            letter-spacing: .28em;
            white-space: nowrap;
        }

        .sidebar-nav {
            margin-top: 34px;
            display: grid;
            gap: 6px;
            transition: margin-top .25s ease;
        }

        body.sidebar-expanded .sidebar-nav {
            margin-top: 44px;
        }

        .sidebar-toggle,
        .nav-item-link {
            width: 58px;
            height: 52px;
            min-height: 52px;
            margin-left: auto;
            margin-right: auto;
            border: 0;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            padding: 0;
            border-radius: 14px;
            color: var(--nav);
            font-weight: 600;
            text-decoration: none;
            overflow: hidden;
            white-space: nowrap;
            transition: background .2s ease, color .2s ease, width .25s ease, padding .25s ease, border-radius .25s ease;
        }

        body.sidebar-expanded .sidebar-toggle,
        body.sidebar-expanded .nav-item-link {
            width: 100%;
            padding: 0 16px;
            justify-content: flex-start;
        }

        .nav-item-link:hover,
        .nav-item-link.active {
            background: #fff;
            color: var(--green);
        }

        .sidebar-toggle:hover {
            background: rgba(7, 101, 31, .08);
            color: var(--green);
        }

        .nav-item-link.active {
            background: #fff;
            box-shadow: inset 4px 0 0 var(--green);
        }

        .sidebar-toggle i,
        .nav-item-link i {
            width: 24px;
            color: var(--green-dark);
            font-size: 1.25rem;
            text-align: center;
            flex: 0 0 auto;
        }

        .nav-item-link.active i {
            color: var(--green);
        }

        .nav-item-link span,
        .sidebar-toggle span {
            display: none;
        }

        body.sidebar-expanded .nav-item-link span,
        body.sidebar-expanded .sidebar-toggle span {
            display: inline;
        }

        .sidebar-footer {
            margin-top: auto;
            border-top: 1px solid var(--line);
            padding-top: 14px;
            display: grid;
            gap: 8px;
        }

        .sidebar-toggle {
            color: var(--muted);
            font-weight: 650;
            margin-bottom: 10px;
        }

        .sidebar-toggle i {
            font-size: 1.35rem;
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
            display: grid;
            place-items: center;
            color: var(--green);
            font-weight: 900;
            overflow: hidden;
            flex: 0 0 auto;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .notification-toggle {
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

        .notification-toggle:hover,
        .notification-toggle.show {
            background: var(--green-soft);
            color: var(--green);
        }

        .notification-badge {
            min-width: 18px;
            height: 18px;
            padding: 0 5px;
            border-radius: 999px;
            background: #d82132;
            color: #fff;
            display: grid;
            place-items: center;
            font-size: .68rem;
            font-weight: 900;
            position: absolute;
            top: 2px;
            right: 1px;
        }

        .notification-menu {
            width: min(360px, calc(100vw - 32px));
            padding: 0;
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: 0 18px 38px rgba(20, 47, 27, .13);
            overflow: hidden;
        }

        .notification-header {
            padding: 16px 18px;
            border-bottom: 1px solid var(--line);
            font-weight: 900;
        }

        .notification-item {
            padding: 14px 18px;
            border-bottom: 1px solid #edf1ee;
            white-space: normal;
        }

        .notification-item:last-child {
            border-bottom: 0;
        }

        .notification-title {
            color: var(--ink);
            font-weight: 850;
            margin-bottom: 4px;
        }

        .notification-text {
            color: #536058;
            font-size: .82rem;
            line-height: 1.45;
            margin-bottom: 6px;
        }

        .notification-time {
            color: #8a958f;
            font-size: .74rem;
            font-weight: 700;
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
            background: linear-gradient(135deg, #54121d 0%, #741926 100%);
            position: relative;
            display: grid;
            place-items: end center;
        }

        .hero-visual img {
            width: 100%;
            height: 100%;
            min-height: 138px;
            object-fit: cover;
            position: relative;
            z-index: 1;
        }

        .hero-visual::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 18% 22%, rgba(255, 255, 255, .08), transparent 22%),
                radial-gradient(circle at 82% 18%, rgba(255, 218, 124, .14), transparent 20%);
        }

        .mosque-art {
            position: relative;
            width: 250px;
            height: 138px;
            transform: translateY(22px);
            filter: drop-shadow(0 16px 18px rgba(0, 0, 0, .2));
        }

        .mosque-dome {
            position: absolute;
            left: 50%;
            bottom: 42px;
            width: 94px;
            height: 86px;
            border-radius: 52px 52px 10px 10px;
            background: #fff7d9;
            transform: translateX(-50%);
            border: 5px solid #eee2bd;
        }

        .mosque-dome::before {
            content: "";
            position: absolute;
            left: 50%;
            top: -21px;
            width: 12px;
            height: 30px;
            border-radius: 999px 999px 0 0;
            background: #fff7d9;
            border: 4px solid #eee2bd;
            transform: translateX(-50%);
        }

        .mosque-dome::after {
            content: "";
            position: absolute;
            left: 50%;
            top: -33px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #f0a51d;
            transform: translateX(-50%);
        }

        .mosque-body {
            position: absolute;
            left: 50%;
            bottom: 0;
            width: 155px;
            height: 60px;
            border: 5px solid #eee2bd;
            background: #fff7d9;
            transform: translateX(-50%);
        }

        .mosque-door {
            position: absolute;
            left: 50%;
            bottom: 0;
            width: 42px;
            height: 42px;
            border-radius: 22px 22px 0 0;
            background: #8d7460;
            border: 4px solid #d8c69f;
            transform: translateX(-50%);
        }

        .mosque-minaret {
            position: absolute;
            bottom: 0;
            width: 28px;
            height: 118px;
            background: #fff7d9;
            border: 5px solid #eee2bd;
        }

        .mosque-minaret.left {
            left: 32px;
        }

        .mosque-minaret.right {
            right: 32px;
        }

        .mosque-minaret::before {
            content: "";
            position: absolute;
            left: 50%;
            top: -23px;
            width: 24px;
            height: 30px;
            border-radius: 14px 14px 0 0;
            background: #fff7d9;
            border: 5px solid #eee2bd;
            transform: translateX(-50%);
        }

        .mosque-minaret::after {
            content: "";
            position: absolute;
            left: 50%;
            top: -33px;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #f0a51d;
            transform: translateX(-50%);
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

        .signature-img {
            max-width: 100%;
            max-height: 112px;
            object-fit: contain;
        }

        .bank-table {
            overflow: hidden;
            border-radius: 20px;
            background: #f1f3f2;
        }

        .bank-table table {
            margin: 0;
            min-width: 760px;
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
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>

<body class="sidebar-expanded">
    <div class="app-layout">
        @include('admin.partials.sidebar', ['active' => 'profil'])

        <main class="content">
            <header class="topbar">
                <div>
                    <h1 class="page-title">Profil Instansi</h1>
                    <p class="page-desc">Kelola informasi identitas, legalitas, dan kontak Masjid/Lembaga Anda</p>
                </div>
                <div class="top-actions">
                    <a class="btn-update" href="{{ route('profil-instansi.edit', $instansi->id) }}">
                        <i class="bi bi-floppy-fill"></i>
                        <span>Update Profil</span>
                    </a>
                    <div class="dropdown">
                        <button
                            id="notificationToggle"
                            class="notification-toggle"
                            type="button"
                            data-bs-toggle="dropdown"
                            data-bs-auto-close="outside"
                            aria-expanded="false"
                            aria-label="Notifikasi profil instansi">
                            <i class="bi bi-bell-fill fs-5"></i>
                            @if ($unreadNotifications > 0)
                            <span id="notificationBadge" class="notification-badge">{{ $unreadNotifications > 9 ? '9+' : $unreadNotifications }}</span>
                            @endif
                        </button>
                        <div class="dropdown-menu dropdown-menu-end notification-menu" aria-labelledby="notificationToggle">
                            <div class="notification-header">Notifikasi Pembaruan</div>
                            @forelse ($notifications as $notification)
                            <div class="notification-item">
                                <div class="notification-title">{{ $notification->title }}</div>
                                <div class="notification-text">{{ $notification->message }}</div>
                                <div class="notification-time">{{ $notification->created_at->diffForHumans() }}</div>
                            </div>
                            @empty
                            <div class="notification-item text-center text-muted">
                                Belum ada pembaruan profil.
                            </div>
                            @endforelse
                        </div>
                    </div>
                    @include('admin.partials.account-identity', [
                        'nameClass' => 'admin-name',
                        'roleClass' => 'admin-role',
                        'avatarClass' => 'avatar',
                    ])
                </div>
            </header>

            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Data belum bisa disimpan.</strong>
                <div>Periksa kembali input pada form.</div>
            </div>
            @endif

            <section class="profile-card mb-4">
                <h2 class="section-title">Informasi Masjid/Lembaga</h2>
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="field-label">Nama Instansi</div>
                        <div class="field-box">{{ $instansi->nama }}</div>
                    </div>
                    <div class="col-lg-6">
                        <div class="field-label">WhatsApp Admin</div>
                        <div class="field-box">{{ $instansi->kontak ?: '-' }}</div>
                    </div>
                    <div class="col-lg-6">
                        <div class="field-label">Tipe Instansi</div>
                        <div class="field-box justify-content-between">
                            <span>{{ $instansi->tipe ?: '-' }}</span>
                            <i class="bi bi-chevron-down text-muted"></i>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="field-label">Email Resmi</div>
                        <div class="field-box">{{ $instansi->email ?: '-' }}</div>
                    </div>
                    <div class="col-lg-6">
                        <div class="field-label">Alamat Lengkap</div>
                        <div class="field-box tall">{{ $instansi->alamat ?: '-' }}</div>
                    </div>
                    <div class="col-lg-6">
                        <div class="field-label invisible">Foto Instansi</div>
                        <div class="hero-visual">
                            @if ($instansi->logo)
                            <img src="{{ asset('storage/'.$instansi->logo) }}" alt="Foto profil {{ $instansi->nama }}">
                            @else
                            <div class="mosque-art" aria-hidden="true">
                                <span class="mosque-minaret left"></span>
                                <span class="mosque-minaret right"></span>
                                <span class="mosque-body"></span>
                                <span class="mosque-dome"></span>
                                <span class="mosque-door"></span>
                            </div>
                            @endif
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
                            <div class="field-box">{{ $instansi->nomor_sk ?: '-' }}</div>
                        </div>
                        <div>
                            <div class="field-label">Masa Berlaku</div>
                            <div class="field-box justify-content-between">
                                <span>{{ $instansi->masa_berlaku ? $instansi->masa_berlaku->translatedFormat('d F Y') : '-' }}</span>
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
                            <div class="field-box">{{ $instansi->nama_pimpinan ?: '-' }}</div>
                        </div>
                        <div>
                            <div class="field-label">Tanda Tangan Digital</div>
                            <div class="upload-box">
                                @if ($instansi->tanda_tangan)
                                <img class="signature-img" src="{{ asset('storage/'.$instansi->tanda_tangan) }}" alt="Tanda tangan digital">
                                @else
                                <div>
                                    <i class="bi bi-vector-pen"></i>
                                    <div class="fw-semibold mb-2">Belum ada tanda tangan digital</div>
                                    <small class="text-muted">Upload melalui tombol Update Profil</small>
                                </div>
                                @endif
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <section class="profile-card">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                    <h2 class="section-title mb-0">Rekening Operasional</h2>
                    <button class="btn btn-link text-success fw-bold text-decoration-none px-0" type="button" data-bs-toggle="modal" data-bs-target="#modalTambahRekening">
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
                            @forelse ($instansi->rekening as $rekening)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="bank-icon"><i class="bi bi-wallet2"></i></span>
                                        <strong>{{ $rekening->nama_bank }}</strong>
                                    </div>
                                </td>
                                <td>{{ $rekening->nomor_rekening }}</td>
                                <td>{{ $rekening->nama_pemilik }}</td>
                                <td class="text-end">
                                    <button class="action-link" type="button" data-bs-toggle="modal" data-bs-target="#modalEditRekening{{ $rekening->id }}">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <form class="d-inline" action="{{ route('profil-instansi.rekening.destroy', $rekening) }}" method="POST" onsubmit="return confirm('Hapus rekening ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="action-link text-danger" type="submit"><i class="bi bi-trash-fill"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Belum ada rekening operasional.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <div class="modal fade" id="modalTambahRekening" tabindex="-1" aria-labelledby="modalTambahRekeningLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('profil-instansi.rekening.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahRekeningLabel">Tambah Rekening</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="nama_bank">Nama Bank</label>
                        <input id="nama_bank" class="form-control" name="nama_bank" value="{{ old('nama_bank') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="nomor_rekening">Nomor Rekening</label>
                        <input id="nomor_rekening" class="form-control" name="nomor_rekening" value="{{ old('nomor_rekening') }}" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label" for="nama_pemilik">Nama Pemilik</label>
                        <input id="nama_pemilik" class="form-control" name="nama_pemilik" value="{{ old('nama_pemilik') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    @foreach ($instansi->rekening as $rekening)
    <div class="modal fade" id="modalEditRekening{{ $rekening->id }}" tabindex="-1" aria-labelledby="modalEditRekeningLabel{{ $rekening->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('profil-instansi.rekening.update', $rekening) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditRekeningLabel{{ $rekening->id }}">Edit Rekening</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="nama_bank_{{ $rekening->id }}">Nama Bank</label>
                        <input id="nama_bank_{{ $rekening->id }}" class="form-control" name="nama_bank" value="{{ old('nama_bank', $rekening->nama_bank) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="nomor_rekening_{{ $rekening->id }}">Nomor Rekening</label>
                        <input id="nomor_rekening_{{ $rekening->id }}" class="form-control" name="nomor_rekening" value="{{ old('nomor_rekening', $rekening->nomor_rekening) }}" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label" for="nama_pemilik_{{ $rekening->id }}">Nama Pemilik</label>
                        <input id="nama_pemilik_{{ $rekening->id }}" class="form-control" name="nama_pemilik" value="{{ old('nama_pemilik', $rekening->nama_pemilik) }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');

        sidebarToggle?.addEventListener('click', () => {
            document.body.classList.toggle('sidebar-expanded');
        });

        const notificationToggle = document.getElementById('notificationToggle');

        notificationToggle?.addEventListener('shown.bs.dropdown', () => {
            const badge = document.getElementById('notificationBadge');
            badge?.remove();

            fetch('{{ route("profil-instansi.notifications.read") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    const badge = document.getElementById('notificationBadge');
                    if (badge) {
                        badge.remove();
                    }
                })
                .catch(error => {
                    console.error('Gagal menandai notifikasi sebagai terbaca:', error);
                });
        });
    </script>
</body>

</html>
