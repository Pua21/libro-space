# Libro Space — design.md untuk Google Stitch

**Role:** Anggota (layanan mandiri) · **Platform default:** Mobile 390 × 844 · **Bahasa UI:** Indonesia

Sumber: `deskripsi-use-case-anggota.md`. Label sumber aturan: **[D]** disetujui, **[U]** usulan, **[K]** keputusan terbuka.

---

## 0. Cara Pakai

1. Di Stitch, pilih mode **Mobile**. Untuk versi web, lihat Bagian 7.
2. Tempel **Bagian 1 (Prompt Global)** bersama prompt layar **S01** pada generate pertama.
3. Untuk layar berikutnya, tempel **satu prompt layar per generate** (Bagian 3). Jangan gabungkan beberapa layar dalam satu prompt, karena hasilnya kurang konsisten.
4. Jika Stitch di akunmu mendukung impor DESIGN.md atau design system, Bagian 1 bisa dipakai sebagai isinya. Jika tidak, cukup tempel sebagai teks prompt.
5. Setelah semua layar jadi, jalankan **Bagian 5 (Checklist)**, lalu export ke Figma.
6. Pasang interaksi antarlayar di Figma mengikuti **Bagian 2 (Peta Navigasi)**.

---

## 1. Prompt Global (tempel pertama kali)

