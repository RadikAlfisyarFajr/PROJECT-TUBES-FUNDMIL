@php
$title = 'Tambah Pemasukan Zakat';
$description = 'Pilih sub-kategori dana berdasarkan kategori utama yang aktif.';
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | Admin Instansi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Pemasukan Zakat | Admin Instansi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
    <style>
        .pemasukan-shell {
            max-width: 1180px;
            margin: 0 auto;
        }

        .page-heading {
            margin-bottom: 26px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .back-link {
            border: 0;
            background: transparent;
            color: var(--green);
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-weight: 900;
            text-decoration: none;
        }

        .page-heading h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 900;
        }

        .form-card,
        .summary-card,
        .mini-panel {
            border: 1px solid var(--line);
            border-radius: 18px;
            background: #fff;
            box-shadow: var(--shadow);
        }

        .form-card {
            padding: 34px;
        }

        .section-title {
            margin: 0 0 26px;
            color: #aaa7a3;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.2rem;
            font-weight: 900;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .section-title i {
            color: var(--green);
        }

        .field-label {
            margin-bottom: 9px;
            color: #625f5b;
            display: block;
            font-size: .72rem;
            font-weight: 900;
            text-transform: uppercase;
        }

        .soft-input,
        .soft-select {
            width: 100%;
            min-height: 50px;
            border: 0;
            border-radius: 18px;
            background: #f7f8f7;
            color: #17211b;
            outline: 0;
            padding: 0 18px;
            font-weight: 650;
        }

        .soft-input::placeholder {
            color: #6b7280;
            font-weight: 500;
        }

        .soft-select {
            appearance: auto;
        }

        .payment-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 14px;
            table-layout: fixed;
        }

        .payment-table th {
            padding: 0 10px;
            color: #625f5b;
            font-size: .72rem;
            font-weight: 900;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .payment-table td {
            padding: 0 10px;
            vertical-align: top;
        }

        .payment-table th:nth-child(1),
        .payment-table td:nth-child(1) {
            width: 18%;
        }

        .payment-table th:nth-child(2),
        .payment-table td:nth-child(2) {
            width: 16%;
        }

        .payment-table th:nth-child(3),
        .payment-table td:nth-child(3) {
            width: 22%;
        }

        .payment-table th:nth-child(4),
        .payment-table td:nth-child(4) {
            width: 16%;
        }

        .payment-table th:nth-child(5),
        .payment-table td:nth-child(5) {
            width: 24%;
        }

        .payment-table th:nth-child(6),
        .payment-table td:nth-child(6) {
            width: 4%;
        }

        .payment-input-stack {
            display: flex;
            min-height: 122px;
            flex-direction: column;
            justify-content: flex-start;
        }

        .payment-input-stack .soft-input {
            max-width: 100%;
        }

        .payment-row-shell {
            padding: 16px 0;
            border-bottom: 1px solid var(--line);
        }

        .row-actions {
            min-height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .remove-row {
            width: 38px;
            height: 38px;
            border: 0;
            border-radius: 50%;
            background: #f4eeee;
            color: #b33232;
            display: grid;
            place-items: center;
        }

        .add-item-btn {
            min-height: 44px;
            border: 0;
            background: transparent;
            color: var(--green);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 900;
        }

        .add-item-btn i {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: var(--green);
            color: #fff;
            display: grid;
            place-items: center;
            font-size: .85rem;
        }

        .segmented {
            min-height: 44px;
            padding: 4px;
            border-radius: 999px;
            background: #f2f1f0;
            display: flex;
            gap: 4px;
        }

        .segmented label {
            flex: 1;
            min-width: 70px;
            min-height: 36px;
            border-radius: 999px;
            color: #605f5d;
            display: grid;
            place-items: center;
            font-size: .82rem;
            font-weight: 900;
            cursor: pointer;
        }

        .segmented input {
            display: none;
        }

        .segmented input:checked+span {
            width: 100%;
            min-height: 36px;
            border-radius: 999px;
            background: var(--green);
            color: #fff;
            box-shadow: 0 8px 16px rgba(7, 101, 31, .18);
            display: grid;
            place-items: center;
        }

        .subtle-note {
            margin-top: 7px;
            color: #9b9894;
            font-size: .68rem;
            font-style: italic;
        }

        .fidyah-budget-grid {
            margin-top: 0;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .mini-field-label {
            margin-bottom: 6px;
            color: #625f5b;
            display: block;
            font-size: .66rem;
            font-weight: 900;
            text-transform: uppercase;
        }

        .fidyah-budget-grid .soft-input {
            min-height: 50px;
            border-radius: 14px;
            padding: 0 12px;
            font-size: .82rem;
        }

        .summary-card {
            margin-top: 28px;
            padding: 28px 34px;
        }

        .summary-label {
            margin-bottom: 8px;
            color: #aaa7a3;
            font-size: .72rem;
            font-weight: 900;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .summary-value {
            margin: 0;
            color: var(--green);
            font-size: 2rem;
            font-weight: 950;
        }

        .payment-choice {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .payment-choice label {
            min-width: 118px;
            min-height: 52px;
            border: 2px solid #e5e5e2;
            border-radius: 17px;
            color: #716d69;
            display: grid;
            place-items: center;
            font-weight: 900;
            cursor: pointer;
        }

        .payment-choice input {
            display: none;
        }

        .payment-choice input:checked+span {
            width: 100%;
            min-height: 48px;
            border: 2px solid var(--green);
            border-radius: 15px;
            color: var(--green);
            display: grid;
            place-items: center;
        }

        .submit-area {
            margin-top: 28px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 22px;
        }

        .cancel-btn {
            border: 0;
            background: transparent;
            color: #aaa7a3;
            font-weight: 900;
        }

        .save-print-btn {
            min-height: 58px;
            padding: 0 34px;
            border: 0;
            border-radius: 18px;
            background: var(--green);
            color: #fff;
            box-shadow: 0 14px 26px rgba(7, 101, 31, .24);
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-weight: 900;
        }

        .save-print-btn:disabled {
            opacity: .7;
            cursor: wait;
        }

        .mini-panel {
            min-height: 140px;
            padding: 24px 26px;
        }

        .mini-title {
            margin: 0 0 12px;
            color: var(--green-dark);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1rem;
            font-weight: 900;
        }

        .mini-copy {
            margin: 0;
            color: #4c574f;
            line-height: 1.65;
        }

        .success-flash {
            display: none;
            margin-bottom: 18px;
            border: 1px solid #badfc4;
            border-radius: 16px;
            background: #eaf8ee;
            color: var(--green-dark);
            padding: 14px 18px;
            font-weight: 800;
        }

        .invalid-feedback-box {
            display: none;
            margin-bottom: 18px;
            border: 1px solid #f1c9c9;
            border-radius: 16px;
            background: #fff1f1;
            color: #9c2626;
            padding: 14px 18px;
            font-weight: 800;
        }

        @media (max-width: 991px) {

            .form-card,
            .summary-card {
                padding: 24px;
            }

            .payment-table,
            .payment-table tbody,
            .payment-table tr,
            .payment-table td {
                display: block;
                width: 100%;
            }

            .payment-table thead {
                display: none;
            }

            .payment-table td {
                padding: 7px 0;
            }

            .submit-area {
                align-items: stretch;
                flex-direction: column-reverse;
            }

            .save-print-btn {
                justify-content: center;
                width: 100%;
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
                    <p class="admin-page-desc">Input satu muzaki dengan banyak item pembayaran dalam satu kuitansi.</p>
                </div>
                <div class="admin-top-actions">
                    <button class="admin-icon-btn has-dot" type="button" aria-label="Notifikasi">
                        <i class="bi bi-bell-fill"></i>
                    </button>
                    @include('admin.partials.account-identity')
                </div>
            </header>

            <div class="pemasukan-shell">
                <div class="page-heading">
                    <a class="back-link" href="{{ route('pemasukan.index') }}">
                        <i class="bi bi-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                    <h1>Input Data Pemasukan</h1>
                </div>


                <div id="successFlash" class="success-flash"></div>
                <div id="errorBox" class="invalid-feedback-box"></div>

                @if (session('success'))
                <div class="success-flash" style="display:block">{{ session('success') }}</div>
                @endif

                <form id="pemasukanForm" action="{{ route('pemasukan.store') }}" method="POST" novalidate>
                    @csrf
                    <input id="nomorKuitansi" type="hidden" name="nomor_kuitansi" value="{{ $nomorKuitansi }}">

                    <section class="form-card">
                        <h2 class="section-title">
                            <i class="bi bi-person-fill"></i>
                            Identitas Muzaki
                        </h2>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="field-label" for="namaMuzakki">Nama Lengkap</label>
                                <input id="namaMuzakki" class="soft-input" name="nama_muzakki" type="text" placeholder="Masukkan nama muzaki" required>
                            </div>
                            <div class="col-md-6">
                                <label class="field-label" for="nomorWa">Nomor Telepon / WhatsApp</label>
                                <input id="nomorWa" class="soft-input" name="nomor_wa" type="text" placeholder="0812...">
                            </div>
                            <div class="col-md-6">
                                <label class="field-label" for="desa">Desa / Kelurahan</label>
                                <select id="desa" class="soft-select" name="desa" required>
                                    <option value="">Pilih Desa/Kelurahan</option>
                                    @foreach ($desaOptions as $desa)
                                    <option value="{{ $desa }}">{{ $desa }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="field-label" for="alamatDetail">RW / RT (Detail Alamat)</label>
                                <input id="alamatDetail" class="soft-input" type="text" placeholder="Contoh: RW 05 / RT 02">
                            </div>
                        </div>

                        <h2 class="section-title mt-5">
                            <i class="bi bi-receipt-cutoff"></i>
                            Detail Pembayaran
                        </h2>

                        <div class="table-responsive">
                            <table class="payment-table">
                                <thead>
                                    <tr>
                                        <th style="width: 190px">Kategori Utama</th>
                                        <th style="width: 170px">Tipe / Sub</th>
                                        <th style="width: 210px">Nilai Input</th>
                                        <th style="width: 170px">Subtotal</th>
                                        <th>Catatan / Keterangan</th>
                                        <th style="width: 52px"></th>
                                    </tr>
                                </thead>
                                <tbody id="paymentRows"></tbody>
                            </table>
                        </div>

                        <button id="addItemBtn" class="add-item-btn" type="button">
                            <i class="bi bi-plus-lg"></i>
                            Tambah Item (Fidyah, Infaq, dll)
                        </button>

                        <section class="summary-card">
                            <div class="row g-4 align-items-center">
                                <div class="col-md-4">
                                    <div class="summary-label">Total Nominal Uang</div>
                                    <p id="grandTotal" class="summary-value">Rp 0</p>
                                </div>
                                <div class="col-md-3">
                                    <div class="summary-label">Total Berat Beras</div>
                                    <p id="totalBeras" class="summary-value">0 KG</p>
                                </div>
                                <div class="col-md-5">
                                    <div class="summary-label">Metode Pembayaran</div>
                                    <div class="payment-choice">
                                        <label>
                                            <input type="radio" name="jenis_pembayaran" value="tunai" checked>
                                            <span>Tunai</span>
                                        </label>
                                        <label>
                                            <input type="radio" name="jenis_pembayaran" value="transfer">
                                            <span>Transfer</span>
                                        </label>
                                        <label>
                                            <input type="radio" name="jenis_pembayaran" value="qris">
                                            <span>QRIS</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="submit-area">
                                <button id="resetBtn" class="cancel-btn" type="button">Batal</button>
                                <button id="submitBtn" class="save-print-btn" type="submit">
                                    <i class="bi bi-printer-fill"></i>
                                    Simpan & Cetak Struk
                                </button>
                            </div>
                        </section>
                    </section>
                </form>

                <div class="row g-4 mt-4">
                    <div class="col-md-4">
                        <section class="mini-panel" style="background:#eaf8ee;border-color:#badfc4">
                            <h2 class="mini-title">
                                <i class="bi bi-info-circle-fill"></i>
                                Info Kurs Zakat
                            </h2>
                            <p class="mini-copy">
                                Zakat Fitrah: Rp {{ number_format($rates['fitrahUangPerJiwa'], 0, ',', '.') }} / 2.5 Kg Beras.
                                Fidyah: Rp {{ number_format($rates['fidyahPerHari'], 0, ',', '.') }} per hari/jiwa
                                (buka puasa Rp {{ number_format($rates['fidyahBukaPuasaPerHari'], 0, ',', '.') }} +
                                sahur Rp {{ number_format($rates['fidyahSahurPerHari'], 0, ',', '.') }}).
                            </p>
                        </section>
                    </div>
                    <div class="col-md-4">
                        <section class="mini-panel">
                            <h2 class="mini-title">
                                <i class="bi bi-arrow-counterclockwise"></i>
                                Transaksi Terakhir
                            </h2>
                            <p class="mini-copy">Setelah tersimpan, form otomatis kosong dan nomor kuitansi baru disiapkan untuk muzaki berikutnya.</p>
                        </section>
                    </div>
                    <div class="col-md-4">
                        <section class="mini-panel" style="background:#1c7b2a;color:#fff">
                            <h2 class="mini-title" style="color:#fff">Kuitansi Aktif</h2>
                            <p id="receiptPreview" class="summary-value" style="color:#fff;font-size:1.6rem">{{ $nomorKuitansi }}</p>
                        </section>
                    </div>
                </div>
            </div>
        </main>
    </div>


    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');

        sidebarToggle?.addEventListener('click', () => {
            document.body.classList.toggle('sidebar-expanded');
        });
    </script>
</body>

<div
    id="zakatRatesData"
    hidden
    data-fitrah-uang-per-jiwa="{{ $rates['fitrahUangPerJiwa'] }}"
    data-fitrah-beras-kg-per-jiwa="{{ $rates['fitrahBerasKgPerJiwa'] }}"
    data-harga-beras-per-kg="{{ $rates['hargaBerasPerKg'] }}"
    data-fidyah-per-hari="{{ $rates['fidyahPerHari'] }}"
    data-fidyah-buka-puasa-per-hari="{{ $rates['fidyahBukaPuasaPerHari'] }}"
    data-fidyah-sahur-per-hari="{{ $rates['fidyahSahurPerHari'] }}"
    data-pertanian-per-kg="{{ $rates['pertanianPerKg'] }}"
    data-peternakan-per-ekor="{{ $rates['peternakanPerEkor'] }}"></div>
<script>
    const zakatRatesData = document.getElementById('zakatRatesData').dataset;
    const zakatRates = {
        fitrahUangPerJiwa: Number(zakatRatesData.fitrahUangPerJiwa),
        fitrahBerasKgPerJiwa: Number(zakatRatesData.fitrahBerasKgPerJiwa),
        hargaBerasPerKg: Number(zakatRatesData.hargaBerasPerKg),
        fidyahPerHari: Number(zakatRatesData.fidyahPerHari),
        fidyahBukaPuasaPerHari: Number(zakatRatesData.fidyahBukaPuasaPerHari),
        fidyahSahurPerHari: Number(zakatRatesData.fidyahSahurPerHari),
        pertanianPerKg: Number(zakatRatesData.pertanianPerKg),
        peternakanPerEkor: Number(zakatRatesData.peternakanPerEkor),
    };
    const form = document.getElementById('pemasukanForm');
    const rowsContainer = document.getElementById('paymentRows');
    const addItemBtn = document.getElementById('addItemBtn');
    const resetBtn = document.getElementById('resetBtn');
    const submitBtn = document.getElementById('submitBtn');
    const grandTotal = document.getElementById('grandTotal');
    const totalBeras = document.getElementById('totalBeras');
    const successFlash = document.getElementById('successFlash');
    const errorBox = document.getElementById('errorBox');
    const nomorKuitansi = document.getElementById('nomorKuitansi');
    const receiptPreview = document.getElementById('receiptPreview');
    let rowCounter = 0;

    const formatRupiah = (value) => new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0
    }).format(value || 0);

    const cleanNumber = (value) => {
        const number = Number(value || 0);
        return Number.isInteger(number) ? String(number) : number.toFixed(2).replace(/\.?0+$/, '');
    };

    const escapeHtml = (value) => String(value || '').replace(/[&<>"']/g, (character) => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    } [character]));

    const categoryOptions = `
            <option value="zakat_fitrah">Zakat Fitrah</option>
            <option value="zakat_maal">Zakat Maal</option>
            <option value="infaq_sedekah">Infaq & Sedekah</option>
            <option value="fidyah">Fidyah</option>
        `;

    function addRow(defaultCategory = 'zakat_fitrah') {
        const index = rowCounter++;
        const row = document.createElement('tr');
        row.className = 'payment-row';
        row.innerHTML = `
                <td>
                    <select class="soft-select js-category" name="items[${index}][kategori_utama]">
                        ${categoryOptions}
                    </select>
                </td>
                <td>
                    <div class="js-fitrah-type segmented">
                        <label>
                            <input type="radio" name="items[${index}][fitrah_media]" value="uang" checked>
                            <span>Uang</span>
                        </label>
                        <label>
                            <input type="radio" name="items[${index}][fitrah_media]" value="beras">
                            <span>Beras</span>
                        </label>
                    </div>
                    <select class="soft-select js-maal-type d-none" name="items[${index}][sub_maal]">
                        <option value="Profesi">Profesi</option>
                        <option value="Simpanan">Simpanan</option>
                        <option value="Perdagangan">Perdagangan</option>
                        <option value="Emas">Emas</option>
                        <option value="Pertanian">Pertanian</option>
                        <option value="Peternakan">Peternakan</option>
                    </select>
                </td>
                <td>
                    <div class="payment-input-stack">
                        <label class="field-label js-amount-label">Jumlah Jiwa</label>
                        <input class="soft-input js-amount" name="items[${index}][jumlah_input]" type="number" min="0" step="0.01" value="1">
                        <div class="subtle-note js-note">Standar: Rp 45.000/jiwa</div>
                        <div class="js-fidyah-budget fidyah-budget-grid d-none">
                            <div>
                                <label class="mini-field-label">Buka Puasa</label>
                                <input class="soft-input js-fidyah-buka" name="items[${index}][fidyah_buka_puasa]" type="number" min="0" step="1000" value="${zakatRates.fidyahBukaPuasaPerHari}">
                            </div>
                            <div>
                                <label class="mini-field-label">Sahur</label>
                                <input class="soft-input js-fidyah-sahur" name="items[${index}][fidyah_sahur]" type="number" min="0" step="1000" value="${zakatRates.fidyahSahurPerHari}">
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <input class="soft-input js-subtotal" type="text" value="Rp 45.000" readonly>
                </td>
                <td>
                    <input class="soft-input js-note-input" name="items[${index}][keterangan]" type="text" placeholder="Masukkan keterangan tambahan">
                </td>
                <td>
                    <div class="row-actions">
                        <button class="remove-row" type="button" aria-label="Hapus item">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </div>
                </td>
            `;

        rowsContainer.appendChild(row);
        row.querySelector('.js-category').value = defaultCategory;
        bindRow(row);
        updateRow(row);
    }

    function bindRow(row) {
        row.querySelectorAll('input, select').forEach((element) => {
            element.addEventListener('input', () => updateRow(row));
            element.addEventListener('change', () => updateRow(row));
        });

        row.querySelector('.remove-row').addEventListener('click', () => {
            if (rowsContainer.querySelectorAll('.payment-row').length > 1) {
                row.remove();
                updateTotals();
            }
        });
    }

    function rowData(row) {
        const category = row.querySelector('.js-category').value;
        const amount = Number(row.querySelector('.js-amount').value || 0);
        const fitrahMedia = row.querySelector('.js-fitrah-type input:checked')?.value || 'uang';
        const maalType = row.querySelector('.js-maal-type').value;
        const fidyahBuka = Number(row.querySelector('.js-fidyah-buka').value || 0);
        const fidyahSahur = Number(row.querySelector('.js-fidyah-sahur').value || 0);
        let subtotal = 0;
        let berasKg = 0;

        if (category === 'zakat_fitrah') {
            subtotal = amount * zakatRates.fitrahUangPerJiwa;
            berasKg = fitrahMedia === 'beras' ? amount * zakatRates.fitrahBerasKgPerJiwa : 0;
        } else if (category === 'zakat_maal') {
            if (maalType === 'Pertanian') {
                subtotal = amount * zakatRates.pertanianPerKg;
            } else if (maalType === 'Peternakan') {
                subtotal = amount * zakatRates.peternakanPerEkor;
            } else {
                subtotal = amount;
            }
        } else if (category === 'fidyah') {
            subtotal = amount * (fidyahBuka + fidyahSahur);
        } else {
            subtotal = amount;
        }

        return {
            category,
            amount,
            fitrahMedia,
            maalType,
            fidyahBuka,
            fidyahSahur,
            subtotal,
            berasKg
        };
    }

    function updateRow(row) {
        const data = rowData(row);
        const fitrahType = row.querySelector('.js-fitrah-type');
        const maalType = row.querySelector('.js-maal-type');
        const amountLabel = row.querySelector('.js-amount-label');
        const note = row.querySelector('.js-note');
        const subtotal = row.querySelector('.js-subtotal');
        const fidyahBudget = row.querySelector('.js-fidyah-budget');

        fitrahType.classList.toggle('d-none', data.category !== 'zakat_fitrah');
        maalType.classList.toggle('d-none', data.category !== 'zakat_maal');
        fidyahBudget.classList.toggle('d-none', data.category !== 'fidyah');

        if (data.category === 'zakat_fitrah') {
            amountLabel.textContent = 'Jumlah Jiwa';
            note.textContent = data.fitrahMedia === 'beras' ?
                `Standar: ${zakatRates.fitrahBerasKgPerJiwa} Kg/jiwa, ekuivalen Rp 45.000` :
                'Standar: Rp 45.000/jiwa';
        } else if (data.category === 'zakat_maal') {
            if (data.maalType === 'Pertanian') {
                amountLabel.textContent = 'Berat Hasil Panen (Kg)';
                note.textContent = `Konversi audit: ${formatRupiah(zakatRates.pertanianPerKg)}/Kg`;
            } else if (data.maalType === 'Peternakan') {
                amountLabel.textContent = 'Jumlah Hewan (Ekor)';
                note.textContent = `Konversi audit: ${formatRupiah(zakatRates.peternakanPerEkor)}/Ekor`;
            } else {
                amountLabel.textContent = 'Nominal Rupiah';
                note.textContent = 'Masukkan nominal uang yang diterima';
            }
        } else if (data.category === 'fidyah') {
            amountLabel.textContent = 'Jumlah Hari/Jiwa';
            note.textContent = `Budget harian: buka puasa + sahur = ${formatRupiah(data.fidyahBuka + data.fidyahSahur)} per hari/jiwa`;
        } else {
            amountLabel.textContent = 'Nominal Uang';
            note.textContent = 'Masukkan nominal uang yang diterima';
        }

        subtotal.value = formatRupiah(data.subtotal);
        updateTotals();
    }

    function updateTotals() {
        let total = 0;
        let beras = 0;

        rowsContainer.querySelectorAll('.payment-row').forEach((row) => {
            const data = rowData(row);
            total += data.subtotal;
            beras += data.berasKg;
        });

        grandTotal.textContent = formatRupiah(total);
        totalBeras.textContent = `${cleanNumber(beras)} KG`;
    }

    function resetForm(nextReceipt = null) {
        form.reset();
        rowsContainer.innerHTML = '';
        rowCounter = 0;
        addRow('zakat_fitrah');
        addRow('zakat_maal');

        if (nextReceipt) {
            nomorKuitansi.value = nextReceipt;
            nomorKuitansi.defaultValue = nextReceipt;
            receiptPreview.textContent = nextReceipt;
        }
    }

    function buildReceipt(data) {
        const rows = Array.from(rowsContainer.querySelectorAll('.payment-row')).map((row) => {
            const rowInfo = rowData(row);
            const category = escapeHtml(row.querySelector('.js-category option:checked').textContent.trim());
            return `<tr><td>${category}</td><td>${cleanNumber(rowInfo.amount)}</td><td>${formatRupiah(rowInfo.subtotal)}</td></tr>`;
        }).join('');

        return `
                <html>
                    <head>
                        <title>Struk ${data.nomor_kuitansi}</title>
                        <style>
                            body{font-family:Inter,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;padding:24px;color:#111}
                            h1{font-size:18px;margin:0 0 4px}
                            table{width:100%;border-collapse:collapse;margin-top:18px}
                            td,th{border-bottom:1px solid #ddd;padding:8px;text-align:left}
                            .total{font-size:20px;font-weight:800;margin-top:18px}
                        </style>
                    </head>
                    <body>
                        <h1>FUNDMIL SOREANG</h1>
                        <div>Kuitansi: ${data.nomor_kuitansi}</div>
                        <div>Muzaki: ${escapeHtml(document.getElementById('namaMuzakki').value)}</div>
                        <table>
                            <thead><tr><th>Item</th><th>Input</th><th>Subtotal</th></tr></thead>
                            <tbody>${rows}</tbody>
                        </table>
                        <div class="total">Total: ${formatRupiah(data.total)}</div>
                    </body>
                </html>
            `;
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        submitBtn.disabled = true;
        errorBox.style.display = 'none';
        successFlash.style.display = 'none';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                },
                body: new FormData(form),
            });

            const payload = await response.json();

            if (!response.ok) {
                const firstError = payload.errors ? Object.values(payload.errors).flat()[0] : payload.message;
                throw new Error(firstError || 'Data belum berhasil disimpan.');
            }

            const printWindow = window.open('', '_blank', 'width=520,height=720');
            if (printWindow) {
                printWindow.document.write(buildReceipt(payload));
                printWindow.document.close();
                printWindow.focus();
                printWindow.print();
            }

            successFlash.textContent = `${payload.message} Nomor kuitansi ${payload.nomor_kuitansi}.`;
            successFlash.style.display = 'block';

            // popup auto-hide (biar user ga klik berkali-kali)
            submitBtn.textContent = 'Menyimpan...';
            let isToastVisible = true;
            clearTimeout(window.__pemasukanToastTimer);
            window.__pemasukanToastTimer = setTimeout(() => {
                if (!isToastVisible) return;
                successFlash.style.display = 'none';
                isToastVisible = false;
            }, 2500);

            resetForm(payload.next_nomor_kuitansi);
        } catch (error) {
            errorBox.textContent = error.message;
            errorBox.style.display = 'block';
        } finally {
            submitBtn.disabled = false;
        }
    });

    addItemBtn.addEventListener('click', () => addRow('infaq_sedekah'));
    resetBtn.addEventListener('click', () => resetForm());

    document.getElementById('sidebarToggle')?.addEventListener('click', () => {
        document.body.classList.toggle('sidebar-expanded');
    });

    resetForm();
</script>
</body>

</html>
