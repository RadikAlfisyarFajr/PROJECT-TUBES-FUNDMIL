@php
    $generatedAt = $generatedAt ?? now();
    $report = $report ?? 'pemasukan';
    $breakdownPemasukan = collect($breakdownPemasukan ?? []);
    $breakdownPenyaluran = collect($breakdownPenyaluran ?? []);
    $breakdownProgram = collect($breakdownProgram ?? []);
    $breakdownStatus = collect($breakdownStatus ?? []);

    $backUrl = match ($report) {
        'pemasukan-struk' => route('laporan.pemasukan'),
        'mustahik' => route('laporan.mustahik', request()->except(['print'])),
        'penyaluran' => route('laporan.penyaluran', request()->except(['print'])),
        'keuangan' => route('laporan.keuangan', request()->except(['print'])),
        default => route('laporan.pemasukan', request()->except(['print'])),
    };

    $title = match ($report) {
        'pemasukan-struk' => 'Struk Pemasukan',
        'mustahik' => 'Cetak Laporan Mustahik',
        'penyaluran' => 'Cetak Laporan Penyaluran',
        'keuangan' => 'Cetak Laporan Keuangan',
        default => 'Cetak Laporan Pemasukan',
    };

    $subtitle = match ($report) {
        'pemasukan-struk' => 'Bukti ringkas transaksi pemasukan yang siap disimpan sebagai PDF.',
        'mustahik' => 'Ringkasan data penerima manfaat. Tidak menampilkan daftar individu.',
        'penyaluran' => 'Ringkasan distribusi bantuan. Tidak menampilkan daftar penerima individu.',
        'keuangan' => 'Rekap kas masuk dan keluar dengan rincian per kategori dana.',
        default => 'Ringkasan total pemasukan dana dengan rincian per jenis dana.',
    };

    $bodyClass = match ($report) {
        'penyaluran' => 'report-penyaluran',
        'keuangan' => 'report-keuangan',
        'mustahik' => 'report-mustahik',
        'pemasukan-struk' => 'report-pemasukan-struk',
        default => 'report-pemasukan',
    };
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        @page { size: A4 portrait; margin: 14mm; }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, Helvetica, sans-serif; color: #142017; background: #f3f7f3; }
        a { color: inherit; text-decoration: none; }
        .sheet { max-width: 100%; margin: 0 auto; }
        .paper { background: #fff; border: 1px solid #dfe8df; border-radius: 18px; padding: 24px; }
        .header { display: flex; justify-content: space-between; gap: 18px; align-items: flex-start; padding-bottom: 18px; border-bottom: 2px solid #0f722b; margin-bottom: 18px; }
        body.report-penyaluran .header,
        body.report-keuangan .header { border-bottom-color: #0f722b; }
        .brand { font-weight: 900; color: #06451f; font-size: 1.15rem; margin-bottom: 4px; }
        .sub { color: #5e6b60; font-size: .82rem; line-height: 1.55; max-width: 520px; }
        .meta { text-align: right; font-size: .82rem; color: #5e6b60; line-height: 1.6; }
        .meta strong { color: #142017; }
        .summary { display: grid; gap: 12px; margin-bottom: 18px; }
        .summary.cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .summary.cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .summary.cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        .card { border: 1px solid #e2ebe4; border-radius: 14px; padding: 14px 16px; background: #f8faf8; }
        .card small { display: block; color: #6a756b; text-transform: uppercase; letter-spacing: .04em; font-size: .68rem; font-weight: 800; margin-bottom: 6px; }
        .card strong { font-size: 1.05rem; color: #0f722b; }
        .card.green { background: #0f722b; border-color: #0f722b; }
        .card.green small,
        .card.green strong { color: #fff; }
        .section-title { margin: 18px 0 10px; font-size: .92rem; font-weight: 900; color: #142017; }
        table { width: 100%; border-collapse: collapse; }
        thead th { background: #eef4ee; color: #667268; font-size: .68rem; text-transform: uppercase; letter-spacing: .06em; text-align: left; padding: 10px 12px; border-bottom: 1px solid #dfe8df; }
        tbody td { padding: 11px 12px; border-bottom: 1px solid #e8eee8; font-size: .84rem; vertical-align: top; }
        tbody tr:last-child td { border-bottom: 0; }
        .amount { text-align: right; font-weight: 800; color: #06451f; white-space: nowrap; }
        .grid-two { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; }
        .note { margin-top: 18px; padding: 12px 14px; border-left: 4px solid #0f722b; background: #f5fbf6; border-radius: 12px; color: #304133; font-size: .86rem; line-height: 1.7; }
        .detail-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
        .detail { border: 1px solid #e2ebe4; border-radius: 14px; padding: 12px 14px; background: #f8faf8; }
        .detail small { display: block; color: #6a756b; text-transform: uppercase; letter-spacing: .04em; font-size: .68rem; font-weight: 800; margin-bottom: 6px; }
        .detail strong { color: #142017; }
        .actions { display: flex; gap: 10px; margin: 0 0 16px; }
        .btn { border: 0; border-radius: 999px; padding: 10px 14px; font-weight: 800; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .btn.print { background: #0f722b; color: #fff; }
        .btn.back { background: #e8efe9; color: #06451f; }
        @media print {
            body { background: #fff; }
            .actions { display: none; }
            .paper { border: 0; border-radius: 0; padding: 0; }
        }
    </style>
</head>
<body class="{{ $bodyClass }}">
    <div class="sheet">
        <div class="actions">
            <button class="btn print" onclick="window.print()">Cetak / Simpan PDF</button>
            <a class="btn back" href="{{ $backUrl }}">Kembali</a>
        </div>
        <div class="paper">
            <div class="header">
                <div>
                    <div class="brand">{{ $title }}</div>
                    <div class="sub">{{ $subtitle }}</div>
                </div>
                <div class="meta">
                    <div><strong>Dicetak:</strong> {{ $generatedAt->format('d M Y H:i') }}</div>
                    @if (!empty($filters))
                        <div><strong>Filter:</strong> {{ trim(collect($filters)->filter()->implode(' ')) ?: 'Semua data' }}</div>
                    @endif
                    @if ($report === 'pemasukan-struk')
                        <div><strong>No. Kuitansi:</strong> {{ $trx->nomor_kuitansi ?? '-' }}</div>
                    @endif
                </div>
            </div>

            @if ($report === 'pemasukan')
                <div class="summary cols-2">
                    <div class="card"><small>Total Transaksi</small><strong>{{ number_format((int) $totalTransaksi, 0, ',', '.') }} transaksi</strong></div>
                    <div class="card"><small>Total Pemasukan</small><strong>Rp {{ number_format((float) $totalPemasukan, 0, ',', '.') }}</strong></div>
                </div>

                <div class="section-title">Rincian Dana Masuk</div>
                <table>
                    <thead><tr><th>Jenis Dana</th><th>Jumlah Transaksi</th><th class="amount">Total Dana</th></tr></thead>
                    <tbody>
                        @forelse ($breakdownPemasukan as $item)
                            <tr>
                                <td>{{ $item['label'] ?? '-' }}</td>
                                <td>{{ number_format((int) ($item['totalTransaksi'] ?? 0), 0, ',', '.') }} transaksi</td>
                                <td class="amount">Rp {{ number_format((float) ($item['totalDana'] ?? 0), 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" style="text-align:center; color:#6a756b; padding:24px;">Tidak ada rincian dana.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            @elseif ($report === 'pemasukan-struk')
                <div class="summary cols-3">
                    <div class="card"><small>Nama Muzaki</small><strong>{{ $trx->nama_muzakki ?? '-' }}</strong></div>
                    <div class="card"><small>Tanggal</small><strong>{{ \Illuminate\Support\Carbon::parse($trx->tanggal)->format('d M Y') }}</strong></div>
                    <div class="card"><small>Total Transaksi</small><strong>1 transaksi</strong></div>
                </div>

                <div class="section-title">Identitas Transaksi</div>
                <div class="detail-grid">
                    <div class="detail"><small>Desa / Kelurahan</small><strong>{{ $trx->desa ?? '-' }}</strong></div>
                    <div class="detail"><small>Telepon / WhatsApp</small><strong>{{ $trx->nomor_wa ?? '-' }}</strong></div>
                    <div class="detail"><small>RW / RT</small><strong>{{ $trx->alamat_detail ?? '-' }}</strong></div>
                    <div class="detail"><small>Metode Pembayaran</small><strong>{{ ($trx->jenis_pembayaran ?? 'tunai') === 'non_tunai' ? 'Non Tunai' : 'Tunai' }}</strong></div>
                </div>

                <div class="section-title">Rincian Dana</div>
                <table>
                    <thead><tr><th>Kategori</th><th>Keterangan</th><th class="amount">Nominal</th></tr></thead>
                    <tbody>
                        @foreach ($items as $row)
                            <tr>
                                <td>{{ $row['label_kategori'] ?? '-' }}</td>
                                <td>{{ $row['keterangan'] ?: '-' }}</td>
                                <td class="amount">Rp {{ number_format((float) ($row['subtotal'] ?? 0), 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @elseif ($report === 'mustahik')
                <div class="summary cols-4">
                    <div class="card"><small>Total Mustahik</small><strong>{{ number_format((int) $totalMustahik, 0, ',', '.') }}</strong></div>
                    <div class="card"><small>Aktif</small><strong>{{ number_format((int) $aktifMustahik, 0, ',', '.') }}</strong></div>
                    <div class="card"><small>Tidak Aktif</small><strong>{{ number_format((int) $tidakAktifMustahik, 0, ',', '.') }}</strong></div>
                    <div class="card"><small>Kategori Dominan</small><strong>{{ $kategoriTerbanyak }}</strong></div>
                </div>

                <div class="grid-two">
                    <div>
                        <div class="section-title">Distribusi Status</div>
                        <table>
                            <thead><tr><th>Status</th><th class="amount">Jumlah</th></tr></thead>
                            <tbody>
                                @forelse ($breakdownStatus as $item)
                                    <tr><td>{{ $item['label'] ?? '-' }}</td><td class="amount">{{ number_format((int) ($item['total'] ?? 0), 0, ',', '.') }}</td></tr>
                                @empty
                                    <tr><td colspan="2" style="text-align:center; color:#6a756b; padding:20px;">Tidak ada distribusi status.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <div class="section-title">Distribusi Kategori Asnaf</div>
                        <table>
                            <thead><tr><th>Kategori</th><th class="amount">Jumlah</th></tr></thead>
                            <tbody>
                                @forelse ($breakdownKategori as $item)
                                    <tr><td>{{ $item['label'] ?? '-' }}</td><td class="amount">{{ number_format((int) ($item['total'] ?? 0), 0, ',', '.') }}</td></tr>
                                @empty
                                    <tr><td colspan="2" style="text-align:center; color:#6a756b; padding:20px;">Tidak ada distribusi kategori.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @elseif ($report === 'penyaluran')
                <div class="summary cols-3">
                    <div class="card"><small>Total Penyaluran</small><strong>{{ number_format((int) $totalPenyaluran, 0, ',', '.') }}</strong></div>
                    <div class="card"><small>Total Penerima</small><strong>{{ number_format((int) $totalPenerimaPenyaluran, 0, ',', '.') }} orang</strong></div>
                    <div class="card"><small>Total Dana</small><strong>Rp {{ number_format((float) $totalDanaPenyaluran, 0, ',', '.') }}</strong></div>
                </div>

                <div class="grid-two">
                    <div>
                        <div class="section-title">Status Penyaluran</div>
                        <table>
                            <thead><tr><th>Status</th><th class="amount">Jumlah</th></tr></thead>
                            <tbody>
                                <tr><td>Selesai</td><td class="amount">{{ number_format((int) $berhasilPenyaluran, 0, ',', '.') }}</td></tr>
                                <tr><td>Dalam Proses</td><td class="amount">{{ number_format((int) $prosesPenyaluran, 0, ',', '.') }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <div class="section-title">Rincian Dana per Program</div>
                        <table>
                            <thead><tr><th>Program</th><th>Penerima</th><th class="amount">Dana</th></tr></thead>
                            <tbody>
                                @forelse ($breakdownProgram as $item)
                                    <tr>
                                        <td>{{ $item['label'] ?? '-' }}</td>
                                        <td>{{ number_format((int) ($item['totalPenerima'] ?? 0), 0, ',', '.') }} orang</td>
                                        <td class="amount">Rp {{ number_format((float) ($item['totalDana'] ?? 0), 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" style="text-align:center; color:#6a756b; padding:20px;">Tidak ada rincian program.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @elseif ($report === 'keuangan')
                <div class="summary cols-4">
                    <div class="card"><small>Saldo Awal</small><strong>Rp {{ number_format((float) $saldoAwal, 0, ',', '.') }}</strong></div>
                    <div class="card"><small>Total Pemasukan</small><strong>Rp {{ number_format((float) $totalPemasukan, 0, ',', '.') }}</strong></div>
                    <div class="card"><small>Total Pengeluaran</small><strong>Rp {{ number_format((float) $totalPenyaluran, 0, ',', '.') }}</strong></div>
                    <div class="card green"><small>Saldo Akhir</small><strong>Rp {{ number_format((float) $saldoBersih, 0, ',', '.') }}</strong></div>
                </div>

                <div class="grid-two">
                    <div>
                        <div class="section-title">Rincian Dana Masuk</div>
                        <table>
                            <thead><tr><th>Kategori</th><th>Transaksi</th><th class="amount">Dana</th></tr></thead>
                            <tbody>
                                @forelse ($breakdownPemasukan as $item)
                                    <tr>
                                        <td>{{ $item['label'] ?? '-' }}</td>
                                        <td>{{ number_format((int) ($item['totalTransaksi'] ?? 0), 0, ',', '.') }} transaksi</td>
                                        <td class="amount">Rp {{ number_format((float) ($item['totalDana'] ?? 0), 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" style="text-align:center; color:#6a756b; padding:20px;">Tidak ada rincian pemasukan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <div class="section-title">Rincian Pengeluaran</div>
                        <table>
                            <thead><tr><th>Program</th><th>Penerima</th><th class="amount">Dana</th></tr></thead>
                            <tbody>
                                @forelse ($breakdownPenyaluran as $item)
                                    <tr>
                                        <td>{{ $item['label'] ?? '-' }}</td>
                                        <td>{{ number_format((int) ($item['totalPenerima'] ?? 0), 0, ',', '.') }} orang</td>
                                        <td class="amount">Rp {{ number_format((float) ($item['totalDana'] ?? 0), 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" style="text-align:center; color:#6a756b; padding:20px;">Tidak ada rincian pengeluaran.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <div class="note">
                Dokumen ini dapat disimpan sebagai PDF melalui dialog cetak browser dan digunakan sebagai struk laporan.
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('load', () => window.print());
    </script>
</body>
</html>
