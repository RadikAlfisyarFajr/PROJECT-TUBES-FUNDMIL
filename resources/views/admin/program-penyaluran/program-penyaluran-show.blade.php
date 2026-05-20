@include('admin.partials.simple-page', [
'title' => 'Detail Program Penyaluran',
'description' => 'Lihat detail program penyaluran, termasuk data kategori dana yang terkait.',
'active' => 'program',
'backRoute' => 'program-penyaluran.index',
])

{{--
Pastikan controller mengirim:
- $program
- $kategoriDana (collection)
--}}

<section class="px-6 pb-12 pt-[10px] lg:px-[56px]">
    <div class="max-w-[1040px] rounded-[15px] bg-white px-[44px] py-[42px] shadow-sm ring-1 ring-[#e6ece9]">
        <div class="flex items-start justify-between gap-6">
            <div>
                <h2 class="text-[26px] font-black leading-tight">{{ $program->nama_program }}</h2>
                <p class="mt-[8px] text-[#758078]">{{ $program->deskripsi ?: 'Tidak ada deskripsi.' }}</p>
            </div>
            <div class="shrink-0">
                <span class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-[11px] font-black uppercase {{ $program->status === 'selesai' ? 'bg-gray-100 text-gray-700' : 'bg-[#98f091] text-[#0b751f]' }}">
                    <span class="h-2 w-2 rounded-full {{ $program->status === 'selesai' ? 'bg-gray-500' : 'bg-[#0b751f]' }}"></span>
                    {{ $program->status === 'selesai' ? 'Selesai' : 'Aktif' }}
                </span>
            </div>
        </div>

        <div class="mt-[28px] grid gap-6 md:grid-cols-2">
            <div>
                <p class="text-[11px] font-black uppercase tracking-[.14em] text-[#6a756f]">Tanggal Mulai</p>
                <p class="mt-[8px] text-[15px] font-black">{{ optional($program->tanggal_mulai)->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="text-[11px] font-black uppercase tracking-[.14em] text-[#6a756f]">Tanggal Selesai</p>
                <p class="mt-[8px] text-[15px] font-black">{{ optional($program->tanggal_selesai)->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="text-[11px] font-black uppercase tracking-[.14em] text-[#6a756f]">Total Dana</p>
                <p class="mt-[8px] text-[15px] font-black">Rp {{ number_format($program->total_dana ?: 0, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-[11px] font-black uppercase tracking-[.14em] text-[#6a756f]">Target Mustahik</p>
                <p class="mt-[8px] text-[15px] font-black">{{ $program->target_mustahik ?: 0 }}</p>
            </div>
        </div>

        <div class="mt-[28px]">
            <h3 class="text-[18px] font-black">Target Asnaf</h3>
            <div class="mt-[12px] flex flex-wrap gap-3">
                @forelse(collect($program->target_asnaf ?? [])->filter() as $asnaf)
                    <span class="rounded-full bg-[#edf1ee] px-[12px] py-[6px] text-[11px] font-black uppercase text-[#7d8880]">
                        {{ \App\Models\Mustahik::KATEGORI[$asnaf] ?? str($asnaf)->replace('_', ' ')->title() }}
                    </span>
                @empty
                    <span class="text-[#6c756f]">Belum ada target asnaf.</span>
                @endforelse
            </div>
        </div>

        <div class="mt-[42px] flex items-center justify-end gap-8 border-t border-[#e7eeea] pt-[32px]">
            <a href="{{ route('program-penyaluran.index') }}" class="text-sm font-black text-[#6c756f]">Kembali</a>
            <a href="{{ route('program-penyaluran.edit', $program) }}" class="h-[52px] rounded-[11px] bg-[#0b751f] px-8 text-sm font-black text-white shadow-[0_10px_20px_rgba(8,117,31,0.24)] inline-flex items-center justify-center">
                Edit Program
            </a>
        </div>
    </div>
</section>
