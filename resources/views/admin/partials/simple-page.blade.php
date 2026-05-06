@php
    $title = $title ?? 'Halaman Admin';
    $description = $description ?? 'Halaman ini memakai kerangka antarmuka yang sama dengan menu admin lainnya.';
    $active = $active ?? '';
    $roleLabel = $roleLabel ?? 'Admin Instansi';
    $sidebar = $sidebar ?? 'admin.partials.sidebar';
    $backRoute = $backRoute ?? null;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | {{ $roleLabel }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>
<body class="sidebar-expanded">
    <div class="admin-layout">
        @include($sidebar, ['active' => $active])

        <main class="admin-page-content">
            <header class="admin-page-topbar">
                <div>
                    <h1 class="admin-page-title">{{ $title }}</h1>
                    <p class="admin-page-desc">{{ $description }}</p>
                </div>
                <div class="admin-top-actions">
                    @if ($backRoute)
                        <a class="admin-secondary-btn" href="{{ route($backRoute) }}">
                            <i class="bi bi-arrow-left"></i>
                            <span>Kembali</span>
                        </a>
                    @endif
                    <button class="admin-icon-btn has-dot" type="button" aria-label="Notifikasi">
                        <i class="bi bi-bell-fill"></i>
                    </button>
                    @include('admin.partials.account-identity')
                </div>
            </header>

            <div class="admin-content-wrap">
                <section class="admin-panel">
                    <div class="admin-empty-state">
                        <div class="admin-empty-icon">
                            <i class="bi bi-layout-sidebar-inset"></i>
                        </div>
                        <h2>{{ $title }}</h2>
                        <p>{{ $description }}</p>
                    </div>
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
