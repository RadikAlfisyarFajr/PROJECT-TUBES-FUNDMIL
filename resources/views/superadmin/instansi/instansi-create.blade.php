<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun Desa | Super Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>
<body class="sidebar-expanded">
    <div class="admin-layout">
        @include('superadmin.partials.sidebar', ['active' => 'instansi'])

        <main class="admin-page-content">
            <header class="admin-page-topbar">
                <div>
                    <h1 class="admin-page-title">Buat Akun Kepala Desa</h1>
                    <p class="admin-page-desc">Akun ini dipakai Kepala Desa untuk approval program dan pelacakan kas wilayah.</p>
                </div>
                <a class="admin-secondary-btn" href="{{ route('superadmin.instansi.index') }}">
                    <i class="bi bi-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </header>

            <div class="admin-content-wrap">
                @if($errors->any())
                    <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">{{ $errors->first() }}</div>
                @endif

                <section class="admin-panel">
                    <form method="POST" action="{{ route('superadmin.instansi.store') }}" class="super-form-grid">
                        @csrf
                        @include('superadmin.instansi.instansi-form', ['instansi' => null, 'admin' => null])
                        <div class="final-actions">
                            <button class="distribution-submit-btn" type="submit">
                                <i class="bi bi-check2-circle"></i>
                                <span>Simpan Akun</span>
                            </button>
                        </div>
                    </form>
                </section>
            </div>
        </main>
    </div>

    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', () => {
            document.body.classList.toggle('sidebar-expanded');
        });
    </script>
</body>
</html>
