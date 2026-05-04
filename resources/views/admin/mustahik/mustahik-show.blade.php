<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mustahik | Admin Instansi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --green:#087026; --ink:#17211b; --muted:#748077; --surface:#f5f8f5; --line:#e2ebe4; --shadow:0 16px 34px rgba(18,55,28,.07); }
        body { min-height:100vh; margin:0; background:var(--surface); color:var(--ink); font-family:Inter,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif; }
        .page { max-width:920px; margin:0 auto; padding:42px 18px; }
        .detail-card { border:1px solid var(--line); border-radius:22px; background:#fff; box-shadow:var(--shadow); overflow:hidden; }
        .head { padding:28px 32px; border-bottom:1px solid var(--line); display:flex; align-items:flex-start; justify-content:space-between; gap:18px; }
        h1 { margin:0 0 8px; color:var(--green); font-size:1.5rem; font-weight:900; }
        .subtitle { margin:0; color:var(--muted); }
        .body { padding:32px; }
        .label { color:#344038; font-size:.72rem; font-weight:900; letter-spacing:.14em; margin-bottom:10px; text-transform:uppercase; }
        .box { min-height:54px; border-radius:16px; background:#eef2f0; padding:15px 18px; display:flex; align-items:center; }
        .box.tall { min-height:112px; align-items:flex-start; line-height:1.7; }
        .status-pill { display:inline-flex; align-items:center; min-height:28px; padding:0 12px; border-radius:999px; font-size:.72rem; font-weight:900; text-transform:uppercase; }
        .status-verified { background:#dff3e4; color:var(--green); }
        .status-pending { background:#fff2cb; color:#8a6500; }
        .status-rejected { background:#ffe1e1; color:#b42323; }
        .btn-main { min-height:44px; padding:0 20px; border-radius:12px; background:var(--green); color:#fff; display:inline-flex; align-items:center; gap:8px; font-weight:900; text-decoration:none; }
        .btn-lightline { min-height:44px; padding:0 20px; border:2px solid var(--green); border-radius:12px; color:var(--green); display:inline-flex; align-items:center; gap:8px; font-weight:900; text-decoration:none; }
    </style>
</head>
<body>
<main class="page">
    <section class="detail-card">
        <div class="head">
            <div>
                <h1>{{ $mustahik->nama }}</h1>
                <p class="subtitle">Detail data penerima manfaat dan status verifikasi.</p>
            </div>
            <span class="status-pill status-{{ $mustahik->status }}">{{ $mustahik->status }}</span>
        </div>
        <div class="body">
            <div class="row g-4">
                <div class="col-md-6"><div class="label">NIK</div><div class="box">{{ $mustahik->nik ?: '-' }}</div></div>
                <div class="col-md-6"><div class="label">Kategori Asnaf</div><div class="box">{{ ucwords($mustahik->kategori_asnaf) }}</div></div>
                <div class="col-12"><div class="label">Alamat</div><div class="box tall">{{ $mustahik->alamat ?: '-' }}</div></div>
                <div class="col-md-6"><div class="label">Latitude</div><div class="box">{{ $mustahik->latitude ?: '-' }}</div></div>
                <div class="col-md-6"><div class="label">Longitude</div><div class="box">{{ $mustahik->longitude ?: '-' }}</div></div>
                <div class="col-md-6"><div class="label">Tanggal Verifikasi</div><div class="box">{{ optional($mustahik->tanggal_verifikasi)->format('d M Y H:i') ?: '-' }}</div></div>
                <div class="col-md-6"><div class="label">Terakhir Diubah</div><div class="box">{{ optional($mustahik->updated_at)->format('d M Y H:i') ?: '-' }}</div></div>
            </div>
            <div class="d-flex flex-column flex-sm-row gap-3 justify-content-end mt-5">
                <a class="btn-lightline" href="{{ route('mustahik.index') }}"><i class="bi bi-arrow-left"></i>Kembali</a>
                <a class="btn-main" href="{{ route('mustahik.edit', $mustahik) }}"><i class="bi bi-pencil-fill"></i>Edit Data</a>
            </div>
        </div>
    </section>
</main>
</body>
</html>
