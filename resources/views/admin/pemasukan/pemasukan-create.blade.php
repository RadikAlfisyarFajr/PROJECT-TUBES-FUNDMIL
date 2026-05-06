@php
    $title = 'Tambah Pemasukan Zakat';
    $description = 'Pilih sub-kategori dana berdasarkan kategori utama yang aktif.';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | Admin Instansi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>
<body class="sidebar-expanded">
    <div class="admin-layout">
        @include('admin.partials.sidebar', ['active' => 'pemasukan'])

        <main class="admin-page-content">
            <header class="admin-page-topbar">
                <div>
                    <h1 class="admin-page-title">{{ $title }}</h1>
                    <p class="admin-page-desc">{{ $description }}</p>
                </div>
                <div class="admin-top-actions">
                    <a class="admin-secondary-btn" href="{{ route('pemasukan.index') }}">
                        <i class="bi bi-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                    <button class="admin-icon-btn has-dot" type="button" aria-label="Notifikasi">
                        <i class="bi bi-bell-fill"></i>
                    </button>
                    <div class="admin-user-name">
                        <strong>Admin Instansi</strong>
                        <div class="admin-user-role">FUNDMIL Soreang</div>
                    </div>
                    <div class="admin-avatar">A</div>
                </div>
            </header>

            <div class="admin-content-wrap">
                <section class="admin-panel">
                    <form method="POST" action="{{ route('pemasukan.store') }}" class="row g-3">
                        @csrf

                        <div class="col-md-6">
                            <label class="form-label fw-bold" for="kategori_id">Kategori Pemasukan</label>
                            <select class="form-select" id="kategori_id" name="kategori_id" required>
                                <option value="">Pilih sub-kategori aktif</option>
                                @forelse ($kategoriDropdown as $kategoriUtama)
                                    <optgroup label="{{ $kategoriUtama->nama }}">
                                        @foreach ($kategoriUtama->children as $subKategori)
                                            <option value="{{ $subKategori->id }}" @selected(old('kategori_id') == $subKategori->id)>
                                                {{ $subKategori->nama }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @empty
                                    <option value="" disabled>Belum ada kategori aktif</option>
                                @endforelse
                            </select>
                            <div class="form-text">Sub-kategori muncul sesuai kategori utama yang aktif di halaman Kategori Dana.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold" for="nama_muzakki">Nama Muzakki</label>
                            <input class="form-control" id="nama_muzakki" name="nama_muzakki" value="{{ old('nama_muzakki') }}" placeholder="Nama pembayar zakat">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold" for="jumlah">Jumlah</label>
                            <input class="form-control" id="jumlah" name="jumlah" type="number" min="0" step="0.01" value="{{ old('jumlah') }}" placeholder="0">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold" for="tanggal">Tanggal</label>
                            <input class="form-control" id="tanggal" name="tanggal" type="date" value="{{ old('tanggal', now()->toDateString()) }}">
                        </div>

                        <div class="col-12 d-flex justify-content-end gap-2 pt-3">
                            <a class="admin-secondary-btn" href="{{ route('kategori-dana.index') }}">
                                <i class="bi bi-tags-fill"></i>
                                <span>Atur Kategori</span>
                            </a>
                            <button class="btn btn-success fw-bold px-4" type="submit">
                                <i class="bi bi-save"></i>
                                Simpan
                            </button>
                        </div>
                    </form>
                </section>
            </div>
        </main>
    </div>

    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');

        sidebarToggle?.addEventListener('click', () => {
            document.body.classList.toggle('sidebar-expanded');
        });
    </script>
</body>
</html>