```
PROYEK
Libro Space adalah sistem perpustakaan. Buat wireframe mid-fidelity yang INTERAKTIF untuk satu role saja: ANGGOTA (layanan mandiri). Jangan membuat layar Petugas atau Admin.

ATURAN PERAN (penting)
- Anggota hanya melihat dan mengelola akunnya sendiri: login, registrasi, profil, katalog, detail buku, pinjaman aktif, perpanjang, riwayat, denda, notifikasi, kartu anggota digital.
- Anggota TIDAK bisa meminjam, mengembalikan, atau membayar denda lewat aplikasi. Semua itu diproses petugas di perpustakaan. Jangan buat tombol "Pinjam" atau "Bayar".
- Fitur opsional: Reservasi buku. Beri nama layernya berawalan "opsional/".

PLATFORM & FRAME
- Mobile-first, frame 390 x 844 px, portrait.
- Grid 4 kolom, margin 16 px, jarak antarelemen kelipatan 8 px.
- Satu layar = satu frame bernama "Sxx – Nama Layar" (nama diberikan di tiap prompt layar).

FIDELITY
- Mid-fidelity wireframe: fokus pada tata letak, hierarki, dan komponen. Hanya satu warna aksen + warna status.
- Sampul buku dan foto = kotak abu-abu dengan ikon gambar.
- Tanpa ilustrasi dekoratif, gradasi, blur, atau bayangan tebal. Pakai warna solid dan border 1 px.

WARNA
- Primary #3949AB, Primary-container #E8EAF6
- Background #F7F8FA, Surface #FFFFFF, Border #E0E3E8
- Teks utama #1F2430, teks sekunder #5F6675
- Sukses / Tersedia / Lunas / Aktif: teks #2E7D32 di latar #E8F5E9
- Peringatan / Dipinjam / Menunggu: teks #B26A00 di latar #FFF3E0
- Bahaya / Terlambat / Error / Belum lunas: teks #C62828 di latar #FFEBEE
- Info: teks #1565C0 di latar #E3F2FD

TIPOGRAFI
- Font Inter. H1 24/32 SemiBold, H2 20/28 SemiBold, Title 16/24 SemiBold, Body 14/20 Regular, Caption 12/16 Medium.

KOMPONEN (struktur dan ukuran identik di semua layar)
- Tombol: Primary (isi #3949AB, teks putih, tinggi 48, radius 12, penuh lebar), Secondary (outline), Text button. State: default, pressed, disabled, loading.
- Input: tinggi 48, radius 8, label di atas, helper atau pesan error di bawah. State: default, fokus, error, disabled (latar abu + ikon gembok).
- Badge status: pill tinggi 24, radius 12, teks Caption. Varian: Tersedia, Dipinjam, Terlambat, Lunas, Belum lunas, Menunggu persetujuan, Aktif.
- Kartu buku (grid): sampul rasio 2:3, judul maksimal 2 baris, pengarang 1 baris, badge status.
- Item buku (list): thumbnail 56 x 84, judul, info, badge.
- App bar: tinggi 56, panah kembali + judul.
- Segmented control: 3 segmen, tinggi 40.
- Chip filter: tinggi 32, radius 16. Aktif = latar Primary-container + teks Primary.
- Bottom navigation: tinggi 64, 5 tab (Beranda, Katalog, Pinjaman, Notifikasi, Profil). Tab aktif = ikon terisi + label Primary. Tab Notifikasi punya badge angka.
- Bottom sheet: radius atas 24, handle bar, scrim hitam 40%.
- Dialog: radius 16, lebar 326.
- Toast: melayang di atas bottom navigation.
- Empty state: ikon 48 + judul + deskripsi singkat.

NAVIGASI
- Bottom navigation hanya tampil di layar utama tiap tab (Beranda, Katalog, Pinjaman, Notifikasi, Profil).
- Bottom navigation disembunyikan di login, registrasi, detail buku, formulir, kartu anggota, dan semua overlay.
- Tab "Pinjaman" memuat tiga layar yang berpindah lewat segmented control: Aktif | Riwayat | Denda.

INTERAKSI
- Setiap elemen yang bisa diketuk (tombol, tautan, kartu, chip, tab, ikon) harus tampak bisa diketuk dan punya tujuan jelas.
- Sediakan state: default, pressed, disabled, fokus dan error (input), loading (tombol), skeleton (daftar).
- Overlay (bottom sheet, dialog) tampil di atas layar induk dengan scrim.
- Panah kembali di app bar kembali ke layar sebelumnya.

SIAP-FIGMA
- Semua teks berupa teks asli (bisa diedit), bukan gambar.
- Susun elemen dengan auto layout (vertikal dan horizontal), hindari posisi absolut berlebihan.
- Beri nama layer deskriptif berpola "komponen/varian", misalnya "btn/primary", "card/buku", "badge/terlambat", "nav/bottom", "input/password".
- Satu set ikon saja (Material Symbols Rounded, 24 px), berupa vektor.
- Komponen yang sama harus identik antarlayar agar mudah dijadikan component di Figma.

BAHASA & NADA
- Seluruh teks UI dalam Bahasa Indonesia, ramah dan ringkas, menyapa dengan "Anda".

DATA DUMMY (pakai konsisten di semua layar)
- "Hari ini" = 8 Nov 2026. Tarif denda dummy Rp 1.000 per hari. Batas perpanjangan 2 kali, lama perpanjangan 7 hari.
- Anggota: Rina Maharani, No. Anggota LS-2025-0142, status Aktif, terdaftar 14 Jan 2025. Alamat: Jl. Melati No. 12, Bandung. Telepon 0812-3456-7890. Email rina.maharani@email.com.
- Pinjaman aktif (3):
  1) Filosofi Teras - Henry Manampiring, jatuh tempo 12 Nov 2026 (4 hari lagi), diperpanjang 0/2.
  2) Atomic Habits - James Clear, jatuh tempo 9 Nov 2026 (Besok), diperpanjang 2/2.
  3) Bumi Manusia - Pramoedya Ananta Toer, jatuh tempo 6 Nov 2026, Terlambat 2 hari.
- Riwayat: Cantik Itu Luka - Eka Kurniawan (pinjam 10 Okt, kembali 24 Okt 2026, terlambat 3 hari); Laskar Pelangi - Andrea Hirata (2 Sep - 14 Sep 2026, tepat waktu); Sapiens - Yuval Noah Harari (15 Agu - 29 Agu 2026, tepat waktu).
- Katalog: Laskar Pelangi (Tersedia), Filosofi Teras (Tersedia), Cantik Itu Luka (Tersedia), Atomic Habits (Dipinjam), Sapiens (Dipinjam), Negeri 5 Menara - A. Fuadi (Dipinjam).
- Denda: 2 denda sudah Lunas (Rp 3.000 dan Rp 1.000). Total denda belum lunas Rp 0.
- Kontak perpustakaan dummy: (021) 555-0123.
```

---

## 2. Peta Navigasi (daftar "kabel" untuk prototype di Figma)

