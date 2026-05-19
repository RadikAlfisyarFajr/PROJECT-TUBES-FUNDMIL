<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | FUNDMIL SOREANG</title>
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
            width: min(100%, 520px);
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
        .form-control {
            min-height: 52px;
            border-radius: 14px;
            border-color: #dde6dd;
            background: #f8faf8;
        }
        .form-control:focus {
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
    </style>
</head>
<body>
    <main class="auth-shell">
        <section class="auth-card">
            <a href="{{ route('public.home') }}" class="brand text-decoration-none d-inline-flex align-items-center gap-2 mb-4">
                <i class="bi bi-shield-check"></i>
                FUNDMIL SOREANG
            </a>

            <h1 class="h3 fw-bold mb-2">Set Password Baru</h1>
            <p class="text-muted mb-4">Masukkan email akun dan password baru untuk menyelesaikan reset password.</p>

            @if ($errors->any())
                <div class="alert alert-danger py-2">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="mb-3">
                    <label class="form-label fw-semibold" for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" class="form-control @error('email') is-invalid @enderror" placeholder="admin@instansi.id" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" for="password">Password Baru</label>
                    <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required autocomplete="new-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold" for="password_confirmation">Konfirmasi Password Baru</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru" required autocomplete="new-password">
                </div>

                <button type="submit" class="btn btn-success w-100">Simpan Password Baru</button>
            </form>

            <div class="border-top mt-4 pt-4 text-center">
                <a href="{{ route('login') }}" class="btn btn-outline-success w-100">Kembali ke Login</a>
            </div>
        </section>
    </main>
</body>
</html>
