<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Petugas;
use App\Models\Anggota;
use App\Models\LogAktivitas;

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
        $identifier = trim($request->input('username', $request->input('identifier', '')));

        $request->validate([
            'username' => 'required_without:identifier',
            'identifier' => 'required_without:username',
            'password' => 'required|min:4',
            'role' => 'required|in:admin,petugas,anggota',
        ], [
            'username.required_without' => 'Username akun wajib diisi.',
            'identifier.required_without' => 'Username akun wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 4 karakter.',
            'role.required' => 'Pilih peran akses Anda.',
        ]);

        $password = $request->input('password');
        $role = $request->input('role');
        $remember = $request->has('remember');

        // Look up user by username first
        $user = User::where('username', $identifier)->first();

        // If not found and role is anggota, try looking up by no_anggota
        if (!$user && $role === 'anggota') {
            $anggota = Anggota::where('no_anggota', $identifier)->first();
            if ($anggota) {
                $user = $anggota->user;
            }
        }

        // Secondary fallback to email if needed
        if (!$user) {
            $user = User::where('email', $identifier)->first();
        }

        // Verify user and password
        if ($user && Hash::check($password, $user->password)) {
            // Verify role matching
            if ($user->role !== $role && $user->role !== 'admin') {
                // Return role mismatch notice
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => "Akun ini terdaftar sebagai peran [{$user->role}], bukan [{$role}]."
                    ], 422);
                }
                return back()->withErrors(['identifier' => "Akun ini terdaftar sebagai peran [{$user->role}], bukan [{$role}]."]);
            }

            Auth::login($user, $remember);
            $user->update(['last_login_at' => now()]);

            // Save session profile
            $sessionProfile = [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'nama' => $user->name,
                'role' => $user->role,
                'avatar' => $user->avatar ?? 'images/avatar-admin.png',
                'status' => $user->status,
            ];
            Session::put('authenticated_user', $sessionProfile);
            Session::put('user_role', $user->role);

            // Record audit log
            try {
                LogAktivitas::create([
                    'user_id' => $user->id,
                    'nama_user' => $user->name,
                    'modul' => 'Autentikasi',
                    'aksi' => 'Login_Keamanan',
                    'deskripsi' => "berhasil login ke sistem sebagai [{$user->role}]",
                    'target' => 'Sesi Web',
                    'payload_json' => ['ip' => $request->ip(), 'agent' => $request->userAgent()],
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'device_info' => 'Browser Client (' . $request->ip() . ')',
                    'integrity_hash' => hash('sha256', $user->id . now()->toIso8601String()),
                ]);
            } catch (\Exception $e) {
                // Ignore audit log error if any
            }

            $welcomeMsg = "Selamat datang kembali, {$user->name}!";
            if ($user->role === 'petugas' || $role === 'petugas') {
                $redirectUrl = route('petugas.portal');
            } elseif ($user->role === 'anggota' || $role === 'anggota') {
                $redirectUrl = route('anggota.portal');
            } else {
                $redirectUrl = route('dashboard');
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $welcomeMsg,
                    'role' => $user->role,
                    'redirect_url' => $redirectUrl
                ]);
            }

            if ($user->role === 'petugas' || $role === 'petugas') {
                return redirect()->route('petugas.portal')
                    ->with('toast_success', $welcomeMsg);
            }

            if ($user->role === 'anggota' || $role === 'anggota') {
                return redirect()->route('anggota.portal')
                    ->with('toast_success', $welcomeMsg);
            }

            return redirect()->route('dashboard')
                ->with('toast_success', $welcomeMsg);
        }

        // Failed credentials
        if ($request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Kombinasi kredensial login atau kata sandi tidak valid.'
            ], 422);
        }

        return back()->withErrors(['identifier' => 'Kombinasi kredensial login atau kata sandi tidak valid.']);
    }

    /**
     * Handle registration for new Petugas and Anggota.
     */
    public function register(Request $request)
    {
        $role = $request->input('role');
        if (!in_array($role, ['petugas', 'anggota'])) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pendaftaran mandiri hanya terbuka untuk peran Petugas atau Anggota.'
                ], 422);
            }
            return back()->withInput()->withErrors(['role' => 'Pendaftaran mandiri hanya terbuka untuk peran Petugas atau Anggota.']);
        }

        $commonRules = [
            'name' => 'required|string|max:150',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:4|confirmed',
            'no_telepon' => 'required|string|max:20',
        ];

        if ($role === 'petugas') {
            $rules = array_merge($commonRules, [
                'nip' => 'nullable|string|max:30|unique:petugas,nip',
                'jabatan' => 'required|string|max:100',
                'divisi' => 'required|string|max:100',
            ]);
        } else {
            $rules = array_merge($commonRules, [
                'tipe_anggota' => 'required|in:mahasiswa,dosen,staf,umum',
                'jurusan_unit' => 'nullable|string|max:100',
                'alamat' => 'nullable|string|max:500',
            ]);
        }

        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username tersebut sudah digunakan.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Alamat email sudah terdaftar di sistem.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 4 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'no_telepon.required' => 'Nomor kontak telepon/WhatsApp wajib diisi.',
            'nip.unique' => 'NIP sudah terdaftar untuk petugas lain.',
            'jabatan.required' => 'Jabatan petugas wajib diisi.',
            'divisi.required' => 'Divisi unit kerja wajib diisi.',
            'tipe_anggota.required' => 'Pilih jenis keanggotaan.',
        ];

        $validated = $request->validate($rules, $messages);

        DB::beginTransaction();
        try {
            // Create User account
            $user = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $role,
                'avatar' => $role === 'petugas' ? 'images/avatar-budi.png' : 'images/avatar-nabila.png',
                'status' => 'aktif',
                'last_login_at' => now(),
            ]);

            if ($role === 'petugas') {
                Petugas::create([
                    'user_id' => $user->id,
                    'nip' => !empty($validated['nip']) ? $validated['nip'] : ('STF-' . date('Y') . '-' . str_pad($user->id, 3, '0', STR_PAD_LEFT)),
                    'jabatan' => $validated['jabatan'],
                    'divisi' => $validated['divisi'],
                    'no_telepon' => $validated['no_telepon'],
                ]);
            } else {
                $noAnggota = 'AGT-' . str_pad($user->id, 4, '0', STR_PAD_LEFT);
                Anggota::create([
                    'user_id' => $user->id,
                    'no_anggota' => $noAnggota,
                    'tipe_anggota' => $validated['tipe_anggota'],
                    'jurusan_unit' => $validated['jurusan_unit'] ?? null,
                    'no_telepon' => $validated['no_telepon'],
                    'alamat' => $validated['alamat'] ?? null,
                    'tgl_registrasi' => now()->toDateString(),
                    'masa_berlaku' => now()->addYear()->toDateString(),
                    'barcode' => 'BAR-' . $noAnggota,
                ]);
            }

            // Record audit log
            try {
                LogAktivitas::create([
                    'user_id' => $user->id,
                    'nama_user' => $user->name,
                    'modul' => 'Autentikasi',
                    'aksi' => 'Tambah',
                    'deskripsi' => "pendaftaran akun baru sebagai [{$role}]",
                    'target' => 'Registrasi Mandiri',
                    'ip_address' => $request->ip(),
                    'device_info' => 'Browser Client (' . $request->ip() . ')',
                    'integrity_hash' => hash('sha256', 'REG_' . $user->id . now()),
                ]);
            } catch (\Exception $e) {}

            DB::commit();

            // Set session profile
            Auth::login($user);
            Session::put('authenticated_user', [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'nama' => $user->name,
                'role' => $user->role,
                'avatar' => $user->avatar,
                'status' => $user->status,
            ]);
            Session::put('user_role', $user->role);

            $redirectUrl = $role === 'petugas' ? route('petugas.portal') : route('anggota.portal');
            $successMsg = "Pendaftaran berhasil! Selamat datang, {$user->name}.";

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $successMsg,
                    'role' => $user->role,
                    'redirect_url' => $redirectUrl,
                ]);
            }

            return redirect($redirectUrl)->with('toast_success', $successMsg);

        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mendaftarkan akun: ' . $e->getMessage()
                ], 500);
            }
            return back()->withInput()->withErrors(['general' => 'Terjadi kesalahan sistem saat pendaftaran: ' . $e->getMessage()]);
        }
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            try {
                LogAktivitas::create([
                    'user_id' => $user->id,
                    'nama_user' => $user->name,
                    'modul' => 'Autentikasi',
                    'aksi' => 'Login_Keamanan',
                    'deskripsi' => 'keluar dari sesi (logout)',
                    'target' => 'Sesi Web',
                    'ip_address' => $request->ip(),
                    'device_info' => 'Browser Client',
                    'integrity_hash' => hash('sha256', 'LOGOUT_' . $user->id . now()),
                ]);
            } catch (\Exception $e) {}
        }

        Auth::logout();
        Session::forget(['authenticated_user', 'user_role']);
        Session::flush();

        return redirect()->route('login')
            ->with('toast_info', 'Anda telah berhasil keluar dari sesi.');
    }
}