| Dari | Elemen | Ke | Jenis |
|---|---|---|---|
| S01 Login | Masuk | S06 Beranda | Navigate |
| S01 | Lupa password? | S03 Lupa Password | Open overlay |
| S01 | Daftar sekarang | S04 Registrasi | Navigate |
| S02 Login Error | (frame referensi, sama seperti S01) | — | Opsional: hubungkan Masuk ke S02 untuk demo error |
| S03 Lupa Password | Mengerti / ✕ | S01 | Close overlay |
| S04 Registrasi | Kirim Pendaftaran | S05 Terkirim | Navigate |
| S04 | Tautan Masuk / panah kembali | S01 | Navigate / Back |
| S05 Terkirim | Kembali ke Login | S01 | Navigate |
| S06 Beranda | Ikon lonceng | S16 Notifikasi | Navigate |
| S06 | Lihat semua / kartu pinjaman | S10 Peminjaman Saya | Navigate |
| S06 | Aksi cepat Kartu Anggota | S20 Kartu Anggota | Navigate |
| S06 | Aksi cepat Cari Buku | S07 Katalog | Navigate |
| S06 | Kartu buku (Baru/Populer) | S08 Detail Buku | Navigate |
| S07 Katalog | Kartu buku | S08 | Navigate |
| S08 Detail Buku | Panah kembali | S07 | Back |
| S08 | Reservasi Buku (opsional) | S09 Reservasi | Open overlay |
| S08 | Tampilkan Kartu Anggota | S20 | Navigate |
| S09 Reservasi | Reservasi / Batal | S08 | Close overlay |
| S10 Peminjaman Saya | Segmen Riwayat / Denda | S14 / S15 | Navigate (tanpa animasi) |
| S10 | Perpanjang (Filosofi Teras) | S11 Konfirmasi | Open overlay |
| S10 | Perpanjang (Atomic Habits) | S13 Ditolak | Open overlay |
| S10 | Perpanjang (Bumi Manusia) | S13 Ditolak | Open overlay (teks alasan diganti, lihat S13) |
| S11 Konfirmasi | Konfirmasi Perpanjang | S12 Berhasil | Swap overlay |
| S11 | Batal | S10 | Close overlay |
| S12 Berhasil | Selesai | S10 | Close overlay |
| S13 Ditolak | Mengerti | S10 | Close overlay |
| S14 Riwayat | Segmen Aktif / Denda | S10 / S15 | Navigate |
| S15 Denda | Segmen Aktif / Riwayat | S10 / S14 | Navigate |
| S16 Notifikasi | Notifikasi jatuh tempo / terlambat | S10 | Navigate |
| S17 Profil | Kartu Anggota | S20 | Navigate |
| S17 | Edit Profil | S18 | Navigate |
| S17 | Ubah Password | S19 | Navigate |
| S17 | Keluar | S01 | Navigate |
| S18 Edit Profil | Simpan / panah kembali | S17 | Navigate / Back |
| S19 Ubah Password | Simpan / panah kembali | S17 | Navigate / Back |
| S20 Kartu Anggota | Panah kembali | Layar sebelumnya | Back |
| **Bottom nav** | Beranda · Katalog · Pinjaman · Notifikasi · Profil | S06 · S07 · S10 · S16 · S17 | Navigate |

---

## 3. Prompt per Layar

> Satu layar per generate. Kode di dalam kurung adalah use case (lihat `use-case-anggota.md`) dan label sumber aturan.

### S01 — Login (U01) [D: nomor anggota, U: pesan]

```
Lanjutkan proyek Libro Space (Anggota), gunakan design system & data dummy yang sama.
Buat layar "S01 – Login". Tanpa bottom nav.
- Atas: logo Libro Space (kotak logo placeholder + wordmark), judul H1 "Masuk ke Libro Space", subjudul "Gunakan nomor anggota Anda".
- Form: input "Nomor Anggota" (placeholder LS-2025-0142), input "Password" dengan ikon tampilkan/sembunyikan, tautan "Lupa password?" rata kanan.
- Tombol Primary penuh lebar "Masuk" (state default, loading, disabled saat form kosong).
- Pemisah tipis, lalu teks "Belum punya akun?" + tautan "Daftar sekarang".
Interaksi: Masuk -> Beranda; Lupa password? -> bottom sheet Lupa Password; Daftar sekarang -> Registrasi.
```

### S02 — Login, Pesan Error (U01 · A1) [U]

