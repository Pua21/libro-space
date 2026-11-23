<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('anggota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->unique();
            $table->string('no_anggota', 30)->unique();
            $table->enum('tipe_anggota', ['mahasiswa', 'dosen', 'staf', 'umum'])->default('mahasiswa');
            $table->string('jurusan_unit', 100)->nullable();
            $table->string('no_telepon', 20);
            $table->text('alamat')->nullable();
            $table->date('tgl_registrasi')->nullable();
            $table->date('masa_berlaku')->nullable();
            $table->string('barcode', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('anggota');
    }
};
