<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profil Instansi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: #f6f8f6;
            color: #101411;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .page-shell {
            max-width: 1080px;
            margin: 0 auto;
            padding: 0;
        }

        .panel {
            border: 1px solid #e4ebe6;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 14px 34px rgba(20, 47, 27, .06);
            padding: 28px;
        }

        .form-label {
            color: #263026;
            font-size: .78rem;
            font-weight: 900;
            text-transform: uppercase;
        }

        .form-control,
        .form-select {
            min-height: 48px;
            border-color: #e2ebe4;
            background: #f7faf8;
        }

        .btn-save {
            min-height: 48px;
            padding: 0 24px;
            border: 0;
            border-radius: 14px;
            background: #07651f;
            color: #fff;
            font-weight: 800;
        }

        .preview-img {
            max-height: 140px;
            border-radius: 14px;
            border: 1px solid #e4ebe6;
            object-fit: contain;
            background: #f7faf8;
        }
    </style>
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>

<body class="sidebar-expanded">
    <div class="admin-layout">
        @include('admin.partials.sidebar', ['active' => 'profil'])

        <main class="admin-page-content">
            <div class="page-shell">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                    <div>
                        <h1 class="fw-black mb-1">Update Profil Instansi</h1>
                        <p class="text-muted mb-0">Lengkapi informasi profil, foto profil, dan tanda tangan digital.</p>
                    </div>
                    <a class="btn btn-outline-secondary" href="{{ route('profil-instansi.index') }}">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Data belum bisa disimpan.</strong>
                    <div>Periksa kembali field yang ditandai.</div>
                </div>
                @endif

                <form class="panel" action="{{ route('profil-instansi.update', $instansi->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label" for="nama">Nama Instansi</label>
                            <input id="nama" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama', $instansi->nama) }}" required>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="tipe">Tipe Instansi</label>
                            <select id="tipe" class="form-select @error('tipe') is-invalid @enderror" name="tipe">
                                @foreach (['Masjid', 'Mushola', 'Lembaga Amil', 'Yayasan', 'Lainnya'] as $tipe)
                                <option value="{{ $tipe }}" @selected(old('tipe', $instansi->tipe) === $tipe)>{{ $tipe }}</option>
                                @endforeach
                            </select>
                            @error('tipe')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="kontak">WhatsApp Admin</label>
                            <input id="kontak" class="form-control @error('kontak') is-invalid @enderror" name="kontak" value="{{ old('kontak', $instansi->kontak) }}">
                            @error('kontak')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="email">Email Resmi</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $instansi->email) }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="kelurahan">Desa/Kelurahan</label>
                            <input id="kelurahan" class="form-control @error('kelurahan') is-invalid @enderror" name="kelurahan" value="{{ old('kelurahan', $instansi->kelurahan) }}">
                            @error('kelurahan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="alamat">Alamat Lengkap</label>
                            <textarea id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" rows="4">{{ old('alamat', $instansi->alamat) }}</textarea>
                            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="nomor_sk">Nomor SK/Izin Operasional</label>
                            <input id="nomor_sk" class="form-control @error('nomor_sk') is-invalid @enderror" name="nomor_sk" value="{{ old('nomor_sk', $instansi->nomor_sk) }}">
                            @error('nomor_sk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="masa_berlaku">Masa Berlaku</label>
                            <input id="masa_berlaku" type="date" class="form-control @error('masa_berlaku') is-invalid @enderror" name="masa_berlaku" value="{{ old('masa_berlaku', optional($instansi->masa_berlaku)->format('Y-m-d')) }}">
                            @error('masa_berlaku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="nama_pimpinan">Nama Ketua/DKM</label>
                            <input id="nama_pimpinan" class="form-control @error('nama_pimpinan') is-invalid @enderror" name="nama_pimpinan" value="{{ old('nama_pimpinan', $instansi->nama_pimpinan) }}">
                            @error('nama_pimpinan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="logo">Foto Profil Instansi</label>
                            <input id="logo" type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" accept="image/png,image/jpeg,image/webp">
                            @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            @if ($instansi->logo)
                            <img class="preview-img mt-3 w-100" src="{{ asset('storage/'.$instansi->logo) }}" alt="Foto profil instansi">
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="tanda_tangan">Tanda Tangan Digital</label>
                            <input id="tanda_tangan" type="file" class="form-control @error('tanda_tangan') is-invalid @enderror" name="tanda_tangan" accept="image/png,image/jpeg,image/webp">
                            @error('tanda_tangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            @if ($instansi->tanda_tangan)
                            <img class="preview-img mt-3 w-100" src="{{ asset('storage/'.$instansi->tanda_tangan) }}" alt="Tanda tangan digital">
                            @endif
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a class="btn btn-light" href="{{ route('profil-instansi.index') }}">Batal</a>
                        <button class="btn-save" type="submit">
                            <i class="bi bi-floppy-fill me-2"></i>Simpan Profil
                        </button>
                    </div>
                </form>
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