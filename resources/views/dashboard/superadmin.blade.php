<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Super Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>

<body class="sidebar-expanded">
    <div class="admin-layout">
        @include('superadmin.partials.sidebar', ['active' => 'dashboard'])

        <main class="admin-page-content">
            <header class="admin-page-topbar mb-4">
                <h1 class="admin-page-title">Dashboard Super Admin</h1>
                <p class="admin-page-desc">Selamat datang di dashboard super admin. Silakan pilih menu di samping untuk mengelola aplikasi.</p>
            </header>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('superadmin.approval-admin-instansi.index') }}" class="text-decoration-none">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex align-items-center gap-3">
                                <i class="bi bi-person-check-fill fs-2 text-success"></i>
                                <div>
                                    <div class="fw-bold">Approval Admin Instansi</div>
                                    <div class="text-muted small">Persetujuan akun admin instansi</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('superadmin.instansi.index') }}" class="text-decoration-none">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex align-items-center gap-3">
                                <i class="bi bi-bank2 fs-2 text-primary"></i>
                                <div>
                                    <div class="fw-bold">Instansi</div>
                                    <div class="text-muted small">Manajemen data instansi</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('superadmin.pengguna.index') }}" class="text-decoration-none">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex align-items-center gap-3">
                                <i class="bi bi-people-fill fs-2 text-info"></i>
                                <div>
                                    <div class="fw-bold">Pengguna</div>
                                    <div class="text-muted small">Manajemen pengguna aplikasi</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('superadmin.harga-beras.index') }}" class="text-decoration-none">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex align-items-center gap-3">
                                <i class="bi bi-basket2-fill fs-2 text-warning"></i>
                                <div>
                                    <div class="fw-bold">Harga Beras</div>
                                    <div class="text-muted small">Pengaturan harga beras</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('superadmin.nishab.index') }}" class="text-decoration-none">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex align-items-center gap-3">
                                <i class="bi bi-gem fs-2 text-danger"></i>
                                <div>
                                    <div class="fw-bold">Nishab</div>
                                    <div class="text-muted small">Pengaturan nishab zakat</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('superadmin.approval-program-penyaluran.index') }}" class="text-decoration-none">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex align-items-center gap-3">
                                <i class="bi bi-clipboard2-check-fill fs-2 text-success"></i>
                                <div>
                                    <div class="fw-bold">Approval Program</div>
                                    <div class="text-muted small">Persetujuan program penyaluran</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('superadmin.monitoring.index') }}" class="text-decoration-none">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex align-items-center gap-3">
                                <i class="bi bi-graph-up-arrow fs-2 text-secondary"></i>
                                <div>
                                    <div class="fw-bold">Monitoring</div>
                                    <div class="text-muted small">Monitoring distribusi &amp; program</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
