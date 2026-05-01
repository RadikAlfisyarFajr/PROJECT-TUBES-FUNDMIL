<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FundMil Soreang · Autentikasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: #edf5ec;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .auth-split {
            min-height: 100vh;
        }
        .auth-left {
            background: #fff;
            border-radius: 32px;
            box-shadow: 0 25px 60px rgba(15, 23, 42, .08);
        }
        .auth-right {
            background: linear-gradient(135deg, #1e5e33 0%, #2a8a46 40%, #65c17d 100%);
            border-radius: 32px;
            position: relative;
            overflow: hidden;
            min-height: 100%;
            color: #fff;
        }
        .auth-right::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top left, rgba(255,255,255,.17), transparent 25%),
                        radial-gradient(circle at bottom right, rgba(255,255,255,.12), transparent 22%);
            pointer-events: none;
        }
        .auth-right .card {
            background: rgba(255,255,255,.1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,.18);
        }
        .form-control,
        .form-select {
            border-radius: 16px;
            background: #f5f7f6;
            border: 1px solid #e7ece6;
            min-height: 54px;
        }
        .form-control:focus,
        .form-select:focus {
            box-shadow: none;
            border-color: #8ccf8d;
        }
        .btn-primary {
            background: #2d8f45;
            border-color: #2d8f45;
        }
        .btn-primary:hover {
            background: #25713a;
            border-color: #25713a;
        }
        .text-muted-soft {
            color: #6f7a72;
        }
        .form-label {
            font-weight: 600;
            color: #3e4a43;
        }
        .auth-footer {
            color: rgba(255,255,255,.7);
            font-size: .9rem;
        }
        .auth-right .form-control,
        .auth-right .form-select {
            background: rgba(255,255,255,.12);
            color: #f8fbf7;
            border-color: rgba(255,255,255,.22);
        }
        .auth-right .form-control:focus,
        .auth-right .form-select:focus {
            border-color: rgba(255,255,255,.55);
        }
        .auth-right .form-check-label,
        .auth-right .form-text,
        .auth-right .text-white-75,
        .auth-right a {
            color: rgba(255,255,255,.85);
        }
        .auth-right a:hover {
            color: #fff;
        }
        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: #dc3545;
        }
        @media (max-width: 991px) {
            .auth-left,
            .auth-right {
                border-radius: 24px;
            }
            .auth-split {
                min-height: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row g-4 auth-split justify-content-center align-items-center">
            <div class="col-lg-6">
                <div class="p-4 auth-left">
                    <div class="mb-4">
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 fw-semibold">
                            <i class="bi bi-bank2-fill me-2"></i> FUND MIL SOREANG
                        </span>
                    </div>
                    <h2 class="fw-bold">Registrasi Instansi</h2>
                    <p class="text-muted-soft mb-4">Daftarkan lembaga atau masjid Anda untuk mulai mengelola amanah zakat secara digital dan transparan.</p>

                    @if(session('success'))
                        <div class="alert alert-success py-2">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger py-2">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('auth.register') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="nama_instansi">Nama Instansi</label>
                            <input id="nama_instansi" type="text" name="nama_instansi" value="{{ old('nama_instansi') }}" class="form-control @error('nama_instansi') is-invalid @enderror" placeholder="Contoh: Masjid Agung Al-Falah">
                            @error('nama_instansi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="desa">Desa</label>
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
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="admin@instansi.id">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label" for="username">Username</label>
                                <input id="username" type="text" name="username" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror" placeholder="Username">
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="password">Password</label>
                                <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill">Daftar Sekarang</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="p-4 auth-right d-flex flex-column justify-content-between">
                    <div class="position-relative" style="z-index: 1;">
                        <div class="mb-4">
                            <span class="badge rounded-pill bg-white bg-opacity-15 border border-white border-opacity-20 text-white px-3 py-2 fw-semibold">
                                <i class="bi bi-shield-lock-fill me-2"></i> Masuk ke Sistem
                            </span>
                        </div>
                        <h1 class="fw-bold display-6 mb-3">Selamat Datang Kembali</h1>
                        <p class="text-white-75 mb-5">Lanjutkan pengelolaan dana zakat, infak, dan sedekah dengan sistem yang aman dan amanah.</p>
                        <div class="card rounded-4 p-4 shadow-sm">
                            <div class="card-body">
                                <form method="POST" action="{{ route('auth.login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label text-white-75" for="login_username">Username</label>
                                        <input id="login_username" type="text" name="username" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror" placeholder="Username Anda">
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-white-75" for="login_password">Password</label>
                                        <input id="login_password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label text-white-75" for="remember">Ingat Saya</label>
                                        </div>
                                        <a href="#" class="text-white-75 text-decoration-underline">Lupa Password?</a>
                                    </div>
                                    <button type="submit" class="btn btn-light btn-lg w-100 rounded-pill text-success fw-semibold">Masuk</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="auth-footer text-center mt-4" style="z-index: 1;">
                        © 2024 FUND MIL SOREANG Semua Hak Dilindungi. &middot; Kebijakan Privasi
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
