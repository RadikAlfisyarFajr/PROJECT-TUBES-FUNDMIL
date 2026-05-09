@php
$adminUser = auth()->user();
$adminInstansi = $adminUser?->instansi;
$adminBrandName = $adminInstansi?->nama ?: ($adminUser?->nama_instansi ?: 'FUNDMIL SOREANG');
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengaturan Distribusi - Fundmil Soreang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>

<body class="sidebar-expanded">
    <div class="admin-layout">
        @include('admin.partials.sidebar', ['active' => 'distribusi'])

        <main class="main-content">
            <header class="topbar">
                <div>
                    <h1 class="page-title">Pengaturan Distribusi</h1>
                    <p class="page-desc">Atur metode distribusi program dan tinjau kategori dana yang ikut dialokasikan.</p>
                </div>
                <div class="top-actions">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="search" placeholder="Cari program..." disabled>
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
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h2 class="h5 mb-3">Program Penyaluran</h2>

                                @if($programs->isEmpty())
                                <div class="alert alert-secondary mb-0">
                                    Belum ada program penyaluran. Tambahkan program terlebih dahulu di menu Program Penyaluran.
                                </div>
                                @else
                                <div class="list-group">
                                    @foreach($programs as $program)
                                    <a href="{{ route('pengaturan-distribusi.show', $program) }}" class="list-group-item list-group-item-action {{ optional($selectedProgram)->id === $program->id ? 'active' : '' }}">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $program->nama_program }}</strong>
                                                <small class="d-block text-muted">{{ $program->target_mustahik }} mustahik</small>
                                            </div>
                                            <span class="badge bg-{{ $program->status === 'selesai' ? 'secondary' : 'success' }}">{{ ucfirst($program->status) }}</span>
                                        </div>
                                        <div class="mt-2 text-muted small">
                                            {{ $program->metode_distribusi ? $methods[$program->metode_distribusi] ?? $program->metode_distribusi : 'Belum diatur' }}
                                        </div>
                                    </a>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                @if($selectedProgram)
                                <div class="d-flex justify-content-between align-items-start mb-4">
                                    <div>
                                        <h2 class="h5 mb-1">{{ $selectedProgram->nama_program }}</h2>
                                        <p class="text-muted mb-1">Program penyaluran ini dapat diatur metodenya di sini.</p>
                                        <small class="text-muted">Target {{ $selectedProgram->target_mustahik }} mustahik · {{ $selectedProgram->tanggal_mulai?->format('d M Y') ?? '-' }} sampai {{ $selectedProgram->tanggal_selesai?->format('d M Y') ?? '-' }}</small>
                                    </div>
                                    <span class="badge bg-{{ $selectedProgram->status === 'selesai' ? 'secondary' : 'success' }}">{{ ucfirst($selectedProgram->status) }}</span>
                                </div>

                                <div class="mb-4">
                                    <h3 class="h6">Kategori Dana</h3>
                                    @forelse($selectedProgram->kategoriDana as $kategori)
                                    <span class="badge bg-light text-dark me-1 mb-1">{{ $kategori->nama }}</span>
                                    @empty
                                    <div class="text-muted">Tidak ada kategori dana yang dipilih untuk program ini.</div>
                                    @endforelse
                                </div>

                                <form action="{{ route('pengaturan-distribusi.update', $selectedProgram) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-4">
                                        <label class="form-label">Metode Distribusi</label>
                                        <select name="metode_distribusi" class="form-select">
                                            <option value="">Pilih metode distribusi</option>
                                            @foreach($methods as $key => $label)
                                            <option value="{{ $key }}" @selected(old('metode_distribusi', $selectedProgram->metode_distribusi) === $key)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        @error('metode_distribusi')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                                </form>
                                @else
                                <div class="text-center py-5">
                                    <i class="bi bi-sliders2 fs-1 text-muted"></i>
                                    <h3 class="mt-3">Pilih program untuk mengatur distribusi</h3>
                                    <p class="text-muted">Klik salah satu program di sebelah kiri untuk meninjau dan mengubah metode distribusi.</p>
                                </div>
                                @endif
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