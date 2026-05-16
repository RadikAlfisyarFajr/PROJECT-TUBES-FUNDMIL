@php
$adminUser = auth()->user();
$adminInstansi = $adminUser?->instansi;
$adminBrandName = $adminInstansi?->nama ?: ($adminUser?->nama_instansi ?: 'FUNDMIL SOREANG');
$samplePrograms = collect([
(object) ['id' => 1, 'nama_program' => 'Program Zakat Ramadhan', 'metode' => 'Rata Pembagian', 'saldo_awal' => 283600000, 'alokasi' => 4000000, 'status' => 'aktif'],
(object) ['id' => 2, 'nama_program' => 'Bantuan Sembako', 'metode' => 'Prioritas Keluarga', 'saldo_awal' => 158200000, 'alokasi' => 1200000, 'status' => 'aktif'],
]);
$sampleAntrean = collect([
(object) ['nama' => 'Ahmad Subardjo', 'id' => 'MST-2024-001', 'program' => 'Paket Ramadhan', 'tujuan' => 'Kebutuhan Pokok', 'alokasi' => 500000],
(object) ['nama' => 'Siti Aminah', 'id' => 'MST-2024-005', 'program' => 'Paket Ramadhan', 'tujuan' => 'Kebutuhan Pokok', 'alokasi' => 500000],
(object) ['nama' => 'Budi Hartono', 'id' => 'MST-2024-012', 'program' => 'Paket Ramadhan', 'tujuan' => 'Kebutuhan Pokok', 'alokasi' => 500000],
(object) ['nama' => 'Ratna Sari', 'id' => 'MST-2024-008', 'program' => 'Paket Ramadhan', 'tujuan' => 'Kebutuhan Pokok', 'alokasi' => 500000],
]);
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eksekusi Penyaluran - Fundmil Soreang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>

<body class="sidebar-expanded">
    <div class="admin-layout">
        @include('admin.partials.sidebar', ['active' => 'penyaluran'])

        <main class="main-content">
            <header class="topbar">
                <div>
                    <h1 class="page-title">Eksekusi Penyaluran</h1>
                    <p class="page-desc">Lakukan eksekusi distribusi dana berdasar program dan pengaturan distribusi yang sudah ditetapkan.</p>
                </div>
                <div class="top-actions">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="search" placeholder="Cari penyaluran atau program...">
                    </div>
                    <button class="icon-btn has-dot" type="button" aria-label="Notifikasi">
                        <i class="bi bi-bell-fill"></i>
                    </button>
                    <button class="icon-btn" type="button" aria-label="Bantuan">
                        <i class="bi bi-question-circle-fill"></i>
                    </button>
                    @include('admin.partials.account-identity', [
                    'nameClass' => 'admin-name',
                    'roleClass' => 'admin-role',
                    'avatarClass' => 'avatar',
                    ])
                </div>
            </header>

            <div class="content-wrap">
                <div class="row g-4 mb-4">
                    <div class="col-lg-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h2 class="h5 mb-3">Ringkasan Saldo</h2>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <div class="text-muted">Saldo Awal</div>
                                        <strong class="fs-4">Rp {{ number_format($samplePrograms[0]->saldo_awal, 0, ',', '.') }}</strong>
                                    </div>
                                    <span class="badge bg-success">Tersedia</span>
                                </div>
                                <div class="mb-3">
                                    <div class="text-muted small">Total Antrean</div>
                                    <strong>{{ $sampleAntrean->count() }} Mustahik</strong>
                                </div>
                                <div>
                                    <div class="text-muted small">Estimasi Total Eksekusi</div>
                                    <strong>Rp {{ number_format($sampleAntrean->sum('alokasi'), 0, ',', '.') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h2 class="h5 mb-3">Status Eksekusi</h2>
                                <div class="row text-center">
                                    <div class="col-6 mb-3">
                                        <span class="d-block text-muted">Program Aktif</span>
                                        <strong>{{ $samplePrograms->count() }}</strong>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <span class="d-block text-muted">Tersedia Sumber Dana</span>
                                        <strong>4 Sumber</strong>
                                    </div>
                                    <div class="col-6">
                                        <span class="d-block text-muted">Alokasi Rata</span>
                                        <strong>Rp 500.000</strong>
                                    </div>
                                    <div class="col-6">
                                        <span class="d-block text-muted">Total Eksekusi</span>
                                        <strong>Rp {{ number_format($sampleAntrean->sum('alokasi'), 0, ',', '.') }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-xl-7">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div>
                                        <h2 class="h5 mb-1">Antrean Penyaluran</h2>
                                        <p class="text-muted mb-0">Daftar mustahik dan alokasi yang siap disalurkan.</p>
                                    </div>
                                    <a href="#" class="btn btn-sm btn-outline-secondary">Lihat Riwayat</a>
                                </div>

                                <div class="table-responsive">
                                    <table class="table align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Penerima / Institusi</th>
                                                <th>Program</th>
                                                <th>Tujuan</th>
                                                <th class="text-end">Alokasi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($sampleAntrean as $item)
                                            <tr>
                                                <td>
                                                    <div class="fw-bold">{{ $item->nama }}</div>
                                                    <div class="text-muted small">{{ $item->id }}</div>
                                                </td>
                                                <td>{{ $item->program }}</td>
                                                <td class="text-muted">{{ $item->tujuan }}</td>
                                                <td class="text-end">Rp {{ number_format($item->alokasi, 0, ',', '.') }}</td>
                                            </tr>
                                            @endforeach
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
                                        <h2 class="h5 mb-1">Formulir Eksekusi Penyaluran</h2>
                                        <p class="text-muted mb-0">Pilih program, sumber dana, dan jalankan distribusi.</p>
                                    </div>
                                    <span class="badge bg-primary">Siap Eksekusi</span>
                                </div>

                                <form>
                                    <div class="mb-3">
                                        <label class="form-label">Program Penyaluran</label>
                                        <select class="form-select">
                                            @foreach($samplePrograms as $program)
                                            <option value="{{ $program->id }}">{{ $program->nama_program }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Tipe Penerima</label>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="recipient_type" id="recipient_database" autocomplete="off" checked>
                                            <label class="btn btn-outline-secondary" for="recipient_database">Database Mustahik</label>
                                            <input type="radio" class="btn-check" name="recipient_type" id="recipient_manual" autocomplete="off">
                                            <label class="btn btn-outline-secondary" for="recipient_manual">Input Manual / Mitra</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Sumber Dana</label>
                                        <div class="d-flex flex-wrap gap-2">
                                            <button type="button" class="btn btn-outline-success btn-sm flex-fill text-start">Zakat Fitrah</button>
                                            <button type="button" class="btn btn-outline-success btn-sm flex-fill text-start">Zakat Maal</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm flex-fill text-start">Infaq</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm flex-fill text-start">Sedekah</button>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Cari Mustahik / Nama Penerima</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input type="text" class="form-control" placeholder="Ketik nama atau ID...">
                                        </div>
                                    </div>

                                    <div class="mb-4 rounded-3 border p-3 bg-light">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Saldo Awal</span>
                                            <strong>Rp {{ number_format($samplePrograms[0]->saldo_awal, 0, ',', '.') }}</strong>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Total Distribusi Antrean</span>
                                            <strong>Rp {{ number_format($sampleAntrean->sum('alokasi'), 0, ',', '.') }}</strong>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Estimasi Sisa Saldo</span>
                                            <strong>Rp {{ number_format($samplePrograms[0]->saldo_awal - $sampleAntrean->sum('alokasi'), 0, ',', '.') }}</strong>
                                        </div>
                                    </div>

                                    <div class="d-grid gap-3">
                                        <button type="button" class="btn btn-outline-secondary">Cetak Bukti Penyerahan</button>
                                        <button type="button" class="btn btn-success">Eksekusi Penyaluran Massal</button>
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
    </script>
</body>

</html>