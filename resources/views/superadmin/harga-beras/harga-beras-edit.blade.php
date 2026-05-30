<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Harga Beras | Super Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>
<body class="sidebar-expanded">
    <div class="admin-layout">
        @include('superadmin.partials.sidebar', ['active' => 'harga-beras'])

        <main class="admin-page-content">
            <header class="admin-page-topbar">
                <div>
                    <h1 class="admin-page-title">Edit Harga Beras</h1>
                    <p class="admin-page-desc">{{ $hargaBeras->tanggal_berlaku?->format('d M Y') }}</p>
                </div>
                <a class="admin-secondary-btn" href="{{ route('superadmin.harga-beras.index') }}">
                    <i class="bi bi-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </header>

            <div class="admin-content-wrap">
                @if($errors->any())
                    <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">{{ $errors->first() }}</div>
                @endif

                <section class="admin-panel">
                    <form method="POST" action="{{ route('superadmin.harga-beras.update', $hargaBeras) }}" class="super-form-grid">
                        @csrf
                        @method('PUT')
                        @include('superadmin.harga-beras.harga-beras-form')
                        <div class="final-actions">
                            <button class="distribution-submit-btn" type="submit">
                                <i class="bi bi-check2-circle"></i>
                                <span>Perbarui</span>
                            </button>
                        </div>
                    </form>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
