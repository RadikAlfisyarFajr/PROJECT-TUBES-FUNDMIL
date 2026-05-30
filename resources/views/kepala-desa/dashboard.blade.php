@php
    $rupiah = fn ($value) => 'Rp ' . number_format((float) $value, 0, ',', '.');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Pelacakan Desa | Admin Kepala Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
    <style>
        .village-chart-row {
            display: grid;
            grid-template-columns: 86px 1fr 132px;
            gap: 14px;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #edf3ef;
        }

        .village-chart-row:last-child {
            border-bottom: 0;
        }

        .village-chart-label {
            color: #526157;
            font-size: .82rem;
            font-weight: 800;
        }

        .village-chart-bars {
            display: grid;
            gap: 7px;
        }

        .village-track {
            height: 12px;
            overflow: hidden;
            border-radius: 999px;
            background: #edf3ef;
        }

        .village-track span {
            display: block;
            height: 100%;
            border-radius: inherit;
        }

        .village-track.in span {
            background: #178b3b;
        }

        .village-track.out span {
            background: #d97706;
        }

        .village-chart-value {
            color: #26352b;
            font-size: .76rem;
            font-weight: 800;
            line-height: 1.45;
            text-align: right;
        }

        .village-legend {
            display: flex;
            gap: 14px;
            color: #66766b;
            font-size: .78rem;
            font-weight: 800;
        }

        .village-legend span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .village-dot {
            width: 9px;
            height: 9px;
            border-radius: 999px;
        }

        @media (max-width: 720px) {
            .village-chart-row {
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .village-chart-value {
                text-align: left;
            }
        }
    </style>
</head>
<body class="sidebar-expanded">
    <div class="admin-layout">
        @include('kepala-desa.partials.sidebar', ['active' => 'dashboard'])

        <main class="admin-page-content">
            <header class="admin-page-topbar">
                <div>
                    <h1 class="admin-page-title">Pusat Pelacakan Desa</h1>
                    <p class="admin-page-desc">Sirkulasi kas masuk dan keluar lembaga amil aktif di {{ $desa }}.</p>
                </div>
                <div class="admin-top-actions">
                    <a class="admin-secondary-btn" href="{{ route('kepala-desa.approval.index') }}">
                        <i class="bi bi-clipboard-check-fill"></i>
                        <span>{{ $summary['draftProgram'] }} draft</span>
                    </a>
                    @include('admin.partials.account-identity')
                </div>
            </header>

            <div class="admin-content-wrap">
                @if(session('success'))
                    <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4">{{ session('success') }}</div>
                @endif

                <section class="super-stat-grid">
                    <article class="super-stat-card">
                        <span>Instansi aktif</span>
                        <strong>{{ $summary['instansiAktif'] }}</strong>
                    </article>
                    <article class="super-stat-card">
                        <span>Kas masuk</span>
                        <strong>{{ $rupiah($summary['totalMasuk']) }}</strong>
                    </article>
                    <article class="super-stat-card">
                        <span>Kas keluar</span>
                        <strong>{{ $rupiah($summary['totalKeluar']) }}</strong>
                    </article>
                    <article class="super-stat-card">
                        <span>Saldo wilayah</span>
                        <strong>{{ $rupiah($summary['saldo']) }}</strong>
                    </article>
                </section>

                <section class="super-grid mt-4">
                    <div class="admin-panel">
                        <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
                            <div>
                                <h2 class="super-section-title">Grafik Sirkulasi Kas</h2>
                                <p class="super-section-desc">Perbandingan kas masuk dan keluar enam bulan terakhir.</p>
                            </div>
                            <div class="village-legend">
                                <span><i class="village-dot" style="background:#178b3b"></i>Masuk</span>
                                <span><i class="village-dot" style="background:#d97706"></i>Keluar</span>
                            </div>
                        </div>

                        @forelse($monthlyRows as $row)
                            <div class="village-chart-row">
                                <div class="village-chart-label">{{ $row['label'] }}</div>
                                <div class="village-chart-bars">
                                    <div class="village-track in"><span style="width: {{ $row['masuk'] > 0 ? max(3, ($row['masuk'] / $chartMax) * 100) : 0 }}%"></span></div>
                                    <div class="village-track out"><span style="width: {{ $row['keluar'] > 0 ? max(3, ($row['keluar'] / $chartMax) * 100) : 0 }}%"></span></div>
                                </div>
                                <div class="village-chart-value">
                                    <div>{{ $rupiah($row['masuk']) }}</div>
                                    <div>{{ $rupiah($row['keluar']) }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="admin-empty-state">
                                <div class="admin-empty-icon"><i class="bi bi-graph-up"></i></div>
                                <h2>Belum Ada Sirkulasi</h2>
                                <p>Grafik akan muncul setelah lembaga di desa ini mencatat kas masuk atau penyaluran.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="admin-panel">
                        <h2 class="super-section-title">Status Desa</h2>
                        <p class="super-section-desc">Ringkasan pengawasan program dan saldo lembaga aktif.</p>
                        <div class="super-param-list">
                            <a href="{{ route('kepala-desa.approval.index') }}">
                                <i class="bi bi-hourglass-split"></i>
                                <span>Draft butuh rekomendasi</span>
                                <strong>{{ $summary['draftProgram'] }}</strong>
                            </a>
                            <a href="{{ route('kepala-desa.dashboard') }}">
                                <i class="bi bi-bank2"></i>
                                <span>Lembaga amil aktif</span>
                                <strong>{{ $summary['instansiAktif'] }}</strong>
                            </a>
                            <a href="{{ route('kepala-desa.dashboard') }}">
                                <i class="bi bi-wallet2"></i>
                                <span>Saldo kas wilayah</span>
                                <strong>{{ $rupiah($summary['saldo']) }}</strong>
                            </a>
                        </div>
                    </div>
                </section>

                <section class="admin-panel mt-4">
                    <div class="table-responsive">
                        <table class="table super-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Instansi</th>
                                    <th>Tipe</th>
                                    <th class="text-end">Kas Masuk</th>
                                    <th class="text-end">Kas Keluar</th>
                                    <th class="text-end">Saldo</th>
                                    <th class="text-end">Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rows as $row)
                                    <tr>
                                        <td class="fw-bold">{{ $row['nama'] }}</td>
                                        <td>{{ $row['tipe'] }}</td>
                                        <td class="text-end">{{ $rupiah($row['kas_masuk']) }}</td>
                                        <td class="text-end">{{ $rupiah($row['kas_keluar']) }}</td>
                                        <td class="text-end fw-bold">{{ $rupiah($row['saldo']) }}</td>
                                        <td class="text-end">{{ $row['transaksi'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">Belum ada lembaga amil aktif di desa ini.</td>
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
