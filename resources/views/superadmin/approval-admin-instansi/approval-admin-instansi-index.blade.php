@php
    $pendingUsers = $pendingUsers ?? collect();
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Instansi | Super Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>
<body class="sidebar-expanded">
    <div class="admin-layout">
        @include('superadmin.partials.sidebar', ['active' => 'approval-admin'])

        <main class="admin-page-content">
            <header class="admin-page-topbar">
                <div>
                    <h1 class="admin-page-title">Verifikasi Akun Instansi</h1>
                    <p class="admin-page-desc">Tinjau legalitas lembaga amil zakat baru sebelum akun diaktifkan.</p>
                </div>
                <div class="super-count-pill">
                    <i class="bi bi-hourglass-split"></i>
                    <strong>{{ $pendingUsers->count() }}</strong>
                    <span>pending</span>
                </div>
            </header>

            <div class="admin-content-wrap">
                @if(session('success'))
                    <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">{{ $errors->first() }}</div>
                @endif

                <section class="admin-panel">
                    <div class="table-responsive">
                        <table class="table super-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Instansi</th>
                                    <th>Legalitas</th>
                                    <th>Kontak</th>
                                    <th>Daftar</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingUsers as $user)
                                    @php
                                        $instansi = $user->instansi;
                                        $query = trim(($instansi?->nama ?? $user->nama_instansi) . ' ' . ($instansi?->kelurahan ?? $user->desa) . ' Soreang');
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ $instansi?->nama ?? $user->nama_instansi ?? $user->name }}</div>
                                            <div class="text-muted small">{{ $instansi?->tipe ?? 'Tipe belum diisi' }} - {{ $instansi?->kelurahan ?? $user->desa ?? '-' }}</div>
                                        </td>
                                        <td>
                                            <div>{{ $instansi?->nomor_sk ?? 'Nomor SK belum ada' }}</div>
                                            <div class="text-muted small">Berlaku sampai {{ $instansi?->masa_berlaku?->format('d M Y') ?? '-' }}</div>
                                        </td>
                                        <td>
                                            <div>{{ $user->email }}</div>
                                            <div class="text-muted small">{{ $instansi?->kontak ?? '-' }}</div>
                                        </td>
                                        <td>
                                            <div>{{ $user->created_at?->format('d M Y') ?? '-' }}</div>
                                            <div class="text-muted small">{{ $user->username }}</div>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-inline-flex gap-2 flex-wrap justify-content-end">
                                                <a class="admin-secondary-btn" href="https://www.google.com/search?q={{ urlencode($query) }}" target="_blank" rel="noopener">
                                                    <i class="bi bi-search"></i>
                                                    <span>Cek</span>
                                                </a>
                                                <a class="distribution-submit-btn" href="{{ route('superadmin.approval-admin-instansi.show', $user) }}">
                                                    <i class="bi bi-shield-check"></i>
                                                    <span>Tinjau</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-5">Tidak ada pengajuan akun instansi baru.</td>
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
