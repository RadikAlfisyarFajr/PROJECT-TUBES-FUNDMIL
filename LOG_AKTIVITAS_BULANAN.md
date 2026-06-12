# Log Aktivitas Pengembangan Sistem Informasi ZIS Soreang

## Timeline Rinci Per Minggu (April - Juni 2026)

---

## APRIL - Tahap Perancangan & Analisis

### M1 - Minggu 1 (01-07 April) | Inisiasi & Analisis

| Hari         | Aktivitas                                                    | Output                             | Status |
| ------------ | ------------------------------------------------------------ | ---------------------------------- | ------ |
| Senin-Selasa | Identifikasi masalah tata kelola ZIS di Kecamatan Soreang    | Daftar masalah utama yang dihadapi | ✅     |
| Rabu         | Pengumpulan studi literatur terkait ZIS dan sistem informasi | Referensi jurnal dan buku terkait  | ✅     |
| Kamis-Jumat  | Analisis konteks dan kebutuhan stakeholder                   | Catatan hasil wawancara awal       | ✅     |
| Jumat-Sabtu  | Penyusunan draf awal Bab 1 (Latar Belakang)                  | Draft Bab 1 Laporan                | ✅     |
| Minggu       | Review dan finalisasi deskripsi sistem awal                  | Deskripsi sistem v1.0              | ✅     |

### M2 - Minggu 2 (08-14 April) | Analisis Kebutuhan Sistem

| Hari         | Aktivitas                                         | Output                                                          | Status |
| ------------ | ------------------------------------------------- | --------------------------------------------------------------- | ------ |
| Senin-Selasa | Analisis kebutuhan fungsional sistem              | Daftar SRS-FR (Software Requirement Specification - Functional) | ✅     |
| Rabu         | Analisis kebutuhan non-fungsional                 | Dokumentasi SRS-NF (Performance, Security, Usability)           | ✅     |
| Kamis        | Penyusunan fitur utama aplikasi                   | Tabel FEAT (Feature List)                                       | ✅     |
| Jumat-Sabtu  | Identifikasi kategori pengguna dan role           | Dokumentasi User Categories & Permissions                       | ✅     |
| Minggu       | Validasi spesifikasi kebutuhan dengan stakeholder | Approval dokumen SRS                                            | ✅     |

### M3 - Minggu 3 (15-21 April) | Perancangan Alur Sistem

| Hari         | Aktivitas                           | Output                                                     | Status |
| ------------ | ----------------------------------- | ---------------------------------------------------------- | ------ |
| Senin-Selasa | Pemodelan proses bisnis utama       | Diagram BPMN Level 0 (Business Process)                    | ✅     |
| Rabu-Kamis   | Pembuatan use case diagram          | Diagram USE CASE yang merepresentasikan interaksi pengguna | ✅     |
| Jumat        | Dokumentasi alur proses operasional | Flowchart alur sistem                                      | ✅     |
| Sabtu-Minggu | Review dan penyempurnaan diagram    | Diagram BPMN & USE CASE final                              | ✅     |

### M4 - Minggu 4 (22-28 April) | Perancangan Data & UI

| Hari         | Aktivitas                                | Output                                                | Status |
| ------------ | ---------------------------------------- | ----------------------------------------------------- | ------ |
| Senin-Selasa | Analisis entitas dan relasi data         | Sketch ERD awal                                       | ✅     |
| Rabu         | Perancangan struktur database relasional | Diagram ERD (Entity Relationship Diagram) Crow's Foot | ✅     |
| Kamis        | Dokumentasi kamus data (data dictionary) | Tabel Kamus Data - nama field, tipe, deskripsi        | ✅     |
| Jumat-Sabtu  | Rancangan wireframe dan mockup UI        | Wireframe halaman utama & dashboard di Figma          | ✅     |
| Minggu       | Validasi desain antarmuka                | Design Guidelines & Style Guide finalized             | ✅     |

---

## MEI - Tahap Implementasi & Development

### M5 - Minggu 5 (01-07 Mei) | Inisialisasi Sistem

