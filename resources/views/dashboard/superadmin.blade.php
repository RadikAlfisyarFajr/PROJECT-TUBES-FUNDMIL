@php
    $rupiah = fn ($value) => 'Rp ' . number_format((float) $value, 0, ',', '.');
    $maxPengumpulan = max(1, (float) $chartRows->max('pengumpulan'));
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Global | Super Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>
<body class="sidebar-expanded">
    <div class="admin-layout">
        @include('superadmin.partials.sidebar', ['active' => 'dashboard'])

        <main class="admin-page-content">
            <header class="admin-page-topbar">
                <div>
                    <h1 class="admin-page-title">Dashboard Global</h1>
                    <p class="admin-page-desc">Pemantauan kas dan agregasi pengumpulan ZIS antarinstansi Kecamatan Soreang.</p>
                </div>
                <div class="admin-top-actions">
                    <a class="admin-secondary-btn" href="{{ route('superadmin.approval-admin-instansi.index') }}">
                        <i class="bi bi-person-check-fill"></i>
                        <span>{{ $summary['pendingApproval'] }} pending</span>
                    </a>
                </div>
            </header>

            <div class="admin-content-wrap">
                <section class="super-stat-grid">
                    <article class="super-stat-card">
                        <span>Lembaga amil aktif</span>
                        <strong>{{ $summary['instansiAktif'] }}</strong>
                    </article>
                    <article class="super-stat-card">
                        <span>Total ZIS terkumpul</span>
                        <strong>{{ $rupiah($summary['totalPengumpulan']) }}</strong>
                    </article>
                    <article class="super-stat-card">
                        <span>Kas tersalurkan</span>
                        <strong>{{ $rupiah($summary['totalPenyaluran']) }}</strong>
                    </article>
                    <article class="super-stat-card">
                        <span>Saldo kas agregat</span>
                        <strong>{{ $rupiah($summary['totalSaldo']) }}</strong>
                    </article>
                </section>

                <section class="super-grid mt-4">
                    <div class="admin-panel">
                        <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
                            <div>
                                <h2 class="super-section-title">Performa Pengumpulan ZIS</h2>
                                <p class="super-section-desc">Delapan instansi dengan total pengumpulan tertinggi.</p>
                            </div>
                            <i class="bi bi-bar-chart-fill super-panel-icon"></i>
                        </div>

                        <div class="super-bar-list">
                            @forelse($chartRows as $row)
                                <div class="super-bar-row">
                                    <div>
                                        <strong>{{ $row['nama'] }}</strong>
                                        <span>{{ $row['desa'] }}</span>
                                    </div>
                                    <div class="super-bar-track">
                                        <span style="width: {{ max(4, ($row['pengumpulan'] / $maxPengumpulan) * 100) }}%"></span>
                                    </div>
                                    <b>{{ $rupiah($row['pengumpulan']) }}</b>
                                </div>
                            @empty
                                <div class="admin-empty-state">
                                    <div class="admin-empty-icon"><i class="bi bi-graph-up"></i></div>
                                    <h2>Belum Ada Data ZIS</h2>
                                    <p>Data grafik akan muncul setelah admin instansi mencatat pemasukan ZIS.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="admin-panel">
                        <h2 class="super-section-title">Parameter Nasional</h2>
                        <p class="super-section-desc">Acuan yang dipakai admin instansi dalam transaksi zakat.</p>

                        <div class="super-param-list">
                            <a href="{{ route('superadmin.harga-beras.index') }}">
                                <i class="bi bi-basket2-fill"></i>
                                <span>Harga beras pasar</span>
                                <strong>{{ $rupiah($summary['hargaBeras']) }}/kg</strong>
                            </a>
                            <a href="{{ route('superadmin.nishab.index') }}">
                                <i class="bi bi-gem"></i>
                                <span>Nishab zakat maal</span>
                                <strong>{{ $rupiah($summary['nishabMaal']) }}</strong>
                            </a>
                            <a href="{{ route('superadmin.instansi.index') }}">
                                <i class="bi bi-bank2"></i>
                                <span>Akun resmi desa</span>
                                <strong>Kelola</strong>
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
                                    <th>Desa</th>
                                    <th>Tipe</th>
                                    <th class="text-end">Pengumpulan</th>
                                    <th class="text-end">Tersalurkan</th>
                                    <th class="text-end">Saldo Kas</th>
                                    <th class="text-end">Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rows as $row)
                                    <tr>
                                        <td class="fw-bold">{{ $row['nama'] }}</td>
                                        <td>{{ $row['desa'] }}</td>
                                        <td>{{ $row['tipe'] }}</td>
                                        <td class="text-end">{{ $rupiah($row['pengumpulan']) }}</td>
                                        <td class="text-end">{{ $rupiah($row['penyaluran']) }}</td>
                                        <td class="text-end fw-bold">{{ $rupiah($row['saldo']) }}</td>
                                        <td class="text-end">{{ $row['transaksi'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-5">Belum ada instansi aktif.</td>
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
