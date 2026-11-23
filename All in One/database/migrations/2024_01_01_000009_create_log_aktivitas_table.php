<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('nama_user', 100);
            $table->string('modul', 50);
            $table->enum('aksi', ['Tambah', 'Ubah', 'Hapus', 'Login_Keamanan']);
            $table->text('deskripsi');
            $table->string('target', 255)->nullable();
            $table->json('payload_json')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device_info', 150)->nullable();
            $table->string('integrity_hash', 64)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('log_aktivitas');
    }
};
