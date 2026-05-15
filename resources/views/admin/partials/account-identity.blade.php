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

<style>
    .account-profile {
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
    }

    .account-dropdown {
        position: relative;
    }

    .account-dropdown summary {
        cursor: pointer;
        list-style: none;
    }

    .account-dropdown summary::-webkit-details-marker {
        display: none;
    }

    .account-dropdown-menu {
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        width: 190px;
        padding: 8px;
        border: 1px solid #e2ebe4;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 18px 38px rgba(20, 47, 27, .13);
        z-index: 30;
    }

    .account-dropdown-item {
        width: 100%;
        min-height: 40px;
        padding: 0 10px;
        border: 0;
        border-radius: 10px;
        background: transparent;
        color: #26352b;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: .84rem;
        font-weight: 800;
        text-decoration: none;
        text-align: left;
    }

    .account-dropdown-item:hover {
        background: #eaf3eb;
        color: #0f722b;
    }

    .account-dropdown-item.logout {
        color: #b42318;
    }

    .account-dropdown-item.logout:hover {
        background: #fff0ee;
        color: #9f1f14;
    }
</style>

<div class="account-profile">
    <div class="{{ $nameClass }}">
        <strong>{{ $accountName }}</strong>
        <div class="{{ $roleClass }}">{{ $accountRole }}</div>
    </div>
    <details class="account-dropdown">
        <summary class="{{ $avatarClass }}" aria-label="Buka menu profil">
            @if ($accountLogo)
                <img class="{{ $imageClass }}" src="{{ asset('storage/'.$accountLogo) }}" alt="Logo {{ $accountName }}">
            @else
                {{ $accountInitials }}
            @endif
        </summary>
        <div class="account-dropdown-menu">
            <a class="account-dropdown-item" href="{{ route('profil-instansi.index') }}">
                <i class="bi bi-person-circle"></i>
                <span>Lihat Profile</span>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="account-dropdown-item logout" type="submit">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout Akun</span>
                </button>
            </form>
        </div>
    </details>
</div>
