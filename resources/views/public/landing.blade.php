@php
$summary = $summary ?? [];
$instansiComparison = collect($instansiComparison ?? []);
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUNDMIL SOREANG | Transparansi Zakat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet">
    <style>
        :root {
            --green: #0f722b;
            --green-dark: #063d19;
            --ink: #111711;
            --muted: #687268;
            --line: #e4ebe4;
            --surface: #f4f7f4;
        }

        * {
            letter-spacing: 0;
        }

        body {
            background: #f8faf8;
            color: var(--ink);
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .site-nav {
            background: rgba(248, 250, 248, .94);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(14px);
        }

        .brand {
            align-items: center;
            display: inline-flex;
            text-decoration: none;
        }

        .brand-lockup {
            width: clamp(210px, 26vw, 286px);
            height: auto;
            display: block;
        }

        .nav-link {
            color: #263326;
            font-size: .92rem;
            font-weight: 600;
        }

        .nav-link.active {
            color: var(--green);
            border-bottom: 2px solid var(--green);
        }

        .btn-outline-darkgreen {
            border: 1.5px solid var(--green-dark);
            color: var(--green-dark);
            border-radius: 999px;
            font-weight: 700;
            padding: .55rem 1.4rem;
        }

        .btn-green {
            background: var(--green);
            color: #fff;
            border: 0;
            border-radius: 12px;
            box-shadow: 0 12px 24px rgba(15, 114, 43, .22);
            font-weight: 800;
            padding: .9rem 1.35rem;
        }

        .btn-soft {
            background: #e9eeea;
            color: #263326;
            border: 0;
            border-radius: 12px;
            font-weight: 700;
            padding: .9rem 1.35rem;
        }

        .hero {
            padding: 92px 0 72px;
        }

        .eyebrow {
            display: inline-flex;
            color: var(--green);
            background: #e5f3e8;
            border-radius: 999px;
            font-size: .75rem;
            font-weight: 800;
            padding: .35rem .75rem;
        }

        .hero h1 {
            font-size: clamp(2.8rem, 7vw, 5.8rem);
            line-height: .95;
            font-weight: 900;
        }

        .hero h1 span {
            color: var(--green);
            font-style: italic;
        }

        .hero-copy {
            color: #4f5b50;
            font-size: 1.05rem;
            max-width: 650px;
        }

        .hero-photo {
            width: 100%;
            min-height: 540px;
            object-fit: cover;
            border-radius: 28px;
            box-shadow: 0 28px 55px rgba(19, 35, 22, .18);
        }

        .section-soft {
            background: #eff3f0;
        }

        .section-pad {
            padding: 88px 0;
        }

        .stat-card,
        .program-card,
        .check-card {
            background: #fff;
            border: 1px solid #e8eee8;
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(22, 35, 24, .04);
        }

        .stat-card {
            min-height: 170px;
            border-bottom: 3px solid var(--green);
            padding: 34px;
        }

        .stat-card.is-compact {
            min-height: 140px;
            padding: 26px 28px;
        }

        .stat-icon {
            color: var(--green);
            font-size: 1.55rem;
        }

        .stat-label {
            color: #677267;
            font-size: .78rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        .stat-value {
            font-size: clamp(1.55rem, 2.8vw, 2.15rem);
            font-weight: 900;
            line-height: 1.05;
        }

        .stat-meta {
            color: #5f6b61;
            font-size: .84rem;
            font-weight: 700;
        }

        .stats-grid {
            display: grid;
            gap: 18px;
        }

        .chart-card {
            background: #fff;
            border: 1px solid #e8eee8;
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(22, 35, 24, .04);
            padding: 28px;
        }

        .chart-head {
            display: flex;
            align-items: start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 18px;
        }

        .chart-title {
            margin: 0;
            font-size: 1.15rem;
            font-weight: 900;
        }

        .chart-subtitle {
            margin: 4px 0 0;
            color: #637065;
            font-size: .92rem;
        }

        .chart-badge {
            padding: .45rem .8rem;
            border-radius: 999px;
            background: #eaf4ec;
            color: var(--green);
            font-size: .76rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .chart-wrap {
            height: 360px;
        }

        .breakdown-list {
            display: grid;
            gap: 12px;
        }

        .breakdown-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 14px;
            background: #f8faf8;
            border: 1px solid #edf3ee;
        }

        .breakdown-name {
            font-size: .86rem;
            font-weight: 800;
        }

        .breakdown-value {
            color: var(--green-dark);
            font-size: .9rem;
            font-weight: 900;
        }

        .instansi-list {
            display: grid;
            gap: 12px;
            margin-top: 18px;
        }

        .instansi-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 14px 16px;
            border-radius: 14px;
            background: #f8faf8;
            border: 1px solid #edf3ee;
        }

        .instansi-name {
            font-size: .92rem;
            font-weight: 800;
            color: var(--ink);
        }

        .instansi-meta {
            color: var(--muted);
            font-size: .8rem;
        }

        .instansi-amount {
            color: var(--green-dark);
            font-size: .95rem;
            font-weight: 900;
            white-space: nowrap;
        }

        .program-image {
            height: 190px;
            width: 100%;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }

        .program-card {
            overflow: hidden;
        }

        .program-title {
            margin-top: -44px;
            color: #fff;
            position: relative;
            z-index: 1;
            padding: 0 18px 16px;
            font-weight: 900;
            text-shadow: 0 3px 14px rgba(0, 0, 0, .45);
        }

        .program-body {
            padding: 20px;
        }

        .progress {
            height: 7px;
            background: #e4e9e4;
        }

        .progress-bar {
            background: var(--green);
        }

        .check-card {
            max-width: 860px;
            margin: 0 auto;
            padding: 54px 42px;
            position: relative;
            overflow: hidden;
        }

        .check-card::after {
            content: "\F52A";
            font-family: "bootstrap-icons";
            position: absolute;
            right: 44px;
            top: 34px;
            color: #edf0ed;
            font-size: 5rem;
        }

        .nik-input {
            min-height: 52px;
            border: 0;
            border-radius: 12px;
            background: #e9eeea;
            padding-left: 16px;
        }

        .nik-input-group .input-group-text {
            border: 0;
            background: #e9eeea;
            color: var(--muted);
            border-radius: 12px 0 0 12px;
            padding-left: 16px;
            padding-right: 12px;
        }

        .nik-input-group .nik-input {
            border-radius: 0 12px 12px 0;
        }

        .lookup-result {
            margin-top: 28px;
            border-radius: 18px;
            border: 1px solid #dfe8df;
            background: #fff;
            padding: 22px;
            text-align: left;
        }

        .lookup-result.is-hidden {
            display: none;
        }

        .lookup-status {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .35rem .75rem;
            border-radius: 999px;
            font-size: .78rem;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .lookup-status.is-aktif {
            background: #e6f5e9;
            color: #0f722b;
        }

        .lookup-status.is-tidak-aktif {
            background: #f6ecec;
            color: #a33a3a;
        }

        .lookup-title {
            font-size: 1.2rem;
            font-weight: 900;
            margin-bottom: .35rem;
        }

        .lookup-meta {
            color: #5f6b61;
            font-size: .92rem;
            margin-bottom: 18px;
        }

        .lookup-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .lookup-item {
            padding: 12px 14px;
            border-radius: 14px;
            background: #f8faf8;
            border: 1px solid #edf3ee;
        }

        .lookup-label {
            display: block;
            color: #6a756b;
            font-size: .78rem;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .lookup-value {
            color: var(--ink);
            font-weight: 800;
            word-break: break-word;
        }

        .lookup-history {
            margin-top: 16px;
            padding: 14px 16px;
            border-left: 4px solid var(--green);
            background: #f5fbf6;
            border-radius: 12px;
            color: #304133;
            font-weight: 600;
        }

        .footer {
            background: #eef3ef;
            border-top: 1px solid #dfe8df;
            color: #4d594f;
        }

        @media (max-width: 991px) {
            .hero {
                padding-top: 48px;
            }

            .hero-photo {
                min-height: 360px;
            }

            .site-nav .nav {
                display: none;
            }
        }
    </style>
</head>

<body>
    <nav class="site-nav sticky-top">
        <div class="container d-flex align-items-center justify-content-between py-3">
            <a class="brand" href="{{ route('public.home') }}">
                <img class="brand-lockup" src="{{ asset('assets/fundmil-lockup.svg') }}" alt="FUNDMIL SOREANG">
            </a>
            <div class="nav gap-4">
                <a class="nav-link active px-0" href="#beranda">Beranda</a>
                <a class="nav-link px-0" href="#statistik">Statistik</a>
                <a class="nav-link px-0" href="#program">Program</a>
                <a class="nav-link px-0" href="#cek-mustahik">Cek Mustahik</a>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('register') }}" class="btn btn-sm btn-link text-success fw-bold text-decoration-none d-none d-md-inline-flex">Daftarkan Instansi Anda</a>
                <a href="{{ route('login') }}" class="btn btn-outline-darkgreen">Masuk</a>
            </div>
        </div>
    </nav>

    <main id="beranda">
        <section class="hero">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <span class="eyebrow mb-4">TRANSPARANSI DIGITAL AMANAH</span>
                        <h1 class="mb-4">Transparansi Zakat &amp; Infaq untuk <span>Soreang</span> yang Lebih Sejahtera</h1>
                        <p class="hero-copy mb-4">Pantau penyaluran dana ZIS secara real-time. Dari umat, oleh umat, untuk umat. Membangun kepercayaan melalui akuntabilitas digital yang tak terputus.</p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="#statistik" class="btn btn-green">Lihat Laporan Penyaluran</a>
                            <a href="#cek-mustahik" class="btn btn-soft">Cek Status Bantuan</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <img class="hero-photo" src="{{ asset('assets/fotozakat.png') }}" alt="Penyaluran zakat Fundmil Soreang">
                    </div>
                </div>
            </div>
        </section>

        <section id="statistik" class="section-soft section-pad" data-stats-url="{{ route('public.home') }}?stats=1">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Grafik Akumulasi Dana ZIS</h2>
                    <p class="text-muted mb-0">Data di bawah ini memperlihatkan instansi mana yang sedang menerima pemasukan.</p>
                </div>
                <div class="row g-4 align-items-stretch">
                    <div class="col-lg-4">
                        <div class="stats-grid h-100">
                            <div class="stat-card is-compact">
                                <i class="bi bi-cash-stack stat-icon"></i>
                                <div class="stat-label mt-3 mb-2">Total Dana Terkumpul</div>
                                <div class="stat-value" data-stat="totalDanaMasuk">{{ 'Rp '.number_format((float) ($summary['totalDanaMasuk'] ?? 0), 0, ',', '.') }}</div>
                                <div class="stat-meta" data-stat="totalTransaksi">{{ number_format((int) ($summary['totalTransaksi'] ?? 0), 0, ',', '.') }} transaksi</div>
                            </div>
                            <div class="stat-card is-compact">
                                <i class="bi bi-hand-thumbs-up-fill stat-icon"></i>
                                <div class="stat-label mt-3 mb-2">Total Dana Tersalurkan</div>
                                <div class="stat-value" data-stat="totalDanaTersalur">{{ 'Rp '.number_format((float) ($summary['totalDanaTersalur'] ?? 0), 0, ',', '.') }}</div>
                                <div class="stat-meta" data-stat="totalPenerima">{{ number_format((int) ($summary['totalPenerima'] ?? 0), 0, ',', '.') }} penerima manfaat</div>
                            </div>
                            <div class="stat-card is-compact">
                                <i class="bi bi-people-fill stat-icon"></i>
                                <div class="stat-label mt-3 mb-2">Instansi Aktif</div>
                                <div class="stat-value" data-stat="totalInstansiAktif">{{ number_format((int) ($summary['totalInstansiAktif'] ?? 0), 0, ',', '.') }}</div>
                                <div class="stat-meta">Akun instansi yang terdata</div>
                            </div>
                            <div class="stat-card is-compact">
                                <i class="bi bi-wallet2 stat-icon"></i>
                                <div class="stat-label mt-3 mb-2">Saldo Siap Salur</div>
                                <div class="stat-value" data-stat="saldoTersedia">{{ 'Rp '.number_format((float) ($summary['saldoTersedia'] ?? 0), 0, ',', '.') }}</div>
                                <div class="stat-meta" data-stat="lastUpdated">Diperbarui {{ $summary['lastUpdated'] ?? now()->format('d M Y H:i:s') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="chart-card h-100">
                            <div class="chart-head">
                                <div>
                                    <h3 class="chart-title">Kontribusi Dana Terbesar</h3>
                                    <p class="chart-subtitle">Detail pemasukan yang tercatat.</p>
                                </div>
                                <span class="chart-badge">Live Update</span>
                            </div>
                            <div class="chart-wrap">
                                <canvas id="zisChart"></canvas>
                            </div>
                            <div class="instansi-list mt-3">
                                @forelse ($instansiComparison as $index => $instansi)
                                <div class="instansi-row">
                                    <div>
                                        <div class="instansi-name">{{ $index + 1 }}. {{ $instansi['nama'] ?? '-' }}</div>
                                        <div class="instansi-meta">{{ $instansi['desa'] ?? '-' }} &middot; {{ number_format((int) ($instansi['totalTransaksi'] ?? 0), 0, ',', '.') }} transaksi admin instansi</div>
                                    </div>
                                    <div class="instansi-amount">{{ 'Rp '.number_format((float) ($instansi['totalDana'] ?? 0), 0, ',', '.') }}</div>
                                </div>
                                @empty
                                <div class="instansi-row">
                                    <div>
                                        <div class="instansi-name">Belum ada data instansi</div>
                                        <div class="instansi-meta">Menunggu pemasukan pertama masuk</div>
                                    </div>
                                    <div class="instansi-amount">-</div>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="program" class="section-pad">
            <div class="container">
                <div class="d-flex justify-content-between align-items-end gap-3 mb-5">
                    <div>
                        <h2 class="fw-bold">Program Unggulan</h2>
                        <p class="text-muted mb-0">Inisiatif strategis untuk mengentaskan kemiskinan dan meningkatkan kualitas hidup masyarakat Soreang.</p>
                    </div>
                    <a href="#" class="text-success fw-bold text-decoration-none d-none d-md-inline-flex">Lihat Semua Program <i class="bi bi-arrow-right ms-2"></i></a>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <article class="program-card">
                            <img class="program-image" src="https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=800&q=80" alt="Program pendidikan anak">
                            <div class="program-title">Soreang Cerdas</div>
                            <div class="program-body">
                                <p class="text-muted">Beasiswa dan perlengkapan sekolah bagi yatim dan dhuafa berprestasi.</p>
                                <div class="d-flex justify-content-between small fw-bold mb-2"><span>Realisasi Target</span><span>92%</span></div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 92%"></div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-4">
                        <article class="program-card">
                            <img class="program-image" src="https://images.unsplash.com/photo-1593113598332-cd288d649433?auto=format&fit=crop&w=800&q=80" alt="Distribusi bantuan pangan">
                            <div class="program-title">Sembako Ramadhan</div>
                            <div class="program-body">
                                <p class="text-muted">Distribusi paket pangan pokok untuk keluarga pra-sejahtera selama bulan suci.</p>
                                <div class="d-flex justify-content-between small fw-bold mb-2"><span>Realisasi Target</span><span>75%</span></div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 75%"></div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-4">
                        <article class="program-card">
                            <img class="program-image" src="https://images.unsplash.com/photo-1556745757-8d76bdb6984b?auto=format&fit=crop&w=800&q=80" alt="Pendampingan usaha kecil">
                            <div class="program-title">Modal UMKM</div>
                            <div class="program-body">
                                <p class="text-muted">Pemberdayaan ekonomi melalui bantuan modal usaha tanpa bunga.</p>
                                <div class="d-flex justify-content-between small fw-bold mb-2"><span>Realisasi Target</span><span>60%</span></div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 60%"></div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section id="cek-mustahik" class="section-soft section-pad">
            <div class="container">
                <div class="check-card text-center">
                    <h2 class="fw-bold mb-3">Cek Status Mustahik</h2>
                    <p class="text-muted mx-auto mb-4" style="max-width: 520px;">Masukkan NIK untuk memeriksa status penerimaan bantuan ZIS Anda.</p>
                    <form class="row g-3 justify-content-center" id="nikLookupForm">
                        <div class="col-md-6">
                            <div class="input-group nik-input-group">
                                <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                                <input type="text" id="nikLookupInput" class="form-control nik-input" placeholder="Masukkan 16 Digit NIK Anda" inputmode="numeric" autocomplete="off" maxlength="16">
                            </div>
                        </div>
                        <div class="col-md-auto">
                            <button class="btn btn-green w-100" type="submit" id="nikLookupButton"><i class="bi bi-search me-2"></i>Periksa Status</button>
                        </div>
                    </form>
                    <div class="lookup-result is-hidden" id="nikLookupResult" aria-live="polite"></div>
                    <div class="d-flex justify-content-center gap-4 flex-wrap mt-4 small text-muted">
                        <span><i class="bi bi-shield-check text-success me-1"></i> Data Aman &amp; Terenkripsi</span>
                        <span><i class="bi bi-arrow-repeat text-success me-1"></i> Update Data Mingguan</span>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h6 class="brand mb-3">FUNDMIL SOREANG</h6>
                    <p>Lembaga amil zakat tingkat kecamatan yang berfokus pada pemerataan kesejahteraan masyarakat Soreang melalui digitalisasi manajemen ZIS.</p>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold mb-3">Informasi Kontak</h6>
                    <p class="mb-2"><i class="bi bi-geo-alt-fill text-success me-2"></i>Kantor Pusat: Jl. Raya Soreang No. 12, Bandung</p>
                    <p class="mb-2"><i class="bi bi-telephone-fill text-success me-2"></i>+62 (22) 589-XXXX</p>
                    <p class="mb-0"><i class="bi bi-gem text-success me-2"></i>Mitra Strategis Muzakki</p>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold mb-3">Akuntabilitas</h6>
                    <p>Pernyataan Kepercayaan &amp; Akuntabilitas</p>
                    <p>Kebijakan Privasi Donatur</p>
                    <p>Laporan Audit Tahunan</p>
                </div>
            </div>
            <div class="border-top mt-5 pt-4 d-flex flex-column flex-md-row justify-content-between gap-2 small">
                <span>&copy; 2024 FUNDMIL SOREANG. Mengelola Amanah dengan Ikhlas.</span>
                <span>Syarat &amp; Ketentuan &nbsp;&nbsp; Sitemap</span>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script>
        const statsSection = document.getElementById('statistik');
        const statsUrl = statsSection?.dataset.statsUrl || '{{ route("public.home") }}?stats=1';
        const currencyFormatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0,
        });
        const chartCanvas = document.getElementById('zisChart');
        let zisChart = null;
        const nikLookupForm = document.getElementById('nikLookupForm');
        const nikLookupInput = document.getElementById('nikLookupInput');
        const nikLookupButton = document.getElementById('nikLookupButton');
        const nikLookupResult = document.getElementById('nikLookupResult');

        const formatRupiah = (value) => currencyFormatter.format(Number(value) || 0);

        const renderNikResult = (payload) => {
            if (!nikLookupResult) {
                return;
            }

            if (!payload?.found) {
                nikLookupResult.classList.remove('is-hidden');
                nikLookupResult.innerHTML = `
                    <div class="lookup-status is-tidak-aktif"><i class="bi bi-x-circle"></i> Tidak ditemukan</div>
                    <div class="lookup-title">NIK tidak ditemukan</div>
                    <div class="lookup-meta">${payload?.message || 'Data tidak ada pada daftar mustahik publik.'}</div>
                `;
                return;
            }

            const statusClass = payload.status === 'aktif' ? 'is-aktif' : 'is-tidak-aktif';
            const statusText = payload.status === 'aktif' ? 'Aktif' : 'Tidak Aktif';

            nikLookupResult.classList.remove('is-hidden');
            nikLookupResult.innerHTML = `
                <div class="lookup-status ${statusClass}"><i class="bi bi-${payload.status === 'aktif' ? 'check-circle' : 'x-circle'}"></i> ${statusText}</div>
                <div class="lookup-title">${payload.nama || '-'}</div>
                <div class="lookup-meta">NIK ${payload.nik || '-'} &middot; ${payload.kategori || '-'} &middot; ${payload.instansi || '-'} (${payload.desa || '-'})</div>
                <div class="lookup-grid">
                    <div class="lookup-item">
                        <span class="lookup-label">Alamat</span>
                        <div class="lookup-value">${payload.alamat || '-'}</div>
                    </div>
                    <div class="lookup-item">
                        <span class="lookup-label">Tanggal Verifikasi</span>
                        <div class="lookup-value">${payload.tanggal_verifikasi || '-'}</div>
                    </div>
                </div>
                <div class="lookup-history">${payload.history || 'Belum ada riwayat yang ditampilkan.'}</div>
            `;
        };

        const lookupNik = () => {
            if (!nikLookupInput || !nikLookupResult) {
                return;
            }

            const nik = nikLookupInput.value.replace(/\D/g, '').slice(0, 16);
            nikLookupInput.value = nik;

            if (nik.length < 16) {
                renderNikResult({
                    found: false,
                    message: 'Masukkan 16 digit NIK agar bisa dicek.',
                });
                return;
            }

            nikLookupButton.disabled = true;
            nikLookupButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>Memeriksa';

            fetch(`{{ route('public.home') }}?lookup=1&nik=${encodeURIComponent(nik)}`, {
                    headers: {
                        accept: 'application/json'
                    },
                    cache: 'no-store',
                })
                .then((response) => response.json())
                .then(renderNikResult)
                .catch(() => {
                    renderNikResult({
                        found: false,
                        message: 'Terjadi kesalahan saat memeriksa NIK.',
                    });
                })
                .finally(() => {
                    nikLookupButton.disabled = false;
                    nikLookupButton.innerHTML = '<i class="bi bi-search me-2"></i>Periksa Status';
                });
        };

        const renderChart = (instansiComparison) => {
            if (!chartCanvas || typeof Chart === 'undefined') {
                return;
            }

            const labels = (instansiComparison || []).map((item) => item.nama || '-');
            const totals = (instansiComparison || []).map((item) => Number(item.totalDana) || 0);

            if (zisChart) {
                zisChart.destroy();
            }

            zisChart = new Chart(chartCanvas, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        label: 'Pemasukan per Instansi',
                        data: totals,
                        borderColor: '#0f722b',
                        backgroundColor: labels.map((_, index) => index === 0 ? 'rgba(15, 114, 43, .86)' : 'rgba(15, 114, 43, .22)'),
                        borderRadius: 12,
                        barPercentage: .72,
                        categoryPercentage: .68,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: (context) => formatRupiah(context.parsed.x),
                            },
                        },
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                color: '#5f6b61',
                                callback: (value) => formatRupiah(value),
                            },
                            grid: {
                                color: '#edf2ed'
                            },
                        },
                        y: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#5f6b61'
                            },
                        },
                    },
                },
            });
        };

        const applyStats = (payload) => {
            const summary = payload?.summary || {};
            let instansiComparison = payload?.instansiComparison || [];

            // Data sudah difilter di backend untuk hanya menampilkan institusi dengan admin_instansi
            document.querySelector('[data-stat="totalDanaMasuk"]').textContent = formatRupiah(summary.totalDanaMasuk);
            document.querySelector('[data-stat="totalTransaksi"]').textContent = `${Number(summary.totalTransaksi || 0).toLocaleString('id-ID')} transaksi`;
            document.querySelector('[data-stat="totalDanaTersalur"]').textContent = formatRupiah(summary.totalDanaTersalur);
            document.querySelector('[data-stat="totalPenerima"]').textContent = `${Number(summary.totalPenerima || 0).toLocaleString('id-ID')} penerima manfaat`;
            document.querySelector('[data-stat="totalInstansiAktif"]').textContent = Number(summary.totalInstansiAktif || 0).toLocaleString('id-ID');
            document.querySelector('[data-stat="saldoTersedia"]').textContent = formatRupiah(summary.saldoTersedia);
            document.querySelector('[data-stat="lastUpdated"]').textContent = `Diperbarui ${summary.lastUpdated || '-'}`;
            renderChart(instansiComparison);
        };

        const refreshStats = () => {
            fetch(statsUrl, {
                    headers: {
                        accept: 'application/json'
                    },
                    cache: 'no-store',
                })
                .then((response) => response.json())
                .then(applyStats)
                .catch(() => {});
        };

        refreshStats();
        setInterval(refreshStats, 30000);

        if (nikLookupInput) {
            nikLookupInput.addEventListener('input', () => {
                nikLookupInput.value = nikLookupInput.value.replace(/\D/g, '').slice(0, 16);
            });
        }

        if (nikLookupForm) {
            nikLookupForm.addEventListener('submit', (event) => {
                event.preventDefault();
                lookupNik();
            });
        }
    </script>
</body>

</html>