```
Lanjutkan proyek Libro Space (Anggota), gunakan design system & data dummy yang sama.
Buat layar "S02 – Login Error": salinan persis layar "S01 – Login", tetapi dengan banner error merah di atas form (ikon peringatan + teks "Nomor anggota atau password salah"). Kedua input diberi garis merah. Pesan harus umum, tidak menyebut mana yang salah. Tombol Masuk tetap aktif.
```

Varian pesan untuk diganti manual di Figma (duplikat frame S02):

| Kondisi | Teks banner | Label |
|---|---|---|
| Akun nonaktif | "Akun Anda nonaktif. Silakan hubungi petugas perpustakaan." | [D] status, [U] pesan |
| Belum disetujui | "Pendaftaran Anda masih menunggu persetujuan petugas." | [K] |
| Terkunci sementara | "Terlalu banyak percobaan. Coba lagi dalam 15 menit." | [K] default 5 kali / 15 menit |

### S03 — Lupa Password (kebijakan U01) [K]

```
Lanjutkan proyek Libro Space (Anggota), gunakan design system & data dummy yang sama.
Buat layar "S03 – Lupa Password": layar "S01 – Login" yang diredupkan dengan scrim, ditumpuk bottom sheet.
- Handle bar, tombol tutup (X) di kanan atas.
- Ikon kunci, judul Title "Lupa password?", teks: "Saat ini reset password dilakukan oleh petugas. Datang ke meja petugas dengan membawa identitas, atau hubungi (021) 555-0123."
- Tombol Primary "Mengerti".
```

### S04 — Registrasi Akun (A01) [D: ada persetujuan petugas, K: field]

```
Lanjutkan proyek Libro Space (Anggota), gunakan design system & data dummy yang sama.
Buat layar "S04 – Registrasi Akun". Tanpa bottom nav. App bar: panah kembali + "Daftar Akun".
- Banner info (biru) di atas: "Pendaftaran akan diverifikasi petugas. Nomor anggota diterbitkan setelah pendaftaran disetujui."
- Form: Nama lengkap, Alamat (multiline), Nomor telepon, Email, Password (ikon tampilkan; helper "Minimal 8 karakter, kombinasi huruf dan angka"), Konfirmasi password.
- Checkbox "Saya menyetujui ketentuan perpustakaan".
- Tombol Primary "Kirim Pendaftaran" (disabled sampai form terisi dan checkbox dicentang).
- Teks "Sudah punya akun?" + tautan "Masuk".
Tampilkan layar dalam state default (tanpa error).
Interaksi: Kirim Pendaftaran -> Pendaftaran Terkirim; Masuk -> Login.
```

### S05 — Pendaftaran Terkirim (A01 · alur utama)

```
Lanjutkan proyek Libro Space (Anggota), gunakan design system & data dummy yang sama.
Buat layar "S05 – Pendaftaran Terkirim". Tanpa bottom nav dan tanpa app bar.
- Ikon centang dalam lingkaran hijau, judul H1 "Pendaftaran terkirim", deskripsi "Petugas akan memverifikasi data Anda. Anda akan diberi tahu setelah akun disetujui."
- Stepper vertikal 3 langkah: "Pendaftaran terkirim" (selesai), "Verifikasi petugas" (sedang berjalan, badge Menunggu persetujuan), "Akun aktif dan nomor anggota terbit" (belum).
- Tombol Primary "Kembali ke Login".
```

### S06 — Beranda (A02) [D]

```
Lanjutkan proyek Libro Space (Anggota), gunakan design system & data dummy yang sama.
Buat layar "S06 – Beranda". Bottom nav: tab Beranda aktif.
- Header: avatar inisial "RM", teks "Halo, Rina" + subteks "Selamat datang kembali", ikon lonceng dengan badge "2" di kanan.
- Dua kartu pengingat: kuning "Atomic Habits jatuh tempo besok", merah "Bumi Manusia terlambat 2 hari".
- Kartu "Pinjaman aktif" berisi 3 baris (judul + chip sisa hari: 4 hari lagi, Besok, Terlambat) dan tautan "Lihat semua".
- Dua aksi cepat berdampingan: "Kartu Anggota" (ikon QR) dan "Cari Buku" (ikon cari).
- Bagian "Buku Baru": carousel horizontal 4 kartu buku kecil dengan badge.
- Bagian "Buku Populer": 3 item list bernomor 1-3 dengan thumbnail, judul, pengarang.
Interaksi: lonceng -> Notifikasi; Lihat semua -> Peminjaman Saya; Kartu Anggota -> Kartu Anggota; Cari Buku -> Katalog; kartu buku -> Detail Buku.
```

