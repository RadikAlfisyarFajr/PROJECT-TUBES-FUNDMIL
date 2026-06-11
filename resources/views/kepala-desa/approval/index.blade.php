@php
    $rupiah = fn ($value) => 'Rp ' . number_format((float) $value, 0, ',', '.');
    $statusOptions = [
        'pending' => 'Pending',
        'approved' => 'Accepted',
        'rejected' => 'Rejected',
        'semua' => 'Semua',
    ];
    $statusLabels = [
        'draft' => 'Pending',
        'pending' => 'Pending',
        'approved' => 'Accepted',
        'rejected' => 'Rejected',
    ];
    $badgeClasses = [
        'draft' => 'text-bg-warning',
        'pending' => 'text-bg-warning',
        'approved' => 'text-bg-success',
        'rejected' => 'text-bg-danger',
    ];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval Program | Admin Kepala Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #eef7ef; color: #18251d; font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
        .page-shell { max-width: 1180px; margin: 0 auto; padding: 32px 20px; }
        .topbar, .panel, .stat-card { background: #fff; border: 1px solid #dfece2; border-radius: 18px; box-shadow: 0 16px 38px rgba(21, 88, 39, .08); }
        .topbar { padding: 22px 24px; }
        .panel { padding: 22px; }
        .stat-card { display: block; padding: 20px; text-decoration: none; color: inherit; transition: transform .15s ease, border-color .15s ease; }
        .stat-card:hover, .stat-card.active { transform: translateY(-2px); border-color: #1f7a3b; }
        .stat-label { color: #69786e; font-size: .78rem; font-weight: 800; letter-spacing: .05em; text-transform: uppercase; }
        .stat-number { color: #1f7a3b; font-size: 2rem; font-weight: 900; line-height: 1; }
        .table thead th { color: #66746b; font-size: .78rem; text-transform: uppercase; letter-spacing: .04em; }
        .btn-accept { background: #1f7a3b; border-color: #1f7a3b; color: #fff; font-weight: 700; }
        .btn-accept:hover { background: #17602d; border-color: #17602d; color: #fff; }
        .reject-box { min-width: 260px; }
    </style>
</head>
<body>
    <main class="page-shell">
        <header class="topbar mb-4 d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-lg-center">
            <div>
                <div class="text-success fw-bold text-uppercase small mb-2">Admin Kepala Desa</div>
                <h1 class="h3 fw-black mb-1">Approval Program Penyaluran</h1>
                <p class="text-muted mb-0">Desa: {{ $desa ?: '-' }}. Kelola persetujuan program dengan status Pending, Accepted, dan Rejected.</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </header>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger border-0 shadow-sm">{{ $errors->first() }}</div>
        @endif

        <section class="row g-3 mb-4">
            <div class="col-md-4">
                <a class="stat-card {{ $status === 'pending' ? 'active' : '' }}" href="{{ route('kepala-desa.approval.index', ['status' => 'pending']) }}">
                    <div class="stat-label mb-2">Pending</div>
                    <div class="stat-number">{{ $counts['pending'] }}</div>
                </a>
            </div>
            <div class="col-md-4">
                <a class="stat-card {{ $status === 'approved' ? 'active' : '' }}" href="{{ route('kepala-desa.approval.index', ['status' => 'approved']) }}">
                    <div class="stat-label mb-2">Accepted</div>
                    <div class="stat-number">{{ $counts['approved'] }}</div>
                </a>
            </div>
            <div class="col-md-4">
                <a class="stat-card {{ $status === 'rejected' ? 'active' : '' }}" href="{{ route('kepala-desa.approval.index', ['status' => 'rejected']) }}">
                    <div class="stat-label mb-2">Rejected</div>
                    <div class="stat-number">{{ $counts['rejected'] }}</div>
                </a>
            </div>
        </section>

        <section class="panel">
            <form method="GET" class="mb-3 d-flex flex-wrap gap-2 align-items-center">
                <label class="fw-bold" for="status">Filter status</label>
                <select id="status" name="status" class="form-select" style="max-width: 220px" onchange="this.form.submit()">
                    @foreach($statusOptions as $value => $label)
                        <option value="{{ $value }}" @selected($status === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </form>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Program</th>
                            <th>Instansi</th>
                            <th>Periode</th>
                            <th>Dana</th>
                            <th>Status</th>
                            <th class="text-end">Aksi Approval</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($programs as $program)
                            <tr>
                                <td>
                                    <strong>{{ $program->nama_program }}</strong>
                                    <div class="text-muted small">{{ $program->metode_distribusi ?: '-' }}</div>
                                </td>
                                <td>
                                    {{ $program->instansi?->nama ?? '-' }}
                                    <div class="text-muted small">{{ $program->instansi?->kelurahan ?? '-' }}</div>
                                </td>
                                <td>
                                    {{ $program->tanggal_mulai?->format('d M Y') ?? '-' }}
                                    <div class="text-muted small">s/d {{ $program->tanggal_selesai?->format('d M Y') ?? '-' }}</div>
                                </td>
                                <td>{{ $rupiah($program->target_dana ?? 0) }}</td>
                                <td>
                                    <span class="badge rounded-pill {{ $badgeClasses[$program->approval_status] ?? 'text-bg-secondary' }}">
                                        {{ $statusLabels[$program->approval_status] ?? $program->approval_status }}
                                    </span>
                                    @if($program->approved_at)
                                        <div class="text-muted small mt-1">{{ $program->approved_at->format('d M Y H:i') }}</div>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @if(in_array($program->approval_status, ['draft', 'pending'], true))
                                        <div class="d-flex flex-column flex-xl-row gap-2 justify-content-end align-items-stretch align-items-xl-start">
                                            <form method="POST" action="{{ route('kepala-desa.approval.approve', $program) }}" onsubmit="return confirm('Accept program ini?')">
                                                @csrf
                                                <button class="btn btn-accept w-100" type="submit">
                                                    <i class="bi bi-check-circle-fill"></i> Accept
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('kepala-desa.approval.reject', $program) }}" class="reject-box">
                                                @csrf
                                                <textarea name="approval_note" class="form-control form-control-sm mb-2" rows="2" required placeholder="Alasan rejected"></textarea>
                                                <button class="btn btn-danger w-100" type="submit" onclick="return confirm('Reject program ini?')">
                                                    <i class="bi bi-x-circle-fill"></i> Rejected
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="text-muted small">
                                            Diproses oleh {{ $program->approver?->name ?? '-' }}<br>
                                            Catatan: {{ $program->approval_note ?: '-' }}
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">Belum ada program pada status ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $programs->links() }}
            </div>
        </section>
    </main>
</body>
</html>