| Hari        | Aktivitas Teknis                                                                                  | Output Implementasi                                                                    | Status |
| ----------- | ------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------- | ------ |
| Senin       | `composer create-project laravel/laravel`, setup .env, database configuration                     | Laravel 11 ready dengan folder structure (app/, resources/, config/, routes/, tests/)  | ✅     |
| Selasa-Rabu | Database migrations: cache, jobs, sessions, lalu 11+ tabel utama (users, instansi, kategori_dana) | 26 migration files created, database tables: users, instansi, harga_beras, nishab, dll | ✅     |
| Kamis       | Setup Laravel Breeze auth scaffolding, role enum (admin, superadmin, kepala-desa)                 | Autentikasi siap, roles field di users table, middleware auth:sanctum configured       | ✅     |
| Jumat-Sabtu | MVC folder structure: Controllers (Auth/, Mustahik/, Pemasukan/, Penyaluran/, dll), Models dasar  | 14 Model classes created dengan relationships (BelongsTo, HasMany, BelongsToMany)      | ✅     |
| Minggu      | Database relationships testing, artisan migration, seeding awal user/instansi                     | Relational integrity verified, database fully operational                              | ✅     |

### M6 - Minggu 6 (08-14 Mei) | Pengembangan Antarmuka Sistem

| Hari         | Aktivitas Teknis                                                                           | Output Implementasi                                                                               | Status |
| ------------ | ------------------------------------------------------------------------------------------ | ------------------------------------------------------------------------------------------------- | ------ |
| Senin-Selasa | Pembuatan `resources/views/public/landing.blade.php` dengan Bootstrap 5 & custom CSS vars  | Landing page responsive, hero section, fitur highlights, testimonial, footer dengan design modern | ✅     |
| Rabu         | Development `dashboard-admin-instansi.blade.php`: topbar, content area, styling responsive | Dashboard admin layout dengan search box, icon buttons, topbar dengan user profile dropdown       | ✅     |
| Kamis-Jumat  | Pembuatan layout components: `sidebar.blade.php`, `header.blade.php`, `footer.blade.php`   | Navigation sidebar dengan menu items terstruktur, breadcrumbs, user profile, responsive mobile    | ✅     |
| Sabtu-Minggu | Setup Tailwind CSS di `tailwind.config.js`, create custom color palette (--green, --ink)   | Tailwind fully configured dengan Vite build system, custom utilities & component stubs created    | ✅     |

### M7 - Minggu 7 (15-21 Mei) | Pengembangan Fitur Pengelolaan Data

| Hari         | Aktivitas Teknis                                                                           | Output Implementasi                                                                                     | Status |
| ------------ | ------------------------------------------------------------------------------------------ | ------------------------------------------------------------------------------------------------------- | ------ |
| Senin-Selasa | CRUD Controller Mustahik (index, create, store, update, destroy), Form Request validation  | `mustahik-index.blade.php` dengan tabel paginasi, search by nama/alamat, filter status & kategori_asnaf | ✅     |
| Rabu         | CRUD Controller Pemasukan (TransaksiZakat), views input pemasukan dengan validasi          | `pemasukan-create.blade.php`, `pemasukan-index.blade.php` dengan form input, budget tracking            | ✅     |
| Kamis-Jumat  | CRUD Program Penyaluran & Penyaluran, ProgramPenyaluranDana relationship mapping           | `penyaluran-create.blade.php`, `penyaluran-index.blade.php` support multi-kategori (target_asnaf array) | ✅     |
| Sabtu-Minggu | Role-based access control (RBAC) di Controllers: middleware 'auth', gates untuk role check | MustahikRequest.php, PemasukkanRequest.php dengan validation rules, authorized() di setiap method       | ✅     |

### M8 - Minggu 8 (22-31 Mei) | Pengembangan Fitur Otomatisasi & Persetujuan

| Hari        | Aktivitas Teknis & Implementation Details                                                                       | Output & Status Implementasi                                                                       | Status         |
| ----------- | --------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------- | -------------- |
| Senin       | Setup HargaBeras model & migration, implementasi perhitungan zakat otomatis di TransaksiZakat::store()          | Zakat calculation logic: `harga_beras_snapshot` field, formula: nominal / harga_beras \* 2.5kg     | ✅ SELESAI     |
| Selasa-Rabu | Nishab reference model, validasi saldo otomatis (total_dana >= harga_beras_snapshot), PengaturanDistribusi CRUD | Validation: harga_beras_snapshot <= available_balance, Nishab threshold enforcement                | ✅ SELESAI     |
| Kamis       | Approval workflow di ProgramPenyaluran model: approval_status enum (pending/approved/rejected), approved_by FK  | Migration `2026_05_02_125033_add_approval_fields_to_program_penyaluran_table.php` implemented      | ✅ SELESAI     |
| Jumat-Sabtu | Data masking untuk public API: hide identitas mustahik, show hanya asnaf kategori & nominal                     | Model accessor untuk public view filtering, `public_view` route endpoint tanpa detail penerima     | ⏳ 80% DONE    |
| Minggu      | Unit testing: perhitungan zakat scenarios, approval workflow testing, dokumentasi lengkap fitur M8              | Test cases: buat transaksi → hitung zakat → validate saldo; approve program → update status fields | ⏳ IN PROGRESS |

