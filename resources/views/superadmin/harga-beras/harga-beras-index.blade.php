@php $rupiah = fn ($value) => 'Rp ' . number_format((float) $value, 0, ',', '.'); @endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harga Beras | Super Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>
<body class="sidebar-expanded">
    <div class="admin-layout">
        @include('superadmin.partials.sidebar', ['active' => 'harga-beras'])

        <main class="admin-page-content">
            <header class="admin-page-topbar">
                <div>
                    <h1 class="admin-page-title">Harga Beras Pasar</h1>
                    <p class="admin-page-desc">Acuan konversi nasional untuk zakat fitrah berbasis beras.</p>
                </div>
                <a class="distribution-submit-btn" href="{{ route('superadmin.harga-beras.create') }}">
                    <i class="bi bi-plus-lg"></i>
                    <span>Tambah Harga</span>
                </a>
            </header>

            <div class="admin-content-wrap">
                @if(session('success'))
                    <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4">{{ session('success') }}</div>
                @endif

                <section class="super-stat-grid mb-4">
                    <article class="super-stat-card">
                        <span>Harga berlaku</span>
                        <strong>{{ $rupiah($latest?->harga_per_kg ?? 0) }}</strong>
                    </article>
                    <article class="super-stat-card">
                        <span>Tanggal acuan</span>
                        <strong>{{ $latest ? $latest->tanggal_berlaku?->format('d M Y') . ' - ' . ($latest->tanggal_berakhir?->format('d M Y') ?? 'seterusnya') : '-' }}</strong>
                    </article>
                </section>

                <section class="admin-panel">
                    <div class="table-responsive">
                        <table class="table super-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Berlaku Mulai</th>
                                    <th>Berlaku Sampai</th>
                                    <th class="text-end">Harga per Kg</th>
                                    <th>Keterangan</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($hargaBeras as $item)
                                    <tr>
                                        <td class="fw-bold">{{ $item->tanggal_berlaku?->format('d M Y') }}</td>
                                        <td>{{ $item->tanggal_berakhir?->format('d M Y') ?? 'Seterusnya' }}</td>
                                        <td class="text-end">{{ $rupiah($item->harga_per_kg) }}</td>
                                        <td>{{ $item->keterangan ?? '-' }}</td>
                                        <td class="text-end">
                                            <div class="d-inline-flex gap-2">
                                                <a class="admin-secondary-btn" href="{{ route('superadmin.harga-beras.edit', $item) }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                    <span>Edit</span>
                                                </a>
                                                <form method="POST" action="{{ route('superadmin.harga-beras.destroy', $item) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="super-danger-btn" type="submit">
                                                        <i class="bi bi-trash3"></i>
                                                        <span>Hapus</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-5">Belum ada harga beras acuan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $hargaBeras->links() }}</div>
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
