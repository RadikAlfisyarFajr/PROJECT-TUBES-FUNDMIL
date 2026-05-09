@php
    $active = $active ?? '';
    $sidebarUser = auth()->user();
    $sidebarInstansi = $instansi ?? $sidebarUser?->instansi;
    $sidebarBrandName = $sidebarInstansi?->nama ?: ($sidebarUser?->nama_instansi ?: 'FUNDMIL SOREANG');
    $items = $items ?? [
        ['key' => 'dashboard', 'label' => 'Beranda', 'icon' => 'bi-house-door-fill', 'route' => 'dashboard.admin', 'pattern' => 'dashboard.admin'],
        ['key' => 'profil', 'label' => 'Profil Instansi', 'icon' => 'bi-bank2', 'route' => 'profil-instansi.index', 'pattern' => 'profil-instansi.*'],
        ['key' => 'kategori', 'label' => 'Kategori Dana', 'icon' => 'bi-tags-fill', 'route' => 'kategori-dana.index', 'pattern' => 'kategori-dana.*'],
        ['key' => 'pemasukan', 'label' => 'Pemasukan Zakat', 'icon' => 'bi-cash-stack', 'route' => 'pemasukan.index', 'pattern' => 'pemasukan.*'],
        ['key' => 'mustahik', 'label' => 'Data Mustahik', 'icon' => 'bi-people-fill', 'route' => 'mustahik.index', 'pattern' => 'mustahik.*'],
        ['key' => 'program', 'label' => 'Program Penyaluran', 'icon' => 'bi-stars', 'route' => 'program-penyaluran.index', 'pattern' => 'program-penyaluran.*'],
        ['key' => 'distribusi', 'label' => 'Pengaturan Distribusi', 'icon' => 'bi-sliders2', 'route' => 'pengaturan-distribusi.index', 'pattern' => 'pengaturan-distribusi.*'],
        ['key' => 'penyaluran', 'label' => 'Penyaluran Zakat', 'icon' => 'bi-send-check-fill', 'route' => 'penyaluran.index', 'pattern' => 'penyaluran.*'],
        ['key' => 'laporan', 'label' => 'Laporan', 'icon' => 'bi-bar-chart-fill', 'route' => 'laporan.index', 'pattern' => 'laporan.*'],
    ];
    $ariaLabel = $ariaLabel ?? 'Navigasi Admin Instansi';
@endphp

@once
    <style>
        .admin-sidebar {
            min-height: 100vh;
            width: 88px;
            padding: 20px 12px 24px;
            background: #f0f3f1;
            border-right: 1px solid #e9eeea;
            display: flex;
            flex: 0 0 auto;
            flex-direction: column;
            overflow-x: hidden;
            transition: width .25s ease, padding .25s ease;
        }

        body.sidebar-expanded .admin-sidebar {
            width: 280px;
            padding: 34px 18px 28px;
        }

        .admin-sidebar .brand {
            min-height: 52px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            overflow: hidden;
        }

        body.sidebar-expanded .admin-sidebar .brand {
            justify-content: flex-start;
            padding: 0 18px;
        }

        .admin-sidebar .brand-icon {
            width: 28px;
            height: 28px;
            border-radius: 10px;
            background: #07651f;
            color: #fff;
            display: grid;
            place-items: center;
            flex: 0 0 auto;
        }

        .admin-sidebar .brand-copy {
            min-width: 0;
            display: none;
            white-space: nowrap;
        }

        body.sidebar-expanded .admin-sidebar .brand-copy {
            display: block;
        }

        .admin-sidebar .brand-title {
            margin-bottom: 6px;
            color: #053f24;
            font-size: 1.2rem;
            font-weight: 900;
            line-height: 1;
            white-space: nowrap;
        }

        .admin-sidebar .brand-subtitle {
            color: #a0a8a2;
            font-size: .62rem;
            font-weight: 800;
            letter-spacing: .18em;
            line-height: 1.2;
            white-space: nowrap;
        }

        .admin-sidebar .sidebar-nav {
            margin-top: 34px;
            display: grid;
            gap: 6px;
            transition: margin-top .25s ease;
        }

        body.sidebar-expanded .admin-sidebar .sidebar-nav {
            margin-top: 44px;
        }

        .admin-sidebar .sidebar-toggle,
        .admin-sidebar .nav-item-link {
            width: 58px;
            height: 52px;
            min-height: 52px;
            margin-left: auto;
            margin-right: auto;
            border: 0;
            border-radius: 14px;
            background: transparent;
            color: #263b52;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            padding: 0;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
            overflow: hidden;
            transition: background .2s ease, color .2s ease, width .25s ease, padding .25s ease;
        }

        body.sidebar-expanded .admin-sidebar .sidebar-toggle,
        body.sidebar-expanded .admin-sidebar .nav-item-link {
            width: 100%;
            padding: 0 16px;
            justify-content: flex-start;
        }

        .admin-sidebar .nav-item-link:hover,
        .admin-sidebar .nav-item-link.active {
            background: #fff;
            color: #07651f;
        }

        .admin-sidebar .sidebar-toggle:hover {
            background: rgba(7, 101, 31, .08);
            color: #07651f;
        }

        .admin-sidebar .nav-item-link.active {
            background: #fff;
            box-shadow: inset 4px 0 0 #07651f;
        }

        .admin-sidebar .sidebar-toggle i,
        .admin-sidebar .nav-item-link i {
            width: 24px;
            color: #053f24;
            font-size: 1.25rem;
            text-align: center;
            flex: 0 0 auto;
        }

        .admin-sidebar .nav-item-link.active i {
            color: #07651f;
        }

        .admin-sidebar .nav-item-link span,
        .admin-sidebar .sidebar-toggle span {
            display: none;
        }

        body.sidebar-expanded .admin-sidebar .nav-item-link span,
        body.sidebar-expanded .admin-sidebar .sidebar-toggle span {
            display: inline;
        }

        .admin-sidebar .sidebar-footer {
            margin-top: auto;
            border-top: 1px solid #e9eeea;
            padding-top: 14px;
            display: grid;
            gap: 8px;
        }

        @media (max-width: 900px) {
            .admin-sidebar {
                display: none;
            }
        }
    </style>
@endonce

<aside class="sidebar admin-sidebar">
    <div class="brand">
        <div class="brand-copy">
            <div class="brand-title">{{ $sidebarBrandName }}</div>
            <div class="brand-subtitle">SISTEM AMANAH DIGITAL</div>
        </div>
    </div>

    <nav class="sidebar-nav" aria-label="{{ $ariaLabel }}">
        <button id="sidebarToggle" class="sidebar-toggle" type="button">
            <i class="bi bi-list"></i>
            <span>Menu</span>
        </button>

        @foreach ($items as $item)
            <a class="nav-item-link {{ $active === $item['key'] || request()->routeIs($item['pattern']) ? 'active' : '' }}" href="{{ route($item['route']) }}">
                <i class="bi {{ $item['icon'] }}"></i>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="sidebar-footer">
        <a class="nav-item-link" href="#">
            <i class="bi bi-question-circle-fill"></i>
            <span>Bantuan</span>
        </a>
    </div>
</aside>
