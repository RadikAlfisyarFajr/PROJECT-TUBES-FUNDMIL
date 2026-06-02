<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Mustahik Baru - Fundmil Soreang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f4f7f5] font-sans text-[#172018] antialiased">
    <div class="min-h-screen lg:flex">
        <aside class="fixed inset-y-0 left-0 z-20 hidden w-[254px] border-r border-[#e8eeeb] bg-white lg:block">
            <div class="px-8 pt-9">
                <h1 class="text-[20px] font-extrabold tracking-wide text-[#0b751f]">FUNDMIL SOREANG</h1>
                <p class="mt-2 text-[10px] font-bold uppercase tracking-[0.34em] text-[#9ba6a0]">Sistem Amanah Digital</p>
            </div>
            <nav class="mt-14 space-y-3 px-4 text-[15px] font-medium text-[#3d5065]">
                @foreach (['Beranda', 'Profil Instansi', 'Kategori Dana', 'Pemasukan Zakat', 'Data Mustahik', 'Program Penyaluran', 'Pengaturan Distribusi', 'Laporan', 'Pengaturan'] as $label)
                <a href="{{ $label === 'Data Mustahik' ? route('mustahik.index') : '#' }}"
                    class="flex items-center gap-4 rounded-2xl px-4 py-3 {{ $label === 'Data Mustahik' ? 'bg-[#f4f8f6] font-extrabold text-[#0b751f] shadow-[inset_4px_0_0_#0b751f]' : 'hover:bg-[#f8faf9]' }}">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4h12v12H4V4Zm3 3v2h6V7H7Zm0 4v2h4v-2H7Z" />
                    </svg>
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
            <header class="flex h-[76px] items-center justify-between bg-white px-6 lg:px-12">
                <a href="{{ route('mustahik.index') }}" class="inline-flex items-center gap-3 text-base font-semibold text-[#6b766e]">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 12H5m6-7-7 7 7 7" />
                    </svg>
                    Kembali ke Database
                </a>
                <div class="hidden items-center gap-6 md:flex">
                    <div class="relative">
                        <svg class="h-6 w-6 text-[#5f6e66]" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 18a2.5 2.5 0 0 0 2.4-2H7.6A2.5 2.5 0 0 0 10 18ZM4 14h12l-1.4-2.3V8a4.6 4.6 0 1 0-9.2 0v3.7L4 14Z" />
                        </svg>
                        <span class="absolute -right-1 -top-1 h-2.5 w-2.5 rounded-full bg-[#c92727]"></span>
                    </div>
                    <div class="h-10 w-px bg-[#dfe5e2]"></div>
                    <div class="text-right">
                        <p class="text-sm font-extrabold">Amil Soreang</p>
                        <p class="mt-1 text-[10px] font-bold text-[#7b8780]">Petugas Lapangan</p>
                    </div>
                    <div class="h-11 w-11 rounded-full bg-[linear-gradient(135deg,#f3ccb9,#162941)] ring-2 ring-white"></div>
                </div>
            </header>

            <section class="px-6 py-10 lg:px-12">
                <div>
                    <h2 class="text-[36px] font-black leading-tight tracking-tight">Tambah Mustahik Baru</h2>
                    <p class="mt-2 text-xl text-[#758176]">Input data lengkap warga penerima manfaat baru untuk proses verifikasi asnaf.</p>
                </div>

                @if ($errors->any())
                <div class="mt-8 rounded-2xl border border-[#ffd2d2] bg-[#fff2f2] px-5 py-4 text-sm font-bold text-[#b42323]">
                    Mohon periksa kembali data yang ditandai pada formulir.
                </div>
                @endif

                <form action="{{ route('mustahik.store') }}" method="POST" class="mt-10 max-w-[930px] rounded-2xl bg-white px-10 py-11 shadow-sm ring-1 ring-[#e8eeeb]">
                    @csrf

                    <section>
                        <div class="mb-8 flex items-center gap-4">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#e8f5ec] text-[#0b751f]">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7 2h6v3h3v13H4V5h3V2Zm2 3h2V4H9v1Zm-1 6a2 2 0 1 0 4 0 2 2 0 0 0-4 0Zm-2 5h8c-.4-2-1.8-3-4-3s-3.6 1-4 3Z" />
                                </svg>
                            </span>
                            <h3 class="text-2xl font-black">Identitas Pribadi</h3>
                        </div>

                        <div class="grid gap-7 md:grid-cols-2">
                            <label class="block">
                                <span class="text-xs font-black uppercase tracking-[0.14em] text-[#7b877e]">Nama Lengkap</span>
                                <input name="nama" value="{{ old('nama') }}" class="mt-3 h-14 w-full rounded-xl border-0 bg-[#e9eeeb] px-5 text-base outline-none ring-1 ring-transparent placeholder:text-[#76838a] focus:bg-white focus:ring-[#0b751f]" placeholder="Sesuai KTP">
                                @error('nama') <span class="mt-2 block text-xs font-bold text-red-600">{{ $message }}</span> @enderror
                            </label>
                            <label class="block">
                                <span class="text-xs font-black uppercase tracking-[0.14em] text-[#7b877e]">NIK (Nomor Induk Kependudukan)</span>
                                <input name="nik" value="{{ old('nik') }}" maxlength="16" class="mt-3 h-14 w-full rounded-xl border-0 bg-[#e9eeeb] px-5 text-base outline-none ring-1 ring-transparent placeholder:text-[#76838a] focus:bg-white focus:ring-[#0b751f]" placeholder="16 digit angka">
                                @error('nik') <span class="mt-2 block text-xs font-bold text-red-600">{{ $message }}</span> @enderror
                            </label>
                            <div class="grid gap-4 sm:grid-cols-[1fr_160px]">
                                <label class="block">
                                    <span class="text-xs font-black uppercase tracking-[0.14em] text-[#7b877e]">Tempat Lahir</span>
                                    <input name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="mt-3 h-14 w-full rounded-xl border-0 bg-[#e9eeeb] px-5 text-base outline-none ring-1 ring-transparent placeholder:text-[#76838a] focus:bg-white focus:ring-[#0b751f]" placeholder="Kota/Kab">
                                    @error('tempat_lahir') <span class="mt-2 block text-xs font-bold text-red-600">{{ $message }}</span> @enderror
                                </label>
                                <label class="block">
                                    <span class="text-xs font-black uppercase tracking-[0.14em] text-[#7b877e]">Tgl Lahir</span>
                                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="mt-3 h-14 w-full rounded-xl border-0 bg-[#e9eeeb] px-5 text-base outline-none ring-1 ring-transparent focus:bg-white focus:ring-[#0b751f]">
                                    @error('tanggal_lahir') <span class="mt-2 block text-xs font-bold text-red-600">{{ $message }}</span> @enderror
                                </label>
                            </div>
                        </div>

                        <div class="mt-7 max-w-[415px]">
                            <p class="text-xs font-black uppercase tracking-[0.14em] text-[#7b877e]">Jenis Kelamin</p>
                            <div class="mt-3 grid grid-cols-2 gap-4">
                                <label class="cursor-pointer">
                                    <input type="radio" name="jenis_kelamin" value="Laki-laki" class="peer sr-only" @checked(old('jenis_kelamin', 'Laki-laki' )==='Laki-laki' )>
                                    <span class="flex h-14 items-center justify-center rounded-xl bg-[#e9eeeb] text-sm font-semibold ring-1 ring-transparent peer-checked:bg-white peer-checked:ring-2 peer-checked:ring-[#0b751f]">Laki-laki</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="jenis_kelamin" value="Perempuan" class="peer sr-only" @checked(old('jenis_kelamin')==='Perempuan' )>
                                    <span class="flex h-14 items-center justify-center rounded-xl bg-[#e9eeeb] text-sm font-semibold ring-1 ring-transparent peer-checked:bg-white peer-checked:ring-2 peer-checked:ring-[#0b751f]">Perempuan</span>
                                </label>
                            </div>
                            @error('jenis_kelamin') <span class="mt-2 block text-xs font-bold text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </section>

                    <section class="mt-12">
                        <div class="mb-8 flex items-center gap-4">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#e8f5ec] text-[#0b751f]">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2 3 11h5v6h8v-6h1L10 2Zm3 11a2 2 0 1 1 0 4 2 2 0 0 1 0-4Z" />
                                </svg>
                            </span>
                            <h3 class="text-2xl font-black">Kategori Asnaf</h3>
                        </div>
                        <label class="block">
                            <span class="text-xs font-black uppercase tracking-[0.14em] text-[#7b877e]">Pilih Kategori Utama</span>
                            <select name="kategori_asnaf" class="mt-3 h-14 w-full rounded-xl border-0 bg-[#e9eeeb] px-5 text-base outline-none ring-1 ring-transparent focus:bg-white focus:ring-[#0b751f]">
                                <option value="">Pilih Asnaf</option>
                                @foreach ($kategoriAsnaf as $kategori)
                                <option value="{{ $kategori }}" @selected(old('kategori_asnaf')===$kategori)>{{ $kategori }}</option>
                                @endforeach
                            </select>
                            <span class="mt-3 block text-xs italic text-[#9aa39c]">Pastikan pemilihan asnaf sesuai dengan hasil survey lapangan terakhir.</span>
                            @error('kategori_asnaf') <span class="mt-2 block text-xs font-bold text-red-600">{{ $message }}</span> @enderror
                        </label>
                    </section>

                    <section class="mt-12">
                        <div class="mb-8 flex items-center gap-4">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#e8f5ec] text-[#0b751f]">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a6 6 0 0 0-6 6c0 4.5 6 10 6 10s6-5.5 6-10a6 6 0 0 0-6-6Zm0 8.3A2.3 2.3 0 1 1 10 5.7a2.3 2.3 0 0 1 0 4.6Z" />
                                </svg>
                            </span>
                            <h3 class="text-2xl font-black">Alamat Lengkap (Soreang)</h3>
                        </div>
                        <div class="grid gap-6 md:grid-cols-[1fr_1fr_1fr]">
                            <label class="block">
                                <span class="text-xs font-black uppercase tracking-[0.14em] text-[#7b877e]">Desa/Kelurahan</span>
                                <select name="desa_kelurahan" class="mt-3 h-14 w-full rounded-xl border-0 bg-[#e9eeeb] px-5 text-base outline-none ring-1 ring-transparent focus:bg-white focus:ring-[#0b751f]">
                                    @foreach (['Cingcin', 'Soreang', 'Pamekaran', 'Sekarwangi'] as $desa)
                                    <option value="{{ $desa }}" @selected(old('desa_kelurahan', 'Cingcin' )===$desa)>{{ $desa }}</option>
                                    @endforeach
                                </select>
                                @error('desa_kelurahan') <span class="mt-2 block text-xs font-bold text-red-600">{{ $message }}</span> @enderror
                            </label>
                            <label class="block">
                                <span class="text-xs font-black uppercase tracking-[0.14em] text-[#7b877e]">RW</span>
                                <input name="rw" value="{{ old('rw') }}" maxlength="3" class="mt-3 h-14 w-full rounded-xl border-0 bg-[#e9eeeb] px-5 text-base outline-none ring-1 ring-transparent placeholder:text-[#76838a] focus:bg-white focus:ring-[#0b751f]" placeholder="00">
                                @error('rw') <span class="mt-2 block text-xs font-bold text-red-600">{{ $message }}</span> @enderror
                            </label>
                            <label class="block">
                                <span class="text-xs font-black uppercase tracking-[0.14em] text-[#7b877e]">RT</span>
                                <input name="rt" value="{{ old('rt') }}" maxlength="3" class="mt-3 h-14 w-full rounded-xl border-0 bg-[#e9eeeb] px-5 text-base outline-none ring-1 ring-transparent placeholder:text-[#76838a] focus:bg-white focus:ring-[#0b751f]" placeholder="00">
                                @error('rt') <span class="mt-2 block text-xs font-bold text-red-600">{{ $message }}</span> @enderror
                            </label>
                        </div>
                        <label class="mt-7 block">
                            <span class="text-xs font-black uppercase tracking-[0.14em] text-[#7b877e]">Alamat Detail</span>
                            <textarea name="alamat" rows="4" class="mt-3 w-full rounded-xl border-0 bg-[#e9eeeb] px-5 py-4 text-base outline-none ring-1 ring-transparent placeholder:text-[#76838a] focus:bg-white focus:ring-[#0b751f]" placeholder="Nama Jalan, No. Rumah, Patokan, dll.">{{ old('alamat') }}</textarea>
                            @error('alamat') <span class="mt-2 block text-xs font-bold text-red-600">{{ $message }}</span> @enderror
                        </label>
                    </section>

                    <div class="mt-12 flex items-center justify-end gap-8 border-t border-[#e4ebe7] pt-8">
                        <a href="{{ route('mustahik.index') }}" class="text-base font-bold text-[#69756d]">Batal</a>
                        <button class="h-14 rounded-xl bg-[#08751f] px-9 text-base font-extrabold text-white shadow-[0_12px_24px_rgba(8,117,31,0.22)]">Simpan Data Mustahik</button>
                    </div>
                </form>

                <footer class="mt-9 flex max-w-[930px] items-center justify-between px-2 text-[10px] font-black uppercase tracking-[0.12em] text-[#a3aca6]">
                    <span>Data dienkripsi & amanah digital sesuai syariat</span>
                    <span>Versi 2.4.0 - Fundmil Soreang</span>
                </footer>
            </section>
        </main>
    </div>
</body>

</html>