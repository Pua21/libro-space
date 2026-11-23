<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
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

        // Look up user by username or email
        $user = User::where(function ($q) use ($identifier) {
            $q->where('username', $identifier)
              ->orWhere('email', $identifier);
        })->first();

        // If not found by username/email, check if identifier is an anggota's no_anggota
        if (!$user && $role === 'anggota') {
            $anggota = \App\Models\Anggota::where('no_anggota', $identifier)->first();
            if ($anggota) {
                $user = $anggota->user;
            }
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
            $redirectUrl = ($user->role === 'petugas' || $role === 'petugas') ? route('petugas.portal') : route('dashboard');

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