### S07 — Katalog Buku (U03) [D]

```
Lanjutkan proyek Libro Space (Anggota), gunakan design system & data dummy yang sama.
Buat layar "S07 – Katalog Buku". Bottom nav: tab Katalog aktif.
- Judul H1 "Katalog Buku". Search bar dengan placeholder "Cari judul, pengarang, atau kategori" dan tombol hapus saat ada teks.
- Baris chip "Cari di:" Judul (aktif) | Pengarang | Kategori.
- Baris chip kategori yang bisa digulir: Semua (aktif), Fiksi, Non-fiksi, Teknologi, Sains, Sejarah.
- Teks "6 buku ditemukan".
- Grid 2 kolom berisi 6 kartu buku sesuai data dummy katalog, masing-masing dengan badge Tersedia atau Dipinjam.
Interaksi: kartu buku -> Detail Buku; chip bisa dipilih dan menampilkan state aktif.
```

### S08 — Detail Buku (A03) [D; tombol reservasi K]

```
Lanjutkan proyek Libro Space (Anggota), gunakan design system & data dummy yang sama.
Buat layar "S08 – Detail Buku" untuk buku "Sapiens" (status Dipinjam). Tanpa bottom nav. App bar: panah kembali + judul "Detail Buku".
- Sampul besar (kotak abu-abu 2:3) di tengah, judul H2 "Sapiens: Riwayat Singkat Umat Manusia", pengarang Yuval Noah Harari, badge Dipinjam.
- Kartu info: Penerbit (KPG), Tahun (2017), Halaman (527), ISBN (dummy), Kategori (Sejarah).
- Ketersediaan: "0 dari 2 eksemplar tersedia". Lokasi rak: "Rak C-2, Lantai 1" dengan ikon pin.
- Sinopsis (3 baris + tautan "Selengkapnya" yang bisa diperluas).
- Kotak info (biru): "Peminjaman diproses oleh petugas di perpustakaan. Tunjukkan Kartu Anggota Anda." + tautan "Tampilkan Kartu Anggota".
- Tombol Secondary "Reservasi Buku" di bagian bawah (beri nama layer "opsional/btn-reservasi"). Jangan buat tombol Pinjam.
Interaksi: Reservasi Buku -> bottom sheet Reservasi; Tampilkan Kartu Anggota -> Kartu Anggota.
```

### S09 — Reservasi Buku (X01, opsional) [K]

```
Lanjutkan proyek Libro Space (Anggota), gunakan design system & data dummy yang sama.
Buat layar "S09 – Reservasi Buku": layar "S08 – Detail Buku" yang diredupkan, ditumpuk bottom sheet.
- Judul "Reservasi buku ini?", teks "Anda akan masuk antrean ke-2 untuk Sapiens. Kami akan memberi tahu saat buku tersedia."
- Tombol Primary "Reservasi", tombol Text "Batal".
Beri nama semua layer berawalan "opsional/".
```

### S10 — Peminjaman Saya (A04) [D; label Terlambat U]

```
Lanjutkan proyek Libro Space (Anggota), gunakan design system & data dummy yang sama.
Buat layar "S10 – Peminjaman Saya". Bottom nav: tab Pinjaman aktif.
- Judul H1 "Pinjaman". Segmented control: Aktif (terpilih) | Riwayat | Denda.
- Ringkasan: "3 buku sedang dipinjam".
- 3 kartu pinjaman sesuai data dummy. Tiap kartu: thumbnail, judul, pengarang, "Jatuh tempo 12 Nov 2026", chip sisa hari (4 hari lagi = hijau, Besok = kuning, Terlambat 2 hari = merah), teks "Diperpanjang 0/2", tombol Secondary "Perpanjang".
- Kartu Bumi Manusia diberi garis merah tipis.
Interaksi: Perpanjang (Filosofi Teras) -> bottom sheet Konfirmasi Perpanjang; Perpanjang (Atomic Habits dan Bumi Manusia) -> dialog Perpanjang Ditolak; segmen Riwayat dan Denda pindah layar.
```

### S11 — Konfirmasi Perpanjang (A05) [D]

