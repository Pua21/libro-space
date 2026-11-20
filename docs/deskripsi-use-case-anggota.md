# Deskripsi Use Case Bagian Anggota

Dokumen ini adalah acuan untuk `design.md` bagian Anggota pada proyek Libro Space. Sumber use case adalah diagram `use-case-libro-space.drawio` (49 elemen, 51 relasi).

## Cakupan

Use case yang dibahas di dokumen ini adalah milik design Anggota:

- **U01** Login
- **U02** Kelola profil dan ubah password
- **U03** Melihat dan mencari katalog
- **A01** Registrasi akun mandiri
- **A02** sampai **A09** layanan anggota
- **X01** Reservasi buku (opsional)
- **X02** Cek syarat perpanjangan

Use case milik Petugas dan Admin (P, S, D, dan X03 sampai X11) hanya disebut sebagai dependensi. Penjelasannya ada di design masing-masing role.

## Label Sumber Aturan

Setiap aturan diberi label sumber agar jelas mana yang sudah disepakati dan mana yang belum.

| Label | Arti |
|---|---|
| **[D]** | Berasal dari dokumen 1.2 yang sudah disetujui |
| **[U]** | Usulan, belum disepakati tim |
| **[K]** | Keputusan terbuka, harus diputuskan sebelum `design.md` difinalkan |

---

## Bagian 1: Pengaturan Akun

### U01 Login

| Field | Isi |
|---|---|
| Aktor | Anggota. Diagram menempatkannya di aktor Pengguna, karena Petugas dan Admin juga login. |
| Tujuan | Masuk ke sistem dan diarahkan ke halaman sesuai role. |
| Kondisi awal | Akun sudah ada dan berstatus aktif. Halaman login bisa dibuka. |
| Pemicu | Pengguna membuka halaman login lalu mengirim form. |
| Input | Nomor anggota **[D]** dan password **[U]**. |
| Alur utama | 1. Sistem menerima nomor anggota dan password. 2. Sistem mencari akun berdasarkan nomor anggota. 3. Sistem memeriksa password dan status akun. 4. Sistem membuat sesi. 5. Pengguna diarahkan ke Beranda anggota. |
| Alur alternatif | **A1** Nomor atau password salah: tampilkan pesan umum "Nomor anggota atau password salah", tanpa menyebut mana yang salah **[U]**.<br>**A2** Akun nonaktif: login ditolak dan pesan meminta menghubungi petugas **[D]** untuk status nonaktif, pesan **[U]**.<br>**A3** Pendaftaran belum disetujui: login ditolak dengan pesan menunggu persetujuan **[K]**.<br>**A4** Salah berulang: akun dikunci sementara setelah sejumlah percobaan **[K]**.<br>**A5** Membuka halaman yang butuh login: diarahkan ke login, lalu kembali ke halaman semula setelah berhasil **[U]**. |
| Kondisi akhir | Sesi aktif dan pengguna berada di Beranda, atau pengguna tetap di halaman login dengan pesan. |
| Catatan | Ini kondisi awal untuk semua use case anggota. Diagram tidak menggambarnya sebagai `<<include>>`, dan itu disengaja. |

### U02 Kelola Profil dan Ubah Password

| Field | Isi |
|---|---|
| Aktor | Anggota. Petugas dan Admin juga memiliki fitur ini untuk profil mereka sendiri, tetapi di luar cakupan design Anggota. |
| Tujuan | Anggota memperbarui data diri dan mengganti password sendiri. |
| Kondisi awal | Sudah login. |
| Pemicu | Anggota membuka halaman Profil. |
| Data yang bisa diubah | Nama, alamat, nomor telepon, dan email **[K]**, daftar field menunggu keputusan tim. |
| Data yang tidak bisa diubah | Nomor anggota, tanggal daftar, status keanggotaan, dan riwayat transaksi **[U]**. |
| Alur utama (data diri) | 1. Anggota membuka Profil. 2. Sistem menampilkan data saat ini. 3. Anggota mengubah data lalu menekan Simpan. 4. Sistem memvalidasi. 5. Data tersimpan dan pesan sukses ditampilkan. |
| Alur utama (password) | 1. Anggota mengisi password lama, password baru, dan konfirmasi. 2. Sistem memeriksa password lama. 3. Sistem memeriksa kecocokan dan aturan password. 4. Password diperbarui. 5. Pesan sukses ditampilkan. |
| Aturan password | Panjang minimal dan kombinasi karakter **[K]**. Password baru tidak boleh sama dengan password lama **[U]**. |
| Alur alternatif | **A1** Password lama salah.<br>**A2** Konfirmasi tidak cocok.<br>**A3** Field wajib kosong.<br>**A4** Email sudah dipakai akun lain **[U]**. |
| Efek samping | Setelah password diganti, sesi di perangkat lain diakhiri **[U]**. |
| Kondisi akhir | Data atau password tersimpan, atau pesan kesalahan ditampilkan. |

