@php
    $rupiah = fn ($value) => 'Rp ' . number_format((float) $value, 0, ',', '.');
    $statusOptions = [
        'pending' => 'Pending',
        'approved' => 'Disetujui',
        'rejected' => 'Ditolak',
        'semua' => 'Semua',
    ];
    $badgeClass = [
        'pending' => 'bg-warning text-dark',
        'approved' => 'bg-success',
        'rejected' => 'bg-danger',
    ];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="30">
    <title>Approval Program | Admin Kepala Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>
<body class="sidebar-expanded">
    <div class="admin-layout">
        @include('kepala-desa.partials.sidebar', ['active' => 'approval'])

        <main class="admin-page-content">
            <header class="admin-page-topbar">
                <div>
                    <h1 class="admin-page-title">Approval Kepala Desa</h1>
                    <p class="admin-page-desc">Berikan rekomendasi pada draf program distribusi sebelum dikirim ke kecamatan.</p>
                </div>
                <div class="admin-top-actions">
                    <div class="super-count-pill">
                        <i class="bi bi-hourglass-split"></i>
                        <strong>{{ $pendingCount }}</strong>
                        <span>pending</span>
                    </div>
                    @include('admin.partials.account-identity')
                </div>
            </header>

            <div class="admin-content-wrap">
                @if(session('success'))
                    <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">{{ $errors->first() }}</div>
                @endif

                <section class="admin-panel mb-4">
                    <form method="GET" class="d-flex flex-wrap gap-2 align-items-center">
                        <label class="distribution-label mb-0" for="status">Status</label>
                        <select id="status" name="status" class="distribution-select" style="max-width: 240px" onchange="this.form.submit()">
                            @foreach($statusOptions as $value => $label)
                                <option value="{{ $value }}" @selected($status === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </form>
                </section>

                <section class="admin-panel">
                    <div class="table-responsive">
                        <table class="table super-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Program</th>
                                    <th>Instansi</th>
                                    <th>Periode</th>
                                    <th class="text-end">Total Dana</th>
                                    <th>Status</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($programs as $program)
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ $program->nama_program }}</div>
                                            <div class="text-muted small">{{ $program->target_mustahik ?? 0 }} target mustahik</div>
                                        </td>
                                        <td>
                                            <div>{{ $program->instansi?->nama ?? '-' }}</div>
                                            <div class="text-muted small">{{ $program->instansi?->tipe ?? '-' }}</div>
                                        </td>
                                        <td>
                                            <div>{{ $program->tanggal_mulai?->format('d M Y') ?? '-' }}</div>
                                            <div class="text-muted small">sampai {{ $program->tanggal_selesai?->format('d M Y') ?? '-' }}</div>
                                        </td>
                                        <td class="text-end">{{ $rupiah($program->total_dana ?? 0) }}</td>
                                        <td>
                                            <span class="badge rounded-pill {{ $badgeClass[$program->approval_status] ?? 'bg-secondary' }}">
                                                {{ $statusOptions[$program->approval_status] ?? $program->approval_status }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a class="distribution-submit-btn" href="{{ route('kepala-desa.approval.show', $program) }}">
                                                <i class="bi bi-eye-fill"></i>
                                                <span>Tinjau</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">Tidak ada program pada status ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <div class="mt-4">
                    {{ $programs->links() }}
                </div>
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
