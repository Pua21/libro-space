<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pengembalian', 30)->unique();
            $table->foreignId('peminjaman_id')->constrained('peminjaman')->onDelete('restrict')->unique();
            $table->foreignId('petugas_id')->constrained('users')->onDelete('restrict');
            $table->date('tgl_dikembalikan');
            $table->integer('hari_terlambat')->default(0);
            $table->enum('kondisi_buku', ['baik', 'rusak_ringan', 'rusak_berat', 'hilang'])->default('baik');
            $table->decimal('denda_terlambat', 10, 2)->default(0);
            $table->decimal('denda_kondisi', 10, 2)->default(0);
            $table->decimal('total_denda', 10, 2)->default(0);
            $table->text('catatan_pemeriksaan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengembalian');
    }
};