### A01 Registrasi Akun Mandiri

| Field | Isi |
|---|---|
| Aktor | **Calon anggota**. Diagram saat ini menghubungkan A01 ke aktor Anggota, padahal calon anggota belum punya akun. Lihat bagian perbaikan diagram. |
| Tujuan | Calon anggota membuat akun sendiri. |
| Kondisi awal | Belum punya akun. Halaman registrasi bisa dibuka. |
| Dasar aturan | Dokumen 1.2 menyebut "registrasi mandiri dapat diaktifkan dengan persetujuan petugas" **[D]**. Registrasi mandiri ada, tetapi aktivasinya melalui persetujuan petugas. |
| Input | Data diri yang diperlukan untuk keanggotaan **[K]**, daftar field menunggu keputusan tim, serta password **[U]**. |
| Alur utama (usulan) | 1. Calon anggota mengisi form. 2. Sistem memvalidasi data. 3. Sistem membuat akun dengan status **Menunggu persetujuan**. 4. Petugas melihat daftar pendaftaran (P02). 5. Petugas menyetujui. 6. Status berubah menjadi **Aktif**, dan nomor anggota diterbitkan **[K]**, apakah saat daftar atau saat disetujui. 7. Calon anggota bisa login. |
| Alur alternatif | **A1** Data tidak valid: form menampilkan kesalahan per field.<br>**A2** Data sudah terdaftar: sistem menolak dan meminta pengguna menghubungi petugas **[K]**, kriteria duplikasi seperti NIK atau email.<br>**A3** Petugas menolak pendaftaran: akun tidak aktif, dan pemberitahuan dikirim lewat notifikasi **[K]**.<br>**A4** Jika registrasi akhirnya tanpa persetujuan, langkah 4 sampai 6 dihapus **[K]**. |
| Kondisi akhir | Akun berstatus Menunggu persetujuan atau Aktif, dan calon anggota mendapat pemberitahuan. |
| Ketergantungan | P02 (Petugas menyetujui registrasi). Diagram belum menghubungkan A01 dengan P02. |

### Status Akun

Acuan untuk seluruh bagian pengaturan user. Gunakan istilah ini secara konsisten di semua design.

```
[Daftar] → Menunggu persetujuan → Aktif ⇄ Nonaktif
                  ↓ ditolak                ↓ dihapus [K]
          (akun tidak dibuat)     (data dihapus atau diarsipkan)
```

- **Aktif** bisa login, meminjam, dan memperpanjang **[D]**.
- **Nonaktif** tidak bisa login. Admin mengatur status ini lewat D04 **[D]**.
- **Dihapus** hanya boleh jika tidak punya riwayat transaksi. Jika punya riwayat, cukup dinonaktifkan **[U]**.

### Siapa Mengatur Apa

| Tindakan | Anggota | Petugas | Admin |
|---|---|---|---|
| Mendaftar akun sendiri | A01 | — | — |
| Menyetujui pendaftaran | — | P02 | — |
| Mengubah data diri | U02 | S02, terbatas | D04 |
| Mengubah password sendiri | U02 | U02, profil staf | U02, profil staf |
| Reset password anggota yang lupa | Hubungi petugas **[K]** | **[K]** | D06 untuk petugas, **[K]** untuk anggota |
| Mengaktifkan atau menonaktifkan | — | — | D04 |
| Menghapus anggota | — | Tidak boleh **[D]**, hak akses "terbatas" | D04, **[K]** aturan hapus |
| Melihat kartu anggota | A09 | — | D05, cetak |

Catatan: hak akses dokumen 1.2 menulis Petugas "Kelola anggota: terbatas", tetapi tidak merinci batasnya. Tim perlu mendefinisikan batas itu. Usulan: Petugas boleh menambah dan mengubah data, tetapi tidak boleh menghapus atau mengubah status akun **[U]**.

---

## Bagian 2: Layanan Anggota

