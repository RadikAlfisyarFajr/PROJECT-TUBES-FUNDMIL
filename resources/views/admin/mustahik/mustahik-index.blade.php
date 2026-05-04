<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mustahik | Admin Instansi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --green:#087026; --green-dark:#06451f; --ink:#17211b; --muted:#748077; --surface:#f5f8f5; --sidebar:#f4f8f2; --line:#e2ebe4; --shadow:0 16px 34px rgba(18,55,28,.07); }
        * { box-sizing:border-box; letter-spacing:0; }
        body { min-height:100vh; margin:0; overflow-x:hidden; background:var(--surface); color:var(--ink); font-family:Inter,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif; }
        .admin-layout { min-height:100vh; display:grid; grid-template-columns:88px minmax(0,1fr); transition:grid-template-columns .25s ease; }
        body.sidebar-expanded .admin-layout { grid-template-columns:280px minmax(0,1fr); }
        .sidebar { min-height:100vh; padding:20px 12px 24px; background:var(--sidebar); border-right:1px solid var(--line); display:flex; flex-direction:column; overflow-x:hidden; transition:padding .25s ease; }
        body.sidebar-expanded .sidebar { padding:38px 18px 28px; }
        .brand { min-height:52px; display:flex; align-items:center; justify-content:center; gap:10px; overflow:hidden; }
        body.sidebar-expanded .brand { justify-content:flex-start; padding:0 18px; }
        .brand-icon { width:28px; height:28px; border-radius:10px; background:var(--green); color:#fff; display:grid; place-items:center; flex:0 0 auto; }
        .brand-copy { display:none; white-space:nowrap; }
        body.sidebar-expanded .brand-copy { display:block; }
        .brand-title { margin-bottom:8px; color:var(--green-dark); font-size:1.25rem; font-weight:900; }
        .brand-subtitle { color:#9ba49e; font-size:.68rem; font-weight:800; letter-spacing:.32em; }
        .sidebar-nav { margin-top:52px; display:grid; gap:10px; }
        .sidebar-toggle,.nav-item-link { width:58px; height:58px; min-height:58px; margin-inline:auto; border:0; border-radius:16px; background:transparent; color:#294158; display:flex; align-items:center; justify-content:center; gap:16px; font-weight:700; text-decoration:none; white-space:nowrap; overflow:hidden; transition:.25s ease; }
        body.sidebar-expanded .sidebar-toggle, body.sidebar-expanded .nav-item-link { width:100%; padding:0 18px; justify-content:flex-start; }
        .nav-item-link:hover,.nav-item-link.active,.sidebar-toggle:hover { background:#fff; color:var(--green); }
        .nav-item-link.active { background:#dceee2; }
        .sidebar-toggle i,.nav-item-link i { width:24px; color:var(--green-dark); font-size:1.25rem; text-align:center; flex:0 0 auto; }
        .nav-item-link span,.sidebar-toggle span { display:none; }
        body.sidebar-expanded .nav-item-link span, body.sidebar-expanded .sidebar-toggle span { display:inline; }
        .sidebar-footer { margin-top:auto; padding-top:18px; border-top:1px solid var(--line); }
        .main-content { min-width:0; padding:18px 24px 38px; }
        .topbar { min-height:56px; margin:-18px -24px 34px; padding:16px 24px; background:#fff; border-bottom:1px solid rgba(226,235,228,.8); display:flex; align-items:center; justify-content:space-between; gap:24px; }
        .page-title { margin:0; font-size:1.12rem; font-weight:900; }
        .top-actions { display:flex; align-items:center; gap:14px; }
        .search-box { width:min(330px,34vw); height:34px; padding:0 12px; border-radius:8px; background:#f2f5f3; color:var(--muted); display:flex; align-items:center; gap:8px; }
        .search-box input { width:100%; border:0; outline:0; background:transparent; font-size:.78rem; }
        .avatar { width:28px; height:28px; border-radius:50%; background:#10384a; color:#fff; display:grid; place-items:center; font-size:.72rem; font-weight:800; }
        .content-wrap { max-width:1180px; margin:0 auto; }
        .page-intro { margin-bottom:24px; display:flex; align-items:flex-start; justify-content:space-between; gap:24px; }
        .page-desc { max-width:630px; margin:0; color:#506057; font-size:.92rem; line-height:1.65; }
        .primary-btn { min-height:48px; padding:0 24px; border:0; border-radius:16px; background:var(--green); color:#fff; box-shadow:0 12px 24px rgba(8,112,38,.22); display:inline-flex; align-items:center; gap:10px; font-weight:800; text-decoration:none; white-space:nowrap; }
        .stat-card,.panel { border:1px solid var(--line); border-radius:18px; background:#fff; box-shadow:var(--shadow); }
        .stat-card { min-height:132px; padding:22px; }
        .stat-icon { width:44px; height:44px; border-radius:14px; display:grid; place-items:center; background:#dff3e4; color:var(--green); font-size:1.2rem; }
        .stat-label { color:var(--muted); font-size:.68rem; font-weight:900; letter-spacing:.18em; text-transform:uppercase; }
        .stat-value { margin:12px 0 0; font-size:2rem; font-weight:900; }
        .filter-panel { padding:18px; margin-bottom:20px; }
        .form-control,.form-select { border:0; background:#eef2f0; min-height:42px; border-radius:12px; }
        .table-panel { overflow:hidden; }
        .table { margin:0; min-width:860px; }
        .table thead th { background:#ebeeec; border:0; color:#243024; font-size:.72rem; font-weight:900; letter-spacing:.16em; padding:18px 22px; text-transform:uppercase; }
        .table tbody td { border-color:#e5ebe6; padding:18px 22px; vertical-align:middle; }
        .status-pill { display:inline-flex; align-items:center; min-height:24px; padding:0 10px; border-radius:999px; font-size:.68rem; font-weight:900; text-transform:uppercase; }
        .status-verified { background:#dff3e4; color:var(--green); }
        .status-pending { background:#fff2cb; color:#8a6500; }
        .status-rejected { background:#ffe1e1; color:#b42323; }
        .action-link { border:0; background:transparent; color:var(--green); padding:6px; }
        .pagination { margin:0; }
        @media (max-width:991px) { .admin-layout{grid-template-columns:1fr}.sidebar{min-height:auto}.main-content{padding:18px 16px 34px}.topbar{margin:-18px -16px 28px;padding:16px;flex-direction:column;align-items:flex-start}.top-actions,.search-box{width:100%}.page-intro{flex-direction:column}.primary-btn{width:100%;justify-content:center} }
    </style>
</head>
<body class="sidebar-expanded">
<div class="admin-layout">
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon"><i class="bi bi-shield-lock-fill"></i></div>
            <div class="brand-copy">
                <div class="brand-title">FUNDMIL SOREANG</div>
                <div class="brand-subtitle">SISTEM AMANAH DIGITAL</div>
            </div>
        </div>
        <nav class="sidebar-nav" aria-label="Navigasi Admin Instansi">
            <button id="sidebarToggle" class="sidebar-toggle" type="button"><i class="bi bi-list"></i><span>Menu</span></button>
            <a class="nav-item-link" href="{{ route('dashboard.admin') }}"><i class="bi bi-house-door-fill"></i><span>Beranda</span></a>
            <a class="nav-item-link" href="{{ route('profil-instansi.index') }}"><i class="bi bi-person-badge-fill"></i><span>Profil Instansi</span></a>
            <a class="nav-item-link" href="{{ route('kategori-dana.index') }}"><i class="bi bi-tags-fill"></i><span>Kategori Dana</span></a>
            <a class="nav-item-link" href="{{ route('pemasukan.index') }}"><i class="bi bi-cash-stack"></i><span>Pemasukan Zakat</span></a>
            <a class="nav-item-link active" href="{{ route('mustahik.index') }}"><i class="bi bi-people-fill"></i><span>Data Mustahik</span></a>
            <a class="nav-item-link" href="{{ route('program-penyaluran.index') }}"><i class="bi bi-stars"></i><span>Program Penyaluran</span></a>
            <a class="nav-item-link" href="{{ route('pengaturan-distribusi.index') }}"><i class="bi bi-sliders2-vertical"></i><span>Pengaturan Distribusi</span></a>
            <a class="nav-item-link" href="{{ route('laporan.index') }}"><i class="bi bi-bar-chart-fill"></i><span>Laporan</span></a>
        </nav>
        <div class="sidebar-footer"><a class="nav-item-link" href="#"><i class="bi bi-question-circle"></i><span>Bantuan</span></a></div>
    </aside>
    <main class="main-content">
        <header class="topbar">
            <h1 class="page-title">Data Mustahik</h1>
            <div class="top-actions">
                <form class="search-box" action="{{ route('mustahik.index') }}" method="GET">
                    <i class="bi bi-search"></i>
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari mustahik...">
                </form>
                <i class="bi bi-bell-fill text-muted"></i>
                <div class="avatar">A</div>
            </div>
        </header>
        <div class="content-wrap">
            <div class="page-intro">
                <p class="page-desc">Kelola data penerima manfaat, status verifikasi, dan kategori asnaf agar proses penyaluran tetap rapi dan mudah diaudit.</p>
                <a class="primary-btn" href="{{ route('mustahik.create') }}"><i class="bi bi-person-plus-fill"></i>Tambah Mustahik</a>
            </div>

            @if (session('success'))
                <div class="alert alert-success border-0 rounded-4 fw-bold">{{ session('success') }}</div>
            @endif

            <div class="row g-4 mb-4">
                <div class="col-md-4"><section class="stat-card"><div class="d-flex justify-content-between"><div class="stat-icon"><i class="bi bi-people-fill"></i></div><span class="stat-label">Total</span></div><p class="stat-value">{{ $totalMustahik }}</p></section></div>
                <div class="col-md-4"><section class="stat-card"><div class="d-flex justify-content-between"><div class="stat-icon"><i class="bi bi-patch-check-fill"></i></div><span class="stat-label">Terverifikasi</span></div><p class="stat-value">{{ $verifiedMustahik }}</p></section></div>
                <div class="col-md-4"><section class="stat-card"><div class="d-flex justify-content-between"><div class="stat-icon"><i class="bi bi-hourglass-split"></i></div><span class="stat-label">Pending</span></div><p class="stat-value">{{ $pendingMustahik }}</p></section></div>
            </div>

            <form class="panel filter-panel" action="{{ route('mustahik.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-lg-5"><input class="form-control" name="search" value="{{ request('search') }}" placeholder="Nama, NIK, alamat, atau asnaf"></div>
                    <div class="col-lg-3">
                        <select class="form-select" name="kategori">
                            <option value="semua">Semua Asnaf</option>
                            @foreach ($kategoriAsnaf as $value => $label)
                                <option value="{{ $value }}" @selected(request('kategori') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <select class="form-select" name="status">
                            <option value="semua">Semua Status</option>
                            <option value="verified" @selected(request('status') === 'verified')>Verified</option>
                            <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                            <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
                        </select>
                    </div>
                    <div class="col-lg-2"><button class="primary-btn w-100 justify-content-center" type="submit"><i class="bi bi-funnel-fill"></i>Filter</button></div>
                </div>
            </form>

            <section class="panel table-panel">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead><tr><th>Mustahik</th><th>Asnaf</th><th>Status</th><th>Alamat</th><th class="text-end">Aksi</th></tr></thead>
                        <tbody>
                        @forelse ($mustahik as $row)
                            <tr>
                                <td><strong>{{ $row->nama }}</strong><div class="text-muted small">{{ $row->nik ?: 'NIK belum diisi' }}</div></td>
                                <td>{{ $kategoriAsnaf[$row->kategori_asnaf] ?? ucfirst($row->kategori_asnaf) }}</td>
                                <td><span class="status-pill status-{{ $row->status }}">{{ $row->status }}</span></td>
                                <td>{{ $row->alamat ?: '-' }}</td>
                                <td class="text-end">
                                    <a class="action-link" href="{{ route('mustahik.show', $row) }}" aria-label="Detail"><i class="bi bi-eye-fill"></i></a>
                                    <a class="action-link" href="{{ route('mustahik.edit', $row) }}" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                                    <form class="d-inline" action="{{ route('mustahik.destroy', $row) }}" method="POST" onsubmit="return confirm('Hapus data mustahik ini?')">
                                        @csrf @method('DELETE')
                                        <button class="action-link text-danger" aria-label="Hapus"><i class="bi bi-trash-fill"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-5 text-center text-muted">Belum ada data mustahik.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="border-top px-4 py-3">{{ $mustahik->links() }}</div>
            </section>
        </div>
    </main>
</div>
<script>document.getElementById('sidebarToggle').addEventListener('click',()=>document.body.classList.toggle('sidebar-expanded'));</script>
</body>
</html>
