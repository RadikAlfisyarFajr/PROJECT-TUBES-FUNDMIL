@php
    $items = [
        ['key' => 'dashboard', 'label' => 'Dashboard Global', 'icon' => 'bi-speedometer2', 'route' => 'dashboard.superadmin', 'pattern' => 'dashboard.superadmin'],
        ['key' => 'instansi', 'label' => 'Akun Desa', 'icon' => 'bi-bank2', 'route' => 'superadmin.instansi.index', 'pattern' => 'superadmin.instansi.*'],
        ['key' => 'approval-admin', 'label' => 'Verifikasi Instansi', 'icon' => 'bi-person-check-fill', 'route' => 'superadmin.approval-admin-instansi.index', 'pattern' => 'superadmin.approval-admin-instansi.*'],
        ['key' => 'harga-beras', 'label' => 'Harga Beras', 'icon' => 'bi-basket2-fill', 'route' => 'superadmin.harga-beras.index', 'pattern' => 'superadmin.harga-beras.*'],
        ['key' => 'nishab', 'label' => 'Nishab', 'icon' => 'bi-gem', 'route' => 'superadmin.nishab.index', 'pattern' => 'superadmin.nishab.*'],
    ];
@endphp

@include('admin.partials.sidebar', [
    'active' => $active ?? '',
    'items' => $items,
    'ariaLabel' => 'Navigasi Super Admin',
])
