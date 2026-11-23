<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('petugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->unique();
            $table->string('nip', 30)->unique()->nullable();
            $table->string('jabatan', 100)->default('Petugas Perpustakaan');
            $table->string('divisi', 100)->default('Sirkulasi & Layanan');
            $table->string('no_telepon', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('petugas');
    }
};
