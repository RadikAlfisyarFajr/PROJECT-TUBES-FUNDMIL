@php
    $instansiInitials = collect(explode(' ', trim($instansi->nama ?? 'Admin')))
        ->filter()
        ->take(2)
        ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
        ->implode('');
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Dana | Admin Instansi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --green: #087026;
            --green-dark: #06451f;
            --green-soft: #dff3e4;
            --green-pale: #eef9f1;
            --ink: #17211b;
            --muted: #748077;
            --surface: #f5f8f5;
            --sidebar: #f4f8f2;
            --line: #e2ebe4;
            --shadow: 0 16px 34px rgba(18, 55, 28, .07);
        }

        * {
            letter-spacing: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            overflow-x: hidden;
            background: var(--surface);
            color: var(--ink);
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .admin-layout {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 88px minmax(0, 1fr);
            transition: grid-template-columns .25s ease;
        }

        body.sidebar-expanded .admin-layout {
            grid-template-columns: 280px minmax(0, 1fr);
        }

        .sidebar {
            min-height: 100vh;
            padding: 20px 12px 24px;
            background: var(--sidebar);
            border-right: 1px solid var(--line);
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            transition: padding .25s ease;
        }

        body.sidebar-expanded .sidebar {
            padding: 38px 18px 28px;
        }

        .brand {
            min-height: 52px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            overflow: hidden;
        }

        body.sidebar-expanded .brand {
            justify-content: flex-start;
            padding: 0 18px;
        }

        .brand-icon {
            width: 28px;
            height: 28px;
            border-radius: 10px;
            background: var(--green);
            color: #fff;
            display: grid;
            place-items: center;
            flex: 0 0 auto;
        }

        .brand-copy {
            display: none;
            white-space: nowrap;
        }

        body.sidebar-expanded .brand-copy {
            display: block;
        }

        .brand-title {
            margin-bottom: 8px;
            color: var(--green-dark);
            font-size: 1.25rem;
            font-weight: 900;
        }

        .brand-subtitle {
            color: #9ba49e;
            font-size: .68rem;
            font-weight: 800;
            letter-spacing: .32em;
        }

        .sidebar-nav {
            margin-top: 52px;
            display: grid;
            gap: 10px;
        }

        body.sidebar-expanded .sidebar-nav {
            margin-top: 66px;
        }

        .sidebar-toggle,
        .nav-item-link {
            width: 58px;
            height: 58px;
            min-height: 58px;
            margin-left: auto;
            margin-right: auto;
            border: 0;
            border-radius: 16px;
            background: transparent;
            color: #294158;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
            overflow: hidden;
            transition: background .2s ease, color .2s ease, width .25s ease, padding .25s ease;
        }

        body.sidebar-expanded .sidebar-toggle,
        body.sidebar-expanded .nav-item-link {
            width: 100%;
            padding: 0 18px;
            justify-content: flex-start;
        }

        .nav-item-link:hover,
        .nav-item-link.active,
        .sidebar-toggle:hover {
            background: #fff;
            color: var(--green);
        }

        .nav-item-link.active {
            background: #dceee2;
        }

        .sidebar-toggle i,
        .nav-item-link i {
            width: 24px;
            color: var(--green-dark);
            font-size: 1.25rem;
            text-align: center;
            flex: 0 0 auto;
        }

        .nav-item-link span,
        .sidebar-toggle span {
            display: none;
        }

        body.sidebar-expanded .nav-item-link span,
        body.sidebar-expanded .sidebar-toggle span {
            display: inline;
        }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 18px;
            border-top: 1px solid var(--line);
        }

        .main-content {
            min-width: 0;
            padding: 18px 24px 38px;
            background: var(--surface);
        }

        .topbar {
            min-height: 56px;
            margin: -18px -24px 34px;
            padding: 16px 24px;
            background: #fff;
            border-bottom: 1px solid rgba(226, 235, 228, .8);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .page-title {
            margin: 0;
            font-size: 1.12rem;
            font-weight: 900;
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .search-box {
            width: min(330px, 34vw);
            height: 34px;
            padding: 0 12px;
            border-radius: 8px;
            background: #f2f5f3;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .search-box input {
            width: 100%;
            border: 0;
            outline: 0;
            background: transparent;
            font-size: .78rem;
        }

        .icon-btn {
            width: 28px;
            height: 28px;
            border: 0;
            border-radius: 50%;
            background: transparent;
            color: #334255;
            display: grid;
            place-items: center;
            position: relative;
        }

        .icon-btn.has-dot::after {
            content: "";
            position: absolute;
            top: 5px;
            right: 6px;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #e23d4d;
        }

        .notification-wrap {
            position: relative;
        }

        .notification-menu {
            position: absolute;
            top: calc(100% + 12px);
            right: 0;
            width: min(360px, calc(100vw - 32px));
            border: 1px solid var(--line);
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 18px 38px rgba(20, 47, 27, .13);
            overflow: hidden;
            display: none;
            z-index: 20;
        }

        .notification-menu.is-open {
            display: block;
        }

        .notification-header {
            padding: 14px 16px;
            border-bottom: 1px solid var(--line);
            font-weight: 900;
        }

        .notification-item {
            padding: 14px 16px;
            border-bottom: 1px solid #edf1ee;
            white-space: normal;
        }

        .notification-item:last-child {
            border-bottom: 0;
        }

        .notification-title {
            color: var(--ink);
            font-size: .86rem;
            font-weight: 850;
            margin-bottom: 4px;
        }

        .notification-text {
            color: #536058;
            font-size: .78rem;
            line-height: 1.45;
            margin-bottom: 6px;
        }

        .notification-time {
            color: #8a958f;
            font-size: .72rem;
            font-weight: 700;
        }

        .admin-name {
            font-size: .72rem;
            line-height: 1.1;
            text-align: right;
        }

        .admin-role {
            color: var(--muted);
            font-size: .62rem;
        }

        .avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #10384a;
            color: #fff;
            display: grid;
            place-items: center;
            font-size: .72rem;
            font-weight: 800;
            overflow: hidden;
            flex: 0 0 auto;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .content-wrap {
            max-width: 1180px;
            margin: 0 auto;
        }

        .page-intro {
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 24px;
        }

        .page-desc {
            max-width: 600px;
            margin: 0;
            color: #506057;
            font-size: .92rem;
            line-height: 1.65;
        }

        .save-btn {
            min-height: 48px;
            padding: 0 26px;
            border: 0;
            border-radius: 16px;
            background: var(--green);
            color: #fff;
            box-shadow: 0 12px 24px rgba(8, 112, 38, .22);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .category-card {
            min-height: 190px;
            padding: 26px;
            border: 1px solid var(--line);
            border-radius: 18px;
            background: #fff;
            box-shadow: var(--shadow);
            position: relative;
        }

        .category-item.is-hidden {
            display: none;
        }

        .category-icon {
            width: 48px;
            height: 48px;
            margin-bottom: 24px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            font-size: 1.35rem;
        }

        .category-icon.green {
            background: #a7edb6;
            color: var(--green);
        }

        .category-icon.gray {
            background: #dfe9e2;
            color: #4d6c57;
        }

        .category-icon.pink {
            background: #ffcfe0;
            color: #c84770;
        }

        .category-title {
            margin: 0 0 8px;
            font-size: 1.08rem;
            font-weight: 900;
        }

        .category-desc {
            min-height: 42px;
            margin: 0 0 20px;
            color: #45554b;
            font-size: .82rem;
            line-height: 1.55;
        }

        .tag-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .tag-pill {
            padding: 6px 10px;
            border-radius: 999px;
            background: #eef4ee;
            color: #58705e;
            font-size: .62rem;
            font-weight: 900;
            text-transform: uppercase;
        }

        .toggle-switch {
            position: absolute;
            top: 26px;
            right: 24px;
        }

        .toggle-switch input {
            display: none;
        }

        .toggle-slider {
            width: 34px;
            height: 18px;
            border-radius: 999px;
            background: #cdd8cf;
            display: block;
            cursor: pointer;
            position: relative;
        }

        .toggle-slider::after {
            content: "";
            position: absolute;
            top: 3px;
            left: 3px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #fff;
            transition: transform .2s ease;
        }

        .toggle-switch input:checked+.toggle-slider {
            background: var(--green);
        }

        .toggle-switch input:checked+.toggle-slider::after {
            transform: translateX(16px);
        }

        .info-panel {
            margin-top: 28px;
            padding: 24px 28px;
            border: 1px solid #b8dfc3;
            border-radius: 18px;
            background: #eaf8ee;
            display: flex;
            align-items: flex-start;
            gap: 18px;
        }

        .info-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #c6ecd0;
            color: var(--green);
            display: grid;
            place-items: center;
            flex: 0 0 auto;
        }

        .info-title {
            margin: 0 0 8px;
            color: var(--green-dark);
            font-size: .96rem;
            font-weight: 900;
        }

        .info-text {
            margin: 0;
            color: #42524a;
            font-size: .82rem;
            line-height: 1.7;
        }

        .empty-search {
            display: none;
            margin-top: 24px;
            padding: 24px;
            border: 1px dashed #cfded4;
            border-radius: 14px;
            background: #f8fbf9;
            color: #4d6254;
            text-align: center;
            font-weight: 700;
        }

        .empty-search.is-visible {
            display: block;
        }

        @media (max-width: 991px) {
            .admin-layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                min-height: auto;
            }

            .main-content {
                padding: 18px 16px 34px;
            }

            .topbar {
                margin: -18px -16px 28px;
                padding: 16px;
                flex-direction: column;
                align-items: flex-start;
            }

            .top-actions,
            .search-box {
                width: 100%;
            }

            .page-intro {
                flex-direction: column;
            }
        }
    </style>
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>

<body class="sidebar-expanded">
    <div class="admin-layout">
        @include('admin.partials.sidebar', ['active' => 'kategori'])

        <main class="main-content">
            <header class="topbar">
                <h1 class="page-title">Kategori Dana</h1>
                <div class="top-actions">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input id="categorySearch" type="search" placeholder="Cari kategori...">
                    </div>
                    <div class="notification-wrap">
                        <button id="notificationToggle" class="icon-btn {{ $unreadNotifications > 0 ? 'has-dot' : '' }}" type="button" aria-label="Notifikasi kategori dana" aria-expanded="false">
                            <i class="bi bi-bell-fill"></i>
                        </button>
                        <div id="notificationMenu" class="notification-menu" aria-labelledby="notificationToggle">
                            <div class="notification-header">Update Konfigurasi</div>
                            @forelse ($notifications as $notification)
                                <div class="notification-item">
                                    <div class="notification-title">{{ $notification->title }}</div>
                                    <div class="notification-text">{{ $notification->message }}</div>
                                    <div class="notification-time">{{ $notification->created_at->diffForHumans() }}</div>
                                </div>
                            @empty
                                <div class="notification-item text-center text-muted">
                                    Belum ada update konfigurasi.
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <button class="icon-btn" type="button" aria-label="Bantuan">
                        <i class="bi bi-question-circle-fill"></i>
                    </button>

                    <div class="admin-name">
                        <strong>{{ $instansi->nama }}</strong>
                        <div class="admin-role">{{ $instansi->tipe ?: 'Admin Instansi' }}</div>
                    </div>
                    <div class="avatar">
                        @if ($instansi->logo)
                            <img src="{{ asset('storage/'.$instansi->logo) }}" alt="Logo {{ $instansi->nama }}">
                        @else
                            {{ $instansiInitials ?: 'A' }}
                        @endif
                    </div>

                    @include('admin.partials.account-identity', [
                        'nameClass' => 'admin-name',
                        'roleClass' => 'admin-role',
                        'avatarClass' => 'avatar',
                    ])
                </div>
            </header>

            <div class="content-wrap">
                @if (session('success'))
                    <div class="alert alert-success border-0 shadow-sm mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('kategori-dana.update', 0) }}">
                    @csrf
                    @method('PUT')

                    <div class="page-intro">
                        <p class="page-desc">Aktifkan kategori utama sebagai payung besar pengelolaan dana di instansi Anda.</p>
                        <button class="save-btn" type="submit">
                            <i class="bi bi-floppy-fill"></i>
                            Simpan Konfigurasi
                        </button>
                    </div>

                    <div class="row g-4">
                        @foreach ($categoryCards as $category)
                            <div class="col-md-6 category-item" data-search="{{ strtolower($category['nama'] . ' ' . $category['description'] . ' ' . implode(' ', $category['tags']) . ' ' . $category['children']->pluck('nama')->implode(' ')) }}">
                                <section class="category-card">
                                    <label class="toggle-switch" aria-label="Aktifkan {{ $category['nama'] }}">
                                        <input type="checkbox" name="categories[]" value="{{ $category['id'] }}" @checked($category['is_active'])>
                                        <span class="toggle-slider"></span>
                                    </label>
                                    <div class="category-icon {{ $category['color'] }}">
                                        <i class="bi {{ $category['icon'] }}"></i>
                                    </div>
                                    <h2 class="category-title">{{ $category['nama'] }}</h2>
                                    <p class="category-desc">{{ $category['description'] }}</p>
                                    <div class="tag-list">
                                        @foreach ($category['tags'] as $tag)
                                            <span class="tag-pill">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                </section>
                            </div>
                        @endforeach
                    </div>

                    <div id="emptySearch" class="empty-search">
                        Kategori dana tidak ditemukan.
                    </div>
                </form>

                <section class="info-panel">
                    <div class="info-icon">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>
                    <div>
                        <h2 class="info-title">Informasi Struktur Data</h2>
                        <p class="info-text">
                            Kategori di atas berfungsi sebagai <strong>Payung Besar</strong>. Apabila kategori induk seperti Zakat Maal diaktifkan,
                            maka sub-kategori spesifik seperti <strong>Tabungan</strong>, <strong>Profesi</strong>, <strong>Perdagangan</strong>,
                            <strong>EMAS/LM</strong>, dan lainnya akan secara otomatis muncul sebagai pilihan dropdown pada halaman <strong>Pemasukan Zakat</strong>.
                        </p>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');

        sidebarToggle.addEventListener('click', () => {
            document.body.classList.toggle('sidebar-expanded');
        });

        const categorySearch = document.getElementById('categorySearch');
        const categoryItems = document.querySelectorAll('.category-item');
        const emptySearch = document.getElementById('emptySearch');

        categorySearch?.addEventListener('input', () => {
            const keyword = categorySearch.value.trim().toLowerCase();
            let visibleCount = 0;

            categoryItems.forEach((item) => {
                const isMatch = item.dataset.search.includes(keyword);

                item.classList.toggle('is-hidden', !isMatch);

                if (isMatch) {
                    visibleCount += 1;
                }
            });

            emptySearch?.classList.toggle('is-visible', visibleCount === 0);
        });

        const notificationToggle = document.getElementById('notificationToggle');
        const notificationMenu = document.getElementById('notificationMenu');

        notificationToggle?.addEventListener('click', (event) => {
            event.stopPropagation();
            const isOpen = notificationMenu?.classList.toggle('is-open');

            notificationToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            notificationToggle.classList.remove('has-dot');

            if (isOpen) {
                fetch('{{ route('kategori-dana.notifications.read') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                }).catch(() => {});
            }
        });

        document.addEventListener('click', (event) => {
            if (!notificationMenu?.classList.contains('is-open')) {
                return;
            }

            if (!notificationMenu.contains(event.target)) {
                notificationMenu.classList.remove('is-open');
                notificationToggle?.setAttribute('aria-expanded', 'false');
            }
        });
    </script>
</body>

</html>
