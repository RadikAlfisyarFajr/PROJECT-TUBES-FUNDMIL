<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Database Mustahik - Fundmil Soreang</title>
    @include('admin.partials.tailwind-assets')
</head>

<body class="bg-[#f6f8f6] font-sans text-[#111813] antialiased">
    @php
    $adminUser = auth()->user();
    $adminInstansi = $adminUser?->instansi;
    $adminBrandName = $adminInstansi?->nama ?: ($adminUser?->nama_instansi ?: 'FUNDMIL SOREANG');
    $badgeKategori = [
    'fakir' => 'bg-red-100 text-red-700',
    'miskin' => 'bg-orange-100 text-orange-700',
    'amil' => 'bg-green-100 text-green-700',
    'riqab' => 'bg-blue-100 text-blue-700',
    'gharim' => 'bg-purple-100 text-purple-700',
    'fisabilillah' => 'bg-pink-100 text-pink-700',
    'ibnu_sabil' => 'bg-gray-200 text-gray-700',
    ];
    $menuItems = [
    ['Beranda', 'grid', route('dashboard.admin')],
    ['Profil Instansi', 'bank', route('profil-instansi.index')],
    ['Kategori Dana', 'shapes', route('kategori-dana.index')],
    ['Pemasukan Zakat', 'cash', route('pemasukan.index')],
    ['Data Mustahik', 'users', route('mustahik.index')],
    ['Program Penyaluran', 'spark', route('program-penyaluran.index')],
    ['Pengaturan Distribusi', 'sliders', route('pengaturan-distribusi.index')],
    ['Laporan', 'report', route('laporan.index')],
    ['Pengaturan', 'gear', '#'],
    ];
    @endphp
    <div class="min-h-screen lg:flex">
        <aside class="fixed inset-y-0 left-0 z-20 hidden w-[286px] bg-white lg:block">
            <div class="px-8 pt-[38px]">
                <h1 class="text-[20px] font-black leading-none tracking-wide text-[#0b751f]">{{ $adminBrandName }}</h1>
                <p class="mt-[13px] text-[10px] font-black uppercase tracking-[0.34em] text-[#a3aaa5]">Sistem Amanah Digital</p>
            </div>
            <nav class="mt-[62px] space-y-[9px] px-4 text-[14px] font-semibold text-[#41546a]">
                @foreach ($menuItems as [$label, $icon, $url])
                <a href="{{ $url }}" class="flex h-[48px] items-center gap-[17px] rounded-[16px] px-[18px] {{ $label === 'Data Mustahik' ? 'bg-[#f4f8f6] font-black text-[#0b751f] shadow-[inset_4px_0_0_#0b751f]' : '' }}">
                    <span class="flex h-5 w-5 items-center justify-center">
                        @if ($icon === 'grid')
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 3h6v6H3V3Zm8 0h6v6h-6V3ZM3 11h6v6H3v-6Zm8 0h6v6h-6v-6Z" />
                        </svg>
                        @elseif ($icon === 'bank')
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2 2 6v2h16V6l-8-4ZM4 9h2v6H4V9Zm5 0h2v6H9V9Zm5 0h2v6h-2V9ZM3 16h14v2H3v-2Z" />
                        </svg>
                        @elseif ($icon === 'users')
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm6.5 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5ZM1.5 17c.5-3.3 2.4-5.5 5.5-5.5s5 2.2 5.5 5.5h-11Zm10.7 0a7.7 7.7 0 0 0-1.5-3.7 4.6 4.6 0 0 1 2.8-.8c2.6 0 4.2 1.8 4.6 4.5h-5.9Z" />
                        </svg>
                        @elseif ($icon === 'spark')
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m10 2 1.4 4.2L16 8l-4.6 1.8L10 14 8.6 9.8 4 8l4.6-1.8L10 2Zm-5 9 1 2.5L8.5 15 6 16l-1 2.5L4 16l-2.5-1L4 13.5 5 11Zm11 1 1 2 2 1-2 1-1 2-1-2-2-1 2-1 1-2Z" />
                        </svg>
                        @elseif ($icon === 'sliders')
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 3h2v14H4V3Zm5 0h2v14H9V3Zm5 0h2v14h-2V3ZM2 6h6v2H2V6Zm5 6h6v2H7v-2Zm5-7h6v2h-6V5Z" />
                        </svg>
                        @else
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4h12v12H4V4Zm3 3v2h6V7H7Zm0 4v2h4v-2H7Z" />
                        </svg>
                        @endif
                    </span>
                    {{ $label }}
                </a>
                @endforeach
            </nav>
            <div class="absolute bottom-[55px] left-4 right-4 border-t border-[#e9eeeb] pt-[30px]">
                <a class="flex items-center gap-[17px] px-[18px] text-[14px] font-semibold text-[#41546a]" href="#">
                    <span class="flex h-5 w-5 items-center justify-center rounded-full bg-[#41546a] text-[11px] font-black text-white">?</span>
                    Bantuan
                </a>
            </div>
        </aside>

        <main class="min-h-screen flex-1 lg:ml-[286px]">
            <header class="flex h-[86px] items-center justify-between bg-white px-6 lg:px-[56px]">
                <div>
                    <div class="text-[11px] font-bold text-[#92a09a]">Dashboard <span class="mx-2">›</span> <span class="text-[#0b751f]">Database Mustahik</span></div>
                    <h1 class="mt-2 text-[25px] font-black">Data Mustahik</h1>
                </div>
                <div class="hidden items-center gap-[24px] md:flex">
                    <form action="{{ route('mustahik.index') }}" method="GET" class="flex h-[58px] w-[290px] items-center gap-3 rounded-full bg-[#eef2f0] px-5">
                        <svg class="h-5 w-5 text-[#71807a]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="m21 21-4.3-4.3M10.8 18a7.2 7.2 0 1 1 0-14.4 7.2 7.2 0 0 1 0 14.4Z" />
                        </svg>
                        <input name="search" value="{{ request('search') }}" class="w-full bg-transparent text-sm outline-none placeholder:text-[#7e8984]" placeholder="Cari data...">
                    </form>
                    <svg class="h-5 w-5 text-[#71807a]" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 18a2.5 2.5 0 0 0 2.4-2H7.6A2.5 2.5 0 0 0 10 18ZM4 14h12l-1.4-2.3V8a4.6 4.6 0 1 0-9.2 0v3.7L4 14Z" />
                    </svg>
                    <div class="h-[44px] w-px bg-[#e2e8e5]"></div>
                    @include('admin.partials.account-identity', [
                    'nameClass' => 'text-right text-[13px] font-black',
                    'roleClass' => 'mt-1 text-[9px] font-bold uppercase tracking-wide text-[#9ba49e]',
                    'avatarClass' => 'grid h-[38px] w-[38px] place-items-center overflow-hidden rounded-full bg-[#e8f4ec] text-[13px] font-black text-[#0b751f] ring-2 ring-white',
                    'imageClass' => 'h-full w-full object-cover',
                    ])
                </div>
            </header>

            <section class="px-6 pb-16 pt-[60px] lg:px-[56px]">
                <div class="flex flex-col gap-5 md:flex-row md:items-start md:justify-between">
                    <div>
                        <h2 class="text-[36px] font-black leading-tight">Database Mustahik</h2>
                        <p class="mt-[9px] text-[16px] text-[#47544d]">Kelola data warga penerima manfaat di wilayah Kelurahan Soreang.</p>
                    </div>
                    <a href="{{ route('mustahik.create') }}" class="inline-flex h-[54px] min-w-[235px] items-center justify-center gap-3 rounded-[13px] bg-[#0b751f] px-5 text-[15px] font-black text-white shadow-[0_12px_20px_rgba(8,117,31,0.28)]">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M11 5H9v4H5v2h4v4h2v-4h4V9h-4V5ZM4 4a3 3 0 1 1 6 0A3 3 0 0 1 4 4Zm-3 13c.5-3.4 2.6-5.6 6-5.6 1.1 0 2.1.2 2.9.7A5.8 5.8 0 0 0 7.8 17H1Z" />
                        </svg>
                        Tambah Mustahik Baru
                    </a>
                </div>

                @if (session('success'))
                <div class="mt-6 rounded-[13px] border border-green-200 bg-green-50 px-5 py-3 text-sm font-black text-green-800">{{ session('success') }}</div>
                @endif

                <div class="mt-[42px] grid gap-[28px] xl:grid-cols-3">
                    <section class="flex h-[212px] items-center gap-[25px] rounded-[14px] bg-white px-[36px] shadow-sm ring-1 ring-[#e6ece9]">
                        <span class="grid h-[64px] w-[64px] place-items-center rounded-[15px] bg-[#eef5f0] text-[#0b751f]">
                            <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm6.5 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5ZM1.5 17c.5-3.3 2.4-5.5 5.5-5.5s5 2.2 5.5 5.5h-11Zm10.7 0a7.7 7.7 0 0 0-1.5-3.7 4.6 4.6 0 0 1 2.8-.8c2.6 0 4.2 1.8 4.6 4.5h-5.9Z" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-[12px] font-black uppercase tracking-[.18em] text-[#526058]">Total Mustahik</p>
                            <p class="mt-2 text-[39px] font-black leading-none">{{ number_format($totalMustahik, 0, ',', '.') }}</p>
                        </div>
                    </section>
                    <section class="flex h-[212px] items-center gap-[25px] rounded-[14px] bg-white px-[36px] shadow-sm ring-1 ring-[#e6ece9]">
                        <span class="grid h-[64px] w-[64px] place-items-center rounded-[15px] bg-pink-50 text-pink-700">
                            <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2h2v7h6v2h-6v7H9v-7H3V9h6V2Z" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-[12px] font-black uppercase tracking-[.18em] text-[#526058]">Kategori Terbanyak</p>
                            <p class="mt-2 text-[42px] font-black leading-[42px]">{{ $kategoriTerbanyak }}</p>
                        </div>
                    </section>
                    <section class="flex h-[212px] items-center gap-[25px] rounded-[14px] bg-[#fffbe6] px-[36px] shadow-sm ring-1 ring-[#f1e8b7]">
                        <span class="grid h-[64px] w-[64px] place-items-center rounded-[15px] bg-[#fff099] text-[#9a7a00]">
                            <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 2h10v3h2v13H3V5h2V2Zm2 3h6V4H7v1Zm3 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm.5 2v2.2l1.8 1.1-.8 1.3L9 14v-3h1.5Z" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-[12px] font-black uppercase tracking-[.18em] text-[#9a7a00]">Tidak Aktif</p>
                            <p class="mt-2 text-[38px] font-black leading-none">{{ number_format($tidakAktifMustahik, 0, ',', '.') }}</p>
                        </div>
                    </section>
                </div>

                <form action="{{ route('mustahik.index') }}" method="GET" class="mt-[44px] grid gap-4 rounded-[15px] bg-[#edf1ef] p-6 lg:grid-cols-[1fr_220px_220px_58px]">
                    <label class="flex h-[48px] items-center gap-3 rounded-[10px] bg-white px-4 shadow-sm">
                        <svg class="h-5 w-5 text-[#536058]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="m21 21-4.3-4.3M10.8 18a7.2 7.2 0 1 1 0-14.4 7.2 7.2 0 0 1 0 14.4Z" />
                        </svg>
                        <input name="search" value="{{ request('search') }}" class="w-full bg-transparent text-sm outline-none placeholder:text-[#738078]" placeholder="Cari berdasarkan Nama atau Alamat">
                    </label>
                    <select name="kategori" class="h-[48px] rounded-[10px] bg-white px-4 text-sm font-bold outline-none shadow-sm">
                        <option value="semua">Kategori Asnaf</option>
                        @foreach ($kategoriAsnaf as $value => $label)
                        <option value="{{ $value }}" @selected(request('kategori')===$value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <select name="status" class="h-[48px] rounded-[10px] bg-white px-4 text-sm font-bold outline-none shadow-sm">
                        <option value="semua">Semua Status</option>
                        <option value="aktif" @selected(request('status')==='aktif' )>Aktif</option>
                        <option value="tidak_aktif" @selected(request('status')==='tidak_aktif' )>Tidak Aktif</option>
                    </select>
                    <button class="grid h-[48px] place-items-center rounded-[10px] bg-[#dfe6e2] text-[#26352c]" type="submit" aria-label="Filter">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 5h9v2H3V5Zm11 0h3v2h-3V5ZM8 9h9v2H8V9Zm-5 0h3v2H3V9Zm0 4h9v2H3v-2Zm11 0h3v2h-3v-2Z" />
                        </svg>
                    </button>
                </form>

                <section class="mt-[46px] overflow-hidden rounded-[15px] bg-white shadow-sm ring-1 ring-[#e6ece9]">
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[1040px] text-left">
                            <thead>
                                <tr class="bg-[#fafbf9] text-[11px] font-black uppercase tracking-[.14em] text-[#303b34]">
                                    <th class="px-8 py-7">Nama Lengkap</th>
                                    <th class="px-6 py-7">NIK</th>
                                    <th class="px-6 py-7">Kategori Asnaf</th>
                                    <th class="px-6 py-7">Alamat/RW</th>
                                    <th class="px-6 py-7">Status Verifikasi</th>
                                    <th class="px-8 py-7 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#edf1ef]">
                                @forelse ($mustahik as $row)
                                @php
                                $initials = collect(explode(' ', $row->nama))->filter()->take(2)->map(fn ($part) => str($part)->substr(0, 1))->join('');
                                @endphp
                                <tr class="hover:bg-[#fbfdfb]">
                                    <td class="px-8 py-7">
                                        <div class="flex items-center gap-4">
                                            <span class="grid h-[42px] w-[42px] place-items-center rounded-full bg-green-200 text-sm font-black text-[#0b751f]">{{ strtoupper($initials ?: 'M') }}</span>
                                            <div>
                                                <p class="text-[15px] font-black">{{ $row->nama }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-7 font-mono text-sm text-[#303b34]">{{ $row->nik ? substr($row->nik, 0, 6).'******'.substr($row->nik, -4) : '-' }}</td>
                                    <td class="px-6 py-7">
                                        <span class="rounded-full px-3 py-1 text-[10px] font-black uppercase {{ $badgeKategori[$row->kategori_asnaf] ?? 'bg-gray-100 text-gray-700' }}">{{ $row->kategori_label }}</span>
                                    </td>
                                    <td class="max-w-[230px] px-6 py-7 text-sm leading-5 text-[#303b34]">{{ $row->alamat }}</td>
                                    <td class="px-6 py-7">
                                        <span class="inline-flex items-center gap-2 text-[11px] font-black uppercase {{ $row->status === 'aktif' ? 'text-[#0b751f]' : 'text-red-700' }}">
                                            <span class="h-2 w-2 rounded-full {{ $row->status === 'aktif' ? 'bg-[#0b751f]' : 'bg-red-600' }}"></span>
                                            {{ $row->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-7">
                                        <div class="flex justify-end gap-7">
                                            <a href="{{ route('mustahik.show', $row) }}" class="text-blue-700" aria-label="Detail">
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 4c4.5 0 7.5 4.2 8 6-.5 1.8-3.5 6-8 6s-7.5-4.2-8-6c.5-1.8 3.5-6 8-6Zm0 3.2a2.8 2.8 0 1 0 0 5.6 2.8 2.8 0 0 0 0-5.6Z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('mustahik.edit', $row) }}" class="text-yellow-700" aria-label="Edit">
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M14.7 2.3a1 1 0 0 1 1.4 0l1.6 1.6a1 1 0 0 1 0 1.4L7.3 15.7 3 17l1.3-4.3L14.7 2.3Z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('mustahik.destroy', $row) }}" method="POST" onsubmit="return confirm('Hapus data mustahik ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-700" aria-label="Hapus" type="submit">
                                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M7 2h6l1 2h4v2H2V4h4l1-2Zm-2 6h10l-.7 10H5.7L5 8Z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-8 py-12 text-center text-[#6c756f]">Belum ada data mustahik.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="flex flex-col gap-4 border-t border-[#edf1ef] px-8 py-7 text-sm text-[#536058] md:flex-row md:items-center md:justify-between">
                        <span>Menampilkan {{ $mustahik->firstItem() ?? 0 }}-{{ $mustahik->lastItem() ?? 0 }} dari {{ number_format($mustahik->total(), 0, ',', '.') }} Mustahik</span>
                        {{ $mustahik->links() }}
                    </div>
                </section>

                <div class="mt-[44px] grid gap-7 lg:grid-cols-2">
                    <section class="flex gap-5 rounded-[14px] border border-green-200 bg-green-50 p-8">
                        <span class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-green-100 text-[#0b751f] font-black">i</span>
                        <div>
                            <h3 class="text-[18px] font-black text-[#0b751f]">Pembaruan Data Berkala</h3>
                            <p class="mt-2 text-sm leading-6 text-[#344139]">Pastikan data Mustahik diperbarui setiap 6 bulan sekali untuk menjaga validitas penyaluran zakat di wilayah Soreang.</p>
                        </div>
                    </section>
                    <section class="flex gap-5 rounded-[14px] border border-[#e2e8e5] bg-white p-8">
                        <span class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-slate-100 text-slate-500">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2 4 4.5V9c0 4 2.4 7 6 9 3.6-2 6-5 6-9V4.5L10 2Z" />
                            </svg>
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