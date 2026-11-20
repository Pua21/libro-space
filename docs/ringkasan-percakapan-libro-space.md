# Ringkasan Percakapan Proyek Libro Space

Dokumen ini merangkum seluruh proses yang sudah dikerjakan, mulai dari persiapan lingkungan sampai pembuatan use case diagram dan push ke GitHub. Dokumen dibagi menjadi dua bagian: **Bagian A** untuk publish ke Git, dan **Bagian B** untuk hal lainnya.

## Gambaran Proyek

| Item | Isi |
|---|---|
| Nama sistem | Sistem Informasi Perpustakaan Libro Space |
| Teknologi | PHP, Laravel 12, MySQL, HTML, CSS, JavaScript (Ajax) |
| Tim | Varely S. Anchieta (Admin), Rafael Rico K (Petugas), Ignatius Papuandri M (Anggota, dipanggil Pua) |
| Peran Pua | Anggota (User): layout dasar, login dan hak akses, serta sebagian dokumentasi |
| Repositori | https://github.com/Pua21/libro-space (private) |
| Lokasi proyek lokal | `D:\laragon\www\libro-space` |

Repositori ini dipakai bersama untuk ketiga role. Pembagian dilakukan lewat folder (`admin/`, `petugas/`, `anggota/`) dan branch fitur.

---

## Bagian A: Publish ke Git

### A1. Ringkasan Hasil

| Item | Status |
|---|---|
| Repositori GitHub `libro-space` (private) | Dibuat |
| Branch `main` | Ada, commit pertama `1fd1454` |
| Branch `develop` | Ada, commit terbaru `fbe14b3` |
| Branch `feature/anggota-desain` | Ada, berisi file use case diagram |
| Struktur folder dan `.gitkeep` | Sudah di-push ke `develop` |
| README versi awal | Sudah di-push ke `develop` |
| Undangan collaborator untuk Varely dan Rico | Belum |

### A2. Urutan Commit

| Hash | Branch | Pesan commit | Isi |
|---|---|---|---|
| `1fd1454` | main | `chore(proyek): inisialisasi proyek Laravel` | 56 file kerangka Laravel |
| `5edfde4` | develop | `chore(struktur): siapkan struktur folder dan layout kosong` | Folder layout, partials, components, role, aset, `.gitkeep` |
| `fbe14b3` | develop | `docs(readme): perbarui panduan instalasi dan struktur proyek` | README |
| `eb14734` | feature/anggota-desain | `docs(uml): tambah use case diagram tiga role` | File PNG pratinjau |
| `11cd87e` | feature/anggota-desain | `docs(uml): tambahkan file sumber use case diagram` | File `.drawio` |

### A3. Langkah yang Dijalankan

**1. Identitas Git**

```
git config --global user.name "Ignatius Papuandri M"
git config --global user.email "<email akun GitHub>"
```

Email harus valid dan sebaiknya sama dengan akun GitHub. Email `Ignatiusmansawan@.com` sempat ditolak karena tidak punya nama domain.

**2. Inisialisasi dan commit pertama**

Laravel sudah membuat folder sebagai repositori Git, sehingga `git init` tidak perlu dijalankan lagi. Setelah itu:

```
git branch -M main
git add .
git status
git commit -m "chore(proyek): inisialisasi proyek Laravel"
```

Pastikan `.env` tidak muncul di `git status`. File `.env` diabaikan lewat `.gitignore`.

**3. Hubungkan ke GitHub**

```
git remote add origin https://github.com/Pua21/libro-space.git
git remote -v
```

Jika muncul `remote origin already exists`:

```
git remote set-url origin https://github.com/Pua21/libro-space.git
```

**4. Push pertama**

```
git push -u origin main
```

Saat pertama kali push, pilih credential helper `manager-core` dan login lewat browser sebagai `Pua21`. Jika GitHub meminta token, gunakan Personal Access Token dengan izin `repo`.

**5. Branch develop**

```
git checkout -b develop
git push -u origin develop
```

**6. Struktur folder dan `.gitkeep`**

Dibuat dengan perintah cmd (satu per satu, bukan digabung dalam satu baris):

```
mkdir resources\views\layouts
mkdir resources\views\partials
type nul > resources\views\partials\.gitkeep
```

Verifikasi:

```
git status
git ls-files | findstr gitkeep
```

Enam file `.gitkeep` terdaftar: `public/img`, `admin`, `anggota`, `components`, `partials`, dan `petugas`.

**7. README dan push**

```
git add README.md
git commit -m "docs(readme): perbarui panduan instalasi dan struktur proyek"
git push origin develop
```

**8. Branch fitur untuk use case diagram**

```
git checkout develop
git checkout -b feature/anggota-desain
```

Jika branch sudah ada, cukup pindah dengan `git checkout feature/anggota-desain`.

Lalu:

```
git add docs
git commit -m "docs(uml): tambah use case diagram tiga role"
git push -u origin feature/anggota-desain
git add docs
git commit -m "docs(uml): tambahkan file sumber use case diagram"
git push
```

**9. Pull request**

Buka `https://github.com/Pua21/libro-space/pull/new/feature/anggota-desain`, lalu pastikan:

- **base**: `develop` (bukan `main`)
- **compare**: `feature/anggota-desain`

Judul yang disarankan: `docs(uml): use case diagram tiga role`. Setelah dibuat, pilih Varely dan Rico sebagai reviewer. Merge setelah minimal satu persetujuan.

### A4. Aturan Git yang Disepakati

1. Semua pekerjaan masuk ke `develop` lewat pull request dari branch `feature/<nama-modul>`.
2. `main` hanya diperbarui di akhir proyek, sekitar minggu 4, setelah sistem stabil.
3. Format commit: `tipe(modul): ringkasan`, dengan tipe `feat`, `fix`, `docs`, `style`, `refactor`, atau `chore`.
4. Sebelum mulai kerja: `git checkout develop`, lalu `git pull origin develop`.
5. Setelah merge yang membawa migration baru: `php artisan migrate`.
6. Jangan commit `.env`, `vendor/`, `node_modules/`, atau file `.txt` catatan pribadi.

### A5. Masalah Git yang Pernah Terjadi

| Pesan | Penyebab | Solusi |
|---|---|---|
| `error: unknown switch 'M'` | Perintah digabung dalam satu baris | Jalankan satu per satu |
| `Please tell me who you are` | Identitas Git belum diatur | Atur `user.name` dan `user.email` |
| `remote origin already exists` | Remote sudah ada | `git remote set-url origin ...` |
| `Repository not found` | Repositori belum dibuat, atau login akun salah | Buat repositori kosong di GitHub, lalu hapus kredensial lama di Credential Manager |
| `a branch named 'feature/...' already exists` | Branch dibuat di percobaan sebelumnya | `git checkout feature/...` |
| `Everything up-to-date` | Commit sudah ada di remote | Tidak perlu tindakan |
| Banner "Compare & pull request" untuk `develop` | `develop` berisi perubahan yang belum ada di `main` | Jangan diklik, `main` diperbarui di akhir proyek |
| `Tutor Command Terminal Laragon.txt` muncul di `git status` | File catatan pribadi di folder proyek | Jangan di-add. Opsional: tambahkan ke `.gitignore` |

### A6. Catatan Kesalahan dari Saran Sebelumnya

- Perintah `composer self-update` tidak bisa dipakai di Composer 2.4.1 dengan PHP 8.5. Solusinya mengganti `composer.phar` secara manual.
- Beberapa perintah sempat ditulis dengan gaya Bash (`mkdir -p`, `touch`), padahal terminal memakai cmd. Gunakan perintah cmd.
- Placeholder `<username>` harus diganti tanpa tanda `< >`, karena di Windows tanda itu dibaca sebagai redirection.

---

## Bagian B: Persiapan Lingkungan, Proyek, dan Desain

### B1. Lingkungan Kerja

| Komponen | Versi | Keterangan |
|---|---|---|
| Laragon | Full 6.0 | Menyediakan Apache, MySQL, PHP, dan terminal |
| PHP | 8.5.12 (VS17) | Dipilih lewat Menu → PHP → Version |
| MySQL | 8.0.30 | Dari Laragon |
| Composer | 2.11.1 | Diganti manual dari `composer.phar` terbaru |
| Git | 2.55.0 | Git for Windows |

Gunakan **Terminal Laragon** untuk semua perintah `php`, `composer`, `mysql`, dan `artisan`.

### B2. Konfigurasi `php.ini`

