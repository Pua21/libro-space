<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AnggotaPortalController extends Controller
{
    /**
     * Tampilkan Portal Anggota (Libro Space).
     */
    public function index()
    {
        return view('anggota.portal');
    }

    /**
     * Memperbarui foto profil anggota.
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'avatar_base64' => 'nullable|string',
        ]);

        $user = Auth::user();
        if (!$user && session()->has('authenticated_user')) {
            $user = User::find(session('authenticated_user.id'));
        }

        $avatarPath = null;

        // 1. Tangani Upload File Biasa
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = 'avatar_' . ($user ? $user->id : 'member') . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('avatars', $fileName, 'public');
            $avatarPath = 'storage/' . $path;
        } 
        // 2. Tangani Upload Base64 (Data URL)
        elseif ($request->filled('avatar_base64')) {
            $base64 = $request->input('avatar_base64');
            if (preg_match('/^data:image\/(\w+);base64,/', $base64, $matches)) {
                $ext = strtolower($matches[1]);
                $data = substr($base64, strpos($base64, ',') + 1);
                $decoded = base64_decode($data);
                if ($decoded !== false) {
                    $fileName = 'avatar_' . ($user ? $user->id : 'member') . '_' . time() . '.' . $ext;
                    Storage::disk('public')->put('avatars/' . $fileName, $decoded);
                    $avatarPath = 'storage/avatars/' . $fileName;
                }
            }
        }

        if ($avatarPath) {
            if ($user) {
                $user->avatar = $avatarPath;
                $user->save();

                if (session()->has('authenticated_user')) {
                    $sess = session('authenticated_user');
                    $sess['avatar'] = $avatarPath;
                    session(['authenticated_user' => $sess]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil diperbarui.',
                'avatar_url' => asset($avatarPath),
                'avatar_path' => $avatarPath,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Tidak ada file gambar valid yang dikirim.',
        ], 422);
    }
}
