<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Mustahik - Fundmil Soreang</title>
    @include('admin.partials.tailwind-assets')
</head>

<body class="min-h-screen bg-[#f6f8f6] font-sans text-[#111813] antialiased">
    <main class="mx-auto max-w-4xl px-6 py-10">
        <a href="{{ route('mustahik.index') }}" class="inline-flex items-center gap-2 text-sm font-black text-[#0b751f]">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 12H5m6-7-7 7 7 7" />
            </svg>
            Kembali ke Daftar
        </a>

        <section class="mt-8 overflow-hidden rounded-[16px] bg-white shadow-sm ring-1 ring-[#e6ece9]">
            <div class="flex flex-col gap-4 border-b border-[#edf1ef] px-8 py-7 md:flex-row md:items-start md:justify-between">
                <div>
                    <h1 class="text-3xl font-black">{{ $mustahik->nama }}</h1>
                    <p class="mt-2 text-[#6c756f]">Detail lengkap data mustahik.</p>
                </div>
                <span class="rounded-full px-4 py-2 text-xs font-black uppercase {{ $mustahik->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-700' }}">
                    {{ $mustahik->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                </span>
            </div>
            <div class="grid gap-5 p-8 md:grid-cols-2">
                <div>
                    <p class="text-xs font-black uppercase tracking-[.14em] text-[#6c756f]">Nama</p>
                    <p class="mt-2 rounded-[10px] bg-[#eef2f0] px-4 py-3 font-bold">{{ $mustahik->nama }}</p>
                </div>
                <div>
                    <p class="text-xs font-black uppercase tracking-[.14em] text-[#6c756f]">Kategori</p>
                    <p class="mt-2 rounded-[10px] bg-[#eef2f0] px-4 py-3 font-bold">{{ $mustahik->kategori_label }}</p>
                </div>
                <div>
                    <p class="text-xs font-black uppercase tracking-[.14em] text-[#6c756f]">Jenis Kelamin</p>
                    <p class="mt-2 rounded-[10px] bg-[#eef2f0] px-4 py-3 font-bold">
                        {{ $mustahik->jenis_kelamin === 'laki_laki' ? 'Laki-laki' : ($mustahik->jenis_kelamin === 'perempuan' ? 'Perempuan' : '-') }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-black uppercase tracking-[.14em] text-[#6c756f]">Kontak</p>
                    <p class="mt-2 rounded-[10px] bg-[#eef2f0] px-4 py-3 font-bold">{{ $mustahik->kontak ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-black uppercase tracking-[.14em] text-[#6c756f]">Tanggal Dibuat</p>
                    <p class="mt-2 rounded-[10px] bg-[#eef2f0] px-4 py-3 font-bold">{{ optional($mustahik->created_at)->format('d M Y H:i') }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-xs font-black uppercase tracking-[.14em] text-[#6c756f]">Alamat</p>
                    <p class="mt-2 min-h-[80px] rounded-[10px] bg-[#eef2f0] px-4 py-3 font-bold leading-7">{{ $mustahik->alamat }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-xs font-black uppercase tracking-[.14em] text-[#6c756f]">Keterangan</p>
                    <p class="mt-2 min-h-[80px] rounded-[10px] bg-[#eef2f0] px-4 py-3 leading-7">{{ $mustahik->keterangan ?: '-' }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-xs font-black uppercase tracking-[.14em] text-[#6c756f]">Foto Dokumen</p>
                    <div class="mt-2 grid gap-4 md:grid-cols-2">
                        <div class="overflow-hidden rounded-[12px] bg-[#eef2f0]">
                            <div class="border-b border-[#dde7e1] px-4 py-3 text-xs font-black uppercase tracking-[.14em] text-[#6c756f]">KTP</div>
                            @if ($mustahik->foto_ktp)
                                <a href="{{ asset('storage/'.$mustahik->foto_ktp) }}" target="_blank" class="block">
                                    <img src="{{ asset('storage/'.$mustahik->foto_ktp) }}" alt="Foto KTP {{ $mustahik->nama }}" class="h-56 w-full object-cover">
                                </a>
                            @else
                                <div class="grid h-56 place-items-center px-4 text-sm font-bold text-[#6c756f]">Belum ada foto KTP.</div>
                            @endif
                        </div>
                        <div class="overflow-hidden rounded-[12px] bg-[#eef2f0]">
                            <div class="border-b border-[#dde7e1] px-4 py-3 text-xs font-black uppercase tracking-[.14em] text-[#6c756f]">KK</div>
                            @if ($mustahik->foto_kk)
                                <a href="{{ asset('storage/'.$mustahik->foto_kk) }}" target="_blank" class="block">
                                    <img src="{{ asset('storage/'.$mustahik->foto_kk) }}" alt="Foto KK {{ $mustahik->nama }}" class="h-56 w-full object-cover">
                                </a>
                            @else
                                <div class="grid h-56 place-items-center px-4 text-sm font-bold text-[#6c756f]">Belum ada foto KK.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-3 border-t border-[#edf1ef] px-8 py-6">
                <a href="{{ route('mustahik.index') }}" class="inline-flex h-11 items-center rounded-[10px] bg-gray-200 px-5 text-sm font-black text-gray-800">Kembali ke Daftar</a>
                <a href="{{ route('mustahik.edit', $mustahik) }}" class="inline-flex h-11 items-center rounded-[10px] bg-[#0b751f] px-5 text-sm font-black text-white">Edit</a>
            </div>
        </section>
    </main>
</body>

</html>
