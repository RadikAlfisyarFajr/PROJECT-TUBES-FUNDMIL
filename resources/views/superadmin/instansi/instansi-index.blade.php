<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Desa | Super Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>
<body class="sidebar-expanded">
    <div class="admin-layout">
        @include('superadmin.partials.sidebar', ['active' => 'instansi'])

        <main class="admin-page-content">
            <header class="admin-page-topbar">
                <div>
                    <h1 class="admin-page-title">Akun Resmi Desa</h1>
                    <p class="admin-page-desc">Pembuatan akun Admin Kepala Desa untuk approval program distribusi.</p>
                </div>
                <div class="admin-top-actions">
                    <a class="distribution-submit-btn" href="{{ route('superadmin.instansi.create') }}">
                        <i class="bi bi-plus-lg"></i>
                        <span>Buat Akun</span>
                    </a>
                </div>
            </header>

            <div class="admin-content-wrap">
                @if(session('success'))
                    <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4">{{ session('success') }}</div>
                @endif

                <section class="super-stat-grid mb-4">
                    <article class="super-stat-card">
                        <span>Desa tersedia</span>
                        <strong>{{ count($desaOptions) }}</strong>
                    </article>
                    <article class="super-stat-card">
                        <span>Akun Kepala Desa dibuat</span>
                        <strong>{{ $officialAccounts->count() }}</strong>
                    </article>
                    <article class="super-stat-card">
                        <span>Belum dibuat</span>
                        <strong>{{ max(0, count($desaOptions) - $officialAccounts->where('status', 'aktif')->count()) }}</strong>
                    </article>
                </section>

                <section class="admin-panel">
                    <div class="table-responsive">
                        <table class="table super-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Desa</th>
                                    <th>Nama Akun</th>
                                    <th>Admin</th>
                                    <th>Status</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($officialAccounts as $instansi)
                                    @php $admin = $instansi->users->firstWhere('role', \App\Models\User::ROLE_ADMIN_KEPALA_DESA); @endphp
                                    <tr>
                                        <td class="fw-bold">{{ $instansi->kelurahan }}</td>
                                        <td>
                                            <div>{{ $instansi->nama }}</div>
                                            <div class="text-muted small">{{ $instansi->email }}</div>
                                        </td>
                                        <td>
                                            <div>{{ $admin?->name ?? '-' }}</div>
                                            <div class="text-muted small">{{ $admin?->username ?? '-' }}</div>
                                        </td>
                                        <td>
                                            <span class="super-status {{ $instansi->status === 'aktif' ? 'is-active' : 'is-off' }}">{{ $instansi->status }}</span>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-inline-flex gap-2 flex-wrap justify-content-end">
                                                <a class="admin-secondary-btn" href="{{ route('superadmin.instansi.edit', $instansi) }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                    <span>Edit</span>
                                                </a>
                                                <form method="POST" action="{{ route('superadmin.instansi.destroy', $instansi) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="super-danger-btn" type="submit">
                                                        <i class="bi bi-slash-circle"></i>
                                                        <span>Nonaktifkan</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-5">Belum ada akun Kepala Desa.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="admin-panel mt-4">
                    <h2 class="super-section-title">Instansi Terverifikasi Lain</h2>
                    <div class="table-responsive mt-3">
                        <table class="table super-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Instansi</th>
                                    <th>Desa</th>
                                    <th>Legalitas</th>
                                    <th>Admin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($verifiedInstansi as $instansi)
                                    @php $admin = $instansi->users->firstWhere('role', 'admin_instansi'); @endphp
                                    <tr>
                                        <td class="fw-bold">{{ $instansi->nama }}</td>
                                        <td>{{ $instansi->kelurahan ?? '-' }}</td>
                                        <td>{{ $instansi->nomor_sk ?? '-' }}</td>
                                        <td>{{ $admin?->email ?? $instansi->email ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">Belum ada instansi lain yang terverifikasi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', () => {
            document.body.classList.toggle('sidebar-expanded');
        });

    </script>
</body>
</html>
