@php
$title = 'Daftar Pemasukan Zakat';
$description = 'Kelola pemasukan zakat dengan antarmuka admin instansi yang konsisten.';
$active = 'pemasukan';
$roleLabel = 'Admin Instansi';
$sidebar = 'admin.partials.sidebar';
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | {{ $roleLabel }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>

<body class="sidebar-expanded">
    <div class="admin-layout">
        @include($sidebar, ['active' => $active])

        <main class="admin-page-content">
            <header class="admin-page-topbar">
                <div>
                    <h1 class="admin-page-title">{{ $title }}</h1>
                    <p class="admin-page-desc">{{ $description }}</p>
                </div>
                <div class="admin-top-actions">

                    <button class="admin-icon-btn has-dot" type="button" aria-label="Notifikasi">
                        <i class="bi bi-bell-fill"></i>
                    </button>
                    @include('admin.partials.account-identity')
                </div>
            </header>

            <div class="admin-content-wrap">
                <!-- Section Input Pemasukan -->
                <section class="admin-panel" style="margin-bottom: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h3 style="margin: 0; font-size: 18px; font-weight: 600;">Input Pemasukan Zakat</h3>
                        <a href="{{ route('pemasukan.create') }}" class="admin-primary-btn" style="padding: 13px 26px; border-radius: 22px; background: var(--green); color:#fff; font-weight: 900; box-shadow: 0 12px 24px rgba(7, 101, 31, .2); display:inline-flex; align-items:center; gap:10px; text-decoration: none;">
                            <i class="bi bi-plus-lg"></i>
                            <span>Buat Baru</span>
                        </a>
                    </div>
                    <p style="color: #666; margin: 0;">Klik tombol "Buat Baru" untuk menambahkan pemasukan zakat baru ke dalam sistem.</p>
                </section>

                <!-- Section Riwayat Transaksi -->
                <section class="admin-panel">
                    <h3 style="margin: 0 0 20px 0; font-size: 18px; font-weight: 600;">Riwayat Transaksi</h3>

                    <div class="table-responsive" style="height: 400px; overflow-y: auto; border: 1px solid #e5e7eb; border-radius: 16px;">
                        <table class="table align-middle" style="margin-bottom: 0; min-width: 980px; border-collapse: separate; border-spacing: 0;">
                            <thead>
                                <tr class="bg-[#F8F9FA]" style="position: sticky; top: 0; z-index: 1;">
                                    <th style="width: 70px; text-align: center; padding: 0 20px; font-weight: 600; background: #F8F9FA;" class="py-2">No</th>
                                    <th style="width: 280px; padding: 0 20px; font-weight: 600; background: #F8F9FA;" class="py-2">Kode</th>
                                    <th style="padding: 0 20px; font-weight: 600; background: #F8F9FA;" class="py-2">Nama Muzakki</th>
                                    <th style="width: 180px; text-align: center; padding: 0 20px; font-weight: 600; background: #F8F9FA;" class="py-2">Tanggal</th>
                                    <th style="width: 90px; text-align: center; padding: 0 20px; font-weight: 600; background: #F8F9FA;" class="py-2">View</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($transaksi as $trx)
                                <tr style="height: 55px; vertical-align: middle;" class="border-bottom">
                                    <td style="width: 70px; text-align: center; padding: 0 20px; vertical-align: middle;">
                                        <small>{{ $loop->iteration }}</small>
                                    </td>
                                    <td style="width: 280px; padding: 0 20px; vertical-align: middle;">
                                        <small><strong>{{ $trx->nomor_kuitansi }}</strong></small>
                                    </td>
                                    <td style="padding: 0 20px; vertical-align: middle; min-width: 220px;">{{ $trx->nama_muzakki }}</td>
                                    <td style="width: 180px; text-align: center; padding: 0 20px; vertical-align: middle;">
                                        <small>{{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}</small>
                                    </td>
                                    <td style="width: 90px; text-align: center; padding: 0 20px; vertical-align: middle;">
                                        <button
                                            class="btn btn-sm btn-link p-0"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $trx->nomor_kuitansi }}"
                                            title="Lihat Detail"
                                            style="text-decoration: none;">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted" style="font-weight: 600;">
                                        Belum ada data pemasukan zakat
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    <style>
                        /* zebra stripe + hover */
                        table.table > tbody > tr:nth-of-type(odd) { background-color: #ffffff; }
                        table.table > tbody > tr:nth-of-type(even) { background-color: #F8FAFC; }
                        table.table > tbody > tr:hover { background-color: #F8FAFC; }
                    </style>
                    </div>

                    @if($transaksi->hasPages())
                    <div class="mt-3">{{ $transaksi->links() }}</div>
                    @endif

                    <!-- Modal detail dipisahkan dari struktur tabel agar layout tidak rusak -->
                    @foreach($transaksi as $trx)
                    <div
                        class="modal fade"
                        id="detailModal{{ $trx->nomor_kuitansi }}"
                        tabindex="-1"
                        aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div>
                                        <h6 class="modal-title mb-1">{{ $trx->nama_muzakki }}</h6>
                                        <small class="text-muted">{{ $trx->nomor_kuitansi }}</small>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                                    <div style="margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #e5e7eb;">
                                        <small class="text-muted" style="display: block;">Tanggal Transaksi</small>
                                        <small>
                                            <strong>{{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}</strong>
                                        </small>
                                    </div>

                                    <div style="margin-bottom: 12px;">
                                        <small class="text-muted" style="display: block; margin-bottom: 8px;">Kategori Dana</small>
                                    </div>

                                    <table class="table table-sm mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Kategori</th>
                                                <th style="text-align: right;">Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($trx->items as $item)
                                            <tr>
                                                <td><small>{{ $item->kategori?->nama ?? '—' }}</small></td>
                                                <td style="text-align: right;"><small>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</small></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <div style="margin-top: 12px; padding-top: 12px; border-top: 2px solid #e5e7eb;">
                                        <div style="display: flex; justify-content: space-between;">
                                            <strong style="font-size: 14px;">Total</strong>
                                            <strong style="font-size: 14px; color: #07651f;">Rp {{ number_format($trx->jumlah_total, 0, ',', '.') }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </section>
            </div>
        </main>
    </div>

    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        sidebarToggle?.addEventListener('click', () => {
            document.body.classList.toggle('sidebar-expanded');
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>