<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('no_anggota', 30)->unique();
            $table->enum('tipe_anggota', ['mahasiswa', 'dosen', 'staf', 'umum']);
            $table->string('jurusan_unit', 100)->nullable();
            $table->string('no_telepon', 20);
            $table->text('alamat')->nullable();
            $table->date('tgl_registrasi');
            $table->date('masa_berlaku');
            $table->string('barcode', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};
