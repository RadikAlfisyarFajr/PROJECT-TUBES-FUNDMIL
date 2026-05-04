@php
    $items = [
        ['key' => 'approval-admin', 'label' => 'Approval Admin', 'icon' => 'bi-person-check-fill', 'route' => 'dashboard.superadmin', 'pattern' => 'dashboard.superadmin'],
        ['key' => 'instansi', 'label' => 'Instansi', 'icon' => 'bi-bank2', 'route' => 'superadmin.instansi.index', 'pattern' => 'superadmin.instansi.*'],
        ['key' => 'pengguna', 'label' => 'Pengguna', 'icon' => 'bi-people-fill', 'route' => 'superadmin.pengguna.index', 'pattern' => 'superadmin.pengguna.*'],
        ['key' => 'harga-beras', 'label' => 'Harga Beras', 'icon' => 'bi-basket2-fill', 'route' => 'superadmin.harga-beras.index', 'pattern' => 'superadmin.harga-beras.*'],
        ['key' => 'nishab', 'label' => 'Nishab', 'icon' => 'bi-gem', 'route' => 'superadmin.nishab.index', 'pattern' => 'superadmin.nishab.*'],
        ['key' => 'approval-program', 'label' => 'Approval Program', 'icon' => 'bi-clipboard2-check-fill', 'route' => 'superadmin.approval-program-penyaluran.index', 'pattern' => 'superadmin.approval-program-penyaluran.*'],
        ['key' => 'monitoring', 'label' => 'Monitoring', 'icon' => 'bi-graph-up-arrow', 'route' => 'superadmin.monitoring.index', 'pattern' => 'superadmin.monitoring.*'],
    ];
@endphp

@include('admin.partials.sidebar', [
    'active' => $active ?? '',
    'items' => $items,
    'ariaLabel' => 'Navigasi Super Admin',
])
