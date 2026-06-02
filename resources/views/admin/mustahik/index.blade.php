<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Database Mustahik - Fundmil Soreang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f4f7f5] font-sans text-[#162217] antialiased">
@php
    $sampleRows = collect([
        (object) ['id' => 1, 'nama' => 'Ahmad Sobari', 'nik' => '3204129999991001', 'kategori_asnaf' => 'Fakir', 'alamat' => 'Jl. Mawar No. 12', 'rw' => '04', 'status' => 'verified'],
        (object) ['id' => 2, 'nama' => 'Siti Rohayah', 'nik' => '3204129999994005', 'kategori_asnaf' => 'Miskin', 'alamat' => 'Kp. Babakan', 'rw' => '01', 'status' => 'pending'],
        (object) ['id' => 3, 'nama' => 'Maman Mansyur', 'nik' => '3204129999993011', 'kategori_asnaf' => 'Fisabilillah', 'alamat' => 'Gg. Haji Salim', 'rw' => '07', 'status' => 'verified'],
        (object) ['id' => 4, 'nama' => 'Udin Hidayat', 'nik' => '3204129999999002', 'kategori_asnaf' => 'Fakir', 'alamat' => 'Jl. Soreang Indah', 'rw' => '03', 'status' => 'verified'],
    ]);
    $rows = $mustahik->count() ? $mustahik : $sampleRows;
    $displayTotal = $totalMustahik ?: 1284;
    $displayPending = $menungguVerifikasi ?: 12;
    $displayKategori = $kategoriTerbanyak ?: 'Fakir Miskin';
@endphp
<div class="min-h-screen lg:flex">
    <aside class="fixed inset-y-0 left-0 z-20 hidden w-[254px] border-r border-[#e8eeeb] bg-white lg:block">
        <div class="px-8 pt-9">
            <h1 class="text-[20px] font-extrabold tracking-wide text-[#0b751f]">FUNDMIL SOREANG</h1>
            <p class="mt-2 text-[10px] font-bold uppercase tracking-[0.34em] text-[#9ba6a0]">Sistem Amanah Digital</p>
        </div>

        <nav class="mt-14 space-y-3 px-4 text-[15px] font-medium text-[#3d5065]">
            @php
                $menus = [
                    ['Beranda', 'grid'],
                    ['Profil Instansi', 'bank'],
                    ['Kategori Dana', 'shapes'],
                    ['Pemasukan Zakat', 'wallet'],
                    ['Data Mustahik', 'users'],
                    ['Program Penyaluran', 'sparkles'],
                    ['Pengaturan Distribusi', 'sliders'],
                    ['Laporan', 'report'],
                    ['Pengaturan', 'gear'],
                ];
            @endphp
            @foreach ($menus as [$label, $icon])
                <a href="{{ $label === 'Data Mustahik' ? route('mustahik.index') : '#' }}"
                   class="flex items-center gap-4 rounded-2xl px-4 py-3 {{ $label === 'Data Mustahik' ? 'bg-[#f4f8f6] font-extrabold text-[#0b751f] shadow-[inset_4px_0_0_#0b751f]' : 'hover:bg-[#f8faf9]' }}">
                    <span class="flex h-6 w-6 items-center justify-center">
                        @if ($icon === 'grid')
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M3 3h6v6H3V3Zm8 0h6v6h-6V3ZM3 11h6v6H3v-6Zm8 0h6v6h-6v-6Z"/></svg>
                        @elseif ($icon === 'bank')
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2 2 6v2h16V6l-8-4ZM4 9h2v6H4V9Zm5 0h2v6H9V9Zm5 0h2v6h-2V9ZM3 16h14v2H3v-2Z"/></svg>
                        @elseif ($icon === 'users')
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M7 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm6.5 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5ZM1.5 17c.5-3.3 2.4-5.5 5.5-5.5s5 2.2 5.5 5.5h-11Zm10.7 0a7.7 7.7 0 0 0-1.5-3.7 4.6 4.6 0 0 1 2.8-.8c2.6 0 4.2 1.8 4.6 4.5h-5.9Z"/></svg>
                        @elseif ($icon === 'sliders')
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3h2v14H4V3Zm5 0h2v14H9V3Zm5 0h2v14h-2V3ZM2 6h6v2H2V6Zm5 6h6v2H7v-2Zm5-7h6v2h-6V5Z"/></svg>
                        @elseif ($icon === 'gear')
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="m10 1 1.5 2.1 2.6-.4.9 2.5 2.3 1.3-1.1 2.4L17 11.5l-2.2 1.5-.7 2.6-2.6-.2L10 17.5l-1.5-2.1-2.6.2-.7-2.6L3 11.5l.8-2.6-1.1-2.4L5 5.2l.9-2.5 2.6.4L10 1Zm0 6a3 3 0 1 0 0 6 3 3 0 0 0 0-6Z"/></svg>
                        @else
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4h12v12H4V4Zm3 3v2h6V7H7Zm0 4v2h4v-2H7Z"/></svg>
                        @endif
                    </span>
                    {{ $label }}
                </a>
            @endforeach
        </nav>

        <div class="absolute bottom-11 left-4 right-4 border-t border-[#edf1ef] pt-7">
            <a class="flex items-center gap-4 px-4 text-[15px] font-medium text-[#3d5065]" href="#">
                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-[#3d5065] text-xs font-bold text-white">?</span>
                Bantuan
            </a>
        </div>
    </aside>

    <main class="min-h-screen flex-1 lg:ml-[254px]">
        <header class="flex h-[94px] items-center justify-between bg-white px-6 lg:px-12">
            <div>
                <div class="text-xs font-medium text-[#9aa9b6]">Dashboard <span class="mx-3 text-[#c1cbc5]">›</span> <span class="font-bold text-[#0b751f]">Database Mustahik</span></div>
                <h2 class="mt-2 text-2xl font-extrabold tracking-tight">Data Mustahik</h2>
            </div>
            <div class="hidden items-center gap-7 md:flex">
                <form action="{{ route('mustahik.index') }}" method="GET" class="flex h-14 w-[255px] items-center gap-3 rounded-full bg-[#eef2f0] px-5">
                    <svg class="h-5 w-5 text-[#7f91a5]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m21 21-4.3-4.3M10.8 18a7.2 7.2 0 1 1 0-14.4 7.2 7.2 0 0 1 0 14.4Z"/></svg>
                    <input name="search" value="{{ request('search') }}" class="w-full bg-transparent text-sm outline-none placeholder:text-[#7d8b98]" placeholder="Cari data...">
                </form>
                <svg class="h-6 w-6 text-[#8396ad]" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a2.5 2.5 0 0 0 2.4-2H7.6A2.5 2.5 0 0 0 10 18ZM4 14h12l-1.4-2.3V8a4.6 4.6 0 1 0-9.2 0v3.7L4 14Z"/></svg>
                <div class="h-10 w-px bg-[#dfe5e2]"></div>
                <div class="text-right">
                    <p class="text-sm font-extrabold">Admin Soreang</p>
                    <p class="mt-1 text-[10px] font-bold uppercase text-[#8d9aa5]">Amil Utama</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-[linear-gradient(135deg,#f3caaa,#23465c)] ring-2 ring-white"></div>
            </div>
        </header>

        <section class="px-6 py-12 lg:px-12">
            <div class="flex flex-col justify-between gap-6 xl:flex-row xl:items-start">
                <div>
                    <h3 class="text-[36px] font-black leading-tight tracking-tight">Database Mustahik</h3>
                    <p class="mt-2 text-lg text-[#5f6c63]">Kelola data warga penerima manfaat di wilayah Kelurahan Soreang.</p>
                </div>
                <a href="{{ route('mustahik.create') }}" class="inline-flex h-14 items-center justify-center gap-3 rounded-2xl bg-[#08751f] px-7 text-lg font-extrabold text-white shadow-[0_12px_24px_rgba(8,117,31,0.28)]">
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="M7 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm7-1V5h2v3h3v2h-3v3h-2v-3h-3V8h3ZM1.5 17c.5-3.3 2.4-5.5 5.5-5.5s5 2.2 5.5 5.5h-11Z"/></svg>
                    Tambah Mustahik Baru
                </a>
            </div>

            @if (session('success'))
                <div class="mt-8 rounded-2xl border border-[#bde5c6] bg-[#edfff0] px-5 py-4 text-sm font-bold text-[#0b751f]">{{ session('success') }}</div>
            @endif

            <div class="mt-10 grid gap-6 xl:grid-cols-3">
                <div class="flex min-h-[188px] items-center gap-7 rounded-2xl bg-white p-8 shadow-sm ring-1 ring-[#e9eeee]">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#f0f7f2] text-[#0b751f]">
                        <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 20 20"><path d="M7 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm6.5 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5ZM1.5 17c.5-3.3 2.4-5.5 5.5-5.5s5 2.2 5.5 5.5h-11Zm10.7 0a7.7 7.7 0 0 0-1.5-3.7 4.6 4.6 0 0 1 2.8-.8c2.6 0 4.2 1.8 4.6 4.5h-5.9Z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-black uppercase tracking-[0.12em] text-[#4a554d]">Total Mustahik</p>
                        <p class="mt-2 text-[38px] font-black leading-none">{{ number_format($displayTotal) }}</p>
                    </div>
                </div>
                <div class="flex min-h-[188px] items-center gap-7 rounded-2xl bg-white p-8 shadow-sm ring-1 ring-[#e9eeee]">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#fbf0f5] text-[#9c2454]">
                        <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2 3 11h5v6h8v-6h1L10 2Zm3 11a2 2 0 1 1 0 4 2 2 0 0 1 0-4Z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-black uppercase leading-5 tracking-[0.12em] text-[#4a554d]">Kategori<br>Terbanyak</p>
                        <p class="mt-2 text-[36px] font-black leading-[0.95]">{{ $displayKategori }}</p>
                    </div>
                </div>
                <div class="flex min-h-[188px] items-center gap-7 rounded-2xl border border-[#f6e8a7] bg-[#fffbe6] p-8 shadow-sm">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#fff394] text-[#8d7d08]">
                        <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 20 20"><path d="M5 2h10v2h2v14H3V4h2V2Zm2 4h6V4H7v2Zm6.2 3.1-3.4 3.4-1.5-1.5-1.4 1.4 2.9 2.9 4.8-4.8-1.4-1.4Z"/></svg>
                    </div>
                    <div>
                        <p class="text-base font-black uppercase leading-5 tracking-[0.12em] text-[#a18f00]">Menunggu<br>Verifikasi</p>
                        <p class="mt-2 text-[38px] font-black leading-none text-[#675c03]">{{ number_format($displayPending) }}</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('mustahik.index') }}" method="GET" class="mt-10 flex flex-col gap-4 rounded-2xl bg-[#eef2f0] p-6 lg:flex-row lg:items-center">
                <div class="flex h-14 flex-1 items-center gap-4 rounded-xl bg-white px-5 shadow-sm ring-1 ring-[#dfe6e2]">
                    <svg class="h-6 w-6 text-[#1f2c25]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m21 21-4.3-4.3M10.8 18a7.2 7.2 0 1 1 0-14.4 7.2 7.2 0 0 1 0 14.4Z"/></svg>
                    <input name="search" value="{{ request('search') }}" class="w-full bg-transparent text-sm outline-none placeholder:text-[#68756e]" placeholder="Cari berdasarkan Nama atau NIK">
                </div>
                <select name="kategori" class="h-14 rounded-xl border-0 bg-white px-5 text-sm font-medium text-[#2d3a33] shadow-sm ring-1 ring-[#dfe6e2] lg:w-48">
                    <option value="">Kategori Asnaf</option>
                    @foreach ($kategoriAsnaf as $kategori)
                        <option value="{{ $kategori }}" @selected(request('kategori') === $kategori)>{{ $kategori }}</option>
                    @endforeach
                </select>
                <select name="rw" class="h-14 rounded-xl border-0 bg-white px-5 text-sm font-medium text-[#2d3a33] shadow-sm ring-1 ring-[#dfe6e2] lg:w-48">
                    <option value="">Wilayah RW</option>
                    @foreach ($rwOptions as $rw)
                        <option value="{{ $rw }}" @selected(request('rw') === $rw)>RW {{ $rw }}</option>
                    @endforeach
                    @for ($i = 1; $i <= 10; $i++)
                        @php $rw = str_pad((string) $i, 2, '0', STR_PAD_LEFT); @endphp
                        <option value="{{ $rw }}" @selected(request('rw') === $rw)>RW {{ $rw }}</option>
                    @endfor
                </select>
                <button class="flex h-14 w-14 items-center justify-center rounded-xl bg-[#e0e6e3] text-[#1e2d25]" title="Terapkan filter">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 7h10M18 7h2M16 5v4M4 17h2M10 17h10M8 15v4M4 12h6M14 12h6M12 10v4"/></svg>
                </button>
            </form>

            <div class="mt-10 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-[#e8eeeb]">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[940px] text-left">
                        <thead class="bg-[#fbfcfb] text-xs font-black uppercase tracking-[0.12em] text-[#2b352e]">
                            <tr>
                                <th class="px-8 py-6">Nama Lengkap</th>
                                <th class="px-6 py-6">NIK</th>
                                <th class="px-6 py-6">Kategori<br>Asnaf</th>
                                <th class="px-6 py-6">Alamat/RW</th>
                                <th class="px-6 py-6">Status<br>Verifikasi</th>
                                <th class="px-6 py-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#e9eeee] text-sm">
                            @foreach ($rows as $index => $item)
                                @php
                                    $parts = explode(' ', trim($item->nama));
                                    $initial = strtoupper(substr($parts[0] ?? 'M', 0, 1) . substr($parts[1] ?? $parts[0] ?? 'U', 0, 1));
                                    $nik = $item->nik ? substr($item->nik, 0, 6) . '******' . substr($item->nik, -4) : '320412******0000';
                                    $avatar = ['bg-[#96f28f]', 'bg-[#c8f5c0]', 'bg-[#ffd8e5]', 'bg-[#8eea89]'][$index % 4];
                                @endphp
                                <tr class="{{ $index % 2 ? 'bg-[#fdfefd]' : 'bg-white' }}">
                                    <td class="px-8 py-7">
                                        <div class="flex items-center gap-4">
                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full {{ $avatar }} text-sm font-black text-[#113b17]">{{ $initial }}</div>
                                            <div class="max-w-[150px] text-base font-black leading-5">{{ $item->nama }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-7 font-semibold tracking-wide text-[#39443d]">{{ $nik }}</td>
                                    <td class="px-6 py-7">
                                        <span class="rounded-full bg-[#e1f1e5] px-3 py-1 text-[10px] font-black uppercase text-[#08751f]">{{ $item->kategori_asnaf }}</span>
                                    </td>
                                    <td class="px-6 py-7 font-medium leading-5 text-[#39443d]">{{ $item->alamat ?: '-' }}<br>RW {{ $item->rw ?: '04' }}</td>
                                    <td class="px-6 py-7">
                                        @if ($item->status === 'verified')
                                            <span class="inline-flex items-center gap-3 text-[11px] font-black uppercase text-[#0b751f]"><span class="h-2 w-2 rounded-full bg-[#0b751f]"></span>Terverifikasi</span>
                                        @else
                                            <span class="inline-flex items-center gap-3 text-[11px] font-black uppercase text-[#627063]"><span class="h-2 w-2 rounded-full bg-[#b8c4ba]"></span>Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-7">
                                        <div class="flex items-center justify-center gap-7 text-[#1f2d23]">
                                            <a href="{{ route('mustahik.show', $item->id) }}" title="Lihat detail">
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 4C5 4 2.2 10 2.2 10S5 16 10 16s7.8-6 7.8-6S15 4 10 4Zm0 9a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/></svg>
                                            </a>
                                            <a href="{{ route('mustahik.edit', $item->id) }}" title="Edit data">
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M14.7 2.3a1 1 0 0 1 1.4 0l1.6 1.6a1 1 0 0 1 0 1.4l-9.8 9.8-3.6.8.8-3.6 9.6-10ZM3 17h14v2H3v-2Z"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex flex-col gap-4 border-t border-[#edf1ef] px-8 py-7 text-sm font-medium text-[#324038] md:flex-row md:items-center md:justify-between">
                    <p>Menampilkan {{ $mustahik->count() ? $mustahik->firstItem() : 1 }}-{{ $mustahik->count() ? $mustahik->lastItem() : 10 }} dari {{ number_format($displayTotal) }} Mustahik</p>
                    @if ($mustahik->count())
                        {{ $mustahik->links() }}
                    @else
                        <div class="flex items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#f4f6f5] text-[#b1bbb5]">‹</span>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#08751f] font-black text-white">1</span>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl">2</span>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl">3</span>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl">...</span>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl">129</span>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#eef2f0] text-xl">›</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-10 grid gap-6 xl:grid-cols-2">
                <div class="flex items-start gap-6 rounded-2xl border border-[#b9d8c1] bg-[#edf7ef] p-8">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#ccebd3] text-[#0b751f]">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 1 0 0 16 8 8 0 0 0 0-16Zm1 12H9V8h2v6Zm0-8H9V4h2v2Z"/></svg>
                    </span>
                    <div>
                        <h4 class="text-xl font-black text-[#0b751f]">Pembaruan Data Berkala</h4>
                        <p class="mt-2 max-w-[520px] text-base leading-7 text-[#43524a]">Pastikan data Mustahik diperbarui setiap 6 bulan sekali untuk menjaga validitas penyaluran zakat di wilayah Soreang.</p>
                    </div>
                </div>
                <div class="flex items-start gap-6 rounded-2xl border border-[#dfe7ec] bg-white p-8">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#eef3f8] text-[#8aa1bd]">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2 4 4.5v4.8c0 3.8 2.5 7.2 6 8.3 3.5-1.1 6-4.5 6-8.3V4.5L10 2Zm1 11H9V7h2v6Z"/></svg>
                    </span>
                    <div>
                        <h4 class="text-xl font-black">Keamanan Data Amanah</h4>
                        <p class="mt-2 max-w-[520px] text-base leading-7 text-[#43524a]">Sistem enkripsi FUNDMIL melindungi kerahasiaan identitas (NIK & Alamat) penerima manfaat sesuai protokol Amanah Digital.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
</body>
</html>