Salin `php.ini-development` menjadi `php.ini` di folder PHP yang aktif. Jangan edit file aslinya. Lakukan:

- Aktifkan ekstensi: `fileinfo`, `intl`, `mbstring`, `openssl`, `pdo_mysql`, `zip`, `bcmath`, `ctype`, `tokenizer`, `xml`
- Atur `extension_dir = "ext"`
- Atur `date.timezone = Asia/Jakarta`
- Nonaktifkan `extension=curl`, karena `php_curl.dll` build ini menyebabkan Apache gagal start
- Opsional: `error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT` untuk menyembunyikan peringatan

Setelah diedit, restart dengan **Stop All** lalu **Start All**. Verifikasi dengan `php --ini`, `php -m`, dan `php -i | findstr "date.timezone"`.

### B3. Proyek Laravel

```
cd D:\laragon\www
composer create-project laravel/laravel:^12.0 libro-space
cd libro-space
php artisan --version
```

Setelah `.env` diatur ke MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=libro_space
DB_USERNAME=root
DB_PASSWORD=
```

Database dibuat dengan:

```
mysql -u root -e "CREATE DATABASE IF NOT EXISTS libro_space CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

Verifikasi koneksi:

```
php artisan migrate:status
php artisan tinker --execute="echo DB::connection()->getDatabaseName();"
```

Hasil yang benar: `Migration table not found` (normal, tabel belum dibuat) dan `libro_space`. Jangan jalankan `php artisan migrate` sebelum migration Varely masuk ke `develop`.

### B4. Peringatan yang Boleh Diabaikan

- `Deprecated: Constant PDO::MYSQL_ATTR_SSL_CA` dari `config/database.php` bawaan Laravel. Tidak memengaruhi fungsi.
- `Deprecation Notice` pada Composer lama. Tidak menghentikan proses.
- `WARN could not find driver (sqlite)` sebelum `.env` diubah. Selesai setelah `DB_CONNECTION=mysql`.

### B5. Dokumen 1.2: Rincian Halaman per Role

Sumber utama aturan dan halaman, dengan tiga role:

- **Admin**: dashboard, data buku, data master, data anggota, data petugas, data peminjaman, pengembalian dan denda, pengaturan sistem, laporan, log aktivitas, profil.
- **Petugas**: dashboard operasional, data buku (tanpa hapus), data anggota, peminjaman baru, pengembalian, pembayaran denda, riwayat transaksi, laporan harian, profil.
- **Anggota**: login dan registrasi (persetujuan petugas), beranda, katalog, detail buku, peminjaman saya, riwayat, denda saya, notifikasi, profil dan kartu anggota.

Tabel hak akses juga berasal dari dokumen ini, misalnya hapus buku hanya Admin, dan Petugas "kelola anggota: terbatas" (batasnya belum dirinci).

### B6. Tugas 1.5: Use Case Diagram

Dibuat dengan script Python yang menghasilkan file `.drawio` dan PNG pratinjau. Isi diagram:

- Aktor: Pengguna (abstraksi), Anggota, Petugas, Admin
- Use case: U01 sampai U03 (bersama), A01 sampai A09 (anggota), P01 sampai P04 (petugas), S01 sampai S05 (petugas dan admin), D01 sampai D11 (admin), X01 sampai X11 (include dan extend)
- Total: 43 elemen dan 51 relasi

File yang dihasilkan:

- `use-case-libro-space.drawio`: file sumber untuk draw.io
- `use-case-libro-space-pratinjau.png`: pratinjau

Keputusan yang masih terbuka dan ditandai di diagram: reservasi buku (X01), logout, dan posisi Pengguna sebagai abstraksi.

Perbaikan diagram yang disarankan:
1. A01 sebaiknya terhubung ke aktor "Calon anggota".
2. Tambahkan relasi A01 ke P02.
3. Logout bisa ditambahkan jika tim menginginkannya.

### B7. Deskripsi Use Case Anggota

File: `deskripsi-use-case-anggota.md`. Isinya meliputi:

