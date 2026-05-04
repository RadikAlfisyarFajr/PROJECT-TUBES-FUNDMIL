@php
    $active = $active ?? '';
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

<aside class="sidebar admin-sidebar">
    <div class="brand">
        <div class="brand-icon">
            <i class="bi bi-shield-lock-fill"></i>
        </div>
        <div class="brand-copy">
            <div class="brand-title">FUNDMIL SOREANG</div>
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
