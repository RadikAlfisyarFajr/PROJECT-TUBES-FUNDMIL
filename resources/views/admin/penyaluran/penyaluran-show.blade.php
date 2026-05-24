<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Penyaluran - Admin Instansi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>

<body class="sidebar-expanded">
    <div class="admin-layout">
        @include('admin.partials.sidebar', ['active' => 'penyaluran'])
        @php
            $plan = $penyaluran->pengaturanDistribusi;
            $targetAsnaf = collect($plan?->programPenyaluran?->target_asnaf ?? $penyaluran->programPenyaluran?->target_asnaf ?? []);
        @endphp

        <main class="admin-page-content">
            <header class="admin-page-topbar">
                <div>
                    <h1 class="admin-page-title">Detail Penyaluran</h1>
                    <p class="admin-page-desc">{{ $penyaluran->programPenyaluran?->nama_program ?? 'Program tidak tersedia' }}</p>
                </div>
                <div class="admin-top-actions">
                    <a class="admin-secondary-btn" href="{{ route('penyaluran.index') }}">
                        <i class="bi bi-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                    <button class="admin-icon-btn" type="button" onclick="window.print()" aria-label="Cetak">
                        <i class="bi bi-printer"></i>
                    </button>
                    @include('admin.partials.account-identity')
                </div>
            </header>

            <div class="admin-content-wrap">
                <div class="row g-4 mb-4">
                    <div class="col-lg-3">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <div class="text-muted">Tanggal Penyaluran</div>
                                <strong class="fs-4">{{ $penyaluran->tanggal_penyaluran?->format('d M Y') }}</strong>
                                <div class="mt-3">
                                    <span class="badge {{ $penyaluran->status === 'selesai' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ str($penyaluran->status)->title() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <div class="text-muted">Rencana Asal</div>
                                <strong class="fs-5 d-block">{{ $penyaluran->programPenyaluran?->nama_program ?? '-' }}</strong>
                                @if($plan)
                                <div class="mt-2 text-muted small">{{ $plan->kode_rencana }}</div>
                                @endif
                                <div class="mt-2 text-muted small">Data mengikuti pengaturan distribusi yang dieksekusi.</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <div class="text-muted">Total Penerima</div>
                                <strong class="fs-3">{{ $penyaluran->penyaluranDetail->count() }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <div class="text-muted">Total Tersalur</div>
                                <strong class="fs-4">Rp {{ number_format($penyaluran->penyaluranDetail->sum('jumlah_diterima'), 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-xl-8">
                        <section class="card shadow-sm">
                            <div class="card-body">
                                <h2 class="h5 mb-3">Daftar Penerima</h2>
                                @if($targetAsnaf->isNotEmpty())
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    @foreach($targetAsnaf as $asnaf)
                                    <span class="badge bg-light border text-dark">
                                        {{ \App\Models\Mustahik::KATEGORI[$asnaf] ?? str($asnaf)->replace('_', ' ')->title() }}
                                    </span>
                                    @endforeach
                                </div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Penerima</th>
                                                <th>Jenis</th>
                                                <th>Status</th>
                                                <th class="text-end">Nominal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($penyaluran->penyaluranDetail as $detail)
                                            <tr>
                                                <td>
                                                    <div class="fw-bold">{{ $detail->nama_penerima ?? $detail->mustahik?->nama ?? '-' }}</div>
                                                    <div class="text-muted small">{{ $detail->keterangan ?? '-' }}</div>
                                                </td>
                                                <td>{{ str($detail->jenis_penerima)->replace('_', ' ')->title() }}</td>
                                                <td>
                                                    <span class="badge bg-success">{{ str($detail->status_penerimaan)->title() }}</span>
                                                </td>
                                                <td class="text-end">Rp {{ number_format((float) $detail->jumlah_diterima, 0, ',', '.') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </div>

                    <div class="col-xl-4">
                        <section class="card shadow-sm">
                            <div class="card-body">
                                <h2 class="h5 mb-3">Catatan</h2>
                                <p class="text-muted mb-4" style="white-space: pre-line;">{{ $penyaluran->keterangan ?: 'Tidak ada catatan tambahan.' }}</p>

                                @if($penyaluran->bukti_foto)
                                <a href="{{ asset('storage/'.$penyaluran->bukti_foto) }}" target="_blank" class="btn btn-outline-success w-100">
                                    <i class="bi bi-image"></i>
                                    Lihat Bukti Foto
                                </a>
                                @else
                                <div class="alert alert-light border mb-0">Belum ada bukti foto.</div>
                                @endif
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        sidebarToggle?.addEventListener('click', () => document.body.classList.toggle('sidebar-expanded'));
    </script>
</body>

</html>
