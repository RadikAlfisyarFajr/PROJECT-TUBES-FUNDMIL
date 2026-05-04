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
        .password-toggle-btn {
            min-width: 52px;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            color: #324337;
            background-color: #f8faf7;
            border-color: rgba(51, 68, 58, .15);
        }
        .password-toggle-btn i {
            font-size: 1.05rem;
            color: inherit;
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

            <h1 class="h3 fw-bold mb-2">Login Admin</h1>
            <p class="text-muted mb-4">Masuk sebagai super admin atau admin instansi sesuai akun yang sudah terdaftar.</p>

            @if(session('success'))
                <div class="alert alert-success py-2">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('auth.login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold" for="username">Username</label>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror" placeholder="Masukkan username">
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" for="password">Password</label>
                    <div class="input-group">
                        <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password">
                        <button type="button" class="btn btn-outline-secondary border-start-0 password-toggle-btn" id="togglePasswordLogin" aria-label="Tampilkan password">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Ingat saya</label>
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
        document.addEventListener('DOMContentLoaded', function () {
            var passwordInput = document.getElementById('password');
            var toggle = document.getElementById('togglePasswordLogin');
            if (passwordInput && toggle) {
                toggle.addEventListener('click', function () {
                    var visible = passwordInput.type === 'password';
                    passwordInput.type = visible ? 'text' : 'password';
                    var icon = this.querySelector('i');
                    icon.classList.toggle('bi-eye-fill', !visible);
                    icon.classList.toggle('bi-eye-slash-fill', visible);
                });
            }
        });
    </script>
</body>
</html>
