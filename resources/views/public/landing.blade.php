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
            color: var(--green-dark);
            font-weight: 800;
            text-decoration: none;
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
            padding-left: 44px;
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
            <a class="brand" href="{{ route('public.home') }}">FUNDMIL SOREANG</a>
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
                        <p class="hero-copy mb-4">Pantau penyalregister ran dana ZIS secara real-time. Dari umat, oleh umat, untuk umat. Membangun kepercayaan melalui akuntabilitas digital yang tak terputus.</p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="#statistik" class="btn btn-green">Lihat Laporan Penyaluran</a>
                            <a href="#cek-mustahik" class="btn btn-soft">Cek Status Bantuan</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <img class="hero-photo" src="https://images.unsplash.com/photo-1564769625905-50e93615e769?auto=format&fit=crop&w=1000&q=80" alt="Masjid sebagai simbol pengelolaan zakat">
                    </div>
                </div>
            </div>
        </section>

        <section id="statistik" class="section-soft section-pad">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Laporan Filantropi Terkini</h2>
                    <p class="text-muted mb-0">Update real-time kontribusi masyarakat Soreang hingga hari ini.</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="stat-card">
                            <i class="bi bi-cash-stack stat-icon"></i>
                            <div class="stat-label mt-4 mb-2">Total Dana Terkumpul</div>
                            <div class="h3 fw-bold">Rp 2.450.800.000</div>
                            <small class="text-success fw-bold">+12% Bulan ini</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <i class="bi bi-hand-thumbs-up-fill stat-icon"></i>
                            <div class="stat-label mt-4 mb-2">Total Dana Tersalurkan</div>
                            <div class="h3 fw-bold">Rp 2.083.180.000</div>
                            <small class="text-success fw-bold">85% Tersalurkan</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <i class="bi bi-people-fill stat-icon"></i>
                            <div class="stat-label mt-4 mb-2">Jumlah Penerima Manfaat</div>
                            <div class="h3 fw-bold">12.840 Jiwa</div>
                            <small class="text-success fw-bold">Tersebar di 18 Desa</small>
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
                    <form class="row g-3 justify-content-center">
                        <div class="col-md-6 position-relative">
                            <i class="bi bi-person-vcard position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                            <input type="text" class="form-control nik-input" placeholder="Masukkan 16 Digit NIK Anda">
                        </div>
                        <div class="col-md-auto">
                            <button class="btn btn-green w-100" type="button"><i class="bi bi-search me-2"></i>Periksa Status</button>
                        </div>
                    </form>
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
</body>

</html>