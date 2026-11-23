<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kategori', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kategori', 30)->unique();
            $table->string('nama_kategori', 100);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        Schema::create('pengarang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pengarang', 150);
            $table->text('biografi')->nullable();
            $table->timestamps();
        });

        Schema::create('penerbit', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penerbit', 150);
            $table->text('alamat')->nullable();
            $table->string('kontak', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('rak', function (Blueprint $table) {
            $table->id();
            $table->string('kode_rak', 30)->unique();
            $table->string('nama_rak', 100);
            $table->string('lokasi', 150)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rak');
        Schema::dropIfExists('penerbit');
        Schema::dropIfExists('pengarang');
        Schema::dropIfExists('kategori');
    }
};