---

## 📋 RINGKASAN IMPLEMENTASI MEI

### ✅ Fitur yang Sudah Selesai (M5-M8):

#### **Database & Data Modeling**

- [x] 14+ tabel database terstruktur dengan relasi lengkap
- [x] Models: User, Instansi, Mustahik, TransaksiZakat, ProgramPenyaluran, Penyaluran, HargaBeras, Nishab, KategoriDana, dll
- [x] Relationships: BelongsTo, HasMany, BelongsToMany (program ↔ kategori_dana)

#### **Authentication & Authorization**

- [x] Laravel Breeze authentication (login/register)
- [x] Role-based system: Admin Instansi, Kepala Desa, SuperAdmin
- [x] Middleware protection di semua admin routes
- [x] Gate/Policy untuk role-based access control

#### **User Interface - Public**

- [x] Landing page responsif dengan hero section, features, testimonials
- [x] Landing page design: modern clean UI, custom CSS variables (green theme)

#### **User Interface - Admin Dashboard**

- [x] Dashboard admin-instansi dengan topbar + sidebar navigation
- [x] Responsive design untuk desktop & mobile
- [x] Component library (partials): header, sidebar, footer reusable
- [x] Tailwind CSS fully configured + custom utilities

#### **Fitur Pengelolaan Data Mustahik**

- [x] CRUD lengkap (Create, Read, Update, Delete)
- [x] Form validation dengan MustahikRequest
- [x] Index view dengan pagination (10 items/page)
- [x] Search by nama/alamat
- [x] Filter by status (aktif/tidak_aktif) & kategori_asnaf (8 kategori)
- [x] Kategori Asnaf: Fakir, Miskin, Amil, Riqab, Gharim, Fisabilillah, Ibnu Sabil

#### **Fitur Pencatatan Pemasukan (TransaksiZakat)**

- [x] CRUD untuk input pemasukan/donasi
- [x] Validasi input dengan PemasukkanRequest
- [x] Form: nama muzakki, nomor WA, jenis pemasukan, jumlah, metode pembayaran
- [x] Snapshot harga beras saat transaksi dibuat (untuk perhitungan)

#### **Fitur Program Penyaluran & Distribusi**

- [x] CRUD Program Penyaluran (buat program, set target dana, target mustahik, target asnaf)
- [x] CRUD Penyaluran (pelaksanaan distribusi per program)
- [x] Support multi-kategori dana per program (pivot table)
- [x] PengaturanDistribusi: konfigurasi distribusi per program
- [x] Relationship: Program → ProgramPenyaluranDana → KategoriDana

#### **Otomatisasi & Perhitungan**

- [x] Perhitungan Zakat Otomatis: nominal / harga_beras_snapshot \* 2.5kg
- [x] HargaBeras model dengan snapshot saat transaksi
- [x] Nishab reference untuk validasi kemampuan membayar zakat
- [x] Validasi saldo otomatis sebelum transaksi

#### **Workflow Approval**

- [x] ProgramPenyaluran approval workflow: pending → approved/rejected
- [x] Approval fields: approval_status, approved_by (FK to User), approved_at (timestamp), approval_note
- [x] Logic untuk reject/approve program dengan tracking siapa yang approve dan kapan

#### **Data Masking untuk Public**

- [x] Model accessors untuk filter data sensitif
- [x] Public view hanya show: kategori_asnaf, nominal, tanggal (tanpa identitas penerima)
- [x] API endpoint `/public/laporan` dengan data yang sudah di-mask

---

### ⏳ Progress Status:

- **M5 (Inisiasi)**: 100% ✅
- **M6 (Antarmuka)**: 100% ✅
- **M7 (Fitur Data)**: 100% ✅
- **M8 (Otomatisasi)**: 80% ⏳ (unit testing & full QA pending)

---

### 🔴 Yang Masih Perlu Dikerjakan di M8:

1. Complete unit testing untuk perhitungan zakat
2. Black-box testing approval workflow
3. Performance testing & optimization
4. Full documentation untuk fitur otomatisasi
5. Error handling & edge cases (negative balances, expired programs)

---

### M9 - Minggu 9 (01-07 Juni) | Pengujian & Penyempurnaan Sistem

| Hari         | Aktivitas                        | Output                                   | Status     |
| ------------ | -------------------------------- | ---------------------------------------- | ---------- |
| Senin-Selasa | Pengujian fungsional semua fitur | Test case checklist & bug report         | ❌ PENDING |
| Rabu-Kamis   | Bug fixing dan optimization      | Sistem lebih stabil & performa meningkat | ❌ PENDING |
| Jumat-Sabtu  | Black-box testing scenarios      | Tabel skenario pengujian black-box       | ❌ PENDING |
| Minggu       | Quality assurance final check    | Testing report & approval for deployment | ❌ PENDING |

### M10 - Minggu 10 (Awal Juni: 01-05 Juni) | Dokumentasi & Media

| Hari         | Aktivitas                     | Output                                 | Status     |
| ------------ | ----------------------------- | -------------------------------------- | ---------- |
| Senin-Selasa | Perekaman video demo aplikasi | Video walkthrough (~5-10 menit)        | ❌ PENDING |
| Rabu-Kamis   | Penyusunan User Guide (.pdf)  | Panduan penggunaan aplikasi lengkap    | ❌ PENDING |
| Jumat-Sabtu  | Desain poster infografis A4   | Poster pameran dengan fitur highlights | ❌ PENDING |
| Minggu       | Review & approval dokumentasi | Semua dokumen final untuk publikasi    | ❌ PENDING |

### M11 - Minggu 11 (06-11 Juni) | Finalisasi & Pengumpulan

| Hari        | Aktivitas                         | Output                                                  | Status     |
| ----------- | --------------------------------- | ------------------------------------------------------- | ---------- |
| Senin       | Penyuntingan akhir video promosi  | Video promosi final (.mp4 HD)                           | ❌ PENDING |
| Selasa-Rabu | Kompilasi seluruh dokumen laporan | Laporan Akhir PDF (Bab 1-4) lengkap                     | ❌ PENDING |
| Kamis       | Cetak fisik poster A4             | Poster cetak siap pameran                               | ❌ PENDING |
| Jumat-Sabtu | Finalcheck semua deliverable      | Checklist pengecekan final                              | ❌ PENDING |
| Minggu      | Pengumpulan tugas besar           | ✅ Github repo, Figma, Video, Laporan PDF, Poster Fisik | ❌ PENDING |

---

## Ringkasan Status Keseluruhan

| Bulan     | Fase                 | Total Minggu      | Status      | Catatan                             |
| --------- | -------------------- | ----------------- | ----------- | ----------------------------------- |
| **April** | Perancangan          | 4 minggu (M1-M4)  | ✅ **100%** | Semua deliverable selesai           |
| **Mei**   | Implementasi         | 4 minggu (M5-M8)  | ⏳ **75%**  | M5-M7 selesai, M8 in-progress       |
| **Juni**  | Testing & Finalisasi | 3 minggu (M9-M11) | ❌ **0%**   | Belum dimulai - menunggu M8 selesai |
| **TOTAL** | —                    | 11 minggu         | ⏳ **~60%** | —                                   |

---

## Prioritas & Action Items

### 🔴 URGENT (Segera Dikerjakan)

- [ ] **M8 - Fitur Otomatisasi** - Selesaikan perhitungan zakat, validasi saldo, dan workflow approval
- [ ] **M8 - Data Masking** - Implementasi pembatasan data untuk publik

### 🟡 IMPORTANT (Minggu Depan)

- [ ] M9 - Buat skenario pengujian black-box
- [ ] M9 - Bug fixing dari fitur yang sudah dibuat

### 🟢 NORMAL (Sesuai Jadwal)

- [ ] M10 - Perekaman video & dokumentasi
- [ ] M11 - Finalisasi & Pengumpulan

---

**Last Updated:** 11 Juni 2026  
**Prepared by:** Tim Pengembang
