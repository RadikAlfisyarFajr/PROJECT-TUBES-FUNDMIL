<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} - Fundmil Soreang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>
<body class="sidebar-expanded min-h-screen bg-[#f6f8f6] font-sans text-[#122016] antialiased">
<div class="fixed inset-0 z-0 overflow-hidden bg-[#f6f8f6]">
    <div class="flex min-h-screen opacity-80 blur-[3px]">
        @include('admin.partials.sidebar', ['active' => 'program'])
        <main class="flex-1">
            <header class="h-[66px] bg-white"></header>
            <section class="px-6 pt-[38px] lg:px-[44px]">
                <div class="max-w-[980px]">
                    <div class="h-4 w-[150px] rounded-full bg-[#dce7e0]"></div>
                    <div class="mt-5 h-10 w-[420px] max-w-full rounded-full bg-[#dce7e0]"></div>
                    <div class="mt-4 h-5 w-[560px] max-w-full rounded-full bg-[#e5ece8]"></div>
                    <div class="mt-8 grid gap-5 md:grid-cols-3">
                        <div class="h-[190px] rounded-[14px] bg-white shadow-sm ring-1 ring-[#e2e9e5]"></div>
                        <div class="h-[190px] rounded-[14px] bg-white shadow-sm ring-1 ring-[#e2e9e5]"></div>
                        <div class="h-[190px] rounded-[14px] bg-[#0b751f] shadow-sm"></div>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <div class="absolute inset-0 bg-black/30"></div>
</div>

@php
    $selectedAsnaf = old('target_asnaf', $selectedTargetAsnaf ?? array_keys(\App\Models\Mustahik::KATEGORI));
@endphp

<main class="relative z-10 flex min-h-screen items-start justify-center px-3 pb-12 pt-[9px] sm:px-4">
            <form action="{{ $action }}" method="POST" class="w-full max-w-[728px] overflow-hidden rounded-[18px] bg-white shadow-[0_24px_58px_rgba(18,32,22,0.22)]" onsubmit="if (!this.querySelector('[name=&quot;target_asnaf[]&quot;]:checked')) { alert('Pilih minimal satu target asnaf.'); return false; }">
                @csrf
                @if ($method !== 'POST')
                    @method($method)
                @endif

                <input type="hidden" name="status" value="{{ old('status', $program->status ?? 'aktif') }}">
                <input type="hidden" name="tanggal_mulai" value="{{ old('tanggal_mulai', optional($program?->tanggal_mulai ?? now())->format('Y-m-d')) }}">

                <div class="flex min-h-[96px] items-center justify-between border-b border-[#edf1ef] px-[34px] sm:px-[38px]">
                    <h1 class="text-[16px] font-black leading-tight text-[#0b751f]">{{ $title }}</h1>
                    <a href="{{ route('program-penyaluran.index') }}" class="grid h-9 w-9 place-items-center rounded-full text-[26px] font-light leading-none text-[#26312b] transition hover:bg-[#eef4f0]" aria-label="Tutup">&times;</a>
                </div>

                @if ($errors->any())
                    <div class="mx-[33px] mt-5 rounded-[12px] border border-red-200 bg-red-50 px-4 py-3 text-sm font-bold text-red-700">Lengkapi data yang masih belum valid.</div>
                @endif

                <div class="px-[34px] py-[32px] sm:px-[38px]">
                    <section>
                        <h2 class="border-l-[4px] border-[#0b751f] pl-[10px] text-[11px] font-black uppercase tracking-[0.32em] text-[#303b34]">Identitas Program</h2>
                        <div class="mt-[31px] grid gap-[28px] md:grid-cols-2">
                            <label>
                                <span class="text-[9px] font-black uppercase text-[#344038]">Nama Program</span>
                                <input required name="nama_program" value="{{ old('nama_program', $program->nama_program ?? '') }}" class="mt-3 h-[48px] w-full rounded-[9px] border-0 bg-[#e6ebe8] px-4 text-[11px] font-bold outline-none placeholder:text-[#75818b] focus:bg-white focus:ring-2 focus:ring-[#0b751f]" placeholder="Contoh: Soreang Cerdas - Beasiswa SM">
                                @error('nama_program') <span class="mt-2 block text-xs font-bold text-red-600">{{ $message }}</span> @enderror
                            </label>
                            <label>
                                <span class="text-[9px] font-black uppercase text-[#344038]">Kategori Program</span>
                                <select class="mt-3 h-[48px] w-full rounded-[9px] border-0 bg-[#e6ebe8] px-4 text-[11px] font-bold text-[#5f6a63] outline-none focus:bg-white focus:ring-2 focus:ring-[#0b751f]">
                                    <option>Pilih Kategori</option>
                                    <option>Pendidikan</option>
                                    <option>Kesehatan</option>
                                    <option>Ekonomi</option>
                                    <option>Sosial</option>
                                </select>
                            </label>
                        </div>
                    </section>

                    <section class="mt-8">
                        <h2 class="border-l-[4px] border-[#0b751f] pl-[10px] text-[11px] font-black uppercase tracking-[0.32em] text-[#303b34]">Target & Asnaf</h2>
                        <div class="mt-[31px]">
                            <div class="space-y-4">
                                <label>
                                    <span class="text-[9px] font-black uppercase text-[#344038]">Estimasi Target Penerima</span>
                                    <div class="mt-3 flex h-[48px] items-center rounded-[9px] bg-[#e6ebe8]">
                                        <input type="number" min="0" name="target_mustahik" value="{{ old('target_mustahik', $program->target_mustahik ?? 100) }}" class="h-full w-full border-0 bg-transparent px-4 text-[11px] font-bold outline-none ring-0 focus:border-transparent focus:outline-none focus:ring-0">
                                        <span class="pr-4 text-[9px] font-black uppercase text-[#111a14]">Jiwa</span>
                                    </div>
                                </label>

                                <div>
                                    <span class="text-[9px] font-black uppercase text-[#344038]">Target Asnaf Program</span>
                                    <div class="mt-3 flex min-h-[28px] flex-wrap items-center gap-[7px] rounded-[9px] bg-[#e6ebe8] px-3 py-1.5">
                                        @foreach (\App\Models\Mustahik::KATEGORI as $value => $label)
                                            <label class="cursor-pointer">
                                                <input type="checkbox" name="target_asnaf[]" value="{{ $value }}" class="peer sr-only" @checked(in_array($value, $selectedAsnaf, true))>
                                                <span class="inline-flex h-[21px] items-center justify-center rounded-[4px] bg-[#dce4df] px-[9px] text-[7px] font-black uppercase text-[#536058] peer-checked:bg-[#0b751f] peer-checked:text-white">{{ $label }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('target_asnaf') <span class="mt-2 block text-xs font-bold text-red-600">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="mt-8">
                        <h2 class="border-l-[4px] border-[#0b751f] pl-[10px] text-[11px] font-black uppercase tracking-[0.32em] text-[#303b34]">Waktu Program</h2>
                        <div class="mt-[31px] grid gap-[27px] md:grid-cols-1">
                            <label>
                                <span class="text-[9px] font-black uppercase text-[#344038]">Target Tanggal Penyaluran</span>
                                <input required type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', optional($program?->tanggal_selesai ?? null)->format('Y-m-d')) }}" class="mt-3 h-[48px] w-full rounded-[9px] border-0 bg-[#e6ebe8] px-4 text-[11px] font-bold outline-none focus:bg-white focus:ring-2 focus:ring-[#0b751f]">
                                @error('tanggal_selesai') <span class="mt-2 block text-xs font-bold text-red-600">{{ $message }}</span> @enderror
                            </label>
                        </div>
                        <label class="mt-[24px] block">
                            <span class="text-[9px] font-black uppercase text-[#344038]">Deskripsi Singkat Program</span>
                            <textarea name="deskripsi" rows="4" class="mt-3 h-[84px] w-full resize-none rounded-[9px] border-0 bg-[#e6ebe8] px-4 py-3 text-[11px] outline-none placeholder:text-[#75818b] focus:bg-white focus:ring-2 focus:ring-[#0b751f]" placeholder="Jelaskan detail program, tujuan, dan kriteria penerima manfaat...">{{ old('deskripsi', $program->deskripsi ?? '') }}</textarea>
                        </label>
                    </section>
                </div>

                <div class="flex min-h-[80px] flex-col gap-5 border-t border-[#edf1ef] bg-[#f8faf9] px-8 py-4 sm:flex-row sm:items-center sm:justify-end sm:px-[38px]">
                    <div class="flex items-center justify-end gap-[13px]">
                        <a href="{{ route('program-penyaluran.index') }}" class="flex h-[48px] w-[100px] items-center justify-center rounded-[11px] border-2 border-[#0b751f] text-[14px] font-black text-[#0b751f]">Batal</a>
                        <button class="h-[48px] w-[194px] rounded-[11px] bg-[#0b751f] text-[14px] font-black text-white shadow-[0_10px_20px_rgba(8,117,31,0.25)]">{{ $buttonLabel === 'Update' ? 'Update Program' : 'Simpan Program' }}</button>
                    </div>
                </div>
            </form>
</main>
</body>
</html>
