<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 50)->nullable()->unique();
            $table->enum('role', ['admin', 'petugas', 'anggota'])->nullable();
            $table->enum('status', ['menunggu_persetujuan', 'aktif', 'nonaktif', 'suspend'])
                ->default('nonaktif');
            $table->string('avatar')->nullable();
            $table->timestamp('last_login_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn(['username', 'role', 'status', 'avatar', 'last_login_at']);
        });
    }
};
