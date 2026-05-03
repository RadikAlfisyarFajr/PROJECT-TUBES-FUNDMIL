<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Program Penyaluran - Fundmil Soreang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f4f7f5] font-sans text-[#111c14] antialiased">
@php
    $samplePrograms = collect([
        (object) ['id' => 1, 'nama_program' => 'Beasiswa Anak Yatim RW 05', 'tanggal_mulai' => now(), 'tanggal_selesai' => now()->addMonths(3), 'total_dana' => 125000000, 'target_mustahik' => 50, 'status' => 'aktif', 'progress' => 75, 'tags' => ['Fakir Miskin']],
        (object) ['id' => 2, 'nama_program' => 'Bantuan Kesehatan Lansia', 'tanggal_mulai' => now(), 'tanggal_selesai' => now()->addMonths(2), 'total_dana' => 90000000, 'target_mustahik' => 120, 'status' => 'aktif', 'progress' => 40, 'tags' => ['Miskin', 'Asnaf']],
        (object) ['id' => 3, 'nama_program' => 'Modal Usaha Mikro Soreang', 'tanggal_mulai' => now()->subMonths(2), 'tanggal_selesai' => now()->subWeek(), 'total_dana' => 65000000, 'target_mustahik' => 30, 'status' => 'selesai', 'progress' => 100, 'tags' => ['Muallaf']],
        (object) ['id' => 4, 'nama_program' => 'Renovasi Musholla At-Taqwa', 'tanggal_mulai' => now(), 'tanggal_selesai' => now()->addMonths(4), 'total_dana' => 45000000, 'target_mustahik' => 1, 'status' => 'aktif', 'progress' => 15, 'tags' => ['Fisabilillah']],
    ]);
    $rows = $programs->count() ? $programs : $samplePrograms;
@endphp
<div class="min-h-screen lg:flex">
    <aside class="fixed inset-y-0 left-0 hidden w-[254px] border-r border-[#e8eeeb] bg-white lg:block">
        <div class="px-8 pt-9">
            <h1 class="text-[20px] font-extrabold tracking-wide text-[#0b751f]">FUNDMIL SOREANG</h1>
            <p class="mt-2 text-[10px] font-bold uppercase tracking-[0.34em] text-[#9ba6a0]">Sistem Amanah Digital</p>
        </div>
        <nav class="mt-14 space-y-3 px-4 text-[15px] font-medium text-[#3d5065]">
            @foreach (['Beranda', 'Profil Instansi', 'Kategori Dana', 'Pemasukan Zakat', 'Data Mustahik', 'Program Penyaluran', 'Pengaturan Distribusi', 'Laporan', 'Pengaturan'] as $label)
                <a href="{{ $label === 'Program Penyaluran' ? route('program-penyaluran.index') : '#' }}"
                   class="flex items-center gap-4 rounded-2xl px-4 py-3 {{ $label === 'Program Penyaluran' ? 'bg-[#f4f8f6] font-extrabold text-[#0b751f] shadow-[inset_4px_0_0_#0b751f]' : 'hover:bg-[#f8faf9]' }}">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2 3 11h5v6h8v-6h1L10 2Zm0 4 2.1 3H7.9L10 6Z"/></svg>
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
        <header class="flex h-[64px] items-center justify-between bg-white px-6 lg:px-9">
            <form action="{{ route('program-penyaluran.index') }}" method="GET" class="flex h-10 w-full max-w-[320px] items-center gap-3 rounded-full bg-[#eef2f0] px-4">
                <svg class="h-5 w-5 text-[#84918a]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m21 21-4.3-4.3M10.8 18a7.2 7.2 0 1 1 0-14.4 7.2 7.2 0 0 1 0 14.4Z"/></svg>
                <input name="search" value="{{ request('search') }}" class="w-full bg-transparent text-sm outline-none placeholder:text-[#7d8982]" placeholder="Cari program atau mustahik...">
            </form>
            <div class="hidden items-center gap-6 md:flex">
                <svg class="h-5 w-5 text-[#646f68]" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a2.5 2.5 0 0 0 2.4-2H7.6A2.5 2.5 0 0 0 10 18ZM4 14h12l-1.4-2.3V8a4.6 4.6 0 1 0-9.2 0v3.7L4 14Z"/></svg>
                <svg class="h-6 w-6 text-[#646f68]" fill="currentColor" viewBox="0 0 20 20"><path d="m10 1 1.5 2.1 2.6-.4.9 2.5 2.3 1.3-1.1 2.4.8 2.6-2.2 1.5-.7 2.6-2.6-.2L10 17.5l-1.5-2.1-2.6.2-.7-2.6L3 11.5l.8-2.6-1.1-2.4L5 5.2l.9-2.5 2.6.4L10 1Zm0 6a3 3 0 1 0 0 6 3 3 0 0 0 0-6Z"/></svg>
                <div class="h-10 w-px bg-[#dfe5e2]"></div>
                <div class="text-right">
                    <p class="text-sm font-extrabold">Amil Zakat</p>
                    <p class="mt-1 text-[10px] font-bold uppercase text-[#8d9aa5]">Administrator</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-[linear-gradient(135deg,#19803a,#f2d0a6)] ring-2 ring-white"></div>
            </div>
        </header>

        <section class="px-6 py-10 lg:px-9">
            <div class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between">
                <div>
                    <h2 class="text-[32px] font-black leading-tight tracking-tight">Manajemen Program Penyaluran</h2>
                    <p class="mt-2 max-w-[640px] text-lg leading-7 text-[#46534b]">Rencanakan dan pantau alokasi dana ZIS untuk program bantuan warga di wilayah Soreang dan sekitarnya.</p>
                </div>
                <a href="{{ route('program-penyaluran.create') }}" class="inline-flex min-h-16 items-center justify-center gap-4 rounded-2xl bg-[#0b751f] px-8 text-lg font-black text-white shadow-[0_12px_22px_rgba(8,117,31,0.25)]">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-white text-[#0b751f]">+</span>
                    [+] Buat Program<br class="hidden sm:block"> Baru
                </a>
            </div>

            @if (session('success'))
                <div class="mt-7 rounded-2xl border border-[#bde5c6] bg-[#edfff0] px-5 py-4 text-sm font-bold text-[#0b751f]">{{ session('success') }}</div>
            @endif

            <div class="mt-9 grid gap-6 lg:grid-cols-2">
                <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-[#e8eeeb]">
                    <div class="flex items-start justify-between">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#98f091] text-[#0b751f]">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4h12v12H4V4Zm3 3v6h6V7H7Zm2 2h2v2H9V9Z"/></svg>
                        </span>
                        <p class="text-[10px] font-black uppercase tracking-[0.25em] text-[#8b968f]">Dana Terkumpul</p>
                    </div>
                    <p class="mt-12 text-[38px] font-black leading-none">Rp {{ number_format($totalDana, 0, ',', '.') }}</p>
                    <p class="mt-3 text-lg text-[#4d5a52]">Total Dana Tersedia</p>
                </div>
                <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-[#e8eeeb]">
                    <div class="flex items-start justify-between">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#c9f3c5] text-[#0b751f]">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="M3 5h14v10H3V5Zm3 3a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm5 0h4v2h-4V8Zm0 3h3v1h-3v-1Z"/></svg>
                        </span>
                        <p class="text-[10px] font-black uppercase tracking-[0.25em] text-[#8b968f]">Alokasi Aktif</p>
                    </div>
                    <p class="mt-12 text-[38px] font-black leading-none">Rp {{ number_format($alokasiAktif, 0, ',', '.') }}</p>
                    <p class="mt-3 text-lg text-[#4d5a52]">Total Dialokasikan</p>
                </div>
            </div>

            <form action="{{ route('program-penyaluran.index') }}" method="GET" class="mt-8 flex max-w-[630px] overflow-hidden rounded-2xl bg-[#eef2f0] p-1">
                @foreach (['semua' => 'Semua Program', 'aktif' => 'Aktif', 'selesai' => 'Selesai', 'draft' => 'Draft'] as $value => $label)
                    <button name="status" value="{{ $value }}" class="h-10 flex-1 rounded-xl text-sm font-bold {{ request('status', 'semua') === $value ? 'bg-white text-[#0b751f] shadow-sm' : 'text-[#1e2b23]' }}">{{ $label }}</button>
                @endforeach
            </form>

            <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($rows as $index => $program)
                    @php
                        $progress = $program->progress ?? min(100, $program->target_mustahik ? round(($program->distribusi_count ?? $program->distribusi->count()) / max($program->target_mustahik, 1) * 100) : 0);
                        $tags = $program->tags ?? $program->programDana->pluck('kategoriDana.nama')->filter()->take(2)->all();
                        $isSelesai = $program->status === 'selesai';
                    @endphp
                    <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-[#e5ece8]">
                        <div class="flex items-start justify-between">
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#e8eeeb] text-[#0b751f]">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="m10 3 8 4-8 4-8-4 8-4Zm-5 7.2 5 2.5 5-2.5V14l-5 2.5L5 14v-3.8Z"/></svg>
                            </span>
                            <span class="rounded-full px-3 py-1 text-[10px] font-black uppercase {{ $isSelesai ? 'bg-[#ddddda] text-[#60665f]' : 'bg-[#98f091] text-[#0b751f]' }}">{{ $program->status }}</span>
                        </div>
                        <h3 class="mt-7 text-xl font-black">{{ $program->nama_program }}</h3>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @forelse ($tags as $tag)
                                <span class="rounded bg-[#edf1ee] px-2 py-1 text-[10px] font-black uppercase text-[#7b877e]">{{ $tag }}</span>
                            @empty
                                <span class="rounded bg-[#edf1ee] px-2 py-1 text-[10px] font-black uppercase text-[#7b877e]">ZIS</span>
                            @endforelse
                        </div>
                        <p class="mt-5 text-xs font-bold text-[#536056]">{{ $program->tanggal_mulai->format('d M Y') }} - {{ $program->tanggal_selesai->format('d M Y') }}</p>
                        <p class="mt-2 text-sm font-black">Rp {{ number_format($program->total_dana, 0, ',', '.') }}</p>
                        <div class="mt-5 flex items-center justify-between text-xs font-bold">
                            <span>Progress Penyaluran</span>
                            <span class="{{ $isSelesai ? 'text-[#777b76]' : 'text-[#0b751f]' }}">{{ $progress }}%</span>
                        </div>
                        <div class="mt-3 h-2 rounded-full bg-[#e2e6e3]">
                            <div class="h-2 rounded-full {{ $isSelesai ? 'bg-[#9b9792]' : 'bg-[#0b751f]' }}" style="width: {{ $progress }}%"></div>
                        </div>
                        <div class="mt-5 flex items-center justify-between text-sm">
                            <span>Target: <strong>{{ $program->target_mustahik }} {{ $program->target_mustahik > 1 ? 'Jiwa' : 'Bangunan' }}</strong></span>
                            <div class="flex items-center gap-3 font-black">
                                <a class="{{ $isSelesai ? 'text-[#9b9f9b]' : 'text-[#0b751f]' }}" href="{{ route('program-penyaluran.distribusi', $program->id) }}">Atur Distribusi</a>
                                <a class="text-[#0b751f]" href="{{ route('program-penyaluran.edit', $program->id) }}">Edit</a>
                                <form action="{{ route('program-penyaluran.destroy', $program->id) }}" method="POST" onsubmit="return confirm('Hapus program ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach

                <a href="{{ route('program-penyaluran.create') }}" class="flex min-h-[265px] flex-col items-center justify-center rounded-2xl border-2 border-dashed border-[#d9e2dd] bg-white text-center">
                    <span class="flex h-14 w-14 items-center justify-center rounded-full bg-[#80df7b] text-3xl font-black text-[#0b751f]">+</span>
                    <span class="mt-7 text-lg font-black text-[#0b751f]">Buat Program Baru</span>
                    <span class="mt-2 max-w-[230px] text-sm leading-6 text-[#5a665f]">Tambahkan inisiatif penyaluran baru untuk masyarakat.</span>
                </a>
            </div>

            @if ($programs->count())
                <div class="mt-8">{{ $programs->links() }}</div>
            @endif
        </section>
    </main>
</div>
</body>
</html>
