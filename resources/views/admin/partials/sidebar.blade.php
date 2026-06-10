@php
$active = $active ?? '';
$sidebarUser = auth()->user();
$sidebarInstansi = $instansi ?? $sidebarUser?->instansi;
$sidebarBrandName = $sidebarInstansi?->nama ?: ($sidebarUser?->nama_instansi ?: 'FUNDMIL SOREANG');
$sidebarRole = $sidebarUser?->role ?? null;
$defaultItems = match ($sidebarRole) {
\App\Models\User::ROLE_SUPER_ADMIN => [
['key' => 'dashboard', 'label' => 'Dashboard Global', 'icon' => 'bi-speedometer2', 'route' => 'dashboard.superadmin', 'pattern' => 'dashboard.superadmin'],
['key' => 'instansi', 'label' => 'Akun Desa', 'icon' => 'bi-bank2', 'route' => 'superadmin.instansi.index', 'pattern' => 'superadmin.instansi.*'],
['key' => 'approval-admin', 'label' => 'Verifikasi Instansi', 'icon' => 'bi-person-check-fill', 'route' => 'superadmin.approval-admin-instansi.index', 'pattern' => 'superadmin.approval-admin-instansi.*'],
['key' => 'harga-beras', 'label' => 'Harga Beras', 'icon' => 'bi-basket2-fill', 'route' => 'superadmin.harga-beras.index', 'pattern' => 'superadmin.harga-beras.*'],
['key' => 'nishab', 'label' => 'Nishab', 'icon' => 'bi-gem', 'route' => 'superadmin.nishab.index', 'pattern' => 'superadmin.nishab.*'],
],
\App\Models\User::ROLE_ADMIN_KEPALA_DESA => [
['key' => 'dashboard', 'label' => 'Pusat Pelacakan Desa', 'icon' => 'bi-graph-up-arrow', 'route' => 'kepala-desa.dashboard', 'pattern' => 'kepala-desa.dashboard'],
['key' => 'approval', 'label' => 'Approval Program', 'icon' => 'bi-clipboard-check-fill', 'route' => 'kepala-desa.approval.index', 'pattern' => 'kepala-desa.approval.*'],
],
default => [
['key' => 'dashboard', 'label' => 'Beranda', 'icon' => 'bi-house-door-fill', 'route' => 'dashboard.admin', 'pattern' => 'dashboard.admin'],
['key' => 'profil', 'label' => 'Profil Instansi', 'icon' => 'bi-bank2', 'route' => 'profil-instansi.index', 'pattern' => 'profil-instansi.*'],
['key' => 'kategori', 'label' => 'Kategori Dana', 'icon' => 'bi-tags-fill', 'route' => 'kategori-dana.index', 'pattern' => 'kategori-dana.*'],
['key' => 'pemasukan', 'label' => 'Pemasukan Zakat', 'icon' => 'bi-cash-stack', 'route' => 'pemasukan.index', 'pattern' => 'pemasukan.*'],
['key' => 'mustahik', 'label' => 'Data Mustahik', 'icon' => 'bi-people-fill', 'route' => 'mustahik.index', 'pattern' => 'mustahik.*'],
['key' => 'program', 'label' => 'Program Penyaluran', 'icon' => 'bi-stars', 'route' => 'program-penyaluran.index', 'pattern' => 'program-penyaluran.*'],
['key' => 'distribusi', 'label' => 'Pengaturan Distribusi', 'icon' => 'bi-sliders2', 'route' => 'pengaturan-distribusi.index', 'pattern' => 'pengaturan-distribusi.*'],
['key' => 'penyaluran', 'label' => 'Penyaluran Zakat', 'icon' => 'bi-send-check-fill', 'route' => 'penyaluran.index', 'pattern' => 'penyaluran.*'],
['key' => 'laporan', 'label' => 'Laporan', 'icon' => 'bi-bar-chart-fill', 'route' => 'laporan.index', 'pattern' => 'laporan.*'],
],
};
$items = collect($items ?? $defaultItems)
->filter(fn ($item) => isset($item['route'], $item['key'], $item['label'], $item['icon'], $item['pattern']))
->values()
->all();
$ariaLabel = $ariaLabel ?? 'Navigasi Admin Instansi';
@endphp

<aside class="sidebar admin-sidebar">
    <div class="brand">
        <img class="brand-icon" src="{{ asset('assets/logo_amil.png') }}" alt="Logo UNFMIL Amil Beras">
    </div>

    <nav class="sidebar-nav" aria-label="{{ $ariaLabel }}">
        <button id="sidebarToggle" class="sidebar-toggle" type="button" onclick="event.stopImmediatePropagation(); document.body.classList.toggle('sidebar-expanded');">
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
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="nav-item-link">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>