<div class="distribution-field">
    <label for="harga_per_kg">Harga per Kg</label>
    <input id="harga_per_kg" type="number" min="1000" step="1" name="harga_per_kg" class="distribution-input" value="{{ old('harga_per_kg', $hargaBeras?->harga_per_kg ?? '') }}" required>
</div>

<div class="distribution-field">
    <label for="tanggal_berlaku">Berlaku Mulai Tanggal</label>
    <input id="tanggal_berlaku" type="date" name="tanggal_berlaku" class="distribution-input" value="{{ old('tanggal_berlaku', $hargaBeras?->tanggal_berlaku?->format('Y-m-d') ?? now()->toDateString()) }}" required>
</div>

<div class="distribution-field">
    <label for="tanggal_berakhir">Berlaku Sampai Tanggal</label>
    <input id="tanggal_berakhir" type="date" name="tanggal_berakhir" class="distribution-input" value="{{ old('tanggal_berakhir', $hargaBeras?->tanggal_berakhir?->format('Y-m-d') ?? '') }}">
</div>

<div class="distribution-field super-span-2">
    <label for="keterangan">Keterangan</label>
    <textarea id="keterangan" name="keterangan" class="distribution-textarea" placeholder="Contoh: Rata-rata harga beras medium pasar Soreang">{{ old('keterangan', $hargaBeras?->keterangan ?? '') }}</textarea>
</div>
