@php
    $instansi = $user->instansi;
    $mapsQuery = trim(($instansi?->alamat ?? '') . ' ' . ($instansi?->kelurahan ?? $user->desa) . ' Soreang Bandung');
    $searchQuery = trim(($instansi?->nama ?? $user->nama_instansi) . ' ' . ($instansi?->nomor_sk ?? '') . ' Soreang');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Verifikasi | Super Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>
<body class="sidebar-expanded">
    <div class="admin-layout">
        @include('superadmin.partials.sidebar', ['active' => 'approval-admin'])

        <main class="admin-page-content">
            <header class="admin-page-topbar">
                <div>
                    <h1 class="admin-page-title">Detail Verifikasi</h1>
                    <p class="admin-page-desc">{{ $instansi?->nama ?? $user->nama_instansi ?? $user->name }}</p>
                </div>
                <div class="admin-top-actions">
                    <a class="admin-secondary-btn" href="{{ route('superadmin.approval-admin-instansi.index') }}">
                        <i class="bi bi-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </header>

            <div class="admin-content-wrap">
                @if($errors->any())
                    <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">{{ $errors->first() }}</div>
                @endif

                <section class="super-grid">
                    <div class="admin-panel">
                        <h2 class="super-section-title">Identitas Lembaga</h2>
                        <dl class="super-detail-list">
                            <div><dt>Nama</dt><dd>{{ $instansi?->nama ?? '-' }}</dd></div>
                            <div><dt>Tipe</dt><dd>{{ $instansi?->tipe ?? '-' }}</dd></div>
                            <div><dt>Desa</dt><dd>{{ $instansi?->kelurahan ?? $user->desa ?? '-' }}</dd></div>
                            <div><dt>Alamat</dt><dd>{{ $instansi?->alamat ?? '-' }}</dd></div>
                            <div><dt>Pimpinan</dt><dd>{{ $instansi?->nama_pimpinan ?? $user->name }}</dd></div>
                            <div><dt>Email</dt><dd>{{ $user->email }}</dd></div>
                            <div><dt>Kontak</dt><dd>{{ $instansi?->kontak ?? '-' }}</dd></div>
                            <div><dt>Nomor SK</dt><dd>{{ $instansi?->nomor_sk ?? '-' }}</dd></div>
                            <div><dt>Masa Berlaku</dt><dd>{{ $instansi?->masa_berlaku?->format('d M Y') ?? '-' }}</dd></div>
                        </dl>

                        <div class="d-flex flex-wrap gap-2 mt-4">
                            <a class="admin-secondary-btn" href="https://www.google.com/search?q={{ urlencode($searchQuery) }}" target="_blank" rel="noopener">
                                <i class="bi bi-search"></i>
                                <span>Cari Nama/SK</span>
                            </a>
                            <a class="admin-secondary-btn" href="https://www.google.com/maps/search/?api=1&query={{ urlencode($mapsQuery) }}" target="_blank" rel="noopener">
                                <i class="bi bi-geo-alt-fill"></i>
                                <span>Cek Lokasi</span>
                            </a>
                            @if($instansi?->kontak)
                                <a class="admin-secondary-btn" href="tel:{{ preg_replace('/\s+/', '', $instansi->kontak) }}">
                                    <i class="bi bi-telephone-fill"></i>
                                    <span>Hubungi</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="admin-panel">
                        <h2 class="super-section-title">Checklist Keamanan</h2>
                        <div class="super-check-list">
                            @foreach($checklist as $item)
                                <div class="{{ $item['ok'] ? 'is-ok' : 'is-bad' }}">
                                    <i class="bi {{ $item['ok'] ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }}"></i>
                                    <span>{{ $item['label'] }}</span>
                                </div>
                            @endforeach
                        </div>

                        <form method="POST" action="{{ route('superadmin.approval-admin-instansi.approve', $user) }}" class="mt-4">
                            @csrf
                            <label class="distribution-label" for="verification_note">Catatan Verifikasi</label>
                            <textarea id="verification_note" name="verification_note" class="distribution-textarea" placeholder="Contoh: SK cocok, alamat terverifikasi, kontak aktif.">{{ old('verification_note') }}</textarea>
                            <label class="super-verify-box mt-3">
                                <input type="checkbox" name="verified" value="1">
                                <span>Saya sudah mengecek legalitas, alamat, dan kontak lembaga.</span>
                            </label>
                            <button class="distribution-submit-btn w-100 mt-3" type="submit">
                                <i class="bi bi-shield-check"></i>
                                <span>Setujui dan Aktifkan</span>
                            </button>
                        </form>

                        <form method="POST" action="{{ route('superadmin.approval-admin-instansi.reject', $user) }}" class="mt-3">
                            @csrf
                            <label class="distribution-label" for="reject_note">Alasan Penolakan</label>
                            <textarea id="reject_note" name="verification_note" class="distribution-textarea" required placeholder="Tuliskan alasan penolakan agar ada jejak audit.">{{ old('verification_note') }}</textarea>
                            <button class="super-danger-btn w-100 mt-3" type="submit">
                                <i class="bi bi-x-lg"></i>
                                <span>Tolak Pengajuan</span>
                            </button>
                        </form>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', () => {
            document.body.classList.toggle('sidebar-expanded');
        });
    </script>
</body>
</html>
