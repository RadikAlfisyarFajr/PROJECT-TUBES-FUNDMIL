<div class="distribution-field">
    <label for="jenis_zakat">Jenis Zakat</label>
    <select id="jenis_zakat" name="jenis_zakat" class="distribution-select" required>
        <option value="zakat_maal" {{ old('jenis_zakat', $nishab?->jenis_zakat ?? '') === 'zakat_maal' ? 'selected' : '' }}>Zakat Maal</option>
        <option value="zakat_fitrah" {{ old('jenis_zakat', $nishab?->jenis_zakat ?? '') === 'zakat_fitrah' ? 'selected' : '' }}>Zakat Fitrah</option>
    </select>
</div>

<div class="distribution-field">
    <label for="tanggal_berlaku">Berlaku Mulai Tanggal</label>
    <input id="tanggal_berlaku" type="date" name="tanggal_berlaku" class="distribution-input" value="{{ old('tanggal_berlaku', $nishab?->tanggal_berlaku?->format('Y-m-d') ?? now()->toDateString()) }}" required>
</div>

<div class="distribution-field">
    <label for="tanggal_berakhir">Berlaku Sampai Tanggal</label>
    <input id="tanggal_berakhir" type="date" name="tanggal_berakhir" class="distribution-input" value="{{ old('tanggal_berakhir', $nishab?->tanggal_berakhir?->format('Y-m-d') ?? '') }}">
</div>

<div class="distribution-field">
    <label for="nishab_kg">Nishab Kg</label>
    <input id="nishab_kg" type="number" min="0" step="0.01" name="nishab_kg" class="distribution-input" value="{{ old('nishab_kg', $nishab?->nishab_kg ?? '') }}">
</div>

<div class="distribution-field">
    <label for="nishab_rupiah">Nishab Rupiah</label>
    <input id="nishab_rupiah" type="number" min="0" step="1" name="nishab_rupiah" class="distribution-input" value="{{ old('nishab_rupiah', $nishab?->nishab_rupiah ?? '') }}">
</div>

<div class="distribution-field">
    <label for="tarif_fitrah_kg">Tarif Fitrah Kg</label>
    <input id="tarif_fitrah_kg" type="number" min="0" step="0.01" name="tarif_fitrah_kg" class="distribution-input" value="{{ old('tarif_fitrah_kg', $nishab?->tarif_fitrah_kg ?? '') }}">
</div>

<div class="distribution-field super-span-2">
    <label for="keterangan">Keterangan</label>
    <textarea id="keterangan" name="keterangan" class="distribution-textarea">{{ old('keterangan', $nishab?->keterangan ?? '') }}</textarea>
</div>
