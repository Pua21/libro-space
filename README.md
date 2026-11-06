# Libro Space

Sistem Informasi Perpustakaan berbasis web.

## Teknologi

- PHP 8.5.12
- Laravel 12
- Composer 2.11.1
- MySQL 8.0.30 (Laragon)
- HTML, CSS, JavaScript (Ajax)
- Framework CSS: <isi setelah diputuskan tim>
- Figma untuk perancangan

## Persyaratan

- PHP 8.2 atau lebih baru
- Composer
- MySQL (Laragon atau XAMPP)
- Git

## Instalasi

1. Clone repositori dan pindah ke branch develop:

```
git clone https://github.com/Pua21/libro-space.git
cd libro-space
git checkout develop
```

2. Instal dependensi:

```
composer install
```

3. Salin konfigurasi:

```
copy .env.example .env
```

4. Buat kunci aplikasi:

```
php artisan key:generate
```

5. Buat database `libro_space` dengan collation `utf8mb4_unicode_ci`.

6. Sesuaikan nilai `DB_*` di file `.env`, lalu pastikan `DB_CONNECTION=mysql`.

7. Jalankan server:

```
php artisan serve
```

## Struktur Folder

- `resources/views/layouts/`: layout induk dan layout per role
- `resources/views/partials/`: navbar, sidebar, footer, alert
- `resources/views/components/`: komponen bersama
- `resources/views/admin/`: halaman role Admin
- `resources/views/petugas/`: halaman role Petugas
- `resources/views/anggota/`: halaman role Anggota
- `public/css/`: stylesheet
- `public/js/`: script

## Branch

- `main`: versi stabil untuk demo dan presentasi
- `develop`: hasil integrasi harian
- `feature/<nama-modul>`: pekerjaan masing-masing anggota

## Aturan Kontribusi

- Semua perubahan masuk ke `develop` lewat pull request.
- Minimal satu anggota lain melakukan review sebelum merge.
- Merge hanya dilakukan jika `php artisan serve` berjalan tanpa error.
- Format commit: `tipe(modul): ringkasan`, dengan tipe `feat`, `fix`, `docs`, `style`, `refactor`, atau `chore`.

## Anggota Tim

- Varely S. Anchieta (24.N1.0034): Admin
- Rafael Rico K (24.N1.0005): Petugas
- Ignatius Papuandri M. (24.N1.0039): Anggota