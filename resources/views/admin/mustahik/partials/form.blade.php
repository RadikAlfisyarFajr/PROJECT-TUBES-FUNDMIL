<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} - Fundmil Soreang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
    <style>
        .mustahik-form input:not([type="radio"]):not([type="checkbox"]),
        .mustahik-form select,
        .mustahik-form textarea {
            border-color: transparent;
            box-shadow: none;
        }

        .mustahik-form input:focus,
        .mustahik-form select:focus,
        .mustahik-form textarea:focus {
            outline: none;
        }
    </style>
</head>

<body class="sidebar-expanded bg-[#f6f8f6] font-sans text-[#111813] antialiased">
    <div class="admin-layout">
        @include('admin.partials.sidebar', ['active' => 'mustahik'])

        <main class="min-h-screen flex-1">
            <header class="flex h-[66px] items-center justify-between bg-white px-6 lg:px-[56px]">
                <a href="{{ route('mustahik.index') }}" class="inline-flex items-center gap-3 text-[14px] font-semibold text-[#6c756f]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 12H5m6-7-7 7 7 7" />
                    </svg>
                    Kembali ke Database
                </a>
                <div class="hidden items-center gap-[24px] md:flex">
                    <svg class="h-5 w-5 text-[#71807a]" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 18a2.5 2.5 0 0 0 2.4-2H7.6A2.5 2.5 0 0 0 10 18ZM4 14h12l-1.4-2.3V8a4.6 4.6 0 1 0-9.2 0v3.7L4 14Z" />
                    </svg>
                    <div class="h-[44px] w-px bg-[#e2e8e5]"></div>
                    @include('admin.partials.account-identity', [
                    'nameClass' => 'text-right text-[13px] font-black',
                    'roleClass' => 'mt-1 text-[9px] font-bold uppercase tracking-wide text-[#9ba49e]',
                    'avatarClass' => 'admin-avatar',
                    'imageClass' => 'h-full w-full object-cover',
                    ])
                </div>
            </header>

            <section class="px-6 pb-12 pt-[38px] lg:px-[56px]">
                <div>
                    <h1 class="text-[34px] font-black leading-tight">{{ $title }}</h1>
                    <p class="mt-[9px] text-[17px] text-[#758078]">Input data lengkap warga penerima manfaat baru untuk proses verifikasi asnaf.</p>
                </div>

                <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="mustahik-form mt-[38px] max-w-[1040px] rounded-[15px] bg-white px-[44px] py-[42px] shadow-sm ring-1 ring-[#e6ece9]">
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
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7 2h6v4h3v12H4V6h3V2Zm2 4h2V4H9v2Z" />
                                </svg>
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
                                    <label for="jenis_kelamin_laki_laki" class="gender-option grid h-[48px] cursor-pointer place-items-center rounded-[11px] border-2 border-transparent bg-[#e5eae7] text-sm font-bold transition" data-gender-option>
                                        <input id="jenis_kelamin_laki_laki" type="radio" name="jenis_kelamin" value="laki_laki" class="sr-only" @checked(old('jenis_kelamin', $mustahik->jenis_kelamin ?? 'laki_laki') === 'laki_laki')>
                                        <span>Laki-laki</span>
                                    </label>
                                    <label for="jenis_kelamin_perempuan" class="gender-option grid h-[48px] cursor-pointer place-items-center rounded-[11px] border-2 border-transparent bg-[#e5eae7] text-sm font-bold transition" data-gender-option>
                                        <input id="jenis_kelamin_perempuan" type="radio" name="jenis_kelamin" value="perempuan" class="sr-only" @checked(old('jenis_kelamin', $mustahik->jenis_kelamin ?? '') === 'perempuan')>
                                        <span>Perempuan</span>
                                    </label>
                                </div>
                                @error('jenis_kelamin') <span class="mt-2 block text-xs font-bold text-red-600">{{ $message }}</span> @enderror
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
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="m10 2 8 4-8 4-8-4 8-4Zm-5 7.2 5 2.5 5-2.5V14l-5 2.5L5 14V9.2Z" />
                                </svg>
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
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18s6-5.4 6-10A6 6 0 1 0 4 8c0 4.6 6 10 6 10Zm0-7.5A2.5 2.5 0 1 1 10 5a2.5 2.5 0 0 1 0 5.5Z" />
                                </svg>
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
    <script>
        const refreshGenderOptions = () => {
            document.querySelectorAll('[data-gender-option]').forEach((option) => {
                const input = option.querySelector('input[type="radio"]');
                const isChecked = input?.checked;

                option.classList.toggle('border-[#0b751f]', isChecked);
                option.classList.toggle('border-transparent', !isChecked);
                option.classList.toggle('bg-white', isChecked);
                option.classList.toggle('bg-[#e5eae7]', !isChecked);
                option.classList.toggle('text-[#0b751f]', isChecked);
            });
        };

        document.querySelectorAll('input[name="jenis_kelamin"]').forEach((input) => {
            input.addEventListener('change', refreshGenderOptions);
        });

        document.querySelectorAll('[data-gender-option]').forEach((option) => {
            option.addEventListener('click', () => {
                const input = option.querySelector('input[type="radio"]');

                if (input) {
                    input.checked = true;
                    input.dispatchEvent(new Event('change', {
                        bubbles: true
                    }));
                }
            });
        });

        refreshGenderOptions();

        document.querySelectorAll('input[type="file"][data-preview-target]').forEach((input) => {
            input.addEventListener('change', () => {
                const file = input.files?.[0];
                const preview = document.getElementById(input.dataset.previewTarget);
                const fileName = document.getElementById(input.dataset.fileNameTarget);
                const overlay = document.querySelector(`[data-preview-overlay="${input.dataset.previewTarget}"]`);

                if (!file || !preview) {
                    return;
                }

                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
                overlay?.classList.remove('bg-transparent');
                overlay?.classList.add('bg-black/35');

                if (fileName) {
                    fileName.textContent = file.name;
                }
            });
        });
    </script>
</body>

</html>
