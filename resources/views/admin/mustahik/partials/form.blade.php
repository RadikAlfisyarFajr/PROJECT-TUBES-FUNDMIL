<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} - Fundmil Soreang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f6f8f6] font-sans text-[#111813] antialiased">
@php
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
            <h1 class="text-[20px] font-black leading-none tracking-wide text-[#0b751f]">FUNDMIL SOREANG</h1>
            <p class="mt-[13px] text-[10px] font-black uppercase tracking-[0.34em] text-[#a3aaa5]">Sistem Amanah Digital</p>
        </div>
        <nav class="mt-[62px] space-y-[9px] px-4 text-[14px] font-semibold text-[#41546a]">
            @foreach ($menuItems as [$label, $icon, $url])
                <a href="{{ $url }}" class="flex h-[48px] items-center gap-[17px] rounded-[16px] px-[18px] {{ $label === 'Data Mustahik' ? 'bg-[#f4f8f6] font-black text-[#0b751f] shadow-[inset_4px_0_0_#0b751f]' : '' }}">
                    <span class="flex h-5 w-5 items-center justify-center">
                        @if ($icon === 'grid')
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M3 3h6v6H3V3Zm8 0h6v6h-6V3ZM3 11h6v6H3v-6Zm8 0h6v6h-6v-6Z"/></svg>
                        @elseif ($icon === 'bank')
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2 2 6v2h16V6l-8-4ZM4 9h2v6H4V9Zm5 0h2v6H9V9Zm5 0h2v6h-2V9ZM3 16h14v2H3v-2Z"/></svg>
                        @elseif ($icon === 'users')
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M7 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm6.5 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5ZM1.5 17c.5-3.3 2.4-5.5 5.5-5.5s5 2.2 5.5 5.5h-11Zm10.7 0a7.7 7.7 0 0 0-1.5-3.7 4.6 4.6 0 0 1 2.8-.8c2.6 0 4.2 1.8 4.6 4.5h-5.9Z"/></svg>
                        @elseif ($icon === 'spark')
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="m10 2 1.4 4.2L16 8l-4.6 1.8L10 14 8.6 9.8 4 8l4.6-1.8L10 2Zm-5 9 1 2.5L8.5 15 6 16l-1 2.5L4 16l-2.5-1L4 13.5 5 11Zm11 1 1 2 2 1-2 1-1 2-1-2-2-1 2-1 1-2Z"/></svg>
                        @elseif ($icon === 'sliders')
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3h2v14H4V3Zm5 0h2v14H9V3Zm5 0h2v14h-2V3ZM2 6h6v2H2V6Zm5 6h6v2H7v-2Zm5-7h6v2h-6V5Z"/></svg>
                        @else
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4h12v12H4V4Zm3 3v2h6V7H7Zm0 4v2h4v-2H7Z"/></svg>
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
        <header class="flex h-[66px] items-center justify-between bg-white px-6 lg:px-[56px]">
            <a href="{{ route('mustahik.index') }}" class="inline-flex items-center gap-3 text-[14px] font-semibold text-[#6c756f]">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5m6-7-7 7 7 7"/></svg>
                Kembali ke Database
            </a>
            <div class="hidden items-center gap-[24px] md:flex">
                <svg class="h-5 w-5 text-[#71807a]" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a2.5 2.5 0 0 0 2.4-2H7.6A2.5 2.5 0 0 0 10 18ZM4 14h12l-1.4-2.3V8a4.6 4.6 0 1 0-9.2 0v3.7L4 14Z"/></svg>
                <div class="h-[44px] w-px bg-[#e2e8e5]"></div>
                <div class="text-right">
                    <p class="text-[13px] font-black">Amil Soreang</p>
                    <p class="mt-1 text-[9px] font-bold text-[#9ba49e]">Petugas Lapangan</p>
                </div>
                <div class="h-[38px] w-[38px] rounded-full bg-[linear-gradient(135deg,#142b22,#f0b98d)]"></div>
            </div>
        </header>

        <section class="px-6 pb-12 pt-[38px] lg:px-[56px]">
            <div>
                <h1 class="text-[34px] font-black leading-tight">{{ $title }}</h1>
                <p class="mt-[9px] text-[17px] text-[#758078]">Input data lengkap warga penerima manfaat baru untuk proses verifikasi asnaf.</p>
            </div>

            <form action="{{ $action }}" method="POST" class="mt-[38px] max-w-[1040px] rounded-[15px] bg-white px-[44px] py-[42px] shadow-sm ring-1 ring-[#e6ece9]">
                @csrf
                @if ($method !== 'POST')
                    @method($method)
                @endif

                @if ($errors->any())
                    <div class="mb-7 rounded-[12px] border border-red-200 bg-red-50 px-5 py-3 text-sm font-bold text-red-700">Lengkapi data yang masih belum valid.</div>
                @endif

                <section>
                    <h2 class="flex items-center gap-3 text-[20px] font-black">
                        <span class="grid h-[30px] w-[30px] place-items-center rounded-[8px] bg-green-50 text-[#0b751f]">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M7 2h6v4h3v12H4V6h3V2Zm2 4h2V4H9v2Z"/></svg>
                        </span>
                        Identitas Pribadi
                    </h2>
                    <div class="mt-[27px] grid gap-[24px] md:grid-cols-2">
                        <label>
                            <span class="text-[11px] font-black uppercase tracking-[.14em] text-[#6a756f]">Nama Lengkap</span>
                            <input required name="nama_lengkap" value="{{ old('nama_lengkap', $mustahik->nama ?? '') }}" class="mt-[10px] h-[48px] w-full rounded-[11px] bg-[#e5eae7] px-4 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#0b751f]" placeholder="Sesuai KTP">
                            @error('nama_lengkap') <span class="mt-2 block text-xs font-bold text-red-600">{{ $message }}</span> @enderror
                        </label>
                        <label>
                            <span class="text-[11px] font-black uppercase tracking-[.14em] text-[#6a756f]">NIK (Nomor Induk Kependudukan)</span>
                            <input name="nik" value="{{ old('nik', $mustahik->nik ?? '') }}" maxlength="16" inputmode="numeric" class="mt-[10px] h-[48px] w-full rounded-[11px] bg-[#e5eae7] px-4 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#0b751f]" placeholder="16 digit angka">
                            @error('nik') <span class="mt-2 block text-xs font-bold text-red-600">{{ $message }}</span> @enderror
                        </label>
                        <label>
                            <span class="text-[11px] font-black uppercase tracking-[.14em] text-[#6a756f]">No. Kartu Keluarga</span>
                            <input class="mt-[10px] h-[48px] w-full rounded-[11px] bg-[#e5eae7] px-4 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#0b751f]" placeholder="16 digit angka">
                        </label>
                        <div class="grid gap-[24px] md:grid-cols-2">
                            <label>
                                <span class="text-[11px] font-black uppercase tracking-[.14em] text-[#6a756f]">Tempat Lahir</span>
                                <input class="mt-[10px] h-[48px] w-full rounded-[11px] bg-[#e5eae7] px-4 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#0b751f]" placeholder="Kota/Kab">
                            </label>
                            <label>
                                <span class="text-[11px] font-black uppercase tracking-[.14em] text-[#6a756f]">Tgl Lahir</span>
                                <input type="date" class="mt-[10px] h-[48px] w-full rounded-[11px] bg-[#e5eae7] px-4 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#0b751f]">
                            </label>
                        </div>
                        <div>
                            <span class="text-[11px] font-black uppercase tracking-[.14em] text-[#6a756f]">Jenis Kelamin</span>
                            <div class="mt-[10px] grid grid-cols-2 gap-4">
                                <button type="button" class="h-[48px] rounded-[11px] border-2 border-[#0b751f] bg-white text-sm font-bold">Laki-laki</button>
                                <button type="button" class="h-[48px] rounded-[11px] bg-[#e5eae7] text-sm font-bold">Perempuan</button>
                            </div>
                        </div>
                        <label>
                            <span class="text-[11px] font-black uppercase tracking-[.14em] text-[#6a756f]">Nomor Telepon</span>
                            <input name="kontak" value="{{ old('kontak', $mustahik->kontak ?? '') }}" class="mt-[10px] h-[48px] w-full rounded-[11px] bg-[#e5eae7] px-4 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#0b751f]" placeholder="08xxxxxxxxxx">
                            @error('kontak') <span class="mt-2 block text-xs font-bold text-red-600">{{ $message }}</span> @enderror
                        </label>
                        <label>
                            <span class="text-[11px] font-black uppercase tracking-[.14em] text-[#6a756f]">Status</span>
                            <select name="status" class="mt-[10px] h-[48px] w-full rounded-[11px] bg-[#e5eae7] px-4 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#0b751f]">
                                <option value="aktif" @selected(old('status', $mustahik->status ?? 'aktif') === 'aktif')>Aktif</option>
                                <option value="tidak_aktif" @selected(old('status', $mustahik->status ?? '') === 'tidak_aktif')>Tidak Aktif</option>
                            </select>
                        </label>
                    </div>
                </section>

                <section class="mt-[42px]">
                    <h2 class="flex items-center gap-3 text-[20px] font-black">
                        <span class="grid h-[30px] w-[30px] place-items-center rounded-[8px] bg-green-50 text-[#0b751f]">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="m10 2 8 4-8 4-8-4 8-4Zm-5 7.2 5 2.5 5-2.5V14l-5 2.5L5 14V9.2Z"/></svg>
                        </span>
                        Kategori Asnaf
                    </h2>
                    <label class="mt-[24px] block">
                        <span class="text-[11px] font-black uppercase tracking-[.14em] text-[#6a756f]">Pilih Kategori Utama</span>
                        <select required name="kategori" class="mt-[10px] h-[48px] w-full rounded-[11px] bg-[#e5eae7] px-4 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#0b751f]">
                            <option value="">Pilih Asnaf</option>
                            @foreach ($kategoriAsnaf as $value => $label)
                                <option value="{{ $value }}" @selected(old('kategori', $mustahik->kategori_asnaf ?? '') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('kategori') <span class="mt-2 block text-xs font-bold text-red-600">{{ $message }}</span> @enderror
                        <span class="mt-2 block text-[11px] italic text-[#8a948e]">Pastikan pemilihan asnaf sesuai dengan hasil survey lapangan terakhir.</span>
                    </label>
                </section>

                <section class="mt-[42px]">
                    <h2 class="flex items-center gap-3 text-[20px] font-black">
                        <span class="grid h-[30px] w-[30px] place-items-center rounded-[8px] bg-green-50 text-[#0b751f]">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18s6-5.4 6-10A6 6 0 1 0 4 8c0 4.6 6 10 6 10Zm0-7.5A2.5 2.5 0 1 1 10 5a2.5 2.5 0 0 1 0 5.5Z"/></svg>
                        </span>
                        Alamat Lengkap (Soreang)
                    </h2>
                    <div class="mt-[24px] grid gap-[24px] md:grid-cols-3">
                        <label>
                            <span class="text-[11px] font-black uppercase tracking-[.14em] text-[#6a756f]">Desa/Kelurahan</span>
                            <select class="mt-[10px] h-[48px] w-full rounded-[11px] bg-[#e5eae7] px-4 text-sm outline-none">
                                <option>Cingcin</option>
                                <option>Soreang</option>
                                <option>Pamekaran</option>
                            </select>
                        </label>
                        <label>
                            <span class="text-[11px] font-black uppercase tracking-[.14em] text-[#6a756f]">RW</span>
                            <input class="mt-[10px] h-[48px] w-full rounded-[11px] bg-[#e5eae7] px-4 text-sm outline-none" placeholder="00">
                        </label>
                        <label>
                            <span class="text-[11px] font-black uppercase tracking-[.14em] text-[#6a756f]">RT</span>
                            <input class="mt-[10px] h-[48px] w-full rounded-[11px] bg-[#e5eae7] px-4 text-sm outline-none" placeholder="00">
                        </label>
                    </div>
                    <label class="mt-[24px] block">
                        <span class="text-[11px] font-black uppercase tracking-[.14em] text-[#6a756f]">Alamat Detail</span>
                        <textarea required name="alamat" rows="4" class="mt-[10px] w-full resize-y rounded-[11px] bg-[#e5eae7] px-4 py-4 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#0b751f]" placeholder="Nama Jalan, No. Rumah, Patokan, dll.">{{ old('alamat', $mustahik->alamat ?? '') }}</textarea>
                        @error('alamat') <span class="mt-2 block text-xs font-bold text-red-600">{{ $message }}</span> @enderror
                    </label>
                    <label class="mt-[24px] block">
                        <span class="text-[11px] font-black uppercase tracking-[.14em] text-[#6a756f]">Keterangan</span>
                        <textarea name="keterangan" rows="3" class="mt-[10px] w-full resize-y rounded-[11px] bg-[#e5eae7] px-4 py-4 text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#0b751f]" placeholder="Catatan tambahan kondisi mustahik">{{ old('keterangan', $mustahik->keterangan ?? '') }}</textarea>
                    </label>
                </section>

                <section class="mt-[42px]">
                    <h2 class="flex items-center gap-3 text-[20px] font-black">
                        <span class="grid h-[30px] w-[30px] place-items-center rounded-[8px] bg-green-50 text-[#0b751f]">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4h12v12H4V4Zm3 3h6v2H7V7Zm0 4h6v2H7v-2Z"/></svg>
                        </span>
                        Foto Dokumen
                    </h2>
                    <div class="mt-[24px] grid gap-[30px] md:grid-cols-2">
                        <div class="grid h-[140px] place-items-center rounded-[12px] border-2 border-dashed border-[#c8d6ce] bg-[#fbfcfb] text-center text-[#6c756f]">
                            <div>
                                <svg class="mx-auto h-8 w-8" fill="currentColor" viewBox="0 0 20 20"><path d="M4 5h3l1-2h4l1 2h3v11H4V5Zm6 3a3 3 0 1 0 0 6 3 3 0 0 0 0-6Z"/></svg>
                                <p class="mt-3 text-[11px] font-black uppercase tracking-[.18em]">Unggah Foto KTP</p>
                            </div>
                        </div>
                        <div class="grid h-[140px] place-items-center rounded-[12px] border-2 border-dashed border-[#c8d6ce] bg-[#fbfcfb] text-center text-[#6c756f]">
                            <div>
                                <svg class="mx-auto h-8 w-8" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3h12v14H4V3Zm3 4h6V5H7v2Zm0 4h6V9H7v2Zm0 4h4v-2H7v2Z"/></svg>
                                <p class="mt-3 text-[11px] font-black uppercase tracking-[.18em]">Unggah Foto KK</p>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="mt-[48px] flex items-center justify-end gap-8 border-t border-[#e7eeea] pt-[32px]">
                    <a href="{{ route('mustahik.index') }}" class="text-sm font-black text-[#6c756f]">{{ $method === 'POST' ? 'Batal' : 'Kembali' }}</a>
                    <button class="h-[52px] min-w-[230px] rounded-[11px] bg-[#0b751f] px-8 text-sm font-black text-white shadow-[0_10px_20px_rgba(8,117,31,0.24)]" type="submit">{{ $method === 'POST' ? 'Simpan Data Mustahik' : 'Update Data Mustahik' }}</button>
                </div>
            </form>

            <div class="mt-[35px] flex max-w-[1040px] items-center justify-between text-[10px] font-black uppercase tracking-[.16em] text-[#8a948e]">
                <span>Data dienkripsi & amanah digital sesuai syariat</span>
                <span>Versi 2.4.0 - Fundmil Soreang</span>
            </div>
        </section>
    </main>
</div>
</body>
</html>
