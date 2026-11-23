<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('denda_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('no_kuitansi', 35)->unique();
            $table->foreignId('pengembalian_id')->constrained('pengembalian')->onDelete('restrict')->unique();
            $table->foreignId('anggota_id')->constrained('anggota')->onDelete('restrict');
            $table->foreignId('petugas_id')->constrained('users')->onDelete('restrict');
            $table->decimal('total_tagihan', 10, 2);
            $table->decimal('uang_diterima', 10, 2)->nullable();
            $table->decimal('uang_kembalian', 10, 2)->default(0);
            $table->enum('metode_bayar', ['tunai', 'qris_dinamis', 'transfer'])->default('tunai');
            $table->enum('status_bayar', ['lunas', 'tertunggak'])->default('tertunggak');
            $table->timestamp('tgl_bayar')->nullable();
            $table->string('referensi_gateway', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('denda_pembayaran');
    }
};
