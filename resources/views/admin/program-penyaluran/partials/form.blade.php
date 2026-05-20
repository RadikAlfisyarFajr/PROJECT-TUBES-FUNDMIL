<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} - Fundmil Soreang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="sidebar-expanded min-h-screen bg-[#9b9f9b] font-sans text-[#122016] antialiased">
<div class="fixed inset-0 -z-10 overflow-hidden bg-[#f6f8f6]">
    <div class="flex min-h-screen blur-[4px]">
        @include('admin.partials.sidebar', ['active' => 'program'])
        <main class="flex-1">
            <div class="h-[64px] bg-white"></div>
            <div class="px-[34px] pt-[35px]">
                <div class="h-[72px] w-[267px] rounded-[15px] bg-[#0b751f]"></div>
            </div>
        </main>
    </div>
    <div class="absolute inset-0 bg-black/35"></div>
</div>

<main class="flex min-h-screen items-center justify-center px-5 py-10">
    <form action="{{ $action }}" method="POST" class="w-full max-w-[670px] overflow-hidden rounded-[22px] bg-white shadow-2xl" onsubmit="if (!this.querySelector('[name=&quot;kategori_dana_ids[]&quot;]:checked')) { alert('Pilih minimal satu jenis dana.'); return false; }">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif

        <input type="hidden" name="status" value="{{ old('status', $program->status ?? 'aktif') }}">
        <input type="hidden" name="tanggal_mulai" value="{{ old('tanggal_mulai', optional($program?->tanggal_mulai ?? now())->format('Y-m-d')) }}">

        <div class="flex h-[95px] items-center justify-between border-b border-[#edf1ef] px-[33px]">
            <h1 class="text-[20px] font-black text-[#0b751f]">{{ $title }}</h1>
            <a href="{{ route('program-penyaluran.index') }}" class="text-[34px] font-light leading-none text-[#17231b]">&times;</a>
        </div>

        @if ($errors->any())
            <div class="mx-[33px] mt-5 rounded-[12px] border border-red-200 bg-red-50 px-4 py-3 text-sm font-bold text-red-700">Lengkapi data yang masih belum valid.</div>
        @endif

        <div class="px-[33px] py-[30px]">
            <section>
                <h2 class="border-l-4 border-[#0b751f] pl-[10px] text-[13px] font-black uppercase tracking-[0.23em] text-[#303b34]">Identitas Program</h2>
                <div class="mt-[24px] grid gap-[27px] md:grid-cols-2">
                    <label>
                        <span class="text-[11px] font-black uppercase text-[#344038]">Nama Program</span>
                        <input required name="nama_program" value="{{ old('nama_program', $program->nama_program ?? '') }}" class="mt-[11px] h-[44px] w-full rounded-[11px] border-0 bg-[#e6ebe8] px-[17px] text-[14px] outline-none placeholder:text-[#75818b] focus:bg-white focus:ring-2 focus:ring-[#0b751f]" placeholder="Contoh: Soreang Cerdas - Beasiswa SM">
                        @error('nama_program') <span class="mt-2 block text-xs font-bold text-red-600">{{ $message }}</span> @enderror
                    </label>
                    <label>
                        <span class="text-[11px] font-black uppercase text-[#344038]">Kategori Program</span>
                        <select class="mt-[11px] h-[44px] w-full rounded-[11px] border-0 bg-[#e6ebe8] px-[17px] text-[14px] outline-none focus:bg-white focus:ring-2 focus:ring-[#0b751f]">
                            <option>Pilih Kategori</option>
                            <option>Pendidikan</option>
                            <option>Kesehatan</option>
                            <option>Ekonomi</option>
                            <option>Sosial</option>
                        </select>
                    </label>
                </div>
            </section>

            <section class="mt-[30px]">
                <h2 class="border-l-4 border-[#0b751f] pl-[10px] text-[13px] font-black uppercase tracking-[0.23em] text-[#303b34]">Target & Asnaf</h2>
                <div class="mt-[24px] grid gap-[27px] md:grid-cols-2">
                    <div>
                        <span class="text-[11px] font-black uppercase text-[#344038]">Target Asnaf</span>
                        <div class="mt-[11px] flex h-[44px] items-center gap-[8px] rounded-[11px] bg-[#e6ebe8] px-[15px]">
                            @foreach ($kategoriDana->take(2) as $kategori)
                                <label class="cursor-pointer">
                                    <input type="checkbox" name="kategori_dana_ids[]" value="{{ $kategori->id }}" class="peer sr-only" @checked(in_array($kategori->id, old('kategori_dana_ids', $selectedKategori ?? [])))>
                                    <span class="inline-flex h-[22px] min-w-[62px] items-center justify-center rounded-[4px] bg-[#dce4df] px-2 text-[9px] font-black uppercase text-[#536058] peer-checked:bg-[#0b751f] peer-checked:text-white">{{ $kategori->nama }}</span>
                                </label>
                            @endforeach
                            @foreach ($kategoriDana->skip(2) as $kategori)
                                <label class="hidden cursor-pointer">
                                    <input type="checkbox" name="kategori_dana_ids[]" value="{{ $kategori->id }}" @checked(in_array($kategori->id, old('kategori_dana_ids', $selectedKategori ?? [])))>
                                </label>
                            @endforeach
                            <span class="ml-auto text-[14px] text-[#7b8580]">Pilih asnaf...</span>
                            <span class="flex h-[22px] w-[22px] items-center justify-center rounded-full bg-[#334238] text-[18px] font-black text-white">+</span>
                        </div>
                        @error('kategori_dana_ids') <span class="mt-2 block text-xs font-bold text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <label>
                        <span class="text-[11px] font-black uppercase text-[#344038]">Estimasi Target Penerima</span>
                        <div class="mt-[11px] flex h-[44px] items-center rounded-[11px] bg-[#e6ebe8]">
                            <input type="number" min="0" name="target_mustahik" value="{{ old('target_mustahik', $program->target_mustahik ?? 100) }}" class="h-full w-full bg-transparent px-[17px] text-[14px] outline-none">
                            <span class="pr-[17px] text-[11px] font-black uppercase">Jiwa</span>
                        </div>
                    </label>
                </div>
            </section>

            <section class="mt-[30px]">
                <h2 class="border-l-4 border-[#0b751f] pl-[10px] text-[13px] font-black uppercase tracking-[0.23em] text-[#303b34]">Anggaran & Waktu</h2>
                <div class="mt-[24px] grid gap-[27px] md:grid-cols-2">
                    <label>
                        <span class="text-[11px] font-black uppercase text-[#344038]">Alokasi Anggaran</span>
                        <div class="mt-[11px] flex h-[44px] items-center rounded-[11px] bg-[#e6ebe8]">
                            <span class="pl-[17px] text-[14px] font-black text-[#0b751f]">Rp</span>
                            <input type="number" min="0" step="1000" name="total_dana" value="{{ old('total_dana', $program->total_dana ?? 0) }}" class="h-full w-full bg-transparent px-[17px] text-[14px] outline-none">
                        </div>
                    </label>
                    <label>
                        <span class="text-[11px] font-black uppercase text-[#344038]">Target Tanggal Penyaluran</span>
                        <input required type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', optional($program?->tanggal_selesai ?? null)->format('Y-m-d')) }}" class="mt-[11px] h-[44px] w-full rounded-[11px] border-0 bg-[#e6ebe8] px-[17px] text-[14px] outline-none focus:bg-white focus:ring-2 focus:ring-[#0b751f]">
                        @error('tanggal_selesai') <span class="mt-2 block text-xs font-bold text-red-600">{{ $message }}</span> @enderror
                    </label>
                </div>
                <label class="mt-[24px] block">
                    <span class="text-[11px] font-black uppercase text-[#344038]">Deskripsi Singkat Program</span>
                    <textarea name="deskripsi" rows="4" class="mt-[11px] h-[84px] w-full resize-none rounded-[11px] border-0 bg-[#e6ebe8] px-[17px] py-[15px] text-[14px] outline-none placeholder:text-[#75818b] focus:bg-white focus:ring-2 focus:ring-[#0b751f]" placeholder="Jelaskan detail program, tujuan, dan kriteria penerima manfaat...">{{ old('deskripsi', $program->deskripsi ?? '') }}</textarea>
                </label>
            </section>
        </div>

        <div class="flex min-h-[96px] flex-col gap-5 border-t border-[#edf1ef] bg-[#f8faf9] px-[33px] py-[25px] sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-[10px] text-[9px] font-black uppercase text-[#77827b]">
                <svg class="h-5 w-5 text-[#0b751f]" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2 2 7h16l-8-5ZM4 8h2v6H4V8Zm5 0h2v6H9V8Zm5 0h2v6h-2V8ZM3 15h14v2H3v-2Z"/></svg>
                <div>
                    <p>Saldo Tersedia</p>
                    <p class="mt-[2px] text-[#0b751f]">Rp {{ number_format($saldoTersedia ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="flex items-center justify-end gap-[13px]">
                <a href="{{ route('program-penyaluran.index') }}" class="flex h-[48px] w-[100px] items-center justify-center rounded-[11px] border-2 border-[#0b751f] text-[14px] font-black text-[#0b751f]">Batal</a>
                <button class="h-[48px] w-[194px] rounded-[11px] bg-[#0b751f] text-[14px] font-black text-white shadow-[0_10px_20px_rgba(8,117,31,0.25)]">{{ $buttonLabel === 'Update' ? 'Update Program' : 'Simpan Program' }}</button>
            </div>
        </div>
    </form>
</main>
</body>
</html>
