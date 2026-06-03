# 📊 KAMUS DATA - SISTEM MANAJEMEN DANA ZAKAT (FUNDMIL)

**Tanggal**: 1 Juni 2026  
**Versi**: 1.0

---

## 📑 DAFTAR ISI

1. [Struktur Database](#struktur-database)
2. [Tabel-Tabel Sistem](#tabel-tabel-sistem)
3. [Relasi Antar Tabel](#relasi-antar-tabel)
4. [Enum dan Nilai-Nilai Khusus](#enum-dan-nilai-nilai-khusus)

---

## 🗄️ Struktur Database

Sistem ini menggunakan **19 tabel** yang terbagi menjadi 3 kategori:

1. **Tabel Sistem**: Cache, Jobs, Sessions (sistem Laravel)
2. **Tabel Master Data**: Instansi, Harga Beras, Nishab, Kategori Dana, Users, Rekening Instansi
3. **Tabel Transaksi**: Mustahik, Transaksi Zakat, Program Penyaluran, Penyaluran, Penyaluran Detail, Profil Instansi Notifications

---

## 📋 TABEL-TABEL SISTEM

### 1. 🏢 **INSTANSI**
Menyimpan informasi lembaga/organisasi yang mengelola dana zakat.

| No | Kolom | Tipe Data | Null | Default | Keterangan |
|----|-------|-----------|------|---------|------------|
| 1 | `id` | BIGINT | NO | - | Primary Key |
| 2 | `nama` | VARCHAR(255) | NO | - | Nama lembaga/instansi |
| 3 | `tipe` | VARCHAR(255) | YES | - | Tipe instansi (BAZ, LAZ, dll) |
| 4 | `kelurahan` | VARCHAR(255) | YES | - | Kelurahan lokasi |
| 5 | `alamat` | TEXT | YES | - | Alamat lengkap |
| 6 | `status` | ENUM | NO | pending | Status: pending, aktif, nonaktif |
| 7 | `kontak` | VARCHAR(255) | YES | - | No. telepon/kontak |
| 8 | `email` | VARCHAR(255) | YES | - | Email instansi |
| 9 | `logo` | VARCHAR(255) | YES | - | Path file logo |
| 10 | `nomor_sk` | VARCHAR(255) | YES | - | Nomor Surat Keputusan |
| 11 | `masa_berlaku` | DATE | YES | - | Tanggal berakhir SK |
| 12 | `nama_pimpinan` | VARCHAR(255) | YES | - | Nama pimpinan instansi |
| 13 | `tanda_tangan` | VARCHAR(255) | YES | - | Path file tanda tangan pimpinan |
| 14 | `latitude` | DECIMAL(10,8) | YES | - | Koordinat lintang |
| 15 | `longitude` | DECIMAL(11,8) | YES | - | Koordinat bujur |
| 16 | `created_at` | TIMESTAMP | YES | - | Waktu pembuatan record |
| 17 | `updated_at` | TIMESTAMP | YES | - | Waktu update terakhir |

**Relasi**:
- One-to-Many: Users, Mustahik, Kategori Dana, Transaksi Zakat, Program Penyaluran, Penyaluran, Rekening Instansi, Profil Instansi Notifications

---

### 2. 👥 **USERS**
Menyimpan data pengguna sistem dengan role berbeda.

| No | Kolom | Tipe Data | Null | Default | Keterangan |
|----|-------|-----------|------|---------|------------|
| 1 | `id` | BIGINT | NO | - | Primary Key |
| 2 | `name` | VARCHAR(255) | NO | - | Nama lengkap user |
| 3 | `nama_instansi` | VARCHAR(255) | YES | - | Nama instansi (optional) |
| 4 | `desa` | VARCHAR(255) | YES | - | Nama desa/kelurahan |
| 5 | `email` | VARCHAR(255) | NO | - | Email (UNIQUE) |
| 6 | `username` | VARCHAR(255) | NO | - | Username login (UNIQUE) |
| 7 | `email_verified_at` | TIMESTAMP | YES | - | Waktu verifikasi email |
| 8 | `password` | VARCHAR(255) | NO | - | Password (hashed) |
| 9 | `instansi_id` | BIGINT | YES | - | FK ke instansi (UNIQUE untuk admin/petugas) |
| 10 | `role` | ENUM | NO | - | super_admin atau admin_instansi |
| 11 | `status` | ENUM | NO | pending | pending, active, blocked |
| 12 | `remember_token` | VARCHAR(100) | YES | - | Token untuk remember me |
| 13 | `created_at` | TIMESTAMP | YES | - | Waktu pembuatan record |
| 14 | `updated_at` | TIMESTAMP | YES | - | Waktu update terakhir |

**Constraint**:
- `email` UNIQUE
- `username` UNIQUE
- `instansi_id` UNIQUE (hanya 1 admin per instansi)
- FK `instansi_id` → instansi.id (SET NULL on delete)

**Relasi**:
- Many-to-One: Instansi
- One-to-Many: Program Penyaluran (approved_by)

---

### 3. 👨‍👩‍👧‍👦 **MUSTAHIK**
Menyimpan data penerima zakat (fakir miskin, dll).

| No | Kolom | Tipe Data | Null | Default | Keterangan |
|----|-------|-----------|------|---------|------------|
| 1 | `id` | BIGINT | NO | - | Primary Key |
| 2 | `instansi_id` | BIGINT | NO | - | FK ke instansi |
| 3 | `nama` | VARCHAR(255) | NO | - | Nama mustahik |
| 4 | `nik` | VARCHAR(16) | YES | - | Nomor Induk Kependudukan |
| 5 | `alamat` | TEXT | YES | - | Alamat lengkap |
| 6 | `kategori_asnaf` | VARCHAR(255) | NO | - | Kategori: fakir, miskin, amil, muallaf, riqab, gharimin, fisabilillah, ibnu sabil |
| 7 | `status` | ENUM | NO | pending | pending, verified, rejected |
| 8 | `tanggal_verifikasi` | TIMESTAMP | YES | - | Waktu verifikasi |
| 9 | `latitude` | DECIMAL(10,8) | YES | - | Koordinat lintang |
| 10 | `longitude` | DECIMAL(11,8) | YES | - | Koordinat bujur |
| 11 | `created_at` | TIMESTAMP | YES | - | Waktu pembuatan record |
| 12 | `updated_at` | TIMESTAMP | YES | - | Waktu update terakhir |

**FK**:
- `instansi_id` → instansi.id (CASCADE on delete)

**Relasi**:
- Many-to-One: Instansi
- One-to-Many: Penyaluran Detail

---

### 4. 📂 **KATEGORI_DANA**
Menyimpan kategori/jenis dana zakat (bisa hierarki).

| No | Kolom | Tipe Data | Null | Default | Keterangan |
|----|-------|-----------|------|---------|------------|
| 1 | `id` | BIGINT | NO | - | Primary Key |
| 2 | `instansi_id` | BIGINT | NO | - | FK ke instansi |
| 3 | `parent_id` | BIGINT | YES | - | FK ke kategori_dana (untuk sub-kategori) |
| 4 | `nama` | VARCHAR(255) | NO | - | Nama kategori |
| 5 | `is_active` | BOOLEAN | NO | true | Status aktif |
| 6 | `start_date` | DATE | YES | - | Tanggal mulai berlaku |
| 7 | `end_date` | DATE | YES | - | Tanggal akhir berlaku |
| 8 | `created_at` | TIMESTAMP | YES | - | Waktu pembuatan record |
| 9 | `updated_at` | TIMESTAMP | YES | - | Waktu update terakhir |

**FK**:
- `instansi_id` → instansi.id (CASCADE on delete)
- `parent_id` → kategori_dana.id (CASCADE on delete)

**Relasi**:
- Many-to-One: Instansi, Kategori Dana (parent)
- One-to-Many: Kategori Dana (children), Transaksi Zakat

---

### 5. 💱 **HARGA_BERAS**
Menyimpan referensi harga beras untuk penentuan zakat fitrah.

| No | Kolom | Tipe Data | Null | Default | Keterangan |
|----|-------|-----------|------|---------|------------|
| 1 | `id` | BIGINT | NO | - | Primary Key |
| 2 | `harga_per_kg` | DECIMAL(10,2) | NO | - | Harga per kilogram (Rp) |
| 3 | `tanggal_berlaku` | DATE | NO | - | Tanggal mulai berlaku |
| 4 | `keterangan` | TEXT | YES | - | Catatan/keterangan |
| 5 | `created_at` | TIMESTAMP | YES | - | Waktu pembuatan record |
| 6 | `updated_at` | TIMESTAMP | YES | - | Waktu update terakhir |

**Relasi**: Digunakan sebagai snapshot pada Transaksi Zakat

---

### 6. 📏 **NISHAB**
Menyimpan nilai nishab zakat (fitrah dan mal).

| No | Kolom | Tipe Data | Null | Default | Keterangan |
|----|-------|-----------|------|---------|------------|
| 1 | `id` | BIGINT | NO | - | Primary Key |
| 2 | `jenis_zakat` | VARCHAR(255) | NO | - | Tipe: zakat fitrah atau zakat mal |
| 3 | `nishab_kg` | DECIMAL(10,2) | YES | - | Nishab dalam kg (untuk fitrah) |
| 4 | `nishab_rupiah` | DECIMAL(15,2) | YES | - | Nishab dalam Rp (untuk mal) |
| 5 | `tarif_fitrah_kg` | DECIMAL(10,2) | YES | - | Tarif harga beras untuk fitrah |
| 6 | `tanggal_berlaku` | DATE | NO | - | Tanggal mulai berlaku |
| 7 | `keterangan` | TEXT | YES | - | Catatan/keterangan |
| 8 | `created_at` | TIMESTAMP | YES | - | Waktu pembuatan record |
| 9 | `updated_at` | TIMESTAMP | YES | - | Waktu update terakhir |

**Relasi**: Master data untuk perhitungan zakat

---

### 7. 💵 **TRANSAKSI_ZAKAT**
Menyimpan transaksi penerimaan zakat dari muzakki.

| No | Kolom | Tipe Data | Null | Default | Keterangan |
|----|-------|-----------|------|---------|------------|
| 1 | `id` | BIGINT | NO | - | Primary Key |
| 2 | `instansi_id` | BIGINT | NO | - | FK ke instansi |
| 3 | `kategori_id` | BIGINT | NO | - | FK ke kategori_dana |
| 4 | `nomor_kuitansi` | VARCHAR(255) | NO | - | Nomor kuitansi (UNIQUE) |
| 5 | `nama_muzakki` | VARCHAR(255) | NO | - | Nama pembayar zakat |
| 6 | `jenis` | VARCHAR(255) | NO | - | Jenis: zakat, infak, sedekah |
| 7 | `sub_jenis` | VARCHAR(255) | YES | - | Sub-jenis: beras, uang, dll |
| 8 | `jumlah` | DECIMAL(15,2) | NO | - | Jumlah nominal (Rp) atau kg |
| 9 | `harga_beras_snapshot` | DECIMAL(10,2) | YES | - | Snapshot harga beras saat transaksi |
| 10 | `jenis_pembayaran` | ENUM | NO | tunai | Metode: tunai, transfer, qris |
| 11 | `bukti_pembayaran` | VARCHAR(255) | YES | - | Path file bukti (struk, foto) |
| 12 | `keterangan` | TEXT | YES | - | Catatan tambahan |
| 13 | `tanggal` | DATE | NO | - | Tanggal transaksi |
| 14 | `created_at` | TIMESTAMP | YES | - | Waktu pembuatan record |
| 15 | `updated_at` | TIMESTAMP | YES | - | Waktu update terakhir |

**FK**:
- `instansi_id` → instansi.id (CASCADE on delete)
- `kategori_id` → kategori_dana.id (CASCADE on delete)

**Constraint**:
- `nomor_kuitansi` UNIQUE
- Index: (instansi_id, tanggal), (kategori_id)

**Relasi**:
- Many-to-One: Instansi, Kategori Dana

---

### 8. 📋 **PROGRAM_PENYALURAN**
Menyimpan program/kegiatan penyaluran dana zakat.

| No | Kolom | Tipe Data | Null | Default | Keterangan |
|----|-------|-----------|------|---------|------------|
| 1 | `id` | BIGINT | NO | - | Primary Key |
| 2 | `instansi_id` | BIGINT | NO | - | FK ke instansi |
| 3 | `nama_program` | VARCHAR(255) | NO | - | Nama program penyaluran |
| 4 | `tanggal_mulai` | DATE | YES | - | Tanggal mulai program |
| 5 | `tanggal_selesai` | DATE | YES | - | Tanggal selesai program |
| 6 | `metode_distribusi` | VARCHAR(255) | YES | - | Metode: langsung, bank, pooling |
| 7 | `target_dana` | DECIMAL(15,2) | YES | - | Target dana yang disalurkan (Rp) |
| 8 | `status` | ENUM | NO | draft | Status: draft, aktif, selesai |
| 9 | `approval_status` | ENUM | NO | draft | Approval: draft, pending, approved, rejected |
| 10 | `approved_by` | BIGINT | YES | - | FK ke users (yang approve) |
| 11 | `approved_at` | TIMESTAMP | YES | - | Waktu approval |
| 12 | `approval_note` | TEXT | YES | - | Catatan approval/penolakan |
| 13 | `created_at` | TIMESTAMP | YES | - | Waktu pembuatan record |
| 14 | `updated_at` | TIMESTAMP | YES | - | Waktu update terakhir |

**FK**:
- `instansi_id` → instansi.id (CASCADE on delete)
- `approved_by` → users.id (SET NULL on delete)

**Constraint**:
- Index: (instansi_id), (approval_status, approved_by)

**Relasi**:
- Many-to-One: Instansi, Users (approved_by)
- One-to-Many: Penyaluran

---

### 9. 🎯 **PENYALURAN**
Menyimpan detail pelaksanaan penyaluran dana per program.

| No | Kolom | Tipe Data | Null | Default | Keterangan |
|----|-------|-----------|------|---------|------------|
| 1 | `id` | BIGINT | NO | - | Primary Key |
| 2 | `instansi_id` | BIGINT | NO | - | FK ke instansi |
| 3 | `program_id` | BIGINT | NO | - | FK ke program_penyaluran |
| 4 | `tanggal_penyaluran` | DATE | NO | - | Tanggal pelaksanaan |
| 5 | `status` | ENUM | NO | draft | Status: draft, selesai, dibatalkan |
| 6 | `keterangan` | TEXT | YES | - | Catatan penyaluran |
| 7 | `bukti_foto` | VARCHAR(255) | YES | - | Path file foto bukti |
| 8 | `created_at` | TIMESTAMP | YES | - | Waktu pembuatan record |
| 9 | `updated_at` | TIMESTAMP | YES | - | Waktu update terakhir |

**FK**:
- `instansi_id` → instansi.id (CASCADE on delete)
- `program_id` → program_penyaluran.id (CASCADE on delete)

**Constraint**:
- Index: (instansi_id, tanggal_penyaluran)

**Relasi**:
- Many-to-One: Instansi, Program Penyaluran
- One-to-Many: Penyaluran Detail

---

### 10. 💳 **PENYALURAN_DETAIL**
Menyimpan detail penerimaan dana per individu/lembaga dalam satu penyaluran.

| No | Kolom | Tipe Data | Null | Default | Keterangan |
|----|-------|-----------|------|---------|------------|
| 1 | `id` | BIGINT | NO | - | Primary Key |
| 2 | `penyaluran_id` | BIGINT | NO | - | FK ke penyaluran |
| 3 | `jenis_penerima` | VARCHAR(255) | NO | - | Tipe: individu, keluarga, lembaga |
| 4 | `mustahik_id` | BIGINT | YES | - | FK ke mustahik (optional) |
| 5 | `nama_penerima` | VARCHAR(255) | YES | - | Nama penerima (jika tidak di mustahik) |
| 6 | `jumlah_diterima` | DECIMAL(15,2) | NO | - | Jumlah diterima (Rp) |
| 7 | `status_penerimaan` | ENUM | NO | pending | Status: pending, diterima, ditolak |
| 8 | `tanggal_diterima` | TIMESTAMP | YES | - | Waktu penerimaan |
| 9 | `keterangan` | TEXT | YES | - | Catatan penerimaan |
| 10 | `created_at` | TIMESTAMP | YES | - | Waktu pembuatan record |
| 11 | `updated_at` | TIMESTAMP | YES | - | Waktu update terakhir |

**FK**:
- `penyaluran_id` → penyaluran.id (CASCADE on delete)
- `mustahik_id` → mustahik.id (SET NULL on delete)

**Relasi**:
- Many-to-One: Penyaluran, Mustahik

---

### 11. 🏦 **REKENING_INSTANSI**
Menyimpan informasi rekening bank instansi.

| No | Kolom | Tipe Data | Null | Default | Keterangan |
|----|-------|-----------|------|---------|------------|
| 1 | `id` | BIGINT | NO | - | Primary Key |
| 2 | `instansi_id` | BIGINT | NO | - | FK ke instansi |
| 3 | `nama_bank` | VARCHAR(255) | NO | - | Nama bank |
| 4 | `nomor_rekening` | VARCHAR(255) | NO | - | Nomor rekening |
| 5 | `nama_pemilik` | VARCHAR(255) | NO | - | Nama pemilik rekening |
| 6 | `created_at` | TIMESTAMP | YES | - | Waktu pembuatan record |
| 7 | `updated_at` | TIMESTAMP | YES | - | Waktu update terakhir |

**FK**:
- `instansi_id` → instansi.id (CASCADE on delete)

**Relasi**:
- Many-to-One: Instansi

---

### 12. 🔔 **PROFIL_INSTANSI_NOTIFICATIONS**
Menyimpan notifikasi untuk instansi.

| No | Kolom | Tipe Data | Null | Default | Keterangan |
|----|-------|-----------|------|---------|------------|
| 1 | `id` | BIGINT | NO | - | Primary Key |
| 2 | `instansi_id` | BIGINT | NO | - | FK ke instansi |
| 3 | `title` | VARCHAR(255) | NO | - | Judul notifikasi |
| 4 | `message` | TEXT | YES | - | Isi pesan notifikasi |
| 5 | `type` | VARCHAR(255) | NO | info | Tipe: info, warning, error, success |
| 6 | `read_at` | TIMESTAMP | YES | - | Waktu membaca notifikasi |
| 7 | `created_at` | TIMESTAMP | YES | - | Waktu pembuatan record |
| 8 | `updated_at` | TIMESTAMP | YES | - | Waktu update terakhir |

**FK**:
- `instansi_id` → instansi.id (CASCADE on delete)

**Relasi**:
- Many-to-One: Instansi

---

### 13. 📦 **SESSIONS**
Menyimpan session data pengguna yang login (sistem Laravel).

| No | Kolom | Tipe Data | Null | Default | Keterangan |
|----|-------|-----------|------|---------|------------|
| 1 | `id` | VARCHAR(255) | NO | - | Primary Key (session ID) |
| 2 | `user_id` | BIGINT | YES | - | FK ke users |
| 3 | `ip_address` | VARCHAR(45) | YES | - | IP address pengguna |
| 4 | `user_agent` | TEXT | YES | - | Browser/user agent info |
| 5 | `payload` | LONGTEXT | NO | - | Session data (serialized) |
| 6 | `last_activity` | INT | NO | - | Waktu aktivitas terakhir (unix timestamp) |

**FK**:
- `user_id` → users.id

**Constraint**:
- Index: (user_id), (last_activity)

---

### 14. ⚙️ **CACHE**
Menyimpan data cache sistem (sistem Laravel).

| No | Kolom | Tipe Data | Null | Default | Keterangan |
|----|-------|-----------|------|---------|------------|
| 1 | `key` | VARCHAR(255) | NO | - | Primary Key (cache key) |
| 2 | `value` | MEDIUMTEXT | NO | - | Cache value |
| 3 | `expiration` | BIGINT | NO | - | Waktu kadaluarsa (unix timestamp) |

**Constraint**:
- Index: (expiration)

---

### 15. 🔐 **CACHE_LOCKS**
Menyimpan lock untuk cache sistem (sistem Laravel).

| No | Kolom | Tipe Data | Null | Default | Keterangan |
|----|-------|-----------|------|---------|------------|
| 1 | `key` | VARCHAR(255) | NO | - | Primary Key |
| 2 | `owner` | VARCHAR(255) | NO | - | Owner/pemilik lock |
| 3 | `expiration` | BIGINT | NO | - | Waktu kadaluarsa lock |

**Constraint**:
- Index: (expiration)

---

### 16. 💼 **JOBS**
Menyimpan antrian job/pekerjaan asynchronous (sistem Laravel).

| No | Kolom | Tipe Data | Null | Default | Keterangan |
|----|-------|-----------|------|---------|------------|
| 1 | `id` | BIGINT | NO | - | Primary Key |
| 2 | `queue` | VARCHAR(255) | NO | - | Nama queue |
| 3 | `payload` | LONGTEXT | NO | - | Data job (serialized) |
| 4 | `attempts` | UNSIGNED SMALLINT | NO | - | Jumlah percobaan |
| 5 | `reserved_at` | UNSIGNED INT | YES | - | Waktu reserved |
| 6 | `available_at` | UNSIGNED INT | NO | - | Waktu tersedia |
| 7 | `created_at` | UNSIGNED INT | NO | - | Waktu pembuatan |

**Constraint**:
- Index: (queue)

---

### 17. 📊 **JOB_BATCHES**
Menyimpan batch job untuk proses bulk (sistem Laravel).

| No | Kolom | Tipe Data | Null | Default | Keterangan |
|----|-------|-----------|------|---------|------------|
| 1 | `id` | VARCHAR(255) | NO | - | Primary Key |
| 2 | `name` | VARCHAR(255) | NO | - | Nama batch |
| 3 | `total_jobs` | INT | NO | - | Total job dalam batch |
| 4 | `pending_jobs` | INT | NO | - | Job yang pending |
| 5 | `failed_jobs` | INT | NO | - | Job yang failed |
| 6 | `failed_job_ids` | LONGTEXT | NO | - | ID job yang failed |
| 7 | `options` | MEDIUMTEXT | YES | - | Options/konfigurasi |
| 8 | `cancelled_at` | INT | YES | - | Waktu dibatalkan |
| 9 | `created_at` | INT | NO | - | Waktu pembuatan |
| 10 | `finished_at` | INT | YES | - | Waktu selesai |

---

### 18. ❌ **FAILED_JOBS**
Menyimpan record job yang gagal (sistem Laravel).

| No | Kolom | Tipe Data | Null | Default | Keterangan |
|----|-------|-----------|------|---------|------------|
| 1 | `id` | BIGINT | NO | - | Primary Key |
| 2 | `uuid` | VARCHAR(255) | NO | - | UUID (UNIQUE) |
| 3 | `connection` | TEXT | NO | - | Nama connection |
| 4 | `queue` | TEXT | NO | - | Nama queue |
| 5 | `payload` | LONGTEXT | NO | - | Data job |
| 6 | `exception` | LONGTEXT | NO | - | Error exception |
| 7 | `failed_at` | TIMESTAMP | NO | CURRENT | Waktu gagal |

**Constraint**:
- `uuid` UNIQUE

---

## 🔗 Relasi Antar Tabel

### Relasi One-to-Many (1:N)
```
INSTANSI
├── Users (1:N)
├── Mustahik (1:N)
├── Kategori Dana (1:N)
├── Transaksi Zakat (1:N)
├── Program Penyaluran (1:N)
├── Penyaluran (1:N)
├── Rekening Instansi (1:N)
└── Profil Instansi Notifications (1:N)

KATEGORI_DANA
├── Kategori Dana (self-referencing 1:N untuk sub-kategori)
└── Transaksi Zakat (1:N)

PROGRAM_PENYALURAN
└── Penyaluran (1:N)

PENYALURAN
└── Penyaluran Detail (1:N)

MUSTAHIK
└── Penyaluran Detail (1:N)

USERS (approved_by)
└── Program Penyaluran (1:N)
```

### Relasi Many-to-One (N:1)
```
Users → Instansi
Mustahik → Instansi
Kategori Dana → Instansi
Kategori Dana → Kategori Dana (parent)
Transaksi Zakat → Instansi
Transaksi Zakat → Kategori Dana
Program Penyaluran → Instansi
Program Penyaluran → Users (approved_by)
Penyaluran → Instansi
Penyaluran → Program Penyaluran
Penyaluran Detail → Penyaluran
Penyaluran Detail → Mustahik
Rekening Instansi → Instansi
Profil Instansi Notifications → Instansi
Sessions → Users
```

---

## 📌 Enum dan Nilai-Nilai Khusus

### INSTANSI.status
- `pending` - Menunggu aktivasi
- `aktif` - Aktif dan beroperasi
- `nonaktif` - Tidak aktif

### USERS.role
- `super_admin` - Administrator sistem
- `admin_instansi` - Administrator per instansi

### USERS.status
- `pending` - Akun baru menunggu aktivasi
- `active` - Akun aktif
- `blocked` - Akun diblokir

### MUSTAHIK.status
- `pending` - Menunggu verifikasi
- `verified` - Terverifikasi
- `rejected` - Ditolak

### MUSTAHIK.kategori_asnaf
- `fakir` - Kategori fakir
- `miskin` - Kategori miskin
- `amil` - Pengelola zakat
- `muallaf` - Baru masuk islam
- `riqab` - Budak yang dimerdekakan
- `gharimin` - Orang yang terlilit hutang
- `fisabilillah` - Perjuangan di jalan Allah
- `ibnu sabil` - Pengelana di jalan

### TRANSAKSI_ZAKAT.jenis
- `zakat` - Zakat
- `infak` - Infak
- `sedekah` - Sedekah

### TRANSAKSI_ZAKAT.jenis_pembayaran
- `tunai` - Pembayaran tunai
- `transfer` - Transfer bank
- `qris` - Pembayaran QRIS

### PROGRAM_PENYALURAN.status
- `draft` - Draft program
- `aktif` - Program aktif
- `selesai` - Program selesai

### PROGRAM_PENYALURAN.approval_status
- `draft` - Draft, belum diajukan
- `pending` - Menunggu approval
- `approved` - Disetujui
- `rejected` - Ditolak

### PENYALURAN.status
- `draft` - Draft penyaluran
- `selesai` - Selesai disalurkan
- `dibatalkan` - Dibatalkan

### PENYALURAN_DETAIL.status_penerimaan
- `pending` - Menunggu penerimaan
- `diterima` - Sudah diterima
- `ditolak` - Ditolak penerima

### PENYALURAN_DETAIL.jenis_penerima
- `individu` - Penerima perorangan
- `keluarga` - Penerima keluarga
- `lembaga` - Penerima organisasi/lembaga

### PROFIL_INSTANSI_NOTIFICATIONS.type
- `info` - Informasi
- `warning` - Peringatan
- `error` - Error/kesalahan
- `success` - Sukses

---

## 📊 Statistik Tabel

| Kategori | Jumlah Tabel |
|----------|-------------|
| Sistem | 5 (Cache, Cache Locks, Jobs, Job Batches, Failed Jobs) |
| Master Data | 6 (Instansi, Users, Harga Beras, Nishab, Kategori Dana, Rekening Instansi) |
| Transaksi | 6 (Mustahik, Transaksi Zakat, Program Penyaluran, Penyaluran, Penyaluran Detail, Profil Instansi Notifications) |
| Session | 1 (Sessions) |
| **TOTAL** | **18 Tabel** |

---

## 🔍 Index Penting

| Tabel | Kolom | Tipe |
|-------|-------|------|
| users | email, username | UNIQUE |
| users | instansi_id | UNIQUE |
| transaksi_zakat | nomor_kuitansi | UNIQUE |
| transaksi_zakat | (instansi_id, tanggal) | INDEX |
| program_penyaluran | (approval_status, approved_by) | INDEX |
| penyaluran | (instansi_id, tanggal_penyaluran) | INDEX |
| cache | expiration | INDEX |
| cache_locks | expiration | INDEX |
| jobs | queue | INDEX |
| sessions | user_id, last_activity | INDEX |

---

## 🔐 Foreign Key Relationships

| Tabel | FK Kolom | Merujuk Ke | On Delete |
|-------|----------|------------|-----------|
| users | instansi_id | instansi.id | SET NULL |
| mustahik | instansi_id | instansi.id | CASCADE |
| kategori_dana | instansi_id | instansi.id | CASCADE |
| kategori_dana | parent_id | kategori_dana.id | CASCADE |
| transaksi_zakat | instansi_id | instansi.id | CASCADE |
| transaksi_zakat | kategori_id | kategori_dana.id | CASCADE |
| program_penyaluran | instansi_id | instansi.id | CASCADE |
| program_penyaluran | approved_by | users.id | SET NULL |
| penyaluran | instansi_id | instansi.id | CASCADE |
| penyaluran | program_id | program_penyaluran.id | CASCADE |
| penyaluran_detail | penyaluran_id | penyaluran.id | CASCADE |
| penyaluran_detail | mustahik_id | mustahik.id | SET NULL |
| rekening_instansi | instansi_id | instansi.id | CASCADE |
| profil_instansi_notifications | instansi_id | instansi.id | CASCADE |
| sessions | user_id | users.id | - |

---

**Dokumen ini dibuat otomatis dari migration files sistem.**  
**Untuk pertanyaan atau perubahan struktur database, hubungi tim development.**

---

*Terakhir diupdate: 1 Juni 2026*
