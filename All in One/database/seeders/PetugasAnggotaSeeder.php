<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Petugas;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\DendaPembayaran;

class PetugasAnggotaSeeder extends Seeder
{
    /**
     * Seeder Khusus Akun & Transaksi Role Petugas dan Anggota (Libro Space ERD v2.0).
     */
    public function run()
    {
        $now = now();

        // 1. PETUGAS KHUSUS DEMO OPERASIONAL (PTG-DEMO-001)
        $petugasDemoUser = User::firstOrCreate(
            ['email' => 'petugas.demo@example.test'],
            [
                'name' => 'Petugas Demo',
                'username' => 'petugas_demo',
                'password' => Hash::make('Petugas2026!'),
                'role' => 'petugas',
                'avatar' => 'images/avatar-budi.png',
                'status' => 'aktif',
                'last_login_at' => $now,
            ]
        );

        Petugas::firstOrCreate(
            ['user_id' => $petugasDemoUser->id],
            [
                'nip' => 'PTG-DEMO-001',
                'jabatan' => 'Petugas Meja Sirkulasi',
                'divisi' => 'Sirkulasi & Layanan',
                'no_telepon' => '0215550123',
            ]
        );

        // 2. DAFTAR ANGGOTA DEMO (AGT-DEMO-001 s.d. AGT-DEMO-005) SESUAI WIREFRAME & ERD
        $anggotaDemoList = [
            [
                'name' => 'Rina Maharani',
                'username' => 'AGT-DEMO-001',
                'email' => 'rina@example.test',
                'no_anggota' => 'AGT-DEMO-001',
                'tipe_anggota' => 'mahasiswa',
                'jurusan_unit' => 'Sistem Informasi',
                'no_telepon' => '081200000142',
                'alamat' => 'Jl. Melati 14',
                'status' => 'aktif',
                'avatar' => 'images/avatar-siti.png',
                'tgl_registrasi' => $now->copy()->subMonths(5)->toDateString(),
                'masa_berlaku' => $now->copy()->addMonths(7)->toDateString(),
            ],
            [
                'name' => 'Dimas Pradana',
                'username' => 'AGT-DEMO-002',
                'email' => 'dimas@example.test',
                'no_anggota' => 'AGT-DEMO-002',
                'tipe_anggota' => 'mahasiswa',
                'jurusan_unit' => 'Informatika',
                'no_telepon' => '081200000087',
                'alamat' => 'Jl. Kampus No. 8',
                'status' => 'aktif',
                'avatar' => 'images/avatar-dimas.png',
                'tgl_registrasi' => $now->copy()->subMonths(4)->toDateString(),
                'masa_berlaku' => $now->copy()->addMonths(8)->toDateString(),
            ],
            [
                'name' => 'Sari Kusuma',
                'username' => 'AGT-DEMO-003',
                'email' => 'sari@example.test',
                'no_anggota' => 'AGT-DEMO-003',
                'tipe_anggota' => 'dosen',
                'jurusan_unit' => 'Ilmu Perpustakaan',
                'no_telepon' => '081200000089',
                'alamat' => 'Jl. Dosen No. 12',
                'status' => 'aktif',
                'avatar' => 'images/avatar-siti.png',
                'tgl_registrasi' => $now->copy()->subMonths(3)->toDateString(),
                'masa_berlaku' => $now->copy()->addMonths(9)->toDateString(),
            ],
            [
                'name' => 'Lintang Pratama',
                'username' => 'AGT-DEMO-004',
                'email' => 'lintang@example.test',
                'no_anggota' => 'AGT-DEMO-004',
                'tipe_anggota' => 'mahasiswa',
                'jurusan_unit' => 'Desain Komunikasi Visual',
                'no_telepon' => '081200000048',
                'alamat' => 'Jl. Seni No. 3',
                'status' => 'aktif',
                'avatar' => 'images/avatar-budi.png',
                'tgl_registrasi' => $now->copy()->subMonths(2)->toDateString(),
                'masa_berlaku' => $now->copy()->addMonths(10)->toDateString(),
            ],
            [
                'name' => 'Bella Anindita',
                'username' => 'AGT-DEMO-005',
                'email' => 'bella@example.test',
                'no_anggota' => 'AGT-DEMO-005',
                'tipe_anggota' => 'umum',
                'jurusan_unit' => 'Masyarakat Umum',
                'no_telepon' => '081200000175',
                'alamat' => 'Jl. Anggrek No. 20',
                'status' => 'nonaktif',
                'avatar' => 'images/avatar-nabila.png',
                'tgl_registrasi' => $now->copy()->subYear()->toDateString(),
                'masa_berlaku' => $now->copy()->subDays(5)->toDateString(),
            ],
        ];

        $anggotaDemoMap = [];
        foreach ($anggotaDemoList as $item) {
            $user = User::firstOrCreate(
                ['username' => $item['username']],
                [
                    'name' => $item['name'],
                    'email' => $item['email'],
                    'password' => Hash::make('Anggota2026!'),
                    'role' => 'anggota',
                    'avatar' => $item['avatar'],
                    'status' => $item['status'],
                ]
            );

            $agt = Anggota::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'no_anggota' => $item['no_anggota'],
                    'tipe_anggota' => $item['tipe_anggota'],
                    'jurusan_unit' => $item['jurusan_unit'],
                    'no_telepon' => $item['no_telepon'],
                    'alamat' => $item['alamat'],
                    'tgl_registrasi' => $item['tgl_registrasi'],
                    'masa_berlaku' => $item['masa_berlaku'],
                    'barcode' => 'BAR-' . $item['no_anggota'],
                ]
            );

