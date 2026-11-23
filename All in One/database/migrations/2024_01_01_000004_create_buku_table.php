<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('kode_buku', 30)->unique();
            $table->string('isbn', 30)->unique();
            $table->string('judul', 255);
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('restrict');
            $table->foreignId('pengarang_id')->constrained('pengarang')->onDelete('restrict');
            $table->foreignId('penerbit_id')->constrained('penerbit')->onDelete('restrict');
            $table->foreignId('rak_id')->constrained('rak')->onDelete('restrict');
            $table->year('tahun_terbit')->nullable();
            $table->text('sinopsis')->nullable();
            $table->string('cover_image')->nullable();
            $table->decimal('harga_asli', 12, 2)->default(0);
            $table->integer('total_stok')->default(1);
            $table->integer('stok_tersedia')->default(1);
            $table->integer('stok_dipinjam')->default(0);
            $table->integer('stok_rusak')->default(0);
            $table->enum('status', ['tersedia', 'dipinjam', 'rusak'])->default('tersedia');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('buku');
    }
};