```
Lanjutkan proyek Libro Space (Anggota), gunakan design system & data dummy yang sama.
Buat layar "S11 – Konfirmasi Perpanjang": layar "S10 – Peminjaman Saya" yang diredupkan, ditumpuk bottom sheet.
- Judul "Perpanjang pinjaman?", item buku Filosofi Teras (thumbnail + judul).
- Dua baris perbandingan: "Jatuh tempo saat ini: 12 Nov 2026" dan "Jatuh tempo baru: 19 Nov 2026 (+7 hari)". Teks kecil "Perpanjangan ke-1 dari 2".
- Tombol Primary "Konfirmasi Perpanjang", tombol Text "Batal".
```

### S12 — Perpanjang Berhasil (A05)

```
Lanjutkan proyek Libro Space (Anggota), gunakan design system & data dummy yang sama.
Buat layar "S12 – Perpanjang Berhasil": layar "S10 – Peminjaman Saya" yang diredupkan, ditumpuk dialog.
- Ikon centang hijau, judul "Perpanjangan berhasil", teks "Jatuh tempo baru Filosofi Teras: 19 Nov 2026."
- Tombol Primary "Selesai".
```

### S13 — Perpanjang Ditolak (X02) [D/U/K]

```
Lanjutkan proyek Libro Space (Anggota), gunakan design system & data dummy yang sama.
Buat layar "S13 – Perpanjang Ditolak": layar "S10 – Peminjaman Saya" yang diredupkan, ditumpuk dialog.
- Ikon peringatan merah, judul "Tidak bisa diperpanjang", SATU alasan utama: "Batas perpanjangan sudah tercapai (2 dari 2 kali)."
- Tombol Primary "Mengerti".
```

Teks alasan untuk diganti manual di Figma, urut sesuai prioritas X02. Hanya satu alasan yang ditampilkan.

| No | Alasan | Label |
|---|---|---|
| 1 | "Akun Anda tidak aktif. Hubungi petugas." | [U] |
| 2 | "Masih ada denda yang belum lunas. Selesaikan pembayaran di petugas." | [U] |
| 3 | "Batas perpanjangan sudah tercapai (2 dari 2 kali)." | [D] |
| 4 | "Pinjaman sudah terlambat. Segera kembalikan buku ke petugas." | [U] |
| 5 | "Buku ini sedang direservasi anggota lain." | [K] tergantung X01 |

### S14 — Riwayat Peminjaman (A06) [D]

```
Lanjutkan proyek Libro Space (Anggota), gunakan design system & data dummy yang sama.
Buat layar "S14 – Riwayat Peminjaman". Bottom nav: tab Pinjaman aktif.
- Judul H1 "Pinjaman". Segmented control: Aktif | Riwayat (terpilih) | Denda.
- Chip filter: Semua (aktif), Tepat waktu, Terlambat.
- Daftar dikelompokkan per bulan (Oktober 2026, September 2026, Agustus 2026) berisi 3 item riwayat sesuai data dummy: thumbnail, judul, "Dipinjam 10 Okt 2026 · Kembali 24 Okt 2026", badge "Dikembalikan" (hijau) atau "Dikembalikan terlambat" (merah).
```

### S15 — Denda Saya (A07) [D]

```
Lanjutkan proyek Libro Space (Anggota), gunakan design system & data dummy yang sama.
Buat layar "S15 – Denda Saya". Bottom nav: tab Pinjaman aktif.
- Judul H1 "Pinjaman". Segmented control: Aktif | Riwayat | Denda (terpilih).
- Kartu ringkasan hijau: "Denda belum lunas Rp 0", teks "Tidak ada denda yang harus dibayar".
- Bagian "Rincian Denda": 2 item. Item 1: Cantik Itu Luka, "Terlambat 3 hari x Rp 1.000", nominal Rp 3.000, badge Lunas, "Dibayar 24 Okt 2026". Item 2: Laskar Pelangi, "Terlambat 1 hari x Rp 1.000", Rp 1.000, badge Lunas.
- Kotak info: "Pembayaran denda dilakukan di petugas perpustakaan." Jangan buat tombol Bayar.
```

### S16 — Notifikasi (A08) [D; tandai dibaca U]

