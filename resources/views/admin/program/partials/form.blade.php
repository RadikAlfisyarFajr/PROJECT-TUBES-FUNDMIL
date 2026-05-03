<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} - Fundmil Soreang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#1e241f]/45 font-sans text-[#122016] antialiased">
<div class="fixed inset-0 -z-10 bg-[#f4f7f5] blur-[2px]">
    <div class="ml-[254px] h-16 bg-white"></div>
</div>
<main class="flex min-h-screen items-center justify-center px-5 py-10">
    <form action="{{ $action }}" method="POST" class="w-full max-w-[670px] overflow-hidden rounded-[22px] bg-white shadow-2xl" onsubmit="if (!this.querySelector('[name=&quot;kategori_dana_ids[]&quot;]:checked')) { alert('Pilih minimal satu jenis dana.'); return false; }">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif
        <div class="flex items-center justify-between border-b border-[#edf1ef] px-8 py-8">
            <h1 class="text-xl font-black text-[#0b751f]">{{ $title }}</h1>
            <a href="{{ route('program-penyaluran.index') }}" class="text-3xl leading-none text-[#1d2b22]">&times;</a>
        </div>

        @if ($errors->any())
            <div class="mx-8 mt-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-bold text-red-700">Lengkapi data yang masih belum valid.</div>
        @endif

        <div class="space-y-8 px-8 py-8">
            <section>
                <h2 class="border-l-4 border-[#0b751f] pl-3 text-sm font-black uppercase tracking-[0.25em]">Identitas Program</h2>
                <div class="mt-6 grid gap-7 md:grid-cols-2">
                    <label>
                        <span class="text-xs font-black uppercase text-[#364238]">Nama Program</span>
                        <input required name="nama_program" value="{{ old('nama_program', $program->nama_program ?? '') }}" class="mt-3 h-12 w-full rounded-xl border-0 bg-[#e8edeb] px-4 text-sm outline-none ring-1 ring-transparent placeholder:text-[#73818a] focus:bg-white focus:ring-[#0b751f]" placeholder="Contoh: Soreang Cerdas - Beasiswa SMP">
                        @error('nama_program') <span class="mt-2 block text-xs font-bold text-red-600">{{ $message }}</span> @enderror
                    </label>
                    <label>
                        <span class="text-xs font-black uppercase text-[#364238]">Status Program</span>
                        <select required name="status" class="mt-3 h-12 w-full rounded-xl border-0 bg-[#e8edeb] px-4 text-sm outline-none focus:bg-white focus:ring-[#0b751f]">
                            @foreach (['aktif' => 'Aktif', 'draft' => 'Draft', 'selesai' => 'Selesai'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('status', $program->status ?? 'aktif') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
            </section>

            <section>
                <h2 class="border-l-4 border-[#0b751f] pl-3 text-sm font-black uppercase tracking-[0.25em]">Target & Asnaf</h2>
                <div class="mt-6 grid gap-7 md:grid-cols-2">
                    <div>
                        <span class="text-xs font-black uppercase text-[#364238]">Jenis Dana</span>
                        <div class="mt-3 flex min-h-12 flex-wrap items-center gap-2 rounded-xl bg-[#e8edeb] px-3 py-2">
                            @foreach ($kategoriDana as $kategori)
                                <label class="cursor-pointer">
                                    <input type="checkbox" name="kategori_dana_ids[]" value="{{ $kategori->id }}" class="peer sr-only" @checked(in_array($kategori->id, $selectedKategori))>
                                    <span class="inline-flex rounded bg-[#dce4df] px-3 py-2 text-[11px] font-black uppercase text-[#536058] peer-checked:bg-[#0b751f] peer-checked:text-white">{{ $kategori->nama }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('kategori_dana_ids') <span class="mt-2 block text-xs font-bold text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <label>
                        <span class="text-xs font-black uppercase text-[#364238]">Estimasi Target Penerima</span>
                        <div class="mt-3 flex h-12 items-center rounded-xl bg-[#e8edeb]">
                            <input required type="number" min="1" name="target_mustahik" value="{{ old('target_mustahik', $program->target_mustahik ?? 100) }}" class="h-full w-full bg-transparent px-4 text-sm outline-none">
                            <span class="pr-4 text-xs font-black uppercase">Jiwa</span>
                        </div>
                    </label>
                </div>
            </section>

            <section>
                <h2 class="border-l-4 border-[#0b751f] pl-3 text-sm font-black uppercase tracking-[0.25em]">Anggaran & Waktu</h2>
                <div class="mt-6 grid gap-7 md:grid-cols-2">
                    <label>
                        <span class="text-xs font-black uppercase text-[#364238]">Alokasi Anggaran</span>
                        <div class="mt-3 flex h-12 items-center rounded-xl bg-[#e8edeb]">
                            <span class="pl-4 text-sm font-black text-[#0b751f]">Rp</span>
                            <input required type="number" min="0" step="1000" name="total_dana" x-model="dana" value="{{ old('total_dana', $program->total_dana ?? 0) }}" class="h-full w-full bg-transparent px-4 text-sm outline-none">
                        </div>
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <label>
                            <span class="text-xs font-black uppercase text-[#364238]">Tanggal Mulai</span>
                            <input required type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', optional($program?->tanggal_mulai ?? null)->format('Y-m-d')) }}" class="mt-3 h-12 w-full rounded-xl border-0 bg-[#e8edeb] px-4 text-sm outline-none focus:bg-white focus:ring-[#0b751f]">
                        </label>
                        <label>
                            <span class="text-xs font-black uppercase text-[#364238]">Tanggal Selesai</span>
                            <input required type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', optional($program?->tanggal_selesai ?? null)->format('Y-m-d')) }}" class="mt-3 h-12 w-full rounded-xl border-0 bg-[#e8edeb] px-4 text-sm outline-none focus:bg-white focus:ring-[#0b751f]">
                        </label>
                    </div>
                </div>
                <label class="mt-7 block">
                    <span class="text-xs font-black uppercase text-[#364238]">Deskripsi Singkat Program</span>
                    <textarea name="deskripsi" rows="4" class="mt-3 w-full rounded-xl border-0 bg-[#e8edeb] px-4 py-4 text-sm outline-none placeholder:text-[#73818a] focus:bg-white focus:ring-[#0b751f]" placeholder="Jelaskan detail program, tujuan, dan kriteria penerima manfaat...">{{ old('deskripsi', $program->deskripsi ?? '') }}</textarea>
                </label>
            </section>
        </div>

        <div class="flex flex-col gap-5 border-t border-[#edf1ef] bg-[#f8faf9] px-8 py-7 sm:flex-row sm:items-center sm:justify-between">
            <div class="text-[10px] font-black uppercase text-[#77827b]">
                <p>Saldo Tersedia</p>
                <p class="mt-1 text-[#0b751f]">Rp {{ number_format($saldoTersedia, 0, ',', '.') }}</p>
            </div>
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('program-penyaluran.index') }}" class="flex h-12 w-28 items-center justify-center rounded-xl border-2 border-[#0b751f] font-black text-[#0b751f]">Kembali</a>
                <button class="h-12 rounded-xl bg-[#0b751f] px-8 font-black text-white shadow-[0_10px_20px_rgba(8,117,31,0.25)]">Simpan Program</button>
            </div>
        </div>
    </form>
</main>
</body>
</html>
