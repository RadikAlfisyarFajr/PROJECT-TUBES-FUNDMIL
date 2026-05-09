<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Program Penyaluran - Fundmil Soreang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="sidebar-expanded bg-[#f6f8f6] font-sans text-[#111813] antialiased">
@php
    $samplePrograms = collect([
        (object) ['id' => 1, 'nama_program' => 'Beasiswa Anak Yatim RW 05', 'tanggal_mulai' => now(), 'tanggal_selesai' => now()->addMonths(3), 'total_dana' => 125000000, 'target_mustahik' => 50, 'status' => 'aktif', 'progress' => 75, 'tags' => ['Fakir Miskin'], 'icon' => 'school'],
        (object) ['id' => 2, 'nama_program' => 'Bantuan Kesehatan Lansia', 'tanggal_mulai' => now(), 'tanggal_selesai' => now()->addMonths(2), 'total_dana' => 90000000, 'target_mustahik' => 120, 'status' => 'aktif', 'progress' => 40, 'tags' => ['Miskin', 'Asnaf'], 'icon' => 'medical'],
        (object) ['id' => 3, 'nama_program' => 'Modal Usaha Mikro Soreang', 'tanggal_mulai' => now()->subMonths(2), 'tanggal_selesai' => now()->subWeek(), 'total_dana' => 65000000, 'target_mustahik' => 30, 'status' => 'selesai', 'progress' => 100, 'tags' => ['Muallaf'], 'icon' => 'shop'],
        (object) ['id' => 4, 'nama_program' => 'Renovasi Musholla At-Taqwa', 'tanggal_mulai' => now(), 'tanggal_selesai' => now()->addMonths(4), 'total_dana' => 45000000, 'target_mustahik' => 1, 'status' => 'aktif', 'progress' => 15, 'tags' => ['Fisabilillah'], 'icon' => 'mosque'],
    ]);
    $rows = $programs->count() ? $programs : $samplePrograms;
    $selectedKategori = request('kategori', 'semua');