```
Lanjutkan proyek Libro Space (Anggota), gunakan design system & data dummy yang sama.
Buat layar "S16 – Notifikasi". Bottom nav: tab Notifikasi aktif (badge 2).
- Judul H1 "Notifikasi" dan tombol Text "Tandai semua dibaca" di kanan.
- Grup "Hari ini": (1) ikon jam kuning, "Atomic Habits jatuh tempo besok (9 Nov 2026)", belum dibaca (titik biru); (2) ikon peringatan merah, "Bumi Manusia terlambat 2 hari. Segera kembalikan ke petugas.", belum dibaca.
- Grup "Kemarin": (3) ikon bookmark, "Reservasi Negeri 5 Menara berhasil. Anda di antrean ke-2.", sudah dibaca.
- Grup "Minggu lalu": (4) ikon centang, "Pendaftaran Anda disetujui. Nomor anggota: LS-2025-0142.", sudah dibaca.
Interaksi: notifikasi 1 dan 2 -> Peminjaman Saya.
```

### S17 — Profil (U02) [D]

```
Lanjutkan proyek Libro Space (Anggota), gunakan design system & data dummy yang sama.
Buat layar "S17 – Profil". Bottom nav: tab Profil aktif.
- Header: avatar inisial besar "RM", nama "Rina Maharani", "LS-2025-0142", badge Aktif.
- Kartu "Informasi akun": Alamat, Telepon, Email, Tanggal daftar (14 Jan 2025).
- Daftar menu dengan ikon dan chevron: Kartu Anggota, Edit Profil, Ubah Password.
- Tombol Text merah "Keluar" di bagian bawah.
Interaksi: Kartu Anggota -> Kartu Anggota; Edit Profil -> Edit Profil; Ubah Password -> Ubah Password; Keluar -> Login.
```

### S18 — Edit Profil (U02) [K field, U read-only]

```
Lanjutkan proyek Libro Space (Anggota), gunakan design system & data dummy yang sama.
Buat layar "S18 – Edit Profil". Tanpa bottom nav. App bar: panah kembali + "Edit Profil".
- Bagian bisa diubah: Nama lengkap, Alamat, Nomor telepon, Email (terisi data dummy).
- Bagian tidak bisa diubah (state disabled + ikon gembok): Nomor anggota, Tanggal daftar, Status keanggotaan, dengan teks bantu "Hubungi petugas untuk mengubah data ini."
- Tombol Primary "Simpan" di bawah.
Interaksi: Simpan -> Profil dengan toast "Profil berhasil disimpan".
```

### S19 — Ubah Password (U02) [K aturan, U lainnya]

```
Lanjutkan proyek Libro Space (Anggota), gunakan design system & data dummy yang sama.
Buat layar "S19 – Ubah Password". Tanpa bottom nav. App bar: panah kembali + "Ubah Password".
- Tiga input password dengan ikon tampilkan/sembunyikan: Password lama, Password baru, Konfirmasi password baru.
- Checklist aturan di bawah input baru: "Minimal 8 karakter", "Kombinasi huruf dan angka", "Berbeda dari password lama".
- Kotak info: "Setelah password diganti, Anda akan keluar dari perangkat lain."
- Tombol Primary "Simpan Password".
Interaksi: Simpan Password -> Profil dengan toast "Password berhasil diubah".
```

### S20 — Kartu Anggota Digital (A09) [D; tanda nonaktif U]

```
Lanjutkan proyek Libro Space (Anggota), gunakan design system & data dummy yang sama.
Buat layar "S20 – Kartu Anggota". Tanpa bottom nav. App bar: panah kembali + "Kartu Anggota".
- Satu kartu vertikal berlatar Primary-container, border 1 px: logo Libro Space di atas, avatar placeholder, nama "Rina Maharani", "LS-2025-0142", badge Aktif.
- Di bawah kartu: QR code besar (placeholder) dengan barcode kecil di bawahnya.
- Teks: "Tunjukkan kartu ini kepada petugas saat meminjam atau mengembalikan buku."
```

---

## 4. Varian State (opsional, untuk kelengkapan skenario uji)

Gunakan template ini untuk membuat varian dari layar yang sudah jadi:

```
Lanjutkan proyek Libro Space (Anggota), gunakan design system & data dummy yang sama.
Buat varian dari layar "<NAMA LAYAR>" dengan state: <STATE>. Struktur dan komponen identik, hanya area <BAGIAN> yang diganti dengan <ISI>.
```

