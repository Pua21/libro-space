# Web Anggota Libro Space

Pratinjau interaktif portal anggota dari wireframe Google Stitch S06–S18 dan S20. Halaman awalnya adalah Beranda. Direktori ini siap dipratinjau sebagai web statis.

## Menjalankan

Dari direktori yang memuat `web-petugas` dan `web-anggota`, jalankan:

```bat
php -S 127.0.0.1:8080
```

Buka `http://127.0.0.1:8080/web-anggota/`. Untuk mencoba perubahan lintas peran dalam satu sesi demo, buka Web Petugas pada alamat dan port yang sama, di path `/web-petugas/`.

## Skenario demo

- Cari Laskar Pelangi dari Beranda untuk melihat detail, mencoba reservasi, dan membatalkannya dari tab Reservasi.
- Gunakan pengingat di detail Sapiens saat stok habis. Ketika Petugas mencatat pengembalian Sapiens dalam kondisi baik, notifikasi stok muncul di portal Anggota.
- Perpanjang Filosofi Teras dari Pinjaman. Atomic Habits sudah mencapai batas perpanjangan dan Bumi Manusia memerlukan pengembalian ke petugas.
- Buka Denda untuk melihat status tagihan yang dicatat Petugas. Profil dan kartu digital mengacu pada anggota demo `AGT-DEMO-001`. QR memuat nomor anggota demo tersebut.

Data ilustratif tersimpan di penyimpanan browser lokal dengan kunci `libro-space.demo.sirkulasi.v1`. Frontend dimulai dari `index.html` dan dapat dihubungkan ke alur login Varely saat integrasi aplikasi.

Lisensi font Geist, Space Grotesk, dan Material Symbols disertakan di `assets`. [Foto perpustakaan dari Unsplash](https://images.unsplash.com/photo-1507842217343-583bb7270b66)

## Sumber sampul

Setiap sampul disimpan sebagai WebP lokal dengan rasio gambar aslinya. Laskar Pelangi dan Sapiens memakai varian sampul dari sumber yang tercantum.

- Atomic Habits edisi Indonesia. [Mitra Wacana Media](https://www.mitrawacanamedia.com/atomic-habits)
- Bumi Manusia edisi Seabad Pramoedya. [Katalog Poltekkes Kemenkes Manado](https://perpustakaan.poltekkes-manado.ac.id/index.php?id=3155&keywords=&p=show_detail)
- Cantik Itu Luka edisi sampul merah. [Gramedia](https://www.gramedia.com/products/cantik-itu-luka-hc-limited-edition)
- Filosofi Teras edisi sampul hijau. [Gramedia](https://www.gramedia.com/products/filosofi-teras-new-cover)
- Laskar Pelangi edisi baru. [Gramedia](https://www.gramedia.com/best-seller/resensi-novel-laskar-pelangi-karya-andrea-hirata/)
- Negeri 5 Menara edisi 2009. [Goodreads](https://www.goodreads.com/book/show/6688121-negeri-5-menara)
- Sapiens edisi bahasa Inggris. [HarperCollins](https://i.harperapps.com/covers/9780062316110/y648.jpg)
