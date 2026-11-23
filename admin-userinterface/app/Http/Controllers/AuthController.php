<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Show login form with role options.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login authentication request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required',
            'password' => 'required|min:4',
            'role' => 'required|in:admin,petugas,anggota',
        ], [
            'identifier.required' => 'Username, Email, atau Nomor Anggota wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 4 karakter.',
            'role.required' => 'Pilih peran akses Anda.',
        ]);

        $identifier = trim($request->input('identifier'));
        $password = $request->input('password');
        $role = $request->input('role');
        $remember = $request->has('remember');

        // Simulated user directory based on database design (Option A)
        $usersDatabase = [
            'admin' => [
                'username' => 'admin.utama',
                'email' => 'admin@perpustakaan.go.id',
                'nip' => 'ADM-2024-001',
                'nama' => 'Admin Perpustakaan, S.Kom',
                'role' => 'admin',
                'avatar' => 'images/avatar-admin.png',
                'redirect' => 'dashboard',
                'welcome' => 'Selamat datang kembali, Administrator!'
            ],
            'petugas' => [
                'username' => 'budi.s',
                'email' => 'budi.santoso@perpustakaan.go.id',
                'nip' => 'STF-2024-008',
                'nama' => 'Budi Santoso, S.Kom',
                'role' => 'petugas',
                'avatar' => 'images/avatar-budi.png',
                'redirect' => 'dashboard',
                'welcome' => 'Selamat bertugas di meja sirkulasi, Petugas Budi!'
            ],
            'anggota' => [
                'username' => 'AGT-0001',
                'email' => 'putri.ayu@univ.ac.id',
                'no_anggota' => 'AGT-0001',
                'nama' => 'Putri Ayu Lestari',
                'role' => 'anggota',
                'avatar' => 'images/avatar-nabila.png',
                'redirect' => 'dashboard',
                'welcome' => 'Selamat datang di Portal Perpustakaan, Putri Ayu!'
            ],
        ];

        // Store active session profile for demonstration
        $currentProfile = $usersDatabase[$role] ?? $usersDatabase['admin'];
        Session::put('authenticated_user', $currentProfile);
        Session::put('user_role', $role);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $currentProfile['welcome'],
                'role' => $role,
                'redirect_url' => route($currentProfile['redirect'])
            ]);
        }

        return redirect()->route($currentProfile['redirect'])
            ->with('toast_success', $currentProfile['welcome']);
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Session::forget(['authenticated_user', 'user_role']);
        Session::flush();

        return redirect()->route('login')
            ->with('toast_info', 'Anda telah berhasil keluar dari sesi.');
    }
}
