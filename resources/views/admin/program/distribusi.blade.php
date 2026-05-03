<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atur Distribusi - {{ $program->nama_program }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f4f7f5] font-sans text-[#122016]">
<main class="mx-auto max-w-6xl px-6 py-10">
    <a href="{{ route('program-penyaluran.index') }}" class="font-bold text-[#0b751f]">Kembali ke Program</a>
    <div class="mt-6 rounded-2xl bg-white p-8 shadow-sm ring-1 ring-[#e8eeeb]">
        <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
            <div>
                <h1 class="text-3xl font-black">Atur Distribusi</h1>
                <p class="mt-2 text-lg text-[#5a665f]">{{ $program->nama_program }}</p>
            </div>
            <span class="rounded-full bg-[#98f091] px-4 py-2 text-xs font-black uppercase text-[#0b751f]">{{ $program->status }}</span>
        </div>

        <div class="mt-8 grid gap-5 md:grid-cols-3">
            <div class="rounded-xl bg-[#f4f7f5] p-5">
                <p class="text-xs font-black uppercase text-[#7b877e]">Total Dana</p>
                <p class="mt-2 text-2xl font-black">Rp {{ number_format($program->total_dana, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-xl bg-[#f4f7f5] p-5">
                <p class="text-xs font-black uppercase text-[#7b877e]">Target Mustahik</p>
                <p class="mt-2 text-2xl font-black">{{ $program->target_mustahik }} Jiwa</p>
            </div>
            <div class="rounded-xl bg-[#f4f7f5] p-5">
                <p class="text-xs font-black uppercase text-[#7b877e]">Sudah Diatur</p>
                <p class="mt-2 text-2xl font-black">{{ $distribusi->count() }} Data</p>
            </div>
        </div>

        <div class="mt-8 overflow-hidden rounded-xl border border-[#e1e8e4]">
            <table class="w-full min-w-[760px] text-left text-sm">
                <thead class="bg-[#eef2f0] text-xs font-black uppercase tracking-[0.12em]">
                    <tr>
                        <th class="px-5 py-4">Mustahik</th>
                        <th class="px-5 py-4">Jumlah Dana</th>
                        <th class="px-5 py-4">Tanggal</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#edf1ef] bg-white">
                    @forelse ($distribusi as $item)
                        <tr>
                            <td class="px-5 py-4 font-black">{{ $item->mustahik->nama ?? 'Belum dipilih' }}</td>
                            <td class="px-5 py-4">Rp {{ number_format($item->jumlah_dana, 0, ',', '.') }}</td>
                            <td class="px-5 py-4">{{ optional($item->tanggal_distribusi)->format('d M Y') ?: '-' }}</td>
                            <td class="px-5 py-4"><span class="rounded-full bg-[#e1f1e5] px-3 py-1 text-[10px] font-black uppercase text-[#0b751f]">{{ $item->status }}</span></td>
                            <td class="px-5 py-4">{{ $item->catatan ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-[#68756e]">Belum ada distribusi. Data penerima dapat ditambahkan melalui modul distribusi berikutnya.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
</body>
</html>