            $anggotaDemoMap[$item['no_anggota']] = $agt->id;
        }

        // 3. SEED TRANSAKSI DEMO UNTUK RINA MAHARANI (AGT-DEMO-001)
        $bukuList = Buku::all()->keyBy('kode_buku');

        if ($bukuList->isNotEmpty() && isset($anggotaDemoMap['AGT-DEMO-001'])) {
            $rinaId = $anggotaDemoMap['AGT-DEMO-001'];
            $dimasId = $anggotaDemoMap['AGT-DEMO-002'] ?? $rinaId;
            $sariId = $anggotaDemoMap['AGT-DEMO-003'] ?? $rinaId;
            $lintangId = $anggotaDemoMap['AGT-DEMO-004'] ?? $rinaId;

            // Pinjaman 1: Rina meminjam Filosofi Teras (Aktif, sisa waktu 4 hari)
            if (isset($bukuList['BK-003'])) {
                Peminjaman::firstOrCreate(
                    ['kode_transaksi' => 'PJ-DEMO-001'],
                    [
                        'anggota_id' => $rinaId,
                        'buku_id' => $bukuList['BK-003']->id,
                        'petugas_id' => $petugasDemoUser->id,
                        'tgl_pinjam' => $now->copy()->subDays(10)->toDateString(),
                        'jatuh_tempo' => $now->copy()->addDays(4)->toDateString(),
                        'jumlah_perpanjangan' => 0,
                        'status' => 'dipinjam',
                        'catatan' => 'Pinjaman aktif',
                    ]
                );
            }

            // Pinjaman 2: Rina meminjam Atomic Habits (Perpanjangan max 2x, jatuh tempo besok)
            if (isset($bukuList['BK-006'])) {
                Peminjaman::firstOrCreate(
                    ['kode_transaksi' => 'PJ-DEMO-002'],
                    [
                        'anggota_id' => $rinaId,
                        'buku_id' => $bukuList['BK-006']->id,
                        'petugas_id' => $petugasDemoUser->id,
                        'tgl_pinjam' => $now->copy()->subDays(27)->toDateString(),
                        'jatuh_tempo' => $now->copy()->addDays(1)->toDateString(),
                        'jumlah_perpanjangan' => 2,
                        'status' => 'dipinjam',
                        'catatan' => 'Batas maksimal perpanjangan mandiri tercapai',
                    ]
                );
            }

            // Pinjaman 3: Rina meminjam Bumi Manusia (Terlambat 2 hari, denda berjalan)
            if (isset($bukuList['BK-002'])) {
                Peminjaman::firstOrCreate(
                    ['kode_transaksi' => 'PJ-DEMO-003'],
                    [
                        'anggota_id' => $rinaId,
                        'buku_id' => $bukuList['BK-002']->id,
                        'petugas_id' => $petugasDemoUser->id,
                        'tgl_pinjam' => $now->copy()->subDays(16)->toDateString(),
                        'jatuh_tempo' => $now->copy()->subDays(2)->toDateString(),
                        'jumlah_perpanjangan' => 0,
                        'status' => 'terlambat',
                        'catatan' => 'Terlambat 2 hari di meja sirkulasi',
                    ]
                );
            }

            // Pinjaman 4: Dimas Pradana meminjam Laskar Pelangi
            if (isset($bukuList['BK-001'])) {
                Peminjaman::firstOrCreate(
                    ['kode_transaksi' => 'PJ-DEMO-004'],
                    [
                        'anggota_id' => $dimasId,
                        'buku_id' => $bukuList['BK-001']->id,
                        'petugas_id' => $petugasDemoUser->id,
                        'tgl_pinjam' => $now->toDateString(),
                        'jatuh_tempo' => $now->copy()->addDays(14)->toDateString(),
                        'jumlah_perpanjangan' => 0,
                        'status' => 'dipinjam',
                        'catatan' => 'Pinjaman baru hari ini',
                    ]
                );
            }

            // Pinjaman 5: Rina pernah meminjam & mengembalikan Cantik Itu Luka (Terlambat 2 hari, denda Rp 2.000 tertunggak)
            $bukuCantik = $bukuList['BK-007'] ?? ($bukuList['BK-004'] ?? $bukuList->first());
            if ($bukuCantik) {
                $pjRinaSelesai = Peminjaman::firstOrCreate(
                    ['kode_transaksi' => 'PJ-DEMO-007'],
                    [
                        'anggota_id' => $rinaId,
                        'buku_id' => $bukuCantik->id,
                        'petugas_id' => $petugasDemoUser->id,
                        'tgl_pinjam' => $now->copy()->subDays(37)->toDateString(),
                        'jatuh_tempo' => $now->copy()->subDays(23)->toDateString(),
                        'tgl_kembali_aktual' => $now->copy()->subDays(21)->toDateString(),
                        'jumlah_perpanjangan' => 0,
                        'status' => 'kembali',
                        'catatan' => 'Buku kembali dengan telat 2 hari',
                    ]
                );

                $pengembalianRina = Pengembalian::firstOrCreate(
                    ['peminjaman_id' => $pjRinaSelesai->id],
                    [
                        'kode_pengembalian' => 'PG-DEMO-001',
                        'petugas_id' => $petugasDemoUser->id,
                        'tgl_dikembalikan' => $now->copy()->subDays(21)->toDateString(),
                        'hari_terlambat' => 2,
                        'kondisi_buku' => 'baik',
                        'denda_terlambat' => 2000,
                        'denda_kondisi' => 0,
                        'total_denda' => 2000,
                        'catatan_pemeriksaan' => 'Kondisi fisik buku baik, denda keterlambatan 2 hari x Rp 1.000',
                    ]
                );

                DendaPembayaran::firstOrCreate(
                    ['pengembalian_id' => $pengembalianRina->id],
                    [
                        'no_kuitansi' => 'DN-DEMO-0001',
                        'anggota_id' => $rinaId,
                        'petugas_id' => $petugasDemoUser->id,
                        'total_tagihan' => 2000,
                        'uang_diterima' => null,
                        'uang_kembalian' => 0,
                        'metode_bayar' => 'tunai',
                        'status_bayar' => 'tertunggak',
                        'tgl_bayar' => null,
                        'referensi_gateway' => null,
                    ]
                );
            }
        }
    }
}
