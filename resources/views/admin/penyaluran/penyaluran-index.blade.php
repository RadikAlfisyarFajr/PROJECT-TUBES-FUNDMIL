<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Penyaluran Zakat - Admin Instansi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>

<body class="sidebar-expanded">
    <div class="admin-layout">
        @include('admin.partials.sidebar', ['active' => 'penyaluran'])

        <main class="admin-page-content">
            <header class="admin-page-topbar">
                <div>
                    <h1 class="admin-page-title">Penyaluran Zakat</h1>
                    <p class="admin-page-desc">Riwayat realisasi penyaluran dari rencana distribusi yang sudah dieksekusi.</p>
                </div>
                <div class="admin-top-actions">
                    <a class="admin-secondary-btn" href="{{ route('penyaluran.create') }}">
                        <i class="bi bi-send-check"></i>
                        <span>Eksekusi</span>
                    </a>
                    @include('admin.partials.account-identity')
                </div>
            </header>

            <div class="admin-content-wrap">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <div class="text-muted">Batch Selesai</div>
                                <strong class="fs-3">{{ $totalSelesai }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <div class="text-muted">Total Penerima</div>
                                <strong class="fs-3">{{ $totalPenerima }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <div class="text-muted">Dana Tersalur</div>
                                <strong class="fs-4">Rp {{ number_format($totalDanaTersalur, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h2 class="h5 mb-1">Riwayat Penyaluran</h2>
                                <p class="text-muted mb-0">Setiap baris adalah satu eksekusi rencana distribusi.</p>
                            </div>
                            <a href="{{ route('pengaturan-distribusi.index') }}" class="btn btn-outline-success btn-sm">
                                Buat Rencana
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Program</th>
                                        <th>Status</th>
                                        <th class="text-end">Penerima</th>
                                        <th class="text-end">Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($penyaluran as $item)
                                    <tr>
                                        <td>{{ $item->tanggal_penyaluran?->format('d M Y') }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $item->programPenyaluran?->nama_program ?? '-' }}</div>
                                            <div class="text-muted small">{{ str($item->keterangan)->limit(70) }}</div>
                                        </td>
                                        <td>
                                            <span class="badge {{ $item->status === 'selesai' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ str($item->status)->title() }}
                                            </span>
                                        </td>
                                        <td class="text-end">{{ $item->penyaluranDetail->count() }}</td>
                                        <td class="text-end">Rp {{ number_format($item->penyaluranDetail->sum('jumlah_diterima'), 0, ',', '.') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('penyaluran.show', $item) }}" class="btn btn-sm btn-outline-secondary">Detail</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">
                                            Belum ada penyaluran. Jalankan eksekusi dari rencana distribusi yang sudah siap.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        sidebarToggle?.addEventListener('click', () => document.body.classList.toggle('sidebar-expanded'));
    </script>
</body>

</html>