| Layar | State | Isi |
|---|---|---|
| S07 Katalog | Hasil kosong | Empty state "Tidak ada buku ditemukan" + saran ubah kata kunci |
| S10 / S14 / S15 / S16 | Kosong | Empty state: "Belum ada pinjaman" / "Belum ada riwayat" / "Tidak ada denda" / "Belum ada notifikasi" |
| Semua daftar | Loading | Skeleton |
| Semua daftar | Gagal memuat | Pesan error + tombol "Coba lagi" |
| S04 Registrasi | Error validasi | Garis merah per field, email "sudah terdaftar. Hubungi petugas." |
| S08 Detail Buku | Tersedia | Badge Tersedia, "2 dari 3 eksemplar tersedia", tombol reservasi disembunyikan |
| S15 Denda | Ada denda belum lunas | Kartu ringkasan merah "Rp 3.000 belum lunas", item badge Belum lunas |
| S13 Ditolak | Alasan denda | Teks alasan no. 2 + tombol Secondary "Lihat Denda Saya" -> S15 |
| S20 Kartu | Akun nonaktif | Kartu abu-abu + badge "Tidak aktif" |

---

## 5. Checklist Sebelum dan Sesudah Export ke Figma

**Sebelum export (di Stitch)**
- [ ] Semua frame bernama `Sxx – Nama Layar`.
- [ ] Bottom navigation identik di S06, S07, S10, S14, S15, S16, S17.
- [ ] Teks tidak terpotong dan memakai font Inter.
- [ ] Tidak ada teks atau tombol yang menyatu dengan gambar.
- [ ] Tidak ada tombol Pinjam atau Bayar di layar mana pun.

**Sesudah export (di Figma)**
- [ ] Rapikan layer yang masih posisi absolut menjadi auto layout bila perlu.
- [ ] Ubah elemen berulang menjadi Component: bottom nav, app bar, badge, kartu buku, input, tombol.
- [ ] Buat segmented control Pinjaman sebagai component variant.
- [ ] Buka tab **Prototype**, atur **starting frame = S01**.
- [ ] Hubungkan semua elemen sesuai Bagian 2. Overlay memakai *Open overlay* (S03, S09, S11, S13), sisanya *Navigate to*.
- [ ] Uji dengan tombol Present, jalankan alur: Login → Beranda → Katalog → Detail → Pinjaman → Perpanjang → Profil → Kartu.

> Catatan: sepengetahuan saya, export Stitch ke Figma menghasilkan layer yang bisa diedit, tetapi tautan interaksi antarlayar tidak selalu ikut terbawa. Anggap Bagian 2 sebagai daftar kerja untuk memasang prototype di Figma. Cek fitur export versi Stitch yang kamu pakai.

---

## 6. Keputusan Terbuka yang Dipakai sebagai Default di Wireframe

| Keputusan | Default di wireframe | Label |
|---|---|---|
| Registrasi mandiri | Dengan persetujuan petugas | [D] |
| Nomor anggota terbit | Saat disetujui | [K] |
| Field registrasi dan profil | Nama, alamat, telepon, email | [K] |
| Aturan password | Minimal 8 karakter, huruf dan angka | [K] |
| Lupa password | Hubungi petugas (S03) | [K] |
| Batas login salah | 5 kali, dikunci 15 menit | [K] |
| Katalog tanpa login | Tidak, harus login | [K] |
| Reservasi buku (X01) | Dibuat tetapi diberi layer `opsional/` agar mudah dihapus | [K] |
| Login Anggota vs Petugas/Admin | Hanya layar Anggota (nomor anggota); satu atau dua halaman login belum diputuskan | [K] |

Jika X01 tidak disetujui: hapus S09, tombol reservasi di S08, dan alasan no. 5 di S13.

---

## 7. Versi Web (opsional)

Pilih mode Web/Desktop di Stitch, lalu ganti bagian PLATFORM, KOMPONEN, dan NAVIGASI di Prompt Global dengan:

```
- Web/desktop, frame 1440 x 1024, grid 12 kolom, margin 80, gutter 24, lebar konten maksimal 1200 px.
- Bottom navigation diganti top navbar horizontal (Beranda, Katalog, Pinjaman, Notifikasi, Profil) + menu avatar di kanan.
- Bottom sheet diganti modal di tengah layar. Katalog 4 kolom. Daftar pinjaman 2 kolom.
```