- Deskripsi U01 Login, U02 Kelola profil dan password, dan A01 Registrasi, dengan alur utama dan alternatif
- Status akun: Menunggu persetujuan, Aktif, Nonaktif, Dihapus
- Tabel siapa mengatur apa untuk akun (Anggota, Petugas, Admin)
- Deskripsi A02 sampai A09, U03, X01
- Deskripsi A05 Memperpanjang pinjaman dan X02 Cek syarat perpanjangan
- Panduan menulis `design.md` bagian pengaturan user
- Daftar keputusan yang harus dikunci, dengan usulan default
- Label sumber: **[D]** dari dokumen 1.2, **[U]** usulan, **[K]** keputusan terbuka

### B8. Wireframe Anggota (Tugas 1.6)

Wireframe dibuat dengan Google Stitch dan sudah selesai. Langkah berikutnya:

1. Cek kelengkapan halaman terhadap dokumen 1.2, termasuk kondisi normal, kosong, dan error.
2. Cocokkan setiap tombol dengan use case.
3. Simpan hasil ke `docs/wireframe-anggota/` atau catat link Stitch di `design-anggota.md`.
4. Minta review Varely (alur akun) dan Rico (peminjaman dan denda).
5. Setelah disetujui, gunakan sebagai acuan layout 4.1.

### B9. Alur Pengerjaan Minggu 1 sampai 4

**Minggu 1: Desain dan basis data**
- Pua: tutup 1.7, merge 1.5, wireframe anggota (1.6), kerangka layout (4.1 tahap awal)
- Varely: ERD (1.3), migration dan seeder (2.1)
- Rico: flowchart peminjaman, pengembalian, dan denda (1.4), wireframe petugas (1.6)

**Minggu 2: Fitur dasar dan login**
- Pua: layout 4.1 lengkap, login dan pembatasan akses (4.2), beranda, katalog, detail buku (4.3 dan 4.4)
- Varely: modul buku, data master, anggota, dan petugas
- Rico: peminjaman baru dan pengembalian dengan denda otomatis

**Minggu 3: Integrasi**
- Pua: peminjaman saya dengan perpanjang (4.5), riwayat dan denda (4.6), notifikasi, profil, kartu (4.7), mulai panduan pengguna (5.4)
- Varely: koreksi peminjaman (2.6), pengaturan sistem (2.7), dashboard dan laporan Admin
- Rico: perpanjangan (3.5), pembayaran denda, dashboard dan laporan harian
- Aturan: perpanjangan Anggota (A05) dan Petugas (X09) memakai validasi X02 yang sama

**Minggu 4: Pengujian dan demo**
- Pua: uji dan perbaiki modul anggota (4.8), laporan akhir dan panduan (5.4), merge `develop` ke `main`
- Varely dan Rico: uji silang dan perbaikan bug (5.2, 5.3)
- Semua: demo (5.5)

### B10. Pekerjaan yang Masih Tersisa

**Minggu 1, masih terbuka:**
- Undang Varely dan Rico sebagai collaborator dengan izin Write (Settings → Collaborators)
- Tentukan framework CSS, lalu isi placeholder di README
- Varely dan Rico uji clone dan `php artisan serve`
- Review dan merge pull request 1.5
- Finalkan wireframe anggota dan simpan hasilnya
- ERD, flowchart, dan migration dari Varely dan Rico

**Keputusan yang harus dikunci:**
- Registrasi mandiri dengan atau tanpa persetujuan petugas
- Nomor anggota diterbitkan saat daftar atau saat disetujui
- Field registrasi dan profil
- Aturan password dan kebijakan lupa password
- Batas percobaan login salah
- Apakah katalog bisa dilihat tanpa login
- Aturan hapus anggota
- Reservasi buku (X01)
- Framework CSS

### B11. Keputusan Tim yang Sudah Disepakati

- Cara kerja (1.1) dan analisis kebutuhan (1.2) sudah disetujui.
- Troubleshooting dilakukan setelah tiap bagian selesai, bukan di awal.
- Setiap anggota membuat bagiannya masing-masing dulu.

### B12. Urutan Langkah Berikutnya

1. Tutup 1.7: undangan collaborator dan konfirmasi clone oleh Varely dan Rico.
2. Review dan merge pull request 1.5.
3. Finalkan wireframe anggota, lalu simpan hasilnya.
4. Tulis `design-anggota.md` dengan label **[D]**, **[U]**, dan **[K]**.
5. Mulai kerangka layout 4.1 dari wireframe yang sudah disetujui.
