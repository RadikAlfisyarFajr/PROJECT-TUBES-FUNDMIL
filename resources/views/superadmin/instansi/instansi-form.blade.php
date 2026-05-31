@php
    $isEdit = isset($instansi) && $instansi;
@endphp

<div class="distribution-field">
    <label for="desa">Desa</label>
    <select id="desa" name="desa" class="distribution-select" required>
        <option value="" disabled {{ old('desa', $instansi?->kelurahan ?? '') === '' ? 'selected' : '' }}>Pilih Desa</option>
        @foreach($desaOptions as $desa)
            <option value="{{ $desa }}" {{ old('desa', $instansi?->kelurahan ?? '') === $desa ? 'selected' : '' }}>{{ $desa }}</option>
        @endforeach
    </select>
</div>

<div class="distribution-field">
    <label for="nama">Nama Akun Desa</label>
    <input id="nama" name="nama" class="distribution-input" value="{{ old('nama', $instansi?->nama ?? '') }}" required placeholder="Contoh: Pemerintah Desa Soreang">
</div>

<div class="distribution-field">
    <label for="nama_pimpinan">Nama Admin Kepala Desa</label>
    <input id="nama_pimpinan" name="nama_pimpinan" class="distribution-input" value="{{ old('nama_pimpinan', $instansi?->nama_pimpinan ?? $admin?->name ?? '') }}" required>
</div>

<div class="distribution-field">
    <label for="email">Email Admin</label>
    <input id="email" type="email" name="email" class="distribution-input" value="{{ old('email', $admin?->email ?? $instansi?->email ?? '') }}" required>
</div>

<div class="distribution-field">
    <label for="username">Username</label>
    <input id="username" name="username" class="distribution-input" value="{{ old('username', $admin?->username ?? '') }}" required>
</div>

<div class="distribution-field">
    <label for="kontak">Kontak</label>
    <input id="kontak" name="kontak" class="distribution-input" value="{{ old('kontak', $instansi?->kontak ?? '') }}">
</div>

<div class="distribution-field super-span-2">
    <label for="alamat">Alamat</label>
    <textarea id="alamat" name="alamat" class="distribution-textarea">{{ old('alamat', $instansi?->alamat ?? '') }}</textarea>
</div>

<div class="distribution-field">
    <label for="password">{{ $isEdit ? 'Password Baru' : 'Password' }}</label>
    <div class="password-input-wrap">
        <input id="password" type="password" name="password" class="distribution-input" {{ $isEdit ? '' : 'required' }} placeholder="{{ $isEdit ? 'Kosongkan jika tidak diganti' : 'Minimal 8 karakter' }}" autocomplete="new-password">
        <button class="password-toggle-btn" type="button" data-password-toggle="password" aria-label="Tampilkan password">
            <i class="bi bi-eye-fill"></i>
        </button>
    </div>
</div>

<div class="distribution-field">
    <label for="password_confirmation">Konfirmasi Password</label>
    <div class="password-input-wrap">
        <input id="password_confirmation" type="password" name="password_confirmation" class="distribution-input" {{ $isEdit ? '' : 'required' }} autocomplete="new-password">
        <button class="password-toggle-btn" type="button" data-password-toggle="password_confirmation" aria-label="Tampilkan konfirmasi password">
            <i class="bi bi-eye-fill"></i>
        </button>
    </div>
</div>

@once
    <script>
        document.querySelectorAll('[data-password-toggle]').forEach((button) => {
            button.addEventListener('click', () => {
                const input = document.getElementById(button.dataset.passwordToggle);
                const icon = button.querySelector('i');

                if (! input) {
                    return;
                }

                const isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';
                button.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
                icon?.classList.toggle('bi-eye-fill', ! isHidden);
                icon?.classList.toggle('bi-eye-slash-fill', isHidden);
            });
        });
    </script>
@endonce
