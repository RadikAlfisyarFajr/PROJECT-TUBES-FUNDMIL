<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | FUNDMIL SOREANG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
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
            width: min(100%, 460px);
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
        .password-field {
            position: relative;
        }
        .password-field .form-control {
            padding-right: 52px;
        }
        .password-toggle {
            position: absolute;
            top: 50%;
            right: 14px;
            width: 34px;
            height: 34px;
            border: 0;
            border-radius: 50%;
            background: transparent;
            color: #5e6b61;
            display: grid;
            place-items: center;
            transform: translateY(-50%);
        }
        .password-toggle:hover {
            background: #eaf3eb;
            color: #0f722b;
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
            <a href="{{ url('/') }}" class="brand text-decoration-none d-inline-flex align-items-center gap-2 mb-4">
                <i class="bi bi-shield-check"></i>
                FUNDMIL SOREANG
            </a>

            <h1 class="h3 fw-bold mb-2">Login Admin</h1>
            <p class="text-muted mb-4">Masuk sebagai super admin atau admin instansi sesuai akun yang sudah terdaftar.</p>

            @if (session('status'))
                <div class="alert alert-success py-2">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold" for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan email" required autofocus autocomplete="username">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" for="password">Password</label>
                    <div class="password-field">
                        <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password" required autocomplete="current-password">
                        <button id="togglePassword" class="password-toggle" type="button" aria-label="Tampilkan password" aria-pressed="false">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-success fw-semibold text-decoration-none">Forgot Password?</a>
                    @endif
                </div>

                <button type="submit" class="btn btn-success w-100">Masuk</button>
            </form>

            <div class="border-top mt-4 pt-4 text-center">
                <p class="text-muted mb-2">Belum punya akun instansi?</p>
                <a href="{{ route('register') }}" class="btn btn-outline-success w-100">Daftar Instansi</a>
            </div>
        </section>
    </main>

    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');
        const toggleIcon = togglePassword?.querySelector('i');

        togglePassword?.addEventListener('click', () => {
            const isHidden = passwordInput.type === 'password';

            passwordInput.type = isHidden ? 'text' : 'password';
            togglePassword.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
            togglePassword.setAttribute('aria-pressed', isHidden ? 'true' : 'false');
            toggleIcon?.classList.toggle('bi-eye', !isHidden);
            toggleIcon?.classList.toggle('bi-eye-slash', isHidden);
        });
    </script>
</body>
</html>