| ID | Nama | Alur utama | Alternatif | Kondisi akhir |
|---|---|---|---|---|
| **A02** | Melihat beranda **[D]** | Sistem menampilkan sapaan, ringkasan pinjaman aktif, pengingat jatuh tempo, buku baru, dan buku populer. | Tidak ada pinjaman: keadaan kosong. Gagal memuat: pesan error. | Beranda tampil lengkap atau dalam keadaan kosong. |
| **U03** | Melihat dan mencari katalog **[D]** | 1. Anggota membuka katalog. 2. Anggota mencari berdasarkan judul, pengarang, atau kategori. 3. Sistem menampilkan kartu buku dengan label Tersedia atau Dipinjam. | Hasil kosong: "Tidak ada buku ditemukan". Gagal memuat: pesan error. | Daftar buku tampil. |
| **A03** | Melihat detail buku **[D]** | Anggota memilih buku dari katalog. Sistem menampilkan sampul, sinopsis, data lengkap, jumlah tersedia, dan lokasi rak. | Buku tidak ditemukan atau sudah dihapus Admin (D02): tampil pesan. Jumlah tersedia nol: tombol reservasi tampil jika X01 disetujui **[K]**. | Detail buku tampil. |
| **A04** | Melihat peminjaman aktif **[D]** | Sistem menampilkan buku yang sedang dipinjam, tanggal jatuh tempo, sisa hari, dan tombol Perpanjang. | Tidak ada pinjaman: keadaan kosong. Buku terlambat: sisa hari bernilai negatif dan label Terlambat **[U]**. | Daftar pinjaman tampil. |
| **A06** | Melihat riwayat peminjaman **[D]** | Sistem menampilkan semua peminjaman sebelumnya, beserta status dan tanggal kembali. | Tidak ada riwayat: keadaan kosong. | Riwayat tampil. |
| **A07** | Melihat denda saya **[D]** | Sistem menampilkan rincian denda (buku, jumlah hari terlambat, nominal) dan status pembayaran. | Tidak ada denda: keadaan kosong. | Rincian denda tampil. |
| **A08** | Melihat notifikasi **[D]** | Sistem menampilkan pengingat jatuh tempo, info keterlambatan, dan konfirmasi reservasi. Anggota bisa menandai sudah dibaca **[U]**. | Tidak ada notifikasi: keadaan kosong. | Daftar notifikasi tampil. |
| **A09** | Melihat kartu anggota digital **[D]** | Sistem menampilkan kartu dengan nama, nomor anggota, dan QR atau barcode. | Akun nonaktif: kartu tampil dengan tanda tidak aktif **[U]**. | Kartu tampil. |
| **X01** | Reservasi buku (opsional) **[K]** | Anggota menekan Reservasi pada buku yang sedang dipinjam. Sistem menyimpan antrean dan memberi tahu saat buku kembali. | Sudah pernah direservasi. Batas reservasi tercapai **[K]**. Buku sudah tersedia saat diproses. | Antrean tersimpan, atau pesan penolakan. |

**Catatan X01:** dokumen 1.2 menyebut reservasi sebagai "opsional", dan fitur ini tidak ada di WBS. Jika tidak disetujui, hapus X01, tombol reservasi di A03, dan relasi extend-nya di diagram.

---

## Bagian 3: Peminjaman Mandiri (A05 dan X02)

Bagian ini ada di design Anggota, tetapi aturannya juga dipakai oleh Petugas.

### A05 Memperpanjang Pinjaman

| Field | Isi |
|---|---|
| Aktor | Anggota |
| Kondisi awal | Sudah login. Ada pinjaman aktif untuk buku tersebut. |
| Pemicu | Anggota menekan Perpanjang di A04. |
| Alur utama | 1. Sistem menjalankan X02 (`<<include>>`). 2. Jika semua syarat terpenuhi, tanggal jatuh tempo bertambah sesuai lama perpanjangan dari pengaturan sistem **[D]**, diatur Admin di D09. 3. Jumlah perpanjangan bertambah satu. 4. Sistem menyimpan dan menampilkan tanggal jatuh tempo baru. |
| Alur alternatif | Syarat tidak terpenuhi: perpanjangan ditolak dengan alasan dari X02. |
| Kondisi akhir | Tanggal jatuh tempo baru tersimpan, atau pesan penolakan ditampilkan. |
| Catatan | Petugas juga bisa memperpanjang atas nama anggota lewat X09 (`<<extend>>` dari S04). Keduanya wajib memakai validasi X02 yang sama. |

### X02 Cek Syarat Perpanjangan

