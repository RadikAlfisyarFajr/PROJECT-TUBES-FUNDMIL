# Aturan Slicing Folder

Dokumen ini menjadi patokan pembagian wilayah kerja agar merge ke branch `develop` lebih minim konflik.

## Pola Folder

Setiap fitur memiliki folder sendiri berdasarkan role di:

- `app/Http/Controllers/{NamaFitur}/`
- `app/Http/Controllers/SuperAdmin/{NamaFitur}/`
- `resources/views/admin/{nama-fitur}/`
- `resources/views/superadmin/{nama-fitur}/`
- `database/seeders/`
- `routes/admin/`
- `routes/superadmin/`

Contoh fitur `Pemasukan`:

- Controller: `app/Http/Controllers/Pemasukan/PemasukanController.php`
- View: `resources/views/admin/pemasukan/pemasukan-index.blade.php`
- Seeder: `database/seeders/PemasukanSeeder.php`
- Route: `routes/admin/pemasukan.php`

## Aturan Penamaan View

Gunakan nama file yang spesifik dengan prefix fitur.

Contoh benar:

- `pemasukan-index.blade.php`
- `pemasukan-create.blade.php`
- `program-penyaluran-edit.blade.php`

Hindari nama generik seperti:

- `index.blade.php`
- `create.blade.php`
- `edit.blade.php`

## Aturan Kerja Tim

- Satu anggota tim fokus di satu folder fitur.
- Jika menambah route fitur, edit file di `routes/features/`, bukan langsung menumpuk semua route di `routes/web.php`.
- Jika menambah data dummy, edit seeder fitur masing-masing.
- Edit `DatabaseSeeder.php` hanya saat mendaftarkan seeder baru.
- Hindari mengubah file dashboard utama saat pekerjaan masih di tahap struktur/backend fitur.

## Daftar Fitur Awal

### Admin Instansi

- `ProfilInstansi`
- `KategoriDana`
- `Pemasukan`
- `Mustahik`
- `ProgramPenyaluran`
- `PengaturanDistribusi`
- `Penyaluran`
- `Laporan`

### Super Admin

- `ApprovalAdminInstansi`
- `Instansi`
- `Pengguna`
- `HargaBeras`
- `Nishab`
- `ApprovalProgramPenyaluran`
- `Monitoring`

## Catatan Relasi Muzakki

Saat ini tidak ada tabel atau model `Muzakki`. Data muzakki disimpan sebagai bagian dari `transaksi_zakat` melalui kolom `nama_muzakki`, sehingga input muzakki dikerjakan di fitur `Pemasukan`, bukan folder fitur terpisah.

## Catatan Approval Program Penyaluran

Database sudah disiapkan untuk skenario approval program penyaluran oleh Super Admin/Camat melalui kolom:

- `approval_status`
- `approved_by`
- `approved_at`
- `approval_note`

Kolom ini masih opsional untuk flow aplikasi. Status operasional program tetap memakai kolom `status` (`draft`, `aktif`, `selesai`), sedangkan status approval memakai `approval_status` (`draft`, `pending`, `approved`, `rejected`).
