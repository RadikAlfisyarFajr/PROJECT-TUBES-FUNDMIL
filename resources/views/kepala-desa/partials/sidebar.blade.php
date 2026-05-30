@php
    $items = [
        ['key' => 'dashboard', 'label' => 'Pusat Pelacakan Desa', 'icon' => 'bi-graph-up-arrow', 'route' => 'kepala-desa.dashboard', 'pattern' => 'kepala-desa.dashboard'],
        ['key' => 'approval', 'label' => 'Approval Program', 'icon' => 'bi-clipboard-check-fill', 'route' => 'kepala-desa.approval.index', 'pattern' => 'kepala-desa.approval.*'],
    ];
@endphp

@include('admin.partials.sidebar', [
    'active' => $active ?? '',
    'items' => $items,
    'ariaLabel' => 'Navigasi Admin Kepala Desa',
])