@endphp
<div class="min-h-screen lg:flex">
    @include('admin.partials.sidebar', ['active' => 'program'])

    <main class="min-h-screen flex-1">
        <header class="flex h-[64px] items-center justify-between bg-white px-6 lg:px-[34px]">
            <form action="{{ route('program-penyaluran.index') }}" method="GET" class="ml-0 flex h-[36px] w-[318px] max-w-full items-center gap-3 rounded-full bg-[#eef2f0] px-4">
                <svg class="h-5 w-5 text-[#909a94]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m21 21-4.3-4.3M10.8 18a7.2 7.2 0 1 1 0-14.4 7.2 7.2 0 0 1 0 14.4Z"/></svg>
                <input name="search" value="{{ request('search') }}" class="w-full bg-transparent text-[14px] outline-none placeholder:text-[#87918c]" placeholder="Cari program atau mustahik...">
            </form>

            <div class="hidden items-center gap-[26px] md:flex">
                <svg class="h-5 w-5 text-[#626b66]" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a2.5 2.5 0 0 0 2.4-2H7.6A2.5 2.5 0 0 0 10 18ZM4 14h12l-1.4-2.3V8a4.6 4.6 0 1 0-9.2 0v3.7L4 14Z"/></svg>
                <svg class="h-6 w-6 text-[#626b66]" fill="currentColor" viewBox="0 0 20 20"><path d="m10 1 1.5 2.1 2.6-.4.9 2.5 2.3 1.3-1.1 2.4.8 2.6-2.2 1.5-.7 2.6-2.6-.2L10 17.5l-1.5-2.1-2.6.2-.7-2.6L3 11.5l.8-2.6-1.1-2.4L5 5.2l.9-2.5 2.6.4L10 1Zm0 6a3 3 0 1 0 0 6 3 3 0 0 0 0-6Z"/></svg>
                <div class="h-[42px] w-px bg-[#dfe5e2]"></div>
                @include('admin.partials.account-identity', [
                    'nameClass' => 'text-right text-[13px] font-black leading-none',
                    'roleClass' => 'mt-[7px] text-[9px] font-bold uppercase tracking-wide text-[#89938e]',
                    'avatarClass' => 'grid h-[40px] w-[40px] place-items-center overflow-hidden rounded-full bg-[#e8f4ec] text-[13px] font-black text-[#0b751f] ring-2 ring-white',
                    'imageClass' => 'h-full w-full object-cover',
                ])
            </div>
        </header>

        <section class="px-6 pb-10 pt-[35px] lg:px-[34px]">
            <div class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between">
                <div>
                    <h2 class="text-[30px] font-black leading-tight">Manajemen Program Penyaluran</h2>
                    <p class="mt-[7px] max-w-[600px] text-[16px] leading-[24px] text-[#344139]">Rencanakan dan pantau alokasi dana ZIS untuk program bantuan warga di wilayah Soreang dan sekitarnya.</p>
                </div>
                <a href="{{ route('program-penyaluran.create') }}" class="inline-flex h-[72px] w-[267px] items-center justify-center gap-[22px] rounded-[15px] bg-[#0b751f] text-[16px] font-black leading-[20px] text-white shadow-[0_12px_20px_rgba(8,117,31,0.28)]">
                    <span class="flex h-[20px] w-[20px] items-center justify-center rounded-full bg-white text-[18px] text-[#0b751f]">+</span>
                    [+] Buat Program<br>Baru
                </a>
            </div>

            @if (session('success'))
                <div class="mt-6 rounded-[14px] border border-[#bfe6c7] bg-[#ecfff1] px-5 py-3 text-sm font-black text-[#0b751f]">{{ session('success') }}</div>
            @endif

            <div class="mt-[35px] grid gap-[24px] lg:grid-cols-2">
                <div class="h-[205px] rounded-[13px] bg-white px-[32px] py-[31px] shadow-sm ring-1 ring-[#e7eeea]">
                    <div class="flex items-start justify-between">
                        <span class="flex h-[48px] w-[48px] items-center justify-center rounded-[15px] bg-[#98f091] text-[#0b751f]">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4h12v12H4V4Zm3 3v6h6V7H7Zm2 2h2v2H9V9Z"/></svg>
                        </span>
                        <p class="text-[9px] font-black uppercase tracking-[0.28em] text-[#7f8a83]">Dana Terkumpul</p>
                    </div>
                    <p class="mt-[40px] text-[36px] font-black leading-none">Rp {{ number_format($totalDana ?: 850000000, 0, ',', '.') }}</p>
                    <p class="mt-[8px] text-[15px] text-[#303b34]">Total Dana Tersedia</p>
                </div>
                <div class="h-[205px] rounded-[13px] bg-white px-[32px] py-[31px] shadow-sm ring-1 ring-[#e7eeea]">
                    <div class="flex items-start justify-between">
                        <span class="flex h-[48px] w-[48px] items-center justify-center rounded-[15px] bg-[#c8efc5] text-[#0b751f]">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="M3 5h14v10H3V5Zm3 3a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm5 0h4v2h-4V8Zm0 3h3v1h-3v-1Z"/></svg>
                        </span>
                        <p class="text-[9px] font-black uppercase tracking-[0.28em] text-[#7f8a83]">Alokasi Aktif</p>
                    </div>
                    <p class="mt-[40px] text-[36px] font-black leading-none">Rp {{ number_format($alokasiAktif ?: 425000000, 0, ',', '.') }}</p>
                    <p class="mt-[8px] text-[15px] text-[#303b34]">Total Dialokasikan</p>
                </div>
            </div>

            <form action="{{ route('program-penyaluran.index') }}" method="GET" class="mt-[31px] flex w-full max-w-[630px] overflow-hidden rounded-[14px] bg-[#eef2f0] p-[3px]">
                @if (request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                @foreach (['semua' => 'Semua Program', 'pendidikan' => 'Pendidikan', 'kesehatan' => 'Kesehatan', 'ekonomi' => 'Ekonomi', 'sosial' => 'Sosial'] as $value => $label)
                    <button name="{{ $value === 'semua' ? 'status' : 'kategori' }}" value="{{ $value === 'semua' ? 'semua' : $label }}" class="h-[34px] flex-1 rounded-[11px] text-[13px] font-black {{ ($value === 'semua' && $selectedKategori === 'semua') || $selectedKategori === $label ? 'bg-white text-[#0b751f] shadow-sm' : 'text-[#243129]' }}">{{ $label }}</button>
                @endforeach
            </form>

            <div class="mt-[34px] grid gap-[23px] md:grid-cols-2 xl:grid-cols-3">
                @foreach ($rows as $program)
                    @php
                        $progress = $program->progress ?? ($program->status === 'selesai' ? 100 : 0);
                    $tags = $program->tags ?? $program->kategoriDana->pluck('nama')->filter()->take(2)->all();
                        $isSelesai = $program->status === 'selesai';
                        $isSample = ! $programs->count();
                    @endphp
                    <article class="min-h-[266px] rounded-[13px] bg-white px-[24px] py-[24px] shadow-sm ring-1 ring-[#e3ebe6]">
                        <div class="flex items-start justify-between">
                            <span class="flex h-[48px] w-[48px] items-center justify-center rounded-[15px] bg-[#e8eeeb] text-[#0b751f]">
                                @if (($program->icon ?? '') === 'medical')
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="M8 3h4v4h4v4h-4v4H8v-4H4V7h4V3Z"/></svg>
                                @elseif (($program->icon ?? '') === 'shop')
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="M3 5h14l-1 4H4L3 5Zm1 5h12v6H4v-6Zm2 1v3h3v-3H6Z"/></svg>
                                @elseif (($program->icon ?? '') === 'mosque')
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2c2 1.2 3 2.8 3 5v2h3v8H4V9h3V7c0-2.2 1-3.8 3-5Zm0 9a2 2 0 0 0-2 2v4h4v-4a2 2 0 0 0-2-2Z"/></svg>
                                @else
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="m10 3 8 4-8 4-8-4 8-4Zm-5 7.2 5 2.5 5-2.5V14l-5 2.5L5 14v-3.8Z"/></svg>
                                @endif
                            </span>
                            <span class="rounded-full px-[12px] py-[5px] text-[9px] font-black uppercase {{ $isSelesai ? 'bg-[#ddddda] text-[#5e645f]' : 'bg-[#98f091] text-[#0b751f]' }}">{{ $isSelesai ? 'Selesai' : 'Aktif' }}</span>
                        </div>
                        <h3 class="mt-[25px] text-[18px] font-black leading-[24px]">{{ $program->nama_program }}</h3>
                        <div class="mt-[8px] flex flex-wrap gap-[7px]">
                            @forelse ($tags as $tag)
                                <span class="rounded-[4px] bg-[#edf1ee] px-[8px] py-[4px] text-[9px] font-black uppercase text-[#7d8880]">{{ $tag }}</span>
                            @empty
                                <span class="rounded-[4px] bg-[#edf1ee] px-[8px] py-[4px] text-[9px] font-black uppercase text-[#7d8880]">ZIS</span>
                            @endforelse
                        </div>
                        <div class="mt-[25px] flex items-center justify-between text-[12px] font-bold">
                            <span>Progress Penyaluran</span>
                            <span class="{{ $isSelesai ? 'text-[#6f736f]' : 'text-[#0b751f]' }}">{{ $progress }}%</span>
                        </div>
                        <div class="mt-[10px] h-[7px] rounded-full bg-[#e2e6e3]">
                            <div class="h-[7px] rounded-full {{ $isSelesai ? 'bg-[#9b9792]' : 'bg-[#0b751f]' }}" style="width: {{ $progress }}%"></div>
                        </div>
                        <div class="mt-[17px] flex items-center justify-between text-[12px]">
                            <span>Target: <strong>{{ $program->target_mustahik }} {{ $program->target_mustahik > 1 ? 'Jiwa' : 'Bangunan' }}</strong></span>
                            <div class="flex items-center gap-3 font-black">
                                @if (! $isSample)
                                    <a class="{{ $isSelesai ? 'text-[#9b9f9b]' : 'text-[#0b751f]' }}" href="{{ route('pengaturan-distribusi.index', ['program' => $program->id]) }}">{{ $isSelesai ? 'Arsip >' : 'Detail >' }}</a>
                                    <a class="text-[#0b751f]" href="{{ route('program-penyaluran.edit', $program) }}">Edit</a>
                                    <form action="{{ route('program-penyaluran.destroy', $program) }}" method="POST" onsubmit="return confirm('Hapus program ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600">Hapus</button>
                                    </form>
                                @else
                                    <span class="{{ $isSelesai ? 'text-[#9b9f9b]' : 'text-[#0b751f]' }}">{{ $isSelesai ? 'Arsip >' : 'Detail >' }}</span>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach

                <a href="{{ route('program-penyaluran.create') }}" class="flex min-h-[266px] flex-col items-center justify-center rounded-[13px] border-2 border-dashed border-[#d9e2dd] bg-white text-center">
                    <span class="flex h-[48px] w-[48px] items-center justify-center rounded-full bg-[#80df7b] text-[24px] font-black text-[#0b751f]">+</span>
                    <span class="mt-[24px] text-[17px] font-black text-[#0b751f]">Buat Program Baru</span>
                    <span class="mt-[8px] max-w-[220px] text-[13px] leading-[20px] text-[#4a574f]">Tambahkan inisiatif penyaluran baru untuk masyarakat.</span>
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
