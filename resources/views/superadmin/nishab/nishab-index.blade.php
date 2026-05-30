@php $rupiah = fn ($value) => 'Rp ' . number_format((float) $value, 0, ',', '.'); @endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nishab | Super Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>
<body class="sidebar-expanded">
    <div class="admin-layout">
        @include('superadmin.partials.sidebar', ['active' => 'nishab'])

        <main class="admin-page-content">
            <header class="admin-page-topbar">
                <div>
                    <h1 class="admin-page-title">Nishab Zakat</h1>
                    <p class="admin-page-desc">Batas nilai zakat maal dan parameter fitrah sebagai acuan nasional.</p>
                </div>
                <a class="distribution-submit-btn" href="{{ route('superadmin.nishab.create') }}">
                    <i class="bi bi-plus-lg"></i>
                    <span>Tambah Nishab</span>
                </a>
            </header>

            <div class="admin-content-wrap">
                @if(session('success'))
                    <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4">{{ session('success') }}</div>
                @endif

                <section class="super-stat-grid mb-4">
                    <article class="super-stat-card">
                        <span>Nishab maal berlaku</span>
                        <strong>{{ $rupiah($latestMaal?->nishab_rupiah ?? 0) }}</strong>
                    </article>
                    <article class="super-stat-card">
                        <span>Tanggal acuan</span>
                        <strong>{{ $latestMaal ? $latestMaal->tanggal_berlaku?->format('d M Y') . ' - ' . ($latestMaal->tanggal_berakhir?->format('d M Y') ?? 'seterusnya') : '-' }}</strong>
                    </article>
                </section>

                <section class="admin-panel">
                    <div class="table-responsive">
                        <table class="table super-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Jenis</th>
                                    <th class="text-end">Nishab Kg</th>
                                    <th class="text-end">Nishab Rupiah</th>
                                    <th>Berlaku Mulai</th>
                                    <th>Berlaku Sampai</th>
                                    <th>Keterangan</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($nishabs as $item)
                                    <tr>
                                        <td class="fw-bold">{{ ucwords(str_replace('_', ' ', $item->jenis_zakat)) }}</td>
                                        <td class="text-end">{{ $item->nishab_kg ? number_format((float) $item->nishab_kg, 2, ',', '.') . ' kg' : '-' }}</td>
                                        <td class="text-end">{{ $item->nishab_rupiah ? $rupiah($item->nishab_rupiah) : '-' }}</td>
                                        <td>{{ $item->tanggal_berlaku?->format('d M Y') }}</td>
                                        <td>{{ $item->tanggal_berakhir?->format('d M Y') ?? 'Seterusnya' }}</td>
                                        <td>{{ $item->keterangan ?? '-' }}</td>
                                        <td class="text-end">
                                            <div class="d-inline-flex gap-2">
                                                <a class="admin-secondary-btn" href="{{ route('superadmin.nishab.edit', $item) }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                    <span>Edit</span>
                                                </a>
                                                <form method="POST" action="{{ route('superadmin.nishab.destroy', $item) }}">
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
                                        <td colspan="7" class="text-center text-muted py-5">Belum ada parameter nishab.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $nishabs->links() }}</div>
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
