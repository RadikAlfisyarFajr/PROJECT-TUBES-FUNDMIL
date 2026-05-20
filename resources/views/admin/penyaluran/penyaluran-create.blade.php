@php
$adminUser = auth()->user();
$adminInstansi = $adminUser?->instansi;
$adminBrandName = $adminInstansi?->nama ?: ($adminUser?->nama_instansi ?: 'FUNDMIL SOREANG');
$recipients = collect($selectedPlan?->penerima ?? []);
$sources = collect($selectedPlan?->sumber_dana ?? []);
$selectedProgram = $selectedPlan?->programPenyaluran;
$targetAsnaf = collect($selectedProgram?->target_asnaf ?? []);
$recipientNominal = (float) ($defaultRecipientNominal ?? 0);
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eksekusi Penyaluran - {{ $adminBrandName }}</title>
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
                    <h1 class="admin-page-title">Eksekusi Penyaluran</h1>
                    <p class="admin-page-desc">Realisasikan rencana distribusi yang sudah siap menjadi catatan penyaluran resmi.</p>
                </div>
                <div class="admin-top-actions">
                    <a href="{{ route('pengaturan-distribusi.index') }}" class="admin-secondary-btn">
                        <i class="bi bi-sliders"></i>
                        Atur Distribusi
                    </a>
                    <a href="{{ route('penyaluran.index') }}" class="admin-secondary-btn">
                        <i class="bi bi-clock-history"></i>
                        Riwayat
                    </a>
                    @include('admin.partials.account-identity', [
                    'nameClass' => 'admin-name',
                    'roleClass' => 'admin-role',
                    'avatarClass' => 'admin-avatar',
                    ])
                </div>
            </header>

            <div class="admin-content-wrap">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <div class="row g-4 mb-4">
                    <div class="col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <div class="text-muted">Rencana Siap</div>
                                        <strong class="fs-3">{{ $totalReadyPlans }}</strong>
                                    </div>
                                    <span class="badge bg-success">Antrean</span>
                                </div>
                                <div class="d-flex justify-content-between border-top pt-3">
                                    <span class="text-muted">Total Penerima</span>
                                    <strong>{{ $totalReadyRecipients }} orang/mitra</strong>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <span class="text-muted">Total Alokasi</span>
                                    <strong>Rp {{ number_format($totalReadyAllocation, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <div class="text-muted">Program Terpilih</div>
                                <strong class="fs-5 d-block mt-1">{{ $selectedProgram?->nama_program ?? 'Belum ada rencana siap' }}</strong>
                                <p class="text-muted mb-0 mt-3">{{ $selectedPlan?->kode_rencana ?? 'Buat rencana di menu pengaturan distribusi terlebih dahulu.' }}</p>
                                @if($targetAsnaf->isNotEmpty())
                                <div class="d-flex flex-wrap gap-2 mt-3">
                                    @foreach($targetAsnaf as $asnaf)
                                    <span class="badge bg-light border text-dark">
                                        {{ \App\Models\Mustahik::KATEGORI[$asnaf] ?? str($asnaf)->replace('_', ' ')->title() }}
                                    </span>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <div class="text-muted">Eksekusi Bulan Ini</div>
                                <strong class="fs-3">{{ $completedThisMonth }}</strong>
                                <p class="text-muted mb-0 mt-3">Jumlah batch penyaluran berstatus selesai pada bulan berjalan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-xl-7">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-4">
                                    <div>
                                        <h2 class="h5 mb-1">Antrean Penyaluran</h2>
                                        <p class="text-muted mb-0">Penerima dari rencana distribusi yang akan dieksekusi.</p>
                                    </div>
                                    <span class="badge bg-primary">{{ $recipients->count() }} penerima</span>
                                </div>

                                <div class="table-responsive">
                                    <table class="table align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Penerima / Institusi</th>
                                                <th>Jenis</th>
                                                <th>Tujuan</th>
                                                <th class="text-end">Nominal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recipients as $recipient)
                                            <tr>
                                                <td>
                                                    <div class="fw-bold">{{ $recipient['nama'] ?? '-' }}</div>
                                                    <div class="text-muted small">{{ $selectedProgram?->nama_program ?? '-' }}</div>
                                                </td>
                                                <td>{{ str($recipient['jenis'] ?? $selectedPlan?->tipe_penerima)->replace('_', ' ')->title() }}</td>
                                                <td class="text-muted">{{ $recipient['tujuan_penggunaan'] ?? $selectedPlan?->catatan ?? '-' }}</td>
                                                <td class="text-end">Rp {{ number_format((float) (($recipient['nominal_alokasi'] ?? 0) > 0 ? $recipient['nominal_alokasi'] : $recipientNominal), 0, ',', '.') }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-5">
                                                    Belum ada rencana distribusi yang siap dieksekusi.
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-5">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-4">
                                    <div>
                                        <h2 class="h5 mb-1">Formulir Eksekusi</h2>
                                        <p class="text-muted mb-0">Pilih rencana siap, tanggal realisasi, lalu simpan sebagai penyaluran selesai.</p>
                                    </div>
                                    <span class="badge {{ $selectedPlan ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $selectedPlan ? 'Siap' : 'Kosong' }}
                                    </span>
                                </div>

                                <form action="{{ route('penyaluran.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="pengaturan_distribusi_id" class="form-label">Rencana Distribusi</label>
                                        <select id="pengaturan_distribusi_id" name="pengaturan_distribusi_id" class="form-select" @disabled($readyPlans->isEmpty())>
                                            @forelse($readyPlans as $plan)
                                            <option value="{{ $plan->id }}" @selected($selectedPlan?->id === $plan->id)>
                                                {{ $plan->kode_rencana }} - {{ $plan->programPenyaluran?->nama_program }} - Rp {{ number_format($plan->total_alokasi, 0, ',', '.') }}
                                            </option>
                                            @empty
                                            <option value="">Belum ada rencana siap</option>
                                            @endforelse
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tanggal_penyaluran" class="form-label">Tanggal Penyaluran</label>
                                        <input id="tanggal_penyaluran" name="tanggal_penyaluran" type="date" class="form-control" value="{{ old('tanggal_penyaluran', now()->toDateString()) }}" @disabled(! $selectedPlan)>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Sumber Dana</label>
                                        <div class="d-flex flex-wrap gap-2">
                                            @forelse($sources as $source)
                                            <span class="badge text-bg-light border">
                                                {{ $source['label'] ?? $source['key'] ?? '-' }}
                                            </span>
                                            @empty
                                            <span class="text-muted small">Sumber dana belum tersedia.</span>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="mb-4 rounded-3 border p-3 bg-light">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Saldo Saat Rencana Dibuat</span>
                                            <strong>Rp {{ number_format((float) ($selectedPlan?->saldo_awal ?? 0), 0, ',', '.') }}</strong>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Penerima Rencana</span>
                                            <strong>{{ (int) ($selectedPlan?->jumlah_penerima ?? 0) }} orang/mitra</strong>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Total Distribusi</span>
                                            <strong>Rp {{ number_format((float) ($selectedPlan?->total_alokasi ?? 0), 0, ',', '.') }}</strong>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Estimasi Sisa Saldo</span>
                                            <strong>Rp {{ number_format((float) ($selectedPlan?->estimasi_sisa_saldo ?? 0), 0, ',', '.') }}</strong>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="bukti_foto" class="form-label">Bukti Foto</label>
                                        <input id="bukti_foto" name="bukti_foto" type="file" accept="image/*" class="form-control" @disabled(! $selectedPlan)>
                                    </div>

                                    <div class="mb-4">
                                        <label for="keterangan" class="form-label">Keterangan Eksekusi</label>
                                        <textarea id="keterangan" name="keterangan" class="form-control" rows="3" placeholder="Opsional, contoh: disalurkan langsung di kantor kelurahan." @disabled(! $selectedPlan)>{{ old('keterangan') }}</textarea>
                                    </div>

                                    <div class="d-grid gap-3">
                                        <button type="button" class="btn btn-outline-secondary" onclick="window.print()" @disabled(! $selectedPlan)>
                                            <i class="bi bi-printer"></i>
                                            Cetak Preview Bukti
                                        </button>
                                        <button type="submit" class="btn btn-success" @disabled(! $selectedPlan)>
                                            <i class="bi bi-send-check-fill"></i>
                                            Eksekusi Penyaluran Massal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        sidebarToggle?.addEventListener('click', () => document.body.classList.toggle('sidebar-expanded'));

        const planSelect = document.getElementById('pengaturan_distribusi_id');
        planSelect?.addEventListener('change', () => {
            const url = new URL(window.location.href);
            url.searchParams.set('plan', planSelect.value);
            window.location.href = url.toString();
        });
    </script>
</body>

</html>
