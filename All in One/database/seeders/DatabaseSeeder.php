<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Petugas;
use App\Models\Anggota;
use App\Models\Kategori;
use App\Models\Pengarang;
use App\Models\Penerbit;
use App\Models\Rak;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\DendaPembayaran;
use App\Models\PengaturanSistem;
use App\Models\LogAktivitas;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. DATA MASTER
        $kategoriList = [
            ['kode_kategori' => 'KAT-01', 'nama_kategori' => 'Novel', 'deskripsi' => 'Koleksi fiksi naratif panjang sastra populer'],
            ['kode_kategori' => 'KAT-02', 'nama_kategori' => 'Sastra', 'deskripsi' => 'Karya sastra klasik dan kontemporer nusantara'],
            ['kode_kategori' => 'KAT-03', 'nama_kategori' => 'Sains & Teknologi', 'deskripsi' => 'Buku sains murni, komputasi, dan teknik'],
            ['kode_kategori' => 'KAT-04', 'nama_kategori' => 'Pengembangan Diri', 'deskripsi' => 'Psikologi populer, produktivitas, dan self improvement'],
            ['kode_kategori' => 'KAT-05', 'nama_kategori' => 'Sejarah & Budaya', 'deskripsi' => 'Dokumentasi peradaban, antropologi, dan sejarah dunia'],
            ['kode_kategori' => 'KAT-06', 'nama_kategori' => 'Filsafat', 'deskripsi' => 'Pemikiran filsafat barat, timur, dan logika'],
            ['kode_kategori' => 'KAT-07', 'nama_kategori' => 'Fiksi Sejarah', 'deskripsi' => 'Kisah fiksi berlatar belakang peristiwa sejarah riil'],
        ];
        $kategoriMap = [];
        foreach ($kategoriList as $k) {
            $kat = Kategori::create($k);
            $kategoriMap[$k['nama_kategori']] = $kat->id;
        }

        $pengarangList = [
            ['nama_pengarang' => 'Andrea Hirata', 'biografi' => 'Penulis novel best-seller tetralogi Laskar Pelangi kelahiran Belitung'],
            ['nama_pengarang' => 'Pramoedya Ananta Toer', 'biografi' => 'Sastrawan terkemuka Indonesia penulis tetralogi Buru'],
            ['nama_pengarang' => 'Henry Manampiring', 'biografi' => 'Praktisi periklanan dan penulis Filosofi Teras (stoisisme)'],
            ['nama_pengarang' => 'Leila S. Chudori', 'biografi' => 'Wartawan dan sastrawan penulis Laut Bercerita'],
            ['nama_pengarang' => 'Yuval Noah Harari', 'biografi' => 'Sejarawan dan filsuf Israel penulis Sapiens & Homo Deus'],
            ['nama_pengarang' => 'James Clear', 'biografi' => 'Penulis dan pembicara spesialisasi habit formation Atomic Habits'],
            ['nama_pengarang' => 'Eka Kurniawan', 'biografi' => 'Sastrawan terkemuka Indonesia penulis Cantik Itu Luka dan Lelaki Harimau'],
            ['nama_pengarang' => 'Ahmad Fuadi', 'biografi' => 'Novelis dan jurnalis penulis trilogi Negeri 5 Menara alumni Pondok Gontor'],
        ];
        $pengarangMap = [];
        foreach ($pengarangList as $p) {
            $png = Pengarang::create($p);
            $pengarangMap[$p['nama_pengarang']] = $png->id;
        }

        $penerbitList = [
            ['nama_penerbit' => 'Gramedia Pustaka Utama', 'alamat' => 'Palmerah Barat No. 29-37, Jakarta', 'kontak' => '(021) 53650110'],
            ['nama_penerbit' => 'Bentang Pustaka', 'alamat' => 'Jl. Plemburan No. 1, Sleman, Yogyakarta', 'kontak' => '(0274) 885431'],
            ['nama_penerbit' => 'Mizan Media Utama', 'alamat' => 'Cinambo No. 136, Cisaranten Wetan, Bandung', 'kontak' => '(022) 7834310'],
            ['nama_penerbit' => 'Kepustakaan Populer Gramedia', 'alamat' => 'Gedung Kompas Gramedia Blok 1 Lt. 3, Jakarta', 'kontak' => '(021) 53650111'],
            ['nama_penerbit' => 'Hasta Mitra', 'alamat' => 'Jakarta, Indonesia', 'kontak' => 'info@hastamitra.id'],
            ['nama_penerbit' => 'Kompas Penerbit Buku', 'alamat' => 'Palmerah Selatan No. 26-28, Jakarta', 'kontak' => '(021) 5347710'],
        ];
        $penerbitMap = [];
        foreach ($penerbitList as $pb) {
            $pen = Penerbit::create($pb);
            $penerbitMap[$pb['nama_penerbit']] = $pen->id;
        }

        $rakList = [
            ['kode_rak' => 'Rak A1', 'nama_rak' => 'Rak A1 - Sastra & Fiksi', 'lokasi' => 'Lantai 1 Sayap Barat'],
            ['kode_rak' => 'Rak A2', 'nama_rak' => 'Rak A2 - Sastra Klasik', 'lokasi' => 'Lantai 1 Sayap Barat'],
            ['kode_rak' => 'Rak A3', 'nama_rak' => 'Rak A3 - Fiksi Sejarah', 'lokasi' => 'Lantai 1 Sayap Barat'],
            ['kode_rak' => 'Rak B1', 'nama_rak' => 'Rak B1 - Self Development', 'lokasi' => 'Lantai 1 Sayap Timur'],
            ['kode_rak' => 'Rak B2', 'nama_rak' => 'Rak B2 - Motivasi & Karir', 'lokasi' => 'Lantai 1 Sayap Timur'],
            ['kode_rak' => 'Rak C1', 'nama_rak' => 'Rak C1 - Penelitian & Ilmiah', 'lokasi' => 'Lantai 2 Mezzanine'],
            ['kode_rak' => 'Rak C2', 'nama_rak' => 'Rak C2 - Sains & Sejarah', 'lokasi' => 'Lantai 2 Sayap Utara'],
        ];
        $rakMap = [];
        foreach ($rakList as $r) {
            $rk = Rak::create($r);
            $rakMap[$r['kode_rak']] = $rk->id;
        }

        // 2. USERS: SUPER ADMIN
        $adminUser = User::create([
            'name' => 'Admin Perpustakaan, S.Kom',
            'username' => 'admin.utama',
            'email' => 'admin@perpustakaan.go.id',
            'password' => Hash::make('AdminSecretLibrary2024!'),
            'role' => 'admin',
            'avatar' => 'images/avatar-admin.png',
            'status' => 'aktif',
            'last_login_at' => now(),
        ]);

        Petugas::create([
            'user_id' => $adminUser->id,
            'nip' => 'ADM-2024-001',
            'jabatan' => 'Kepala Pengelola Sistem & TI',
            'divisi' => 'UPT Perpustakaan Pusat',
            'no_telepon' => '0812-3456-7890',
        ]);

        // 3. USERS: PETUGAS SIRKULASI & STAF
        $petugasData = [
            [
                'name' => 'Budi Santoso, S.Kom',
                'username' => 'budi.s',
                'email' => 'budi.santoso@perpustakaan.go.id',
                'password' => Hash::make('Petugas2026!Sirkulasi'),
                'avatar' => 'images/avatar-budi.png',
                'nip' => 'STF-2024-001',
                'jabatan' => 'Kepala Sirkulasi',
                'divisi' => 'Divisi Layanan Pemustaka',
                'no_telepon' => '0812-1111-2222',
            ],
            [
                'name' => 'Siti Rahmawati',
                'username' => 'siti.r',
                'email' => 'siti.rahma@perpustakaan.go.id',
                'password' => Hash::make('Petugas2026!'),
                'avatar' => 'images/avatar-siti.png',
                'nip' => 'STF-2024-002',
                'jabatan' => 'Staf Inventaris & Katalog',
                'divisi' => 'Divisi Pengolahan Koleksi',
                'no_telepon' => '0812-3333-4444',
            ],
            [
                'name' => 'Ahmad Fauzi',
                'username' => 'ahmad.f',
                'email' => 'ahmad.fauzi@perpustakaan.go.id',
                'password' => Hash::make('Petugas2026!'),
                'avatar' => 'images/avatar-dimas.png',
                'nip' => 'STF-2024-003',
                'jabatan' => 'Staf Peminjaman & Layanan',
                'divisi' => 'Divisi Layanan Pemustaka',
                'no_telepon' => '0812-5555-6666',
            ],
            [
                'name' => 'Maya Indriani',
                'username' => 'maya.i',
                'email' => 'maya.indri@perpustakaan.go.id',
                'password' => Hash::make('Petugas2026!'),
                'avatar' => 'images/avatar-nabila.png',
                'nip' => 'STF-2024-004',
                'jabatan' => 'Staf Pengembalian & Denda',
                'divisi' => 'Divisi Layanan Pemustaka',
                'no_telepon' => '0812-7777-8888',
            ],
            [
                'name' => 'Dewi Kartika',
                'username' => 'dewi.k',
                'email' => 'dewi.k@perpustakaan.go.id',
                'password' => Hash::make('Petugas2026!'),
                'avatar' => 'images/avatar-siti.png',
                'nip' => 'STF-2024-005',
                'jabatan' => 'Staf Layanan Referensi',
                'divisi' => 'Divisi Referensi & Literasi',
                'no_telepon' => '0812-9999-0000',
            ],
            [
                'name' => 'Agus Wijaya',
                'username' => 'agus.w',
                'email' => 'agus.wijaya@perpustakaan.go.id',
                'password' => Hash::make('Petugas2026!'),
                'avatar' => 'images/avatar-budi.png',
                'nip' => 'STF-2024-006',
                'jabatan' => 'Petugas Arsip',
                'divisi' => 'Divisi Arsip & Pemeliharaan',
                'no_telepon' => '0813-1234-5678',
            ],
        ];

        $petugasMap = [];
        foreach ($petugasData as $p) {
            $u = User::create([
                'name' => $p['name'],
                'username' => $p['username'],
                'email' => $p['email'],
                'password' => $p['password'],
                'role' => 'petugas',
                'avatar' => $p['avatar'],
                'status' => 'aktif',
                'last_login_at' => now()->subHours(rand(1, 48)),
            ]);

            $ptg = Petugas::create([
                'user_id' => $u->id,
                'nip' => $p['nip'],
                'jabatan' => $p['jabatan'],
                'divisi' => $p['divisi'],
                'no_telepon' => $p['no_telepon'],
            ]);

            $petugasMap[$p['username']] = $u->id;
        }

        // 4. USERS: ANGGOTA (MEMBERS)
        $anggotaData = [
            [
                'name' => 'Putri Ayu Lestari',
                'username' => 'AGT-0001',
                'email' => 'putri.ayu@univ.ac.id',
                'no_anggota' => 'AGT-0001',
                'tipe_anggota' => 'mahasiswa',
                'jurusan_unit' => 'Sistem Informasi',
                'no_telepon' => '0812-3456-1234',
                'alamat' => 'Jl. Kebon Jeruk No. 12, Jakarta Barat',
                'avatar' => 'images/avatar-nabila.png',
                'tgl_registrasi' => '2023-09-14',
                'masa_berlaku' => '2027-09-14',
            ],
            [
                'name' => 'Dimas Pratama',
                'username' => 'AGT-0002',
                'email' => 'dimas.p@univ.ac.id',
                'no_anggota' => 'AGT-0002',
                'tipe_anggota' => 'mahasiswa',
                'jurusan_unit' => 'Akuntansi',
                'no_telepon' => '0813-9876-5678',
                'alamat' => 'Jl. Salemba Tengah No. 4, Jakarta Pusat',
                'avatar' => 'images/avatar-dimas.png',
                'tgl_registrasi' => '2023-10-10',
                'masa_berlaku' => '2027-10-10',
            ],
            [
                'name' => 'Rina Wulandari',
                'username' => 'AGT-0003',
                'email' => 'rina.w@univ.ac.id',
                'no_anggota' => 'AGT-0003',
                'tipe_anggota' => 'dosen',
                'jurusan_unit' => 'Fakultas Ekonomi & Bisnis',
                'no_telepon' => '0857-1122-9012',
                'alamat' => 'Jl. Tebet Barat Raya No. 18, Jakarta Selatan',
                'avatar' => 'images/avatar-siti.png',
                'tgl_registrasi' => '2023-08-05',
                'masa_berlaku' => '2028-08-05',
            ],
            [
                'name' => 'Fajar Ramadhan',
                'username' => 'AGT-0004',
                'email' => 'fajar.r@univ.ac.id',
                'no_anggota' => 'AGT-0004',
                'tipe_anggota' => 'mahasiswa',
                'jurusan_unit' => 'Teknik Informatika',
                'no_telepon' => '0821-4455-6677',
                'alamat' => 'Jl. Rawamangun Muka No. 7, Jakarta Timur',
                'avatar' => 'images/avatar-budi.png',
                'tgl_registrasi' => '2023-09-22',
                'masa_berlaku' => '2027-09-22',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'username' => 'AGT-0005',
                'email' => 'siti.n@univ.ac.id',
                'no_anggota' => 'AGT-0005',
                'tipe_anggota' => 'mahasiswa',
                'jurusan_unit' => 'Ilmu Komunikasi',
                'no_telepon' => '0878-3344-5566',
                'alamat' => 'Jl. Cikini Raya No. 35, Jakarta Pusat',
                'avatar' => 'images/avatar-siti.png',
                'tgl_registrasi' => '2023-11-18',
                'masa_berlaku' => '2027-11-18',
            ],
            [
                'name' => 'Bima Sakti',
                'username' => 'AGT-0006',
                'email' => 'bima.s@univ.ac.id',
                'no_anggota' => 'AGT-0006',
                'tipe_anggota' => 'staf',
                'jurusan_unit' => 'Biro Administrasi Akademik',
                'no_telepon' => '0819-7788-9900',
                'alamat' => 'Jl. Matraman Raya No. 80, Jakarta Timur',
                'avatar' => 'images/avatar-dimas.png',
                'tgl_registrasi' => '2023-12-01',
                'masa_berlaku' => '2028-12-01',
            ],
        ];

        $anggotaMap = [];
        foreach ($anggotaData as $a) {
            $u = User::create([
                'name' => $a['name'],
                'username' => $a['username'],
                'email' => $a['email'],
                'password' => Hash::make('Anggota2026#Putri'),
                'role' => 'anggota',
                'avatar' => $a['avatar'],
                'status' => 'aktif',
            ]);

            $agt = Anggota::create([
                'user_id' => $u->id,
                'no_anggota' => $a['no_anggota'],
                'tipe_anggota' => $a['tipe_anggota'],
                'jurusan_unit' => $a['jurusan_unit'],
                'no_telepon' => $a['no_telepon'],
                'alamat' => $a['alamat'],
                'tgl_registrasi' => $a['tgl_registrasi'],
                'masa_berlaku' => $a['masa_berlaku'],
                'barcode' => 'BAR-' . $a['no_anggota'],
            ]);

            $anggotaMap[$a['no_anggota']] = $agt->id;
        }

        // 5. BUKU KATALOG
        $bukuData = [
            [
                'kode_buku' => 'BK-001',
                'isbn' => '978-979-1227-89-6',
                'judul' => 'Laskar Pelangi',
                'kategori_id' => $kategoriMap['Novel'],
                'pengarang_id' => $pengarangMap['Andrea Hirata'],
                'penerbit_id' => $penerbitMap['Bentang Pustaka'],
                'rak_id' => $rakMap['Rak A1'],
                'tahun_terbit' => 2005,
                'sinopsis' => 'Kisah perjuangan sepuluh anak di Belitung dalam menuntut ilmu di tengah keterbatasan fasilitas sekolah.',
                'cover_image' => 'images/book-laskar-pelangi.png',
                'harga_asli' => 85000,
                'total_stok' => 5,
                'stok_tersedia' => 4,
                'stok_dipinjam' => 1,
                'stok_rusak' => 0,
                'status' => 'tersedia',
            ],
            [
                'kode_buku' => 'BK-002',
                'isbn' => '978-979-973-12-3',
                'judul' => 'Bumi Manusia',
                'kategori_id' => $kategoriMap['Sastra'],
                'pengarang_id' => $pengarangMap['Pramoedya Ananta Toer'],
                'penerbit_id' => $penerbitMap['Hasta Mitra'],
                'rak_id' => $rakMap['Rak A2'],
                'tahun_terbit' => 1980,
                'sinopsis' => 'Roman sejarah pergerakan nasional awal abad ke-20 yang mengisahkan Minke dan Annelies Mellema.',
                'cover_image' => 'images/book-bumi-manusia.png',
                'harga_asli' => 110000,
                'total_stok' => 4,
                'stok_tersedia' => 0,
                'stok_dipinjam' => 4,
                'stok_rusak' => 0,
                'status' => 'dipinjam',
            ],
            [
                'kode_buku' => 'BK-003',
                'isbn' => '978-602-03-3158-4',
                'judul' => 'Filosofi Teras',
                'kategori_id' => $kategoriMap['Pengembangan Diri'],
                'pengarang_id' => $pengarangMap['Henry Manampiring'],
                'penerbit_id' => $penerbitMap['Kompas Penerbit Buku'],
                'rak_id' => $rakMap['Rak B1'],
                'tahun_terbit' => 2018,
                'sinopsis' => 'Penerapan filsafat stoisisme kuno untuk mengatasi kecemasan dan emosi negatif dalam kehidupan modern.',
                'cover_image' => 'images/book-filosofi-teras.png',
                'harga_asli' => 98000,
                'total_stok' => 12,
                'stok_tersedia' => 10,
                'stok_dipinjam' => 1,
                'stok_rusak' => 1,
                'status' => 'tersedia',
            ],
            [
                'kode_buku' => 'BK-004',
                'isbn' => '978-602-424-694-5',
                'judul' => 'Laut Bercerita',
                'kategori_id' => $kategoriMap['Fiksi Sejarah'],
                'pengarang_id' => $pengarangMap['Leila S. Chudori'],
                'penerbit_id' => $penerbitMap['Kepustakaan Populer Gramedia'],
                'rak_id' => $rakMap['Rak A3'],
                'tahun_terbit' => 2017,
                'sinopsis' => 'Kisah aktivis mahasiswa yang diculik pada masa pra-reformasi 1998 dan duka keluarga yang ditinggalkan.',
                'cover_image' => 'images/book-laut-bercerita.png',
                'harga_asli' => 105000,
                'total_stok' => 6,
                'stok_tersedia' => 5,
                'stok_dipinjam' => 1,
                'stok_rusak' => 0,
                'status' => 'tersedia',
            ],
            [
                'kode_buku' => 'BK-005',
                'isbn' => '978-0-06-231609-7',
                'judul' => 'Sapiens: Riwayat Singkat Umat Manusia',
                'kategori_id' => $kategoriMap['Sejarah & Budaya'],
                'pengarang_id' => $pengarangMap['Yuval Noah Harari'],
                'penerbit_id' => $penerbitMap['Kepustakaan Populer Gramedia'],
                'rak_id' => $rakMap['Rak C2'],
                'tahun_terbit' => 2014,
                'sinopsis' => 'Eksplorasi mendalam evolusi Homo sapiens dari kera tak berarti hingga penguasa planet bumi.',
                'cover_image' => 'images/book-sapiens.png',
                'harga_asli' => 135000,
                'total_stok' => 4,
                'stok_tersedia' => 3,
                'stok_dipinjam' => 1,
                'stok_rusak' => 0,
                'status' => 'tersedia',
            ],
            [
                'kode_buku' => 'BK-006',
                'isbn' => '978-602-06-3317-6',
                'judul' => 'Atomic Habits',
                'kategori_id' => $kategoriMap['Pengembangan Diri'],
                'pengarang_id' => $pengarangMap['James Clear'],
                'penerbit_id' => $penerbitMap['Gramedia Pustaka Utama'],
                'rak_id' => $rakMap['Rak B2'],
                'tahun_terbit' => 2019,
                'sinopsis' => 'Perubahan kecil yang memberikan hasil luar biasa melalui pendekatan 4 kaidah perilaku manusia.',
                'cover_image' => 'images/book-atomic-habits.png',
                'harga_asli' => 108000,
                'total_stok' => 10,
                'stok_tersedia' => 8,
                'stok_dipinjam' => 2,
                'stok_rusak' => 0,
                'status' => 'tersedia',
            ],
            [
                'kode_buku' => 'BK-007',
                'isbn' => '978-602-03-1258-3',
                'judul' => 'Cantik Itu Luka',
                'kategori_id' => $kategoriMap['Novel'],
                'pengarang_id' => $pengarangMap['Eka Kurniawan'],
                'penerbit_id' => $penerbitMap['Gramedia Pustaka Utama'],
                'rak_id' => $rakMap['Rak A2'],
                'tahun_terbit' => 2002,
                'sinopsis' => 'Di kota pesisir Halimunda, kisah beberapa generasi keluarga Dewi Ayu bertaut dengan sejarah Indonesia dan cerita rakyat setempat.',
                'cover_image' => 'assets/cantik.webp',
                'harga_asli' => 125000,
                'total_stok' => 3,
                'stok_tersedia' => 2,
                'stok_dipinjam' => 1,
                'stok_rusak' => 0,
                'status' => 'tersedia',
            ],
            [
                'kode_buku' => 'BK-008',
                'isbn' => '978-979-22-4861-6',
                'judul' => 'Negeri 5 Menara',
                'kategori_id' => $kategoriMap['Novel'],
                'pengarang_id' => $pengarangMap['Ahmad Fuadi'],
                'penerbit_id' => $penerbitMap['Gramedia Pustaka Utama'],
                'rak_id' => $rakMap['Rak A3'],
                'tahun_terbit' => 2009,
                'sinopsis' => 'Perjalanan Alif di pesantren bersama lima sahabat yang belajar mengejar cita-cita melalui disiplin, persahabatan, dan tekad Man Jadda Wajada.',
                'cover_image' => 'assets/negeri.webp',
                'harga_asli' => 95000,
                'total_stok' => 3,
                'stok_tersedia' => 2,
                'stok_dipinjam' => 1,
                'stok_rusak' => 0,
                'status' => 'tersedia',
            ],
        ];

        $bukuMap = [];
        foreach ($bukuData as $b) {
            $bk = Buku::create($b);
            $bukuMap[$b['kode_buku']] = $bk->id;
        }

        // 6. TRANSAKSI PEMINJAMAN
        $peminjamanData = [
            [
                'kode_transaksi' => 'PJ-001',
                'anggota_id' => $anggotaMap['AGT-0001'],
                'buku_id' => $bukuMap['BK-001'],
                'petugas_id' => $petugasMap['budi.s'],
                'tgl_pinjam' => '2026-10-02',
                'jatuh_tempo' => '2026-10-09',
                'tgl_kembali_aktual' => '2026-10-09',
                'jumlah_perpanjangan' => 0,
                'status' => 'kembali',
                'catatan' => 'Kembali tepat waktu',
            ],
            [
                'kode_transaksi' => 'PJ-002',
                'anggota_id' => $anggotaMap['AGT-0002'],
                'buku_id' => $bukuMap['BK-002'],
                'petugas_id' => $petugasMap['siti.r'],
                'tgl_pinjam' => '2026-10-20',
                'jatuh_tempo' => '2026-10-27',
                'tgl_kembali_aktual' => '2026-10-30',
                'jumlah_perpanjangan' => 0,
                'status' => 'terlambat',
                'catatan' => 'Terlambat 3 hari (denda berjalan)',
            ],
            [
                'kode_transaksi' => 'PJ-003',
                'anggota_id' => $anggotaMap['AGT-0003'],
                'buku_id' => $bukuMap['BK-003'],
                'petugas_id' => $petugasMap['ahmad.f'],
                'tgl_pinjam' => '2026-10-15',
                'jatuh_tempo' => '2026-10-22',
                'tgl_kembali_aktual' => '2026-10-22',
                'jumlah_perpanjangan' => 0,
                'status' => 'kembali',
                'catatan' => 'Kondisi buku baik',
            ],
            [
                'kode_transaksi' => 'PJ-004',
                'anggota_id' => $anggotaMap['AGT-0004'],
                'buku_id' => $bukuMap['BK-004'],
                'petugas_id' => $petugasMap['budi.s'],
                'tgl_pinjam' => '2026-10-28',
                'jatuh_tempo' => '2026-11-04',
                'tgl_kembali_aktual' => null,
                'jumlah_perpanjangan' => 0,
                'status' => 'dipinjam',
                'catatan' => 'Peminjaman aktif',
            ],
            [
                'kode_transaksi' => 'PJ-005',
                'anggota_id' => $anggotaMap['AGT-0005'],
                'buku_id' => $bukuMap['BK-005'],
                'petugas_id' => $petugasMap['maya.i'],
                'tgl_pinjam' => '2026-10-18',
                'jatuh_tempo' => '2026-10-25',
                'tgl_kembali_aktual' => null,
                'jumlah_perpanjangan' => 0,
                'status' => 'terlambat',
                'catatan' => 'Terlambat melebihi jatuh tempo',
            ],
            [
                'kode_transaksi' => 'PJ-006',
                'anggota_id' => $anggotaMap['AGT-0006'],
                'buku_id' => $bukuMap['BK-006'],
                'petugas_id' => $petugasMap['dewi.k'],
                'tgl_pinjam' => '2026-10-25',
                'jatuh_tempo' => '2026-11-01',
                'tgl_kembali_aktual' => '2026-11-01',
                'jumlah_perpanjangan' => 0,
                'status' => 'kembali',
                'catatan' => 'Selesai tepat waktu',
            ],
        ];

        $peminjamanMap = [];
        foreach ($peminjamanData as $pj) {
            $pm = Peminjaman::create($pj);
            $peminjamanMap[$pj['kode_transaksi']] = $pm->id;
        }

        // 7. TRANSAKSI PENGEMBALIAN & DENDA
        $pengembalian1 = Pengembalian::create([
            'kode_pengembalian' => 'PG-001',
            'peminjaman_id' => $peminjamanMap['PJ-002'],
            'petugas_id' => $petugasMap['maya.i'],
            'tgl_dikembalikan' => '2026-10-30',
            'hari_terlambat' => 3,
            'kondisi_buku' => 'baik',
            'denda_terlambat' => 3000,
            'denda_kondisi' => 0,
            'total_denda' => 3000,
            'catatan_pemeriksaan' => 'Terlambat 3 hari kalender, fisik buku mulus.',
        ]);

        DendaPembayaran::create([
            'no_kuitansi' => 'DND-2026-081',
            'pengembalian_id' => $pengembalian1->id,
            'anggota_id' => $anggotaMap['AGT-0002'],
            'petugas_id' => $petugasMap['maya.i'],
            'total_tagihan' => 3000,
            'uang_diterima' => 5000,
            'uang_kembalian' => 2000,
            'metode_bayar' => 'tunai',
            'status_bayar' => 'lunas',
            'tgl_bayar' => now(),
            'referensi_gateway' => 'CASH-TRX-001',
        ]);

        $pengembalian2 = Pengembalian::create([
            'kode_pengembalian' => 'PG-002',
            'peminjaman_id' => $peminjamanMap['PJ-001'],
            'petugas_id' => $petugasMap['budi.s'],
            'tgl_dikembalikan' => '2026-10-09',
            'hari_terlambat' => 0,
            'kondisi_buku' => 'baik',
            'denda_terlambat' => 0,
            'denda_kondisi' => 0,
            'total_denda' => 0,
            'catatan_pemeriksaan' => 'Kondisi buku baik dan rapi.',
        ]);

        $pengembalian3 = Pengembalian::create([
            'kode_pengembalian' => 'PG-003',
            'peminjaman_id' => $peminjamanMap['PJ-003'],
            'petugas_id' => $petugasMap['siti.r'],
            'tgl_dikembalikan' => '2026-10-22',
            'hari_terlambat' => 0,
            'kondisi_buku' => 'baik',
            'denda_terlambat' => 0,
            'denda_kondisi' => 0,
            'total_denda' => 0,
            'catatan_pemeriksaan' => 'Dikembalikan tepat waktu di meja sirkulasi.',
        ]);

        // 8. PENGATURAN SISTEM
        $pengaturanData = [
            ['setting_key' => 'lama_pinjam_default', 'setting_value' => '7', 'tipe_data' => 'integer', 'keterangan' => 'Durasi standar peminjaman buku sebelum denda (hari)'],
            ['setting_key' => 'max_buku_pinjam', 'setting_value' => '3', 'tipe_data' => 'integer', 'keterangan' => 'Batas maksimal buku aktif dipinjam per akun'],
            ['setting_key' => 'max_perpanjangan', 'setting_value' => '2', 'tipe_data' => 'integer', 'keterangan' => 'Batas toleransi perpanjangan mandiri online'],
            ['setting_key' => 'grace_period', 'setting_value' => '1', 'tipe_data' => 'integer', 'keterangan' => 'Masa tenggang toleransi keterlambatan tanpa denda (hari)'],
            ['setting_key' => 'allow_pinjam_denda', 'setting_value' => 'false', 'tipe_data' => 'boolean', 'keterangan' => 'Izinkan peminjaman baru saat ada tunggakan denda'],
            ['setting_key' => 'denda_harian', 'setting_value' => '1000', 'tipe_data' => 'decimal', 'keterangan' => 'Tarif denda keterlambatan per hari per buku'],
            ['setting_key' => 'denda_rusak_ringan', 'setting_value' => '50000', 'tipe_data' => 'decimal', 'keterangan' => 'Biaya perbaikan kerusakan buku ringan/sedang'],
            ['setting_key' => 'denda_hilang', 'setting_value' => '100000', 'tipe_data' => 'decimal', 'keterangan' => 'Biaya kompensasi buku hilang / rusak berat'],
            ['setting_key' => 'notifikasi_wa', 'setting_value' => 'true', 'tipe_data' => 'boolean', 'keterangan' => 'Notifikasi otomatis pengingat jatuh tempo via WhatsApp Gateway'],
        ];

        foreach ($pengaturanData as $set) {
            $set['updated_by'] = $adminUser->id;
            PengaturanSistem::create($set);
        }

        // 9. LOG AKTIVITAS (AUDIT TRAIL)
        $logData = [
            [
                'user_id' => $petugasMap['budi.s'],
                'nama_user' => 'Budi Santoso',
                'modul' => 'Data Buku',
                'aksi' => 'Tambah',
                'deskripsi' => 'menambahkan 5 eksemplar baru pada buku',
                'target' => '"Atomic Habits" (ISBN: 978-602-06-3317-6)',
                'payload_json' => ['buku_id' => 6, 'eksemplar_added' => 5],
                'ip_address' => '192.168.1.12',
                'device_info' => 'Web Chrome (192.168.1.12)',
                'integrity_hash' => hash('sha256', 'LOG_ENTRY_001'),
            ],
            [
                'user_id' => $petugasMap['siti.r'],
                'nama_user' => 'Siti Rahmawati',
                'modul' => 'Peminjaman',
                'aksi' => 'Ubah',
                'deskripsi' => 'mengubah status peminjaman PJ-002 menjadi',
                'target' => 'Terlambat',
                'payload_json' => ['transaksi_id' => 'PJ-002', 'old_status' => 'dipinjam', 'new_status' => 'terlambat'],
                'ip_address' => '192.168.1.18',
                'device_info' => 'Firefox (192.168.1.18)',
                'integrity_hash' => hash('sha256', 'LOG_ENTRY_002'),
            ],
            [
                'user_id' => $petugasMap['ahmad.f'],
                'nama_user' => 'Ahmad Fauzi',
                'modul' => 'Data Master',
                'aksi' => 'Hapus',
                'deskripsi' => 'menghapus data kategori kedaluwarsa',
                'target' => '"Majalah 2020"',
                'payload_json' => ['kategori_deleted' => 'Majalah 2020'],
                'ip_address' => '192.168.1.33',
                'device_info' => 'Web Safari (192.168.1.33)',
                'integrity_hash' => hash('sha256', 'LOG_ENTRY_003'),
            ],
            [
                'user_id' => $adminUser->id,
                'nama_user' => 'Admin Perpustakaan',
                'modul' => 'Pengaturan',
                'aksi' => 'Ubah',
                'deskripsi' => 'memperbarui aturan denda harian menjadi',
                'target' => 'Rp 1.000 / hari',
                'payload_json' => ['setting_key' => 'denda_harian', 'old_val' => '500', 'new_val' => '1000'],
                'ip_address' => '192.168.1.2',
                'device_info' => 'Edge (192.168.1.2)',
                'integrity_hash' => hash('sha256', 'LOG_ENTRY_004'),
            ],
            [
                'user_id' => $petugasMap['maya.i'],
                'nama_user' => 'Maya Indriani',
                'modul' => 'Data Anggota',
                'aksi' => 'Tambah',
                'deskripsi' => 'mencetak kartu anggota baru untuk',
                'target' => 'Putri Ayu Lestari ( AGT - 0001 )',
                'payload_json' => ['no_anggota' => 'AGT-0001', 'action' => 'PRINT_CARD'],
                'ip_address' => '192.168.1.25',
                'device_info' => 'Chrome (192.168.1.25)',
                'integrity_hash' => hash('sha256', 'LOG_ENTRY_005'),
            ],
            [
                'user_id' => $petugasMap['budi.s'],
                'nama_user' => 'Budi Santoso',
                'modul' => 'Autentikasi',
                'aksi' => 'Login_Keamanan',
                'deskripsi' => 'login berhasil ke sistem melalui verifikasi dua langkah (2FA)',
                'target' => 'Sesi Aktif',
                'payload_json' => ['auth' => '2FA_SUCCESS', 'user' => 'budi.s'],
                'ip_address' => '192.168.1.45',
                'device_info' => 'Firefox (192.168.1.45)',
                'integrity_hash' => hash('sha256', 'LOG_ENTRY_006'),
            ],
        ];

        foreach ($logData as $l) {
            LogAktivitas::create($l);
        }

        // 10. SEED DEMO PETUGAS & ANGGOTA (Libro Space Wireframes & ERD v2.0)
        $this->call(PetugasAnggotaSeeder::class);
    }
}
