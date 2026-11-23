# Web Petugas Libro Space

Pratinjau interaktif alur operasional dari wireframe Google Stitch PT02 dan PT04–PT11. Halaman awalnya adalah Dashboard Operasional. Direktori ini siap dipratinjau sebagai web statis.

## Menjalankan

Dari direktori yang memuat `web-petugas` dan `web-anggota`, jalankan server lokal memakai PHP yang tersedia di Laragon.

```bat
php -S 127.0.0.1:8080
```

Buka `http://127.0.0.1:8080/web-petugas/`. Buka `http://127.0.0.1:8080/web-anggota/` di tab kedua untuk melihat pengembalian dan pembayaran dari sisi anggota. Kedua tab perlu memakai alamat dan port yang sama agar membaca data demo yang sama.

## Skenario demo

- Cari buku dengan judul, ISBN, atau kode seperti `BK-003`. Cari anggota dengan nama atau nomor seperti `AGT-DEMO-002`.
- Catat peminjaman untuk Dimas Pradana dengan buku yang masih tersedia. Untuk melihat validasi kuota dan denda, pilih Rina Maharani.
- Cari `PJ-0003` pada Pengembalian untuk mencoba pengembalian terlambat. Pilih kondisi buku untuk melihat estimasi denda.
- Buka Pembayaran denda dan catat tagihan Rina. Status dan notifikasi akan berubah di tab Anggota.
- Pilih tanggal di Laporan harian untuk mengunduh CSV atau mencetak ringkasan.

Data ilustratif diinisialisasi dengan tanggal WIB saat pertama dibuka. Simulasi memakai kuota tiga buku, masa pinjam 14 hari, dan denda keterlambatan Rp1.000 per hari. Pengaturan ini dipakai oleh kedua tampilan. Perubahan tersimpan di penyimpanan browser lokal pada origin yang sama. Untuk mengulang skenario, hapus data situs lokal dengan kunci `libro-space.demo.sirkulasi.v1`.

Titik masuk frontend ada di `index.html`. Skenario ini berjalan dengan data lokal. Login Varely dan migration Laravel/MySQL mengikuti alur integrasi aplikasi. Lisensi font Plus Jakarta Sans dan Material Symbols disertakan di `assets`.