| No | Syarat | Sumber |
|---|---|---|
| 1 | Akun berstatus aktif | **[U]** |
| 2 | Tidak ada denda yang belum lunas | **[U]** |
| 3 | Jumlah perpanjangan belum mencapai batas di pengaturan sistem | **[D]**, diatur Admin di D09 |
| 4 | Pinjaman belum terlambat | **[U]**, keputusan tim |
| 5 | Buku tidak sedang direservasi anggota lain | **[K]**, bergantung pada X01 |

Hasil X02 hanya dua: **lolos** atau **ditolak**. Jika ditolak, tampilkan satu alasan utama sesuai urutan syarat di atas, supaya anggota tahu apa yang harus diperbaiki.

---

## Bagian 4: Cara Menulis Bagian Pengaturan User di design.md

1. **Ruang lingkup.** Tulis bahwa bagian ini mencakup U01, U02, dan A01 untuk Anggota. Tulis juga bahwa pengelolaan anggota oleh Admin dan Petugas (S02, D04, D05) dirujuk dari design masing-masing, tidak dijelaskan ulang.

2. **Identitas login.** Tulis dengan jelas bahwa Anggota login dengan nomor anggota, sedangkan Admin dan Petugas login dengan username. Tentukan apakah keduanya memakai satu halaman login atau dua.

3. **Status akun.** Salin diagram status di atas, lalu tulis aturan untuk setiap transisi: siapa yang boleh memicunya, dan apa efeknya ke login, pinjaman, dan kartu.

4. **Tabel kepemilikan tindakan.** Gunakan tabel "Siapa Mengatur Apa". Ini mencegah dua role mengerjakan hal yang sama, atau tidak ada yang mengerjakannya.

5. **Setiap use case dalam format yang sama.** Gunakan kolom: ID, nama, aktor, kondisi awal, pemicu, alur utama, alur alternatif, kondisi akhir, dan sumber aturan. Alur alternatif bisa langsung dijadikan skenario uji.

6. **Aturan keamanan.** Tulis pesan kesalahan login yang sama untuk nomor salah dan password salah. Tulis juga kebijakan lupa password, karena jalur reset mandiri belum ada.

7. **Ketergantungan.** Tulis secara eksplisit bagian mana yang menunggu modul lain. Contoh: A01 menunggu P02, A02 dan A04 menunggu data pinjaman dari Rico (3.x), dan U02 bergantung pada tabel anggota dari Varely (1.3 dan 2.1).

8. **Pengujian.** Setiap alur alternatif menjadi satu skenario uji. Contoh: login akun nonaktif harus gagal dengan pesan yang benar.

---

## Bagian 5: Keputusan yang Harus Dikunci

Sebelum `design.md` difinalkan, tim perlu memutuskan hal-hal berikut. Kolom kanan berisi usulan default, supaya rapat lebih cepat.

| Keputusan | Usulan default |
|---|---|
| Registrasi mandiri dengan persetujuan petugas, atau langsung aktif? | Dengan persetujuan petugas, sesuai kalimat di dokumen 1.2 |
| Nomor anggota diterbitkan saat daftar atau saat disetujui? | Saat disetujui |
| Field apa saja untuk registrasi dan profil? | Nama, alamat, telepon, dan email. Sisanya ditambah bila diperlukan. |
| Aturan password | Minimal 8 karakter, kombinasi huruf dan angka |
| Lupa password | Hubungi petugas, sampai ada fitur reset mandiri |
| Batas percobaan login salah | 5 kali, lalu dikunci 15 menit |
| Katalog bisa dilihat tanpa login? | Tidak, harus login |
| Aturan hapus anggota | Hanya jika tidak punya riwayat transaksi. Jika punya, nonaktifkan. |
| Batas perpanjangan dan lama perpanjangan | Ikuti nilai di pengaturan sistem (D09) |
| Reservasi buku (X01) | Ditunda sampai tim memutuskan |

---

## Bagian 6: Perbaikan Diagram yang Disarankan

1. **A01 sebaiknya terhubung ke aktor "Calon anggota"**, bukan Anggota. Calon anggota belum punya akun.
2. **Tambahkan relasi antara A01 dan P02**, misalnya garis asosiasi atau catatan "menunggu persetujuan", agar ketergantungan terlihat di diagram.
3. **Pertimbangkan `<<include>>` dari A05 ke U01** hanya jika tim ingin menegaskan bahwa perpanjangan wajib login. Secara umum, kondisi awal sudah cukup.
4. **Tambahkan Logout** sebagai use case sederhana jika tim ingin mencantumkannya.
