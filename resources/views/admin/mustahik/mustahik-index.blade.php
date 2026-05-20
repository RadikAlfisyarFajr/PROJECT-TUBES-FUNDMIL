<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Database Mustahik - Fundmil Soreang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>
<body class="sidebar-expanded overflow-x-hidden bg-[#f6f8f6] font-sans text-[#111813] antialiased">
@php
    $badgeKategori = [
        'fakir' => 'bg-rose-50 text-rose-700 ring-rose-100',
        'miskin' => 'bg-amber-50 text-amber-700 ring-amber-100',
        'amil' => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
        'riqab' => 'bg-sky-50 text-sky-700 ring-sky-100',
        'gharim' => 'bg-violet-50 text-violet-700 ring-violet-100',
        'fisabilillah' => 'bg-fuchsia-50 text-fuchsia-700 ring-fuchsia-100',
        'ibnu_sabil' => 'bg-slate-100 text-slate-700 ring-slate-200',
    ];
    $hasFilters = request()->filled('search') || request('kategori', 'semua') !== 'semua' || request('status', 'semua') !== 'semua';
@endphp
<div class="admin-layout">
    @include('admin.partials.sidebar', ['active' => 'mustahik'])

    <main class="min-w-0 flex-1 overflow-x-hidden">
        <header class="flex min-h-[64px] items-center justify-between border-b border-[#e8efeb] bg-white px-6 py-3 lg:px-[34px]">
            <div class="hidden">
                <div class="text-[11px] font-bold text-[#92a09a]">Dashboard <span class="mx-2">›</span> <span class="text-[#0b751f]">Database Mustahik</span></div>
                <h1 class="mt-1 truncate text-[20px] font-black">Data Mustahik</h1>
            </div>
            <div class="flex w-full items-center justify-between gap-[24px]">
                <form action="{{ route('mustahik.index') }}" method="GET" class="flex h-[38px] w-full max-w-[420px] items-center gap-3 rounded-full bg-[#eef2f0] px-4 lg:w-[318px]">
                    @if (request('kategori'))
                        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                    @endif
                    @if (request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <i class="bi bi-search text-[#909a94]"></i>
                    <input name="search" value="{{ request('search') }}" class="w-full bg-transparent text-[14px] outline-none placeholder:text-[#87918c]" placeholder="Cari mustahik...">
                </form>
                <div class="hidden items-center gap-[24px] md:flex">
                    <i class="bi bi-bell-fill text-[18px] text-[#71807a]"></i>
                    <div class="h-[42px] w-px bg-[#e2e8e5]"></div>
                    @include('admin.partials.account-identity', [
                        'nameClass' => 'text-right text-[13px] font-black leading-none',
                        'roleClass' => 'mt-[7px] text-[9px] font-bold uppercase tracking-wide text-[#9ba49e]',
                        'avatarClass' => 'grid h-[40px] w-[40px] place-items-center overflow-hidden rounded-full bg-[#e8f4ec] text-[13px] font-black text-[#0b751f] ring-2 ring-white',
                        'imageClass' => 'h-full w-full object-cover',
                    ])
                </div>
            </div>
        </header>

        <section class="px-6 pb-10 pt-[35px] lg:px-[34px]">
            <div class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between">
                <div class="min-w-0">
                    <h2 class="text-[30px] font-black leading-tight">Database Mustahik</h2>
                    <p class="mt-[7px] max-w-[620px] text-[16px] leading-[24px] text-[#344139]">Kelola data penerima manfaat, kategori asnaf, dan status kelayakan warga di wilayah Soreang.</p>
                </div>
                <a href="{{ route('mustahik.create') }}" class="inline-flex h-[52px] w-full items-center justify-center gap-3 rounded-[12px] bg-[#0b751f] px-6 text-[14px] font-black leading-[20px] text-white shadow-[0_12px_20px_rgba(8,117,31,0.22)] transition hover:bg-[#09651d] sm:w-auto">
                    <i class="bi bi-plus-lg text-[18px]"></i>
                    Tambah Mustahik
                </a>
            </div>

            @if (session('success'))
                <div class="mt-6 rounded-[13px] border border-green-200 bg-green-50 px-5 py-3 text-sm font-black text-green-800">{{ session('success') }}</div>
            @endif

            <div class="mt-[35px] grid gap-[18px] sm:grid-cols-2 xl:grid-cols-4">
                <section class="rounded-[8px] bg-white px-[22px] py-[22px] shadow-sm ring-1 ring-[#e7eeea]">
                    <div class="flex items-start justify-between">
                    <span class="grid h-[46px] w-[46px] shrink-0 place-items-center rounded-[14px] bg-[#98f091] text-[#0b751f]">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="M7 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm6.5 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5ZM1.5 17c.5-3.3 2.4-5.5 5.5-5.5s5 2.2 5.5 5.5h-11Zm10.7 0a7.7 7.7 0 0 0-1.5-3.7 4.6 4.6 0 0 1 2.8-.8c2.6 0 4.2 1.8 4.6 4.5h-5.9Z"/></svg>
                    </span>
                        <p class="text-[9px] font-black uppercase tracking-[.24em] text-[#7f8a83]">Total</p>
                    </div>
                    <p class="mt-[28px] text-[34px] font-black leading-none">{{ number_format($totalMustahik, 0, ',', '.') }}</p>
                    <p class="mt-[8px] text-[14px] font-bold text-[#526058]">Mustahik terdata</p>
                </section>
                <section class="rounded-[8px] bg-white px-[22px] py-[22px] shadow-sm ring-1 ring-[#e7eeea]">
                    <div class="flex items-start justify-between">
                    <span class="grid h-[46px] w-[46px] shrink-0 place-items-center rounded-[14px] bg-[#c8efc5] text-[#0b751f]">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="m8.7 13.7 6.6-8 1.5 1.3-7.9 9.5-4.7-4.8 1.4-1.4 3.1 3.4Z"/></svg>
                    </span>
                        <p class="text-[9px] font-black uppercase tracking-[.24em] text-[#7f8a83]">Aktif</p>
                    </div>
                    <p class="mt-[28px] text-[34px] font-black leading-none">{{ number_format($aktifMustahik, 0, ',', '.') }}</p>
                    <p class="mt-[8px] text-[14px] font-bold text-[#526058]">Siap disalurkan</p>
                </section>
                <section class="rounded-[8px] bg-white px-[22px] py-[22px] shadow-sm ring-1 ring-[#e7eeea]">
                    <div class="flex items-start justify-between">
                    <span class="grid h-[46px] w-[46px] shrink-0 place-items-center rounded-[14px] bg-[#f1eeee] text-[#0b751f]">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2h2v7h6v2h-6v7H9v-7H3V9h6V2Z"/></svg>
                    </span>
                        <p class="text-[9px] font-black uppercase tracking-[.24em] text-[#7f8a83]">Kategori</p>
                    </div>
                    <p class="mt-[28px] truncate text-[26px] font-black leading-none" title="{{ $kategoriTerbanyak }}">{{ $kategoriTerbanyak }}</p>
                    <p class="mt-[8px] text-[14px] font-bold text-[#526058]">Paling banyak</p>
                </section>
                <section class="rounded-[8px] bg-white px-[22px] py-[22px] shadow-sm ring-1 ring-[#e7eeea]">
                    <div class="flex items-start justify-between">
                    <span class="grid h-[46px] w-[46px] shrink-0 place-items-center rounded-[14px] bg-[#fff2a8] text-[#9a7a00]">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="M5 2h10v3h2v13H3V5h2V2Zm2 3h6V4H7v1Zm3 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm.5 2v2.2l1.8 1.1-.8 1.3L9 14v-3h1.5Z"/></svg>
                    </span>
                        <p class="text-[9px] font-black uppercase tracking-[.24em] text-[#7f8a83]">Nonaktif</p>
                    </div>
                    <p class="mt-[28px] text-[34px] font-black leading-none">{{ number_format($tidakAktifMustahik, 0, ',', '.') }}</p>
                    <p class="mt-[8px] text-[14px] font-bold text-[#526058]">Perlu pembaruan</p>
                </section>
            </div>

            <form action="{{ route('mustahik.index') }}" method="GET" class="mt-[31px] grid max-w-full gap-3 rounded-[8px] bg-[#eef2f0] p-[6px] lg:grid-cols-[minmax(0,1fr)_minmax(150px,210px)_minmax(140px,190px)_48px_auto]">
                <label class="flex h-[42px] items-center gap-3 rounded-[11px] bg-white px-4 shadow-sm">
                    <i class="bi bi-search text-[#536058]"></i>
                    <input name="search" value="{{ request('search') }}" class="w-full bg-transparent text-sm outline-none placeholder:text-[#738078]" placeholder="Cari berdasarkan Nama atau Alamat">
                </label>
                <select name="kategori" class="h-[42px] min-w-0 rounded-[11px] bg-white px-4 text-sm font-bold outline-none shadow-sm">
                    <option value="semua">Kategori Asnaf</option>
                    @foreach ($kategoriAsnaf as $value => $label)
                        <option value="{{ $value }}" @selected(request('kategori') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <select name="status" class="h-[42px] min-w-0 rounded-[11px] bg-white px-4 text-sm font-bold outline-none shadow-sm">
                    <option value="semua">Semua Status</option>
                    <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
                    <option value="tidak_aktif" @selected(request('status') === 'tidak_aktif')>Tidak Aktif</option>
                </select>
                <button class="grid h-[42px] place-items-center rounded-[11px] bg-[#0b751f] text-white shadow-sm transition hover:bg-[#09651d]" type="submit" aria-label="Filter">
                    <i class="bi bi-funnel-fill"></i>
                </button>
                @if ($hasFilters)
                    <a href="{{ route('mustahik.index') }}" class="inline-flex h-[42px] items-center justify-center rounded-[11px] bg-white px-4 text-sm font-black text-[#536058] shadow-sm transition hover:text-[#0b751f]">Reset</a>
                @endif
            </form>

            <section class="mt-[24px] overflow-hidden rounded-[8px] bg-white shadow-sm ring-1 ring-[#e3ebe6]">
                <div class="flex flex-col gap-2 border-b border-[#edf1ef] px-[24px] py-[20px] md:flex-row md:items-center md:justify-between">
                    <div>
                        <h3 class="text-[18px] font-black">Daftar Mustahik</h3>
                        <p class="mt-1 text-sm text-[#6c756f]">Data terbaru berdasarkan filter yang dipilih.</p>
                    </div>
                    <span class="inline-flex w-fit items-center gap-2 rounded-full bg-[#e7f7eb] px-4 py-2 text-xs font-black text-[#0b751f]">
                        <i class="bi bi-database-fill"></i>
                        {{ number_format($mustahik->total(), 0, ',', '.') }} data
                    </span>
                </div>
                <div class="w-full overflow-x-auto">
                    <table class="w-full min-w-[980px] text-left">
                        <colgroup>
                            <col class="w-[28%]">
                            <col class="w-[13%]">
                            <col class="w-[14%]">
                            <col class="w-[25%]">
                            <col class="w-[10%]">
                            <col class="w-[10%]">
                        </colgroup>
                        <thead>
                            <tr class="bg-[#fafbf9] text-[10px] font-black uppercase text-[#303b34]">
                                <th class="px-4 py-[15px] lg:px-5">Nama Lengkap</th>
                                <th class="px-3 py-4 lg:px-4">NIK</th>
                                <th class="px-3 py-4 lg:px-4">Kategori</th>
                                <th class="px-3 py-4 lg:px-4">Alamat</th>
                                <th class="px-3 py-4 lg:px-4">Status</th>
                                <th class="px-4 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#edf1ef]">
                            @forelse ($mustahik as $row)
                                @php
                                    $initials = collect(explode(' ', $row->nama))->filter()->take(2)->map(fn ($part) => str($part)->substr(0, 1))->join('');
                                @endphp
                                <tr class="hover:bg-[#fbfdfb]">
                                    <td class="px-4 py-[18px] lg:px-5">
                                        <div class="flex items-center gap-4">
                                            <span class="grid h-[42px] w-[42px] shrink-0 place-items-center rounded-full bg-[#e7f7eb] text-sm font-black text-[#0b751f] ring-1 ring-[#ccebd4]">{{ strtoupper($initials ?: 'M') }}</span>
                                            <div class="min-w-0">
                                                <p class="truncate text-[15px] font-black">{{ $row->nama }}</p>
                                                <p class="mt-1 truncate text-xs font-semibold text-[#7b8780]">
                                                    <i class="bi bi-telephone mr-1"></i>{{ $row->kontak ?: 'Kontak belum diisi' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="truncate px-3 py-5 font-mono text-[13px] text-[#303b34] lg:px-4">{{ $row->nik ? substr($row->nik, 0, 6).'******'.substr($row->nik, -4) : '-' }}</td>
                                    <td class="px-3 py-5 lg:px-4">
                                        <span class="inline-flex max-w-full items-center rounded-full px-3 py-1 text-[10px] font-black uppercase ring-1 {{ $badgeKategori[$row->kategori_asnaf] ?? 'bg-gray-100 text-gray-700 ring-gray-200' }}">
                                            <span class="truncate">{{ $row->kategori_label }}</span>
                                        </span>
                                    </td>
                                    <td class="px-3 py-5 text-sm leading-5 text-[#303b34] lg:px-4">
                                        <p class="line-clamp-2">{{ $row->alamat }}</p>
                                    </td>
                                    <td class="px-3 py-5 lg:px-4">
                                        <span class="inline-flex max-w-full items-center gap-2 text-[11px] font-black uppercase {{ $row->status === 'aktif' ? 'text-[#0b751f]' : 'text-red-700' }}">
                                            <span class="h-2 w-2 shrink-0 rounded-full {{ $row->status === 'aktif' ? 'bg-[#0b751f]' : 'bg-red-600' }}"></span>
                                            <span class="truncate">{{ $row->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}</span>
                                        </span>
                                    </td>
                                    <td class="px-4 py-5">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('mustahik.show', $row) }}" class="grid h-9 w-9 place-items-center rounded-[8px] bg-sky-50 text-sky-700 ring-1 ring-sky-100 transition hover:bg-sky-100" aria-label="Detail" title="Detail">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            <a href="{{ route('mustahik.edit', $row) }}" class="grid h-9 w-9 place-items-center rounded-[8px] bg-amber-50 text-amber-700 ring-1 ring-amber-100 transition hover:bg-amber-100" aria-label="Edit" title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('mustahik.destroy', $row) }}" method="POST" onsubmit="return confirm('Hapus data mustahik ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="grid h-9 w-9 place-items-center rounded-[8px] bg-red-50 text-red-700 ring-1 ring-red-100 transition hover:bg-red-100" aria-label="Hapus" title="Hapus" type="submit">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-8 py-14 text-center">
                                        <div class="mx-auto grid h-14 w-14 place-items-center rounded-full bg-[#eef2f0] text-[#0b751f]">
                                            <i class="bi bi-inbox-fill text-[24px]"></i>
                                        </div>
                                        <p class="mt-4 text-[16px] font-black text-[#243129]">Belum ada data mustahik</p>
                                        <p class="mt-1 text-sm text-[#6c756f]">Tambahkan data baru atau ubah filter pencarian.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="flex flex-col gap-4 border-t border-[#edf1ef] px-6 py-5 text-sm text-[#536058] md:flex-row md:items-center md:justify-between">
                    <span>Menampilkan {{ $mustahik->firstItem() ?? 0 }}-{{ $mustahik->lastItem() ?? 0 }} dari {{ number_format($mustahik->total(), 0, ',', '.') }} mustahik</span>
                    {{ $mustahik->links() }}
                </div>
            </section>

            <div class="mt-6 grid gap-5 lg:grid-cols-2">
                <section class="flex gap-4 rounded-[14px] border border-green-200 bg-green-50 p-6">
                    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-green-100 text-[#0b751f] font-black">i</span>
                    <div>
                        <h3 class="text-[18px] font-black text-[#0b751f]">Pembaruan Data Berkala</h3>
                        <p class="mt-2 text-sm leading-6 text-[#344139]">Pastikan data Mustahik diperbarui setiap 6 bulan sekali untuk menjaga validitas penyaluran zakat di wilayah Soreang.</p>
                    </div>
                </section>
                <section class="flex gap-4 rounded-[14px] border border-[#e2e8e5] bg-white p-6">
                    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-slate-100 text-slate-500">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2 4 4.5V9c0 4 2.4 7 6 9 3.6-2 6-5 6-9V4.5L10 2Z"/></svg>
                    </span>
                    <div>
                        <h3 class="text-[18px] font-black">Keamanan Data Amanah</h3>
                        <p class="mt-2 text-sm leading-6 text-[#344139]">Sistem enkripsi FUNDMIL melindungi kerahasiaan identitas penerima manfaat sesuai protokol Amanah Digital.</p>
                    </div>
                </section>
            </div>
        </section>
    </main>
</div>
</body>
</html>
