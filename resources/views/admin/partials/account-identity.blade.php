@php
    $accountUser = auth()->user();
    $accountInstansi = $instansi ?? $accountUser?->instansi;
    $accountName = $accountInstansi?->nama
        ?: ($accountUser?->nama_instansi ?: ($accountUser?->name ?: 'Admin Instansi'));
    $accountRole = $accountInstansi?->tipe ?: 'Admin Instansi';
    $accountLogo = $accountInstansi?->logo;
    $accountInitials = collect(preg_split('/\s+/', trim($accountName)))
        ->filter()
        ->take(2)
        ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
        ->implode('');
    $accountInitials = $accountInitials ?: 'A';
    $nameClass = $nameClass ?? 'admin-user-name';
    $roleClass = $roleClass ?? 'admin-user-role';
    $avatarClass = $avatarClass ?? 'admin-avatar';
    $imageClass = $imageClass ?? '';
@endphp

<div class="{{ $nameClass }}">
    <strong>{{ $accountName }}</strong>
    <div class="{{ $roleClass }}">{{ $accountRole }}</div>
</div>
<div class="{{ $avatarClass }}">
    @if ($accountLogo)
        <img class="{{ $imageClass }}" src="{{ asset('storage/'.$accountLogo) }}" alt="Logo {{ $accountName }}">
    @else
        {{ $accountInitials }}
    @endif
</div>
