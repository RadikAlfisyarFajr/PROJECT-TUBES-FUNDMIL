<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval Admin Instansi | Super Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --green: #0b7131;
            --green-dark: #063d1f;
            --green-soft: #e8f5ec;
            --surface: #f5f8f6;
            --line: #e3ebe4;
            --ink: #111711;
            --muted: #728074;
            --nav-text: #273b51;
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
        .admin-layout {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 320px minmax(0, 1fr);
        }
        .sidebar {
            background: #f0f4f2;
            border-right: 1px solid var(--line);
            padding: 42px 24px 28px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .brand-title {
            color: var(--green-dark);
            font-size: 1.35rem;
            font-weight: 900;
            margin-bottom: 8px;
        }
        .brand-subtitle {
            color: #9aa39b;
            font-size: .78rem;
            font-weight: 800;
            letter-spacing: .34em;
        }
        .sidebar-nav {
            margin-top: 74px;
            display: grid;
            gap: 12px;
        }
        .nav-item-link {
            display: flex;
            align-items: center;
            gap: 18px;
            min-height: 62px;
            padding: 0 22px;
            border-radius: 16px;
            color: var(--nav-text);
            font-size: 1.05rem;
            font-weight: 700;
            text-decoration: none;
        }
        .nav-item-link.active {
            background: #fff;
            color: var(--green);
            box-shadow: 0 12px 28px rgba(15, 45, 22, .05);
            border-left: 4px solid var(--green);
        }
        .nav-item-link i {
            width: 24px;
            color: #41516a;
            font-size: 1.35rem;
            text-align: center;
        }
        .nav-item-link.active i {
            color: var(--green);
        }
        .sidebar-bottom {
            margin-top: auto;
            border-top: 1px solid var(--line);
            padding-top: 28px;
        }
        .logout-button {
            border: 0;
            background: transparent;
            color: var(--nav-text);
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 14px 22px;
            font-size: 1.05rem;
            font-weight: 700;
        }
        .main-content {
            padding: 36px 46px 54px;
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            margin-bottom: 34px;
        }
        .page-title {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 900;
            line-height: 1.05;
            margin: 0 0 8px;
        }
        .page-description {
            color: #394338;
            font-size: 1.08rem;
            margin: 0;
        }
        .summary-card {
            background: var(--green);
            color: #fff;
            border-radius: 18px;
            min-width: 230px;
            padding: 20px 24px;
            box-shadow: 0 18px 35px rgba(11, 113, 49, .18);
        }
        .summary-card .number {
            font-size: 2.4rem;
            line-height: 1;
            font-weight: 900;
        }
        .filter-card,
        .table-card,
        .empty-card {
            background: rgba(255,255,255,.72);
            border: 1px solid #edf1ed;
            border-radius: 20px;
            box-shadow: 0 10px 28px rgba(15, 28, 17, .035);
        }
        .filter-card {
            padding: 22px;
            margin-bottom: 30px;
        }
        .search-wrap {
            position: relative;
        }
        .search-wrap i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #233025;
            font-size: 1.35rem;
        }
        .form-control,
        .form-select {
            min-height: 58px;
            border-radius: 14px;
            border: 1px solid #e1e8e1;
            box-shadow: none;
            font-size: 1rem;
        }
        .search-input {
            padding-left: 58px;
        }
        .table-card {
            overflow: hidden;
        }
        .approval-table {
            margin: 0;
        }
        .approval-table thead th {
            background: #f0f3f1;
            border: 0;
            color: #1f2a20;
            font-size: .8rem;
            font-weight: 900;
            letter-spacing: .2em;
            padding: 24px 28px;
            text-transform: uppercase;
            white-space: nowrap;
        }
        .approval-table tbody td {
            border-color: #edf1ee;
            padding: 28px;
            vertical-align: middle;
        }
        .instansi-icon {
            width: 54px;
            height: 54px;
            border-radius: 12px;
            background: var(--green-soft);
            color: var(--green);
            display: grid;
            place-items: center;
            font-size: 1.45rem;
            flex: 0 0 auto;
        }
        .instansi-name {
            font-size: 1.06rem;
            font-weight: 900;
            margin-bottom: 2px;
        }
        .muted-small {
            color: var(--muted);
            font-size: .9rem;
        }
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            border-radius: 999px;
            background: #fff4d8;
            color: #946200;
            font-size: .78rem;
            font-weight: 900;
            padding: 7px 12px;
            text-transform: uppercase;
        }
        .action-stack {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
        }
        .btn-approve {
            background: var(--green);
            border-color: var(--green);
            color: #fff;
            border-radius: 999px;
            font-weight: 800;
            padding: 10px 16px;
        }
        .btn-reject {
            border-color: #f0b6be;
            color: #b42335;
            background: #fff;
            border-radius: 999px;
            font-weight: 800;
            padding: 10px 16px;
        }
        .empty-card {
            padding: 54px 28px;
            text-align: center;
        }
        .empty-icon {
            width: 74px;
            height: 74px;
            border-radius: 24px;
            display: grid;
            place-items: center;
            margin: 0 auto 20px;
            background: var(--green-soft);
            color: var(--green);
            font-size: 2rem;
        }
        @media (max-width: 991px) {
            .admin-layout {
                grid-template-columns: 1fr;
            }
            .sidebar {
                min-height: auto;
                padding: 24px 18px;
            }
            .sidebar-nav {
                margin-top: 28px;
            }
            .sidebar-bottom {
                margin-top: 28px;
            }
            .main-content {
                padding: 28px 18px 42px;
            }
            .page-header {
                flex-direction: column;
            }
            .summary-card {
                width: 100%;
            }
            .approval-table thead {
                display: none;
            }
            .approval-table,
            .approval-table tbody,
            .approval-table tr,
            .approval-table td {
                display: block;
                width: 100%;
            }
            .approval-table tbody tr {
                border-bottom: 1px solid #edf1ee;
            }
            .approval-table tbody td {
                padding: 18px 20px;
            }
            .action-stack {
                justify-content: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <div>
                <div class="brand-title">FUNDMIL SOREANG</div>
                <div class="brand-subtitle">SISTEM AMANAH DIGITAL</div>
            </div>

            <nav class="sidebar-nav" aria-label="Navigasi Super Admin">
                <a href="{{ route('dashboard.superadmin') }}" class="nav-item-link active">
                    <i class="bi bi-person-check-fill"></i>
                    <span>Approval Admin</span>
                </a>
            </nav>

            <div class="sidebar-bottom">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-button">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="main-content">
            <header class="page-header">
                <div>
                    <h1 class="page-title">Approval Admin Instansi</h1>
                    <p class="page-description">Tinjau akun instansi baru sebelum mereka dapat masuk ke dashboard pengelolaan zakat.</p>
                </div>
                <div class="summary-card">
                    <div class="text-uppercase fw-bold small mb-2">Menunggu Approval</div>
                    <div class="number">{{ $pendingUsers->count() }}</div>
                </div>
            </header>

            @if(session('success'))
                <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4">{{ session('success') }}</div>
            @endif

            <section class="filter-card">
                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="search-wrap">
                            <i class="bi bi-search"></i>
                            <input type="search" class="form-control search-input" placeholder="Cari nama instansi, desa, email, atau username...">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <select class="form-select">
                            <option>Semua akun pending</option>
                            <option>Registrasi terbaru</option>
                            <option>Registrasi terlama</option>
                        </select>
                    </div>
                </div>
            </section>

            @if($pendingUsers->isEmpty())
                <section class="empty-card">
                    <div class="empty-icon">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                    <h2 class="h4 fw-bold mb-2">Tidak Ada Approval Baru</h2>
                    <p class="text-muted mb-0">Semua akun admin instansi sudah ditinjau.</p>
                </section>
            @else
                <section class="table-card">
                    <div class="table-responsive">
                        <table class="table approval-table align-middle">
                            <thead>
                                <tr>
                                    <th>Nama Instansi</th>
                                    <th>Wilayah</th>
                                    <th>Akun Admin</th>
                                    <th>Status</th>
                                    <th>Daftar</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingUsers as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="instansi-icon">
                                                    <i class="bi bi-bank2"></i>
                                                </div>
                                                <div>
                                                    <div class="instansi-name">{{ $user->nama_instansi ?? $user->name }}</div>
                                                    <div class="muted-small">{{ $user->username }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ $user->desa ?? '-' }}</div>
                                            <div class="muted-small">Wilayah operasional</div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ $user->name }}</div>
                                            <div class="muted-small">{{ $user->email }}</div>
                                        </td>
                                        <td>
                                            <span class="status-pill">
                                                <i class="bi bi-clock-history"></i>
                                                Pending
                                            </span>
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ $user->created_at->format('d M Y') }}</div>
                                            <div class="muted-small">{{ $user->created_at->format('H:i') }} WIB</div>
                                        </td>
                                        <td>
                                            <div class="action-stack">
                                                <form method="POST" action="{{ route('superadmin.approve', $user) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-approve">
                                                        <i class="bi bi-check2 me-1"></i> Setujui
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('superadmin.reject', $user) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-reject">
                                                        <i class="bi bi-x-lg me-1"></i> Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            @endif
        </main>
    </div>
</body>
</html>
