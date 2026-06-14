@php
$title = 'Bukti Pembayaran';
$trx = $trx ?? null;
$items = $items ?? [];
$admin = $admin ?? auth()->user();
$instansi = $instansi ?? null;
$total = $total ?? 0;

// Terbilang (angka ke huruf Indonesia)
function terbilang($angka) {
$angka = abs($angka);
$huruf = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
if ($angka < 12) return $huruf[$angka];
    if ($angka < 20) return terbilang($angka - 10) . ' Belas' ;
    if ($angka < 100) return terbilang(intdiv($angka, 10)) . ' Puluh' . ($angka % 10 ? ' ' . terbilang($angka % 10) : '' );
    if ($angka < 200) return 'Seratus' . ($angka - 100 ? ' ' . terbilang($angka - 100) : '' );
    if ($angka < 1000) return terbilang(intdiv($angka, 100)) . ' Ratus' . ($angka % 100 ? ' ' . terbilang($angka % 100) : '' );
    if ($angka < 2000) return 'Seribu' . ($angka - 1000 ? ' ' . terbilang($angka - 1000) : '' );
    if ($angka < 1000000) return terbilang(intdiv($angka, 1000)) . ' Ribu' . ($angka % 1000 ? ' ' . terbilang($angka % 1000) : '' );
    if ($angka < 1000000000) return terbilang(intdiv($angka, 1000000)) . ' Juta' . ($angka % 1000000 ? ' ' . terbilang($angka % 1000000) : '' );
    if ($angka < 1000000000000) return terbilang(intdiv($angka, 1000000000)) . ' Miliar' . ($angka % 1000000000 ? ' ' . terbilang($angka % 1000000000) : '' );
    return terbilang(intdiv($angka, 1000000000000)) . ' Triliun' . ($angka % 1000000000000 ? ' ' . terbilang($angka % 1000000000000) : '' );
    }

    $terbilangText=$total> 0 ? '"' . terbilang($total) . ' Rupiah"' : '"Nol Rupiah"';

    $namaInstansi = $instansi->nama ?? 'FUNDMIL SOREANG';
    $alamatInstansi = $instansi->alamat ?? 'Jl. Raya Soreang No. 124, Bandung, Jawa Barat';
    $kontakInstansi = $instansi->kontak ?? '(022) 5891234';
    $emailInstansi = $instansi->email ?? 'zakat@mosque-soreang.id';
    $namaPimpinan = $instansi->nama_pimpinan ?? $admin->name ?? 'Admin Amil';

    $tanggalFormatted = $trx ? \Carbon\Carbon::parse($trx->tanggal)->translatedFormat('d M Y') : now()->translatedFormat('d M Y');
    $waktuFormatted = $trx ? \Carbon\Carbon::parse($trx->created_at)->format('H:i') . ' WIB' : now()->format('H:i') . ' WIB';
    $nomorKuitansi = $trx->nomor_kuitansi ?? '-';
    @endphp

    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title }} — {{ $nomorKuitansi }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
        <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
        <style>
            @import url('https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap');
            @import url('https://fonts.bunny.net/css?family=amiri:400,700&display=swap');

            .struk-page-wrap {
                max-width: 1180px;
                margin: 0 auto;
            }

            .struk-page-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 28px;
            }

            .struk-page-header h1 {
                margin: 0;
                font-size: 1.8rem;
                font-weight: 900;
            }

            .struk-page-header p {
                margin: 4px 0 0;
                color: #536058;
            }

            .struk-actions-top {
                display: flex;
                gap: 10px;
            }

            .btn-share {
                min-height: 42px;
                border: 1px solid #dce5df;
                border-radius: 14px;
                background: #fff;
                color: #263b52;
                padding: 0 18px;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                font-weight: 800;
                cursor: pointer;
                text-decoration: none;
                font-family: var(--admin-font-sans);
                font-size: .88rem;
            }

            .btn-share:hover {
                background: #e8f4ec;
                color: #07651f;
                border-color: #b8d9c0;
            }

            .btn-cetak {
                min-height: 42px;
                border: 0;
                border-radius: 14px;
                background: linear-gradient(135deg, #07651f 0%, #0a8a2e 100%);
                color: #fff;
                padding: 0 22px;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                font-weight: 800;
                cursor: pointer;
                text-decoration: none;
                font-family: var(--admin-font-sans);
                font-size: .88rem;
                box-shadow: 0 8px 20px rgba(7, 101, 31, .22);
                transition: all .2s ease;
            }

            .btn-cetak:hover {
                transform: translateY(-1px);
                box-shadow: 0 12px 28px rgba(7, 101, 31, .32);
            }

            /* ─── Struk Card ─── */
            .struk-card {
                max-width: 620px;
                margin: 0 auto 32px;
                border: 1px solid #e0e8e2;
                border-radius: 22px;
                background: #fff;
                box-shadow: 0 20px 60px rgba(20, 47, 27, .08);
                overflow: hidden;
                position: relative;
            }

            .struk-inner {
                padding: 0 36px 36px;
                position: relative;
            }

            /* ─── Watermark Logo ─── */
            .struk-watermark {
                width: 100%;
                display: flex;
                justify-content: center;
                padding: 28px 36px 0;
                position: relative;
            }

            .struk-watermark img {
                width: 200px;
                height: auto;
                opacity: .12;
                filter: grayscale(40%);
            }

            .struk-verified-badge {
                position: absolute;
                top: 32px;
                right: 36px;
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 5px 12px;
                border-radius: 999px;
                background: #e8f4ec;
                color: #07651f;
                font-size: .68rem;
                font-weight: 900;
                text-transform: uppercase;
                letter-spacing: .04em;
            }

            .struk-verified-badge i {
                font-size: .72rem;
            }

            /* ─── Identitas Instansi ─── */
            .struk-instansi {
                text-align: center;
                margin-top: -10px;
                margin-bottom: 28px;
            }

            .struk-instansi-icon {
                width: 56px;
                height: 56px;
                border-radius: 16px;
                background: #e8f4ec;
                color: #07651f;
                display: inline-grid;
                place-items: center;
                font-size: 1.5rem;
                margin-bottom: 12px;
            }

            .struk-instansi-name {
                margin: 0;
                font-size: 1.35rem;
                font-weight: 900;
                color: #053f24;
                letter-spacing: .02em;
            }

            .struk-instansi-sub {
                margin: 3px 0 0;
                font-size: .72rem;
                font-weight: 800;
                color: #6c756f;
                letter-spacing: .16em;
                text-transform: uppercase;
            }

            .struk-instansi-address {
                margin: 10px 0 0;
                font-size: .82rem;
                color: #4c574f;
                line-height: 1.5;
            }

            .struk-instansi-contact {
                margin: 3px 0 0;
                font-size: .76rem;
                color: #07651f;
            }

            /* ─── Divider ─── */
            .struk-divider {
                border: 0;
                border-top: 1.5px dashed #d8e2da;
                margin: 22px 0;
            }

            .struk-divider-solid {
                border: 0;
                border-top: 1px solid #e9eeea;
                margin: 20px 0;
            }

            /* ─── Info Grid ─── */
            .struk-info-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 14px;
            }

            .struk-info-item label {
                display: block;
                font-size: .66rem;
                font-weight: 900;
                color: #9b9894;
                text-transform: uppercase;
                letter-spacing: .08em;
                margin-bottom: 4px;
            }

            .struk-info-item span {
                display: block;
                font-size: .92rem;
                font-weight: 800;
                color: #142017;
            }

            /* ─── Rincian Alokasi ─── */
            .struk-section-label {
                font-size: .66rem;
                font-weight: 900;
                color: #9b9894;
                text-transform: uppercase;
                letter-spacing: .1em;
                margin-bottom: 14px;
            }

            .struk-alokasi-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 14px;
                padding: 14px 0;
            }

            .struk-alokasi-left {
                display: flex;
                align-items: center;
                gap: 14px;
            }

            .struk-alokasi-icon {
                width: 44px;
                height: 44px;
                border-radius: 14px;
                background: #e8f4ec;
                color: #07651f;
                display: grid;
                place-items: center;
                font-size: 1.15rem;
                flex: 0 0 auto;
            }

            .struk-alokasi-icon.is-fidyah {
                background: #f4eee4;
                color: #8a5a15;
            }

            .struk-alokasi-name {
                margin: 0;
                font-size: .95rem;
                font-weight: 800;
                color: #142017;
            }

            .struk-alokasi-sub {
                margin: 2px 0 0;
                font-size: .76rem;
                color: #6c756f;
            }

            .struk-alokasi-amount {
                font-size: 1.05rem;
                font-weight: 900;
                color: #07651f;
                white-space: nowrap;
            }

            /* ─── Total Box ─── */
            .struk-total-box {
                margin: 22px 0;
                padding: 22px 28px;
                border-radius: 18px;
                background: linear-gradient(135deg, #07651f 0%, #0a8a2e 50%, #07651f 100%);
                background-size: 200% 200%;
                animation: shimmer 4s ease-in-out infinite;
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            @keyframes shimmer {

                0%,
                100% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }
            }

            .struk-total-label {
                font-size: .68rem;
                font-weight: 900;
                text-transform: uppercase;
                letter-spacing: .12em;
                margin-bottom: 6px;
                opacity: .85;
            }

            .struk-total-value {
                margin: 0;
                font-size: 1.8rem;
                font-weight: 900;
                letter-spacing: -.01em;
            }

            .struk-total-copy {
                width: 44px;
                height: 44px;
                border: 2px solid rgba(255, 255, 255, .25);
                border-radius: 14px;
                background: rgba(255, 255, 255, .12);
                color: #fff;
                display: grid;
                place-items: center;
                cursor: pointer;
                font-size: 1.1rem;
                transition: all .2s ease;
                flex: 0 0 auto;
            }

            .struk-total-copy:hover {
                background: rgba(255, 255, 255, .25);
                border-color: rgba(255, 255, 255, .45);
            }

            /* ─── Terbilang ─── */
            .struk-terbilang {
                text-align: center;
            }

            .struk-terbilang-label {
                font-size: .66rem;
                font-weight: 900;
                color: #9b9894;
                text-transform: uppercase;
                letter-spacing: .1em;
                margin-bottom: 6px;
            }

            .struk-terbilang-text {
                font-size: .88rem;
                font-style: italic;
                color: #3a4a3e;
                font-weight: 600;
            }

            /* ─── Verifikasi & Tanda Tangan ─── */
            .struk-verify-row {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 24px;
                margin-top: 24px;
            }

            .struk-verify-section label,
            .struk-sign-section label {
                display: block;
                font-size: .66rem;
                font-weight: 900;
                color: #9b9894;
                text-transform: uppercase;
                letter-spacing: .08em;
                margin-bottom: 10px;
            }

            .struk-qr-wrap {
                display: flex;
                align-items: flex-start;
                gap: 12px;
            }

            .struk-qr-box {
                width: 72px;
                height: 72px;
                border: 2px solid #d8e2da;
                border-radius: 14px;
                background: #f6f8f6;
                display: grid;
                place-items: center;
                flex: 0 0 auto;
                overflow: hidden;
            }

            .struk-qr-box img {
                width: 100%;
                height: 100%;
                object-fit: contain;
            }

            .struk-qr-desc {
                font-size: .72rem;
                color: #6c756f;
                line-height: 1.55;
            }

            .struk-qr-desc strong {
                display: block;
                color: #142017;
                margin-bottom: 3px;
                font-size: .74rem;
            }

            .struk-sign-box {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .struk-sign-image {
                width: 72px;
                height: 52px;
                border: 2px solid #d8e2da;
                border-radius: 10px;
                background: #f6f8f6;
                display: grid;
                place-items: center;
                margin-bottom: 8px;
                overflow: hidden;
            }

            .struk-sign-image img {
                max-width: 60px;
                max-height: 40px;
                object-fit: contain;
            }

            .struk-sign-name {
                font-size: .82rem;
                font-weight: 900;
                color: #142017;
                margin: 0;
            }

            .struk-sign-id {
                font-size: .68rem;
                color: #9b9894;
                margin: 2px 0 0;
            }

            /* ─── Doa Section ─── */
            .struk-doa-wrap {
                margin: 24px 0 0;
                border-radius: 18px;
                background: linear-gradient(135deg, #f0f7f1 0%, #e4f0e8 100%);
                border: 1px solid #d0e2d4;
                padding: 28px 24px;
                text-align: center;
            }

            .struk-doa-title {
                font-size: .7rem;
                font-weight: 900;
                color: #07651f;
                text-transform: uppercase;
                letter-spacing: .14em;
                margin-bottom: 14px;
            }

            .struk-doa-arabic {
                font-family: 'Amiri', serif;
                font-size: 1.45rem;
                line-height: 2;
                color: #053f24;
                direction: rtl;
                margin-bottom: 12px;
            }

            .struk-doa-latin {
                font-size: .78rem;
                font-style: italic;
                color: #4c574f;
                line-height: 1.65;
                margin-bottom: 14px;
            }

            .struk-doa-meaning {
                font-size: .82rem;
                color: #3a4a3e;
                line-height: 1.65;
            }

            .struk-jazakumullah {
                margin-top: 20px;
                font-size: 1.15rem;
                font-weight: 900;
                font-style: italic;
                color: #053f24;
            }

            .struk-closing-note {
                margin-top: 10px;
                font-size: .76rem;
                color: #6c756f;
                line-height: 1.6;
            }

            /* ─── Disclaimer ─── */
            .struk-disclaimer {
                margin-top: 18px;
                padding-top: 14px;
                border-top: 1px solid #e9eeea;
                text-align: center;
                font-size: .68rem;
                color: #9b9894;
                font-style: italic;
            }

            /* ─── Action Buttons ─── */
            .struk-bottom-actions {
                max-width: 620px;
                margin: 0 auto 48px;
                display: flex;
                justify-content: center;
                gap: 12px;
                flex-wrap: wrap;
            }

            .struk-btn-wa {
                min-height: 50px;
                border: 0;
                border-radius: 16px;
                background: linear-gradient(135deg, #07651f 0%, #0a8a2e 100%);
                color: #fff;
                padding: 0 28px;
                display: inline-flex;
                align-items: center;
                gap: 10px;
                font-weight: 800;
                font-size: .9rem;
                cursor: pointer;
                text-decoration: none;
                font-family: var(--admin-font-sans);
                box-shadow: 0 10px 24px rgba(7, 101, 31, .22);
                transition: all .2s ease;
            }

            .struk-btn-wa:hover {
                transform: translateY(-2px);
                box-shadow: 0 14px 32px rgba(7, 101, 31, .3);
                color: #fff;
            }

            .struk-btn-email,
            .struk-btn-pdf {
                min-height: 50px;
                border: 1.5px solid #dce5df;
                border-radius: 16px;
                background: #fff;
                color: #263b52;
                padding: 0 22px;
                display: inline-flex;
                align-items: center;
                gap: 10px;
                font-weight: 800;
                font-size: .9rem;
                cursor: pointer;
                text-decoration: none;
                font-family: var(--admin-font-sans);
                transition: all .2s ease;
            }

            .struk-btn-email:hover,
            .struk-btn-pdf:hover {
                background: #f0f7f1;
                border-color: #b8d9c0;
                color: #07651f;
                transform: translateY(-1px);
            }

            .struk-help-text {
                max-width: 620px;
                margin: 0 auto 32px;
                text-align: center;
                font-size: .76rem;
                color: #9b9894;
            }

            /* ─── Toast ─── */
            .copy-toast {
                position: fixed;
                bottom: 32px;
                left: 50%;
                transform: translateX(-50%) translateY(80px);
                background: #053f24;
                color: #fff;
                padding: 12px 24px;
                border-radius: 14px;
                font-weight: 800;
                font-size: .84rem;
                box-shadow: 0 12px 32px rgba(5, 63, 36, .35);
                opacity: 0;
                transition: all .35s cubic-bezier(.4, 0, .2, 1);
                z-index: 9999;
                pointer-events: none;
            }

            .copy-toast.show {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }

            /* ─── Print ─── */
            @media print {
                body {
                    background: #fff !important;
                }

                .admin-layout>*:not(main) {
                    display: none !important;
                }

                .admin-page-topbar {
                    display: none !important;
                }

                .struk-page-header {
                    display: none !important;
                }

                .struk-bottom-actions {
                    display: none !important;
                }

                .struk-help-text {
                    display: none !important;
                }

                .struk-card {
                    box-shadow: none;
                    border: 1px solid #ccc;
                }

                .admin-page-content {
                    padding: 0 !important;
                }

                .struk-page-wrap {
                    max-width: 100%;
                }
            }

            @media (max-width: 640px) {
                .struk-inner {
                    padding: 0 20px 28px;
                }

                .struk-watermark {
                    padding: 20px 20px 0;
                }

                .struk-info-grid {
                    grid-template-columns: 1fr;
                    gap: 10px;
                }

                .struk-verify-row {
                    grid-template-columns: 1fr;
                    gap: 18px;
                }

                .struk-total-value {
                    font-size: 1.4rem;
                }

                .struk-doa-arabic {
                    font-size: 1.2rem;
                }

                .struk-bottom-actions {
                    flex-direction: column;
                    align-items: stretch;
                }

                .struk-btn-wa,
                .struk-btn-email,
                .struk-btn-pdf {
                    justify-content: center;
                }
            }
        </style>
    </head>

    <body class="sidebar-expanded">
        <div class="admin-layout">
            @include('admin.partials.sidebar', ['active' => 'pemasukan'])

            <main class="admin-page-content">
                <header class="admin-page-topbar">
                    <div>
                        <h1 class="admin-page-title">Pemasukan Zakat</h1>
                        <p class="admin-page-desc">Bukti transaksi pemasukan zakat yang telah diverifikasi.</p>
                    </div>
                    <div class="admin-top-actions">
                        <button class="admin-icon-btn has-dot" type="button" aria-label="Notifikasi">
                            <i class="bi bi-bell-fill"></i>
                        </button>
                        @include('admin.partials.account-identity')
                    </div>
                </header>

                <div class="struk-page-wrap">
                    {{-- Header Halaman --}}
                    <div class="struk-page-header">
                        <div>
                            <h1>{{ $title }}</h1>
                            <p>Transaksi #{{ $nomorKuitansi }} berhasil diverifikasi</p>
                        </div>
                        <div class="struk-actions-top">
                            <a class="btn-share" href="{{ route('pemasukan.index') }}">
                                <i class="bi bi-arrow-left"></i>
                                <span>Kembali</span>
                            </a>
                            <button class="btn-cetak" onclick="window.print()">
                                <i class="bi bi-printer-fill"></i>
                                <span>Cetak Struk</span>
                            </button>
                        </div>
                    </div>

                    {{-- ═══════════════ STRUK CARD ═══════════════ --}}
                    <div class="struk-card" id="strukCard">

                        {{-- Watermark Logo --}}
                        <div class="struk-watermark">
                            <img src="{{ asset('assets/logo_amil.png') }}" alt="Watermark Logo Amil">
                            <span class="struk-verified-badge">
                                <i class="bi bi-patch-check-fill"></i>
                                TERVERIFIKASI
                            </span>
                        </div>

                        <div class="struk-inner">

                            {{-- Identitas Instansi --}}
                            <div class="struk-instansi">
                                <div class="struk-instansi-icon">
                                    <i class="bi bi-mosque"></i>
                                </div>
                                <h2 class="struk-instansi-name">{{ strtoupper($namaInstansi) }}</h2>
                                <p class="struk-instansi-sub">Sistem Amanah Digital</p>
                                <p class="struk-instansi-address">{{ $alamatInstansi }}</p>
                                <p class="struk-instansi-contact">
                                    Telp: {{ $kontakInstansi }} • Email: {{ $emailInstansi }}
                                </p>
                            </div>

                            <hr class="struk-divider">

                            {{-- Info Transaksi --}}
                            <div class="struk-info-grid">
                                <div class="struk-info-item">
                                    <label>ID Transaksi</label>
                                    <span>#{{ $nomorKuitansi }}</span>
                                </div>
                                <div class="struk-info-item" style="text-align: right;">
                                    <label>Tanggal & Waktu</label>
                                    <span>{{ $tanggalFormatted }} • {{ $waktuFormatted }}</span>
                                </div>
                                <div class="struk-info-item">
                                    <label>Nama Muzakki</label>
                                    <span>{{ $trx->nama_muzakki ?? '-' }}</span>
                                </div>
                                <div class="struk-info-item" style="text-align: right;">
                                    <label>Nama Amil</label>
                                    <span>{{ $admin->name ?? 'Admin' }}</span>
                                </div>
                                <div class="struk-info-item">
                                    <label>Wilayah</label>
                                    <span>{{ $trx->provinsi ?? '-' }}, {{ $trx->kabupaten ?? '-' }}</span>
                                </div>
                                <div class="struk-info-item" style="text-align: right;">
                                    <label>Kecamatan / Desa</label>
                                    <span>{{ $trx->kecamatan ?? '-' }} / {{ $trx->desa ?? '-' }}</span>
                                </div>
                            </div>

                            <hr class="struk-divider">

                            {{-- Rincian Alokasi --}}
                            <div class="struk-section-label">Rincian Alokasi</div>

                            @foreach ($items as $item)
                            <div class="struk-alokasi-item">
                                <div class="struk-alokasi-left">
                                    <div class="struk-alokasi-icon {{ ($item['kategori_utama'] ?? '') === 'fidyah' ? 'is-fidyah' : '' }}">
                                        <i class="bi {{ $item['icon'] ?? 'bi-tags-fill' }}"></i>
                                    </div>
                                    <div>
                                        <p class="struk-alokasi-name">{{ $item['label_kategori'] ?? '-' }}</p>
                                        @if (!empty($item['sub']))
                                        <p class="struk-alokasi-sub">Kategori: {{ ucfirst($item['sub']) }}</p>
                                        @endif
                                        @if (!empty($item['keterangan']))
                                        <p class="struk-alokasi-sub">{{ $item['keterangan'] }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="struk-alokasi-amount">
                                    Rp {{ number_format($item['subtotal'] ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                            @endforeach

                            {{-- Total --}}
                            <div class="struk-total-box">
                                <div>
                                    <div class="struk-total-label">Total Pembayaran</div>
                                    <p class="struk-total-value">Rp {{ number_format($total, 0, ',', '.') }}</p>
                                </div>
                                <button class="struk-total-copy" onclick="copyTotal()" title="Salin nominal" type="button">
                                    <i class="bi bi-clipboard"></i>
                                </button>
                            </div>

                            {{-- Terbilang --}}
                            <div class="struk-terbilang">
                                <div class="struk-terbilang-label">Terbilang</div>
                                <div class="struk-terbilang-text">{!! $terbilangText !!}</div>
                            </div>

                            <hr class="struk-divider-solid">

                            {{-- Verifikasi & Tanda Tangan --}}
                            <div class="struk-verify-row">
                                <div class="struk-verify-section">
                                    <label>Verifikasi Digital</label>
                                    <div class="struk-qr-wrap">
                                        <div class="struk-qr-box">
                                            {{-- QR Code placeholder menggunakan inline SVG --}}
                                            <svg viewBox="0 0 60 60" width="60" height="60" xmlns="http://www.w3.org/2000/svg">
                                                <rect width="60" height="60" fill="#f6f8f6" />
                                                <g fill="#07651f" opacity=".7">
                                                    <rect x="4" y="4" width="18" height="18" rx="3" />
                                                    <rect x="38" y="4" width="18" height="18" rx="3" />
                                                    <rect x="4" y="38" width="18" height="18" rx="3" />
                                                    <rect x="8" y="8" width="10" height="10" rx="1" fill="#fff" />
                                                    <rect x="42" y="8" width="10" height="10" rx="1" fill="#fff" />
                                                    <rect x="8" y="42" width="10" height="10" rx="1" fill="#fff" />
                                                    <rect x="11" y="11" width="4" height="4" rx="1" />
                                                    <rect x="45" y="11" width="4" height="4" rx="1" />
                                                    <rect x="11" y="45" width="4" height="4" rx="1" />
                                                    <rect x="26" y="4" width="4" height="4" rx="1" />
                                                    <rect x="26" y="12" width="4" height="4" rx="1" />
                                                    <rect x="26" y="26" width="4" height="4" rx="1" />
                                                    <rect x="34" y="26" width="4" height="4" rx="1" />
                                                    <rect x="26" y="34" width="4" height="4" rx="1" />
                                                    <rect x="34" y="34" width="4" height="4" rx="1" />
                                                    <rect x="42" y="26" width="4" height="4" rx="1" />
                                                    <rect x="50" y="34" width="4" height="4" rx="1" />
                                                    <rect x="26" y="42" width="4" height="4" rx="1" />
                                                    <rect x="34" y="50" width="4" height="4" rx="1" />
                                                    <rect x="42" y="42" width="4" height="4" rx="1" />
                                                    <rect x="50" y="50" width="4" height="4" rx="1" />
                                                    <rect x="4" y="26" width="4" height="4" rx="1" />
                                                    <rect x="18" y="26" width="4" height="4" rx="1" />
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="struk-qr-desc">
                                            <strong>Verifikasi Digital</strong>
                                            Scan untuk memvalidasi keaslian dokumen pada Sistem Amanah Digital.
                                        </div>
                                    </div>
                                </div>
                                <div class="struk-sign-section">
                                    <label>Tanda Tangan Amil</label>
                                    <div class="struk-sign-box">
                                        <div class="struk-sign-image">
                                            @if ($instansi && $instansi->tanda_tangan)
                                            <img src="{{ asset('storage/' . $instansi->tanda_tangan) }}" alt="Tanda Tangan">
                                            @else
                                            <i class="bi bi-pen" style="font-size: 1.2rem; color: #9b9894;"></i>
                                            @endif
                                        </div>
                                        <p class="struk-sign-name">{{ strtoupper($namaPimpinan) }}</p>
                                        <p class="struk-sign-id">NP: ADM-{{ str_pad($admin->id ?? 1, 3, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Doa Qobul --}}
                            <div class="struk-doa-wrap">
                                <div class="struk-doa-title">Doa Qobul</div>

                                <div class="struk-doa-arabic">
                                    أَجَرَكَ اللهُ فِيمَا أَعْطَيْتَ، وَبَارَكَ فِيمَا أَبْقَيْتَ، وَجَعَلَهُ لَكَ طَهُوْرًا
                                </div>

                                <div class="struk-doa-latin">
                                    <em>"Ajarakallahu fiimaa a'thoita, wa baaraka fiimaa abqoita, wa ja'alahu laka thohuuron"</em>
                                </div>

                                <div class="struk-doa-meaning">
                                    Semoga Allah memberimu pahala atas apa yang telah kau berikan,
                                    memberikan berkah atas apa yang masih kau simpan, dan
                                    menjadikannya sebagai pembersih bagimu.
                                </div>

                                <div class="struk-jazakumullah">Jazakumullah Khairan Katsiran</div>

                                <div class="struk-closing-note">
                                    Terima kasih atas kepercayaan Anda. Dana ini akan dikelola dan
                                    disalurkan secara amanah sesuai dengan prinsip Syariah Islam
                                    kepada para Mustahik yang berhak.
                                </div>
                            </div>

                            {{-- Disclaimer --}}
                            <div class="struk-disclaimer">
                                Ini adalah bukti pembayaran sah yang dihasilkan secara otomatis oleh Sistem Amanah Digital.
                            </div>

                        </div>
                    </div>

                    {{-- Tombol Aksi Bawah --}}
                    <div class="struk-bottom-actions">
                        <a class="struk-btn-wa" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $trx->nomor_wa ?? '') }}?text={{ urlencode('Assalamu\'alaikum, berikut bukti pembayaran zakat Anda. No. Kuitansi: ' . $nomorKuitansi . '. Total: Rp ' . number_format($total, 0, ',', '.') . '. Jazakumullah khairan katsiran.') }}" target="_blank">
                            <i class="bi bi-whatsapp"></i>
                            Kirim via WhatsApp
                        </a>
                        <button class="struk-btn-email" onclick="alert('Fitur kirim email akan segera tersedia.')" type="button">
                            <i class="bi bi-envelope"></i>
                            Kirim Email
                        </button>
                        <button class="struk-btn-pdf" onclick="window.print()" type="button">
                            <i class="bi bi-download"></i>
                            Download PDF
                        </button>
                    </div>

                    <div class="struk-help-text">
                        Pusat Bantuan & Pengaduan: {{ $kontakInstansi }} ({{ $namaInstansi }})
                    </div>

                </div>
            </main>
        </div>

        {{-- Toast --}}
        <div class="copy-toast" id="copyToast">Nominal berhasil disalin!</div>

        <script>
            // Sidebar toggle
            const sidebarToggle = document.getElementById('sidebarToggle');
            sidebarToggle?.addEventListener('click', () => {
                document.body.classList.toggle('sidebar-expanded');
            });

            // Copy total
            function copyTotal() {
                const totalText = 'Rp {{ number_format($total, 0, ",", ".") }}';
                navigator.clipboard.writeText(totalText).then(() => {
                    const toast = document.getElementById('copyToast');
                    toast.classList.add('show');
                    setTimeout(() => toast.classList.remove('show'), 2000);
                });
            }
        </script>
    </body>

    </html>