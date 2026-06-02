# TODO Images Patch

## Progress

- [x] Remove kalimat “Upload foto KTP dan KK tidak diperlukan.” dari form mustahik.
- [x] Identify lokasi gambar upload/tampilan:
    - Avatar navbar: resources/views/admin/partials/account-identity.blade.php
    - Logo & tanda tangan: resources/views/admin/profil-instansi/profil-instansi-index.blade.php

## Storage/link status

- public/storage: ada

## Next steps

- [ ] Terapkan override CSS minimal untuk gambar yang berpotensi terpotong:
    - `.signature-img`
    - `.preview-img`
    - `.admin-avatar img` (display:block)
- [ ] (Opsional/aman) tambah fallback placeholder untuk jika file tidak ditemukan.
- [ ] Jalankan verifikasi manual:
    - Refresh browser
    - Cek avatar navbar
    - Cek tanda tangan profil instansi
    - Cek preview upload pada form edit/create
