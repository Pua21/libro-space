<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class PetugasAnggotaSeeder extends Seeder
{
    private const DEMO_PASSWORD = 'LibroSpace-Demo!2026';

    public function run(): void
    {
        if (! app()->environment(['local', 'testing'])) {
            return;
        }

        $now = now();

        DB::transaction(function () use ($now): void {
            $this->seedProfile('petugas', [
                'email' => 'petugas.demo@example.test',
                'username' => 'petugas_demo',
                'name' => 'Petugas Demo',
                'status' => 'aktif',
            ], [
                'nip' => 'PTG-DEMO-001',
                'jabatan' => 'Petugas Sirkulasi',
                'divisi' => 'Perpustakaan',
            ]);

            $this->seedProfile('anggota', [
                'email' => 'anggota.demo@example.test',
                'username' => 'anggota_demo',
                'name' => 'Anggota Demo',
                'status' => 'aktif',
            ], [
                'no_anggota' => 'AGT-DEMO-001',
                'tipe_anggota' => 'mahasiswa',
                'no_telepon' => '000000000001',
                'tgl_registrasi' => $now->toDateString(),
                'masa_berlaku' => $now->copy()->addYear()->toDateString(),
            ]);
        });
    }

    private function seedProfile(string $role, array $account, array $profile): void
    {
        $user = User::query()->firstOrCreate(['email' => $account['email']], [
            'username' => $account['username'],
            'name' => $account['name'],
            'role' => $role,
            'status' => $account['status'],
            'password' => self::DEMO_PASSWORD,
        ]);

        // A migration rollback can leave demo users with their original Laravel fields.
        if ($user->role === null && $user->username === null
            && $user->name === $account['name'] && Hash::check(self::DEMO_PASSWORD, $user->password)) {
            $user->forceFill([
                'username' => $account['username'],
                'role' => $role,
                'status' => $account['status'],
            ])->save();
        }

        if ($user->username !== $account['username'] || $user->role !== $role) {
            throw new RuntimeException('Email demo sudah dipakai oleh akun lain: '.$account['email']);
        }

        if (! DB::table($role)->where('user_id', $user->id)->exists()) {
            DB::table($role)->insert([
                ...$profile,
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}