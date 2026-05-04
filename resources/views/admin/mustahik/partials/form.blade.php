<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | Admin Instansi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --green:#087026; --green-dark:#06451f; --ink:#17211b; --muted:#748077; --surface:#f5f8f5; --line:#e2ebe4; --shadow:0 16px 34px rgba(18,55,28,.07); }
        * { box-sizing:border-box; letter-spacing:0; }
        body { min-height:100vh; margin:0; background:var(--surface); color:var(--ink); font-family:Inter,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif; }
        .shell { min-height:100vh; display:grid; place-items:center; padding:36px 18px; position:relative; overflow:hidden; }
        .shell::before { content:""; position:absolute; inset:0; background:linear-gradient(135deg,rgba(8,112,38,.12),rgba(255,255,255,.8)); }
        .form-card { width:min(760px,100%); border:1px solid var(--line); border-radius:22px; background:#fff; box-shadow:var(--shadow); position:relative; overflow:hidden; }
        .form-head { min-height:88px; padding:24px 30px; border-bottom:1px solid var(--line); display:flex; align-items:center; justify-content:space-between; gap:18px; }
        .form-title { margin:0; color:var(--green); font-size:1.35rem; font-weight:900; }
        .close-link { width:42px; height:42px; border-radius:14px; display:grid; place-items:center; color:#17231b; text-decoration:none; font-size:1.8rem; line-height:1; }
        .form-body { padding:30px; }
        .section-title { margin:0 0 22px; padding-left:12px; border-left:4px solid var(--green); color:#303b34; font-size:.82rem; font-weight:900; letter-spacing:.2em; text-transform:uppercase; }
        .field-label { color:#344038; font-size:.72rem; font-weight:900; letter-spacing:.14em; margin-bottom:10px; text-transform:uppercase; }
        .form-control,.form-select { border:0; background:#e9eeeb; min-height:46px; border-radius:12px; }
        .form-control:focus,.form-select:focus { border:0; box-shadow:0 0 0 .2rem rgba(8,112,38,.16); background:#fff; }
        textarea.form-control { min-height:116px; resize:vertical; }
        .form-foot { min-height:92px; padding:22px 30px; border-top:1px solid var(--line); background:#f8faf9; display:flex; align-items:center; justify-content:space-between; gap:18px; }
        .muted-note { color:var(--muted); font-size:.76rem; line-height:1.5; }
        .btn-cancel { min-height:48px; padding:0 22px; border:2px solid var(--green); border-radius:12px; color:var(--green); display:inline-flex; align-items:center; font-weight:900; text-decoration:none; }
        .btn-save { min-height:48px; padding:0 28px; border:0; border-radius:12px; background:var(--green); color:#fff; box-shadow:0 10px 20px rgba(8,112,38,.25); font-weight:900; }
        @media (max-width:640px) { .form-head,.form-body,.form-foot{padding-inline:20px}.form-foot{align-items:stretch;flex-direction:column}.btn-cancel,.btn-save{justify-content:center;width:100%} }
    </style>
</head>
<body>
<main class="shell">
    <form class="form-card" action="{{ $action }}" method="POST">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif
        <div class="form-head">
            <h1 class="form-title">{{ $title }}</h1>
            <a class="close-link" href="{{ route('mustahik.index') }}" aria-label="Tutup">&times;</a>
        </div>

        @if ($errors->any())
            <div class="mx-4 mt-4 alert alert-danger border-0 rounded-4 fw-bold">Lengkapi data yang masih belum valid.</div>
        @endif

        <div class="form-body">
            <section>
                <h2 class="section-title">Identitas Mustahik</h2>
                <div class="row g-4">
                    <div class="col-md-7">
                        <label class="field-label" for="nama">Nama Lengkap</label>
                        <input id="nama" class="form-control" name="nama" value="{{ old('nama', $mustahik->nama ?? '') }}" required placeholder="Contoh: Ahmad Fauzi">
                        @error('nama') <div class="text-danger small fw-bold mt-2">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-5">
                        <label class="field-label" for="nik">NIK</label>
                        <input id="nik" class="form-control" name="nik" value="{{ old('nik', $mustahik->nik ?? '') }}" inputmode="numeric" maxlength="16" placeholder="16 digit">
                        @error('nik') <div class="text-danger small fw-bold mt-2">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="field-label" for="kategori_asnaf">Kategori Asnaf</label>
                        <select id="kategori_asnaf" class="form-select" name="kategori_asnaf" required>
                            <option value="">Pilih kategori</option>
                            @foreach ($kategoriAsnaf as $value => $label)
                                <option value="{{ $value }}" @selected(old('kategori_asnaf', $mustahik->kategori_asnaf ?? '') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('kategori_asnaf') <div class="text-danger small fw-bold mt-2">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="field-label" for="status">Status Verifikasi</label>
                        <select id="status" class="form-select" name="status" required>
                            <option value="pending" @selected(old('status', $mustahik->status ?? 'pending') === 'pending')>Pending</option>
                            <option value="verified" @selected(old('status', $mustahik->status ?? '') === 'verified')>Verified</option>
                            <option value="rejected" @selected(old('status', $mustahik->status ?? '') === 'rejected')>Rejected</option>
                        </select>
                        @error('status') <div class="text-danger small fw-bold mt-2">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label class="field-label" for="alamat">Alamat</label>
                        <textarea id="alamat" class="form-control" name="alamat" placeholder="Alamat lengkap mustahik">{{ old('alamat', $mustahik->alamat ?? '') }}</textarea>
                        @error('alamat') <div class="text-danger small fw-bold mt-2">{{ $message }}</div> @enderror
                    </div>
                </div>
            </section>

            <section class="mt-5">
                <h2 class="section-title">Titik Lokasi</h2>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="field-label" for="latitude">Latitude</label>
                        <input id="latitude" class="form-control" name="latitude" value="{{ old('latitude', $mustahik->latitude ?? '') }}" placeholder="-7.02500000">
                        @error('latitude') <div class="text-danger small fw-bold mt-2">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="field-label" for="longitude">Longitude</label>
                        <input id="longitude" class="form-control" name="longitude" value="{{ old('longitude', $mustahik->longitude ?? '') }}" placeholder="107.52000000">
                        @error('longitude') <div class="text-danger small fw-bold mt-2">{{ $message }}</div> @enderror
                    </div>
                </div>
            </section>
        </div>

        <div class="form-foot">
            <div class="muted-note"><i class="bi bi-info-circle-fill text-success me-2"></i>Status verified otomatis mencatat waktu verifikasi.</div>
            <div class="d-flex gap-3 flex-column flex-sm-row">
                <a class="btn-cancel" href="{{ route('mustahik.index') }}">Batal</a>
                <button class="btn-save" type="submit">Simpan Data</button>
            </div>
        </div>
    </form>
</main>
</body>
</html>
