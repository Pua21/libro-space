<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi', 30)->unique();
            $table->foreignId('anggota_id')->constrained('anggota')->onDelete('restrict');
            $table->foreignId('buku_id')->constrained('buku')->onDelete('restrict');
            $table->foreignId('petugas_id')->constrained('users')->onDelete('restrict');
            $table->date('tgl_pinjam');
            $table->date('jatuh_tempo');
            $table->date('tgl_kembali_aktual')->nullable();
            $table->integer('jumlah_perpanjangan')->default(0);
            $table->enum('status', ['dipinjam', 'kembali', 'terlambat'])->default('dipinjam');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('peminjaman');
    }
};
