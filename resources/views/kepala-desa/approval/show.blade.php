@php
    $rupiah = fn ($value) => 'Rp ' . number_format((float) $value, 0, ',', '.');
    $statusLabel = [
        'pending' => 'Menunggu Diproses',
        'approved' => 'Sudah Diproses - Disetujui',
        'rejected' => 'Ditolak',
        'draft' => 'Menunggu Diproses',
    ][$program->approval_status] ?? $program->approval_status;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="30">
    <title>Detail Approval Program | Admin Kepala Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>
<body class="sidebar-expanded">
    <div class="admin-layout">
        @include('kepala-desa.partials.sidebar', ['active' => 'approval'])

        <main class="admin-page-content">
            <header class="admin-page-topbar">
                <div>
                    <h1 class="admin-page-title">Detail Approval Program</h1>
                    <p class="admin-page-desc">{{ $program->nama_program }}</p>
                </div>
                <div class="admin-top-actions">
                    <a class="admin-secondary-btn" href="{{ route('kepala-desa.approval.index') }}">
                        <i class="bi bi-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                    @include('admin.partials.account-identity')
                </div>
            </header>

            <div class="admin-content-wrap">
                @if($errors->any())
                    <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">{{ $errors->first() }}</div>
                @endif

                <section class="super-grid">
                    <div class="admin-panel">
                        <h2 class="super-section-title">Rincian Program</h2>
                        <dl class="super-detail-list">
                            <div><dt>Program</dt><dd>{{ $program->nama_program }}</dd></div>
                            <div><dt>Instansi</dt><dd>{{ $program->instansi?->nama ?? '-' }}</dd></div>
                            <div><dt>Tipe Instansi</dt><dd>{{ $program->instansi?->tipe ?? '-' }}</dd></div>
                            <div><dt>Periode</dt><dd>{{ $program->tanggal_mulai?->format('d M Y') ?? '-' }} sampai {{ $program->tanggal_selesai?->format('d M Y') ?? '-' }}</dd></div>
                            <div><dt>Total Dana</dt><dd>{{ $rupiah($program->total_dana ?? 0) }}</dd></div>
                            <div><dt>Target Mustahik</dt><dd>{{ $program->target_mustahik ?? 0 }} orang</dd></div>
                            <div><dt>Status Operasional</dt><dd>{{ ucfirst($program->status) }}</dd></div>
                            <div><dt>Status Approval</dt><dd>{{ $statusLabel }}</dd></div>
                            <div><dt>Kategori Dana</dt><dd>{{ $program->kategoriDana->pluck('nama')->join(', ') ?: '-' }}</dd></div>
                            <div><dt>Catatan Terakhir</dt><dd>{{ $program->approval_note ?: '-' }}</dd></div>
                        </dl>
                    </div>

                    <div class="admin-panel">
                        <h2 class="super-section-title">Rekomendasi Kepala Desa</h2>
                        <p class="super-section-desc">Persetujuan akan mengubah status program menjadi disetujui.</p>

                        @if($program->approval_status === 'pending' || $program->approval_status === 'draft')
                            <form method="POST" action="{{ route('kepala-desa.approval.approve', $program) }}" class="mt-4">
                                @csrf
                                <label class="distribution-label" for="approval_note">Catatan Rekomendasi</label>
                                <textarea id="approval_note" name="approval_note" class="distribution-textarea" placeholder="Contoh: Program sesuai kebutuhan warga dan data sasaran desa.">{{ old('approval_note') }}</textarea>
                                <button class="distribution-submit-btn w-100 mt-3" type="submit">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Setujui Program</span>
                                </button>
                            </form>

                            <form method="POST" action="{{ route('kepala-desa.approval.reject', $program) }}" class="mt-3">
                                @csrf
                                <label class="distribution-label" for="reject_note">Alasan Penolakan</label>
                                <textarea id="reject_note" name="approval_note" class="distribution-textarea" required placeholder="Tuliskan alasan penolakan agar admin instansi dapat memperbaiki pengajuan.">{{ old('approval_note') }}</textarea>
                                <button class="super-danger-btn w-100 mt-3" type="submit">
                                    <i class="bi bi-x-circle-fill"></i>
                                    <span>Tolak Program</span>
                                </button>
                            </form>
                        @else
                            <div class="admin-empty-state">
                                <div class="admin-empty-icon"><i class="bi bi-clipboard-check-fill"></i></div>
                                <h2>Program Sudah Diproses</h2>
                                <p>Diproses oleh {{ $program->approver?->name ?? '-' }} pada {{ $program->approved_at?->format('d M Y H:i') ?? '-' }}.</p>
                            </div>
                        @endif
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
