<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Instansi | FUNDMIL SOREANG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: #f2f5f1;
            color: #101510;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .auth-shell {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 32px 16px;
        }
        .auth-card {
            width: min(100%, 760px);
            background: #fff;
            border: 1px solid #e6ece5;
            border-radius: 22px;
            box-shadow: 0 24px 60px rgba(18, 42, 24, .08);
            padding: 32px;
        }
        .brand {
            color: #096b26;
            font-weight: 800;
            letter-spacing: .02em;
        }
        .form-control,
        .form-select {
            min-height: 52px;
            border-radius: 14px;
            border-color: #dde6dd;
            background: #f8faf8;
        }
        .form-control:focus,
        .form-select:focus {
            border-color: #0f722b;
            box-shadow: 0 0 0 .18rem rgba(15, 114, 43, .12);
        }
        .btn-success {
            background: #0f722b;
            border-color: #0f722b;
            border-radius: 14px;
            min-height: 52px;
            font-weight: 700;
        }
        .btn-outline-success {
            border-color: #0f722b;
            color: #0f722b;
            border-radius: 14px;
        }
        .invalid-feedback {
            font-size: .9rem;
        }
        .form-label {
            font-weight: 600;
        }
    </style>
</head>
<body>
    <main class="auth-shell">
        <section class="auth-card">
            <a href="{{ route('public.home') }}" class="brand text-decoration-none d-inline-flex align-items-center gap-2 mb-4">
                <i class="bi bi-shield-check"></i>
                FUNDMIL SOREANG
            </a>

            <h1 class="h3 fw-bold mb-2">Registrasi Instansi</h1>
            <p class="text-muted mb-4">Daftarkan masjid atau lembaga agar bisa mengelola zakat, infak, dan sedekah secara digital.</p>

            @if ($errors->any())
                <div class="alert alert-danger p-3 rounded-3 mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-7">
                        <label class="form-label fw-semibold" for="nama_instansi">Nama Instansi</label>
                        <input id="nama_instansi" type="text" name="nama_instansi" value="{{ old('nama_instansi') }}" class="form-control @error('nama_instansi') is-invalid @enderror" placeholder="Contoh: LAZ Al-Falah Soreang">
                        @error('nama_instansi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-semibold" for="tipe">Tipe Lembaga</label>
                        <select id="tipe" name="tipe" class="form-select @error('tipe') is-invalid @enderror">
                            <option value="" disabled selected>Pilih Tipe</option>
                            @foreach(['Masjid', 'UPZ', 'Lembaga Amil Zakat'] as $tipe)
                                <option value="{{ $tipe }}" {{ old('tipe') === $tipe ? 'selected' : '' }}>{{ $tipe }}</option>
                            @endforeach
                        </select>
                        @error('tipe')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mt-0">
                    <div class="col-md-5">
                        <label class="form-label fw-semibold" for="desa">Desa</label>
                        <select id="desa" name="desa" class="form-select @error('desa') is-invalid @enderror">
                            <option value="" disabled selected>Pilih Desa</option>
                            @foreach($desaOptions as $desa)
                                <option value="{{ $desa }}" {{ old('desa') === $desa ? 'selected' : '' }}>{{ $desa }}</option>
                            @endforeach
                        </select>
                        @error('desa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-7">
                        <label class="form-label fw-semibold" for="alamat">Alamat Lengkap</label>
                        <input id="alamat" type="text" name="alamat" value="{{ old('alamat') }}" class="form-control @error('alamat') is-invalid @enderror" placeholder="Nama jalan, RT/RW, patokan lokasi">
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mt-0">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="nomor_sk">Nomor SK/Izin</label>
                        <input id="nomor_sk" type="text" name="nomor_sk" value="{{ old('nomor_sk') }}" class="form-control @error('nomor_sk') is-invalid @enderror" placeholder="Nomor legalitas lembaga">
                        @error('nomor_sk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="masa_berlaku">Masa Berlaku SK</label>
                        <input id="masa_berlaku" type="date" name="masa_berlaku" value="{{ old('masa_berlaku') }}" class="form-control @error('masa_berlaku') is-invalid @enderror">
                        @error('masa_berlaku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mt-0">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="nama_pimpinan">Pimpinan/Penanggung Jawab</label>
                        <input id="nama_pimpinan" type="text" name="nama_pimpinan" value="{{ old('nama_pimpinan') }}" class="form-control @error('nama_pimpinan') is-invalid @enderror" placeholder="Nama lengkap">
                        @error('nama_pimpinan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="kontak">Nomor Kontak</label>
                        <input id="kontak" type="text" name="kontak" value="{{ old('kontak') }}" class="form-control @error('kontak') is-invalid @enderror" placeholder="08xx atau nomor kantor">
                        @error('kontak')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-3 mb-3">
                    <label class="form-label fw-semibold" for="email">Email Admin</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="admin@instansi.id">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="username">Username</label>
                        <input id="username" type="text" name="username" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror" placeholder="Username">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="password">Password</label>
                        <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold" for="password_confirmation">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password">
                </div>
                <button type="submit" class="btn btn-success w-100">Daftar Sekarang</button>
            </form>

            <div class="border-top mt-4 pt-4 text-center">
                <p class="text-muted mb-2">Sudah punya akun?</p>
                <a href="{{ route('login') }}" class="btn btn-outline-success w-100">Masuk ke Login</a>
            </div>
        </section>
    </main>
</body>
</html>
