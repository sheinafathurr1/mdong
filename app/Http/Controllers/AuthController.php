<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Menampilkan Halaman Login
    public function index()
    {
        return view('auth.login');
    }

    // 2. Memproses Login
    public function authenticate(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'role_type' => 'required|in:mahasiswa,dosen'
        ]);

        // 2. Siapkan array kredensial
        // PENTING: Jika di database Anda kolomnya bernama 'nim' atau 'nip', 
        // silakan ganti kata kunci 'username' di bawah ini sesuai nama kolom database Anda.
        $credentials = [
            'username' => $request->username, 
            'password' => $request->password
        ];

        // 3. Cek Role Type dan Lakukan Autentikasi ke Guard masing-masing
        if ($request->role_type === 'mahasiswa') {
            
            // Coba login sebagai mahasiswa
            if (Auth::guard('mahasiswa')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('mahasiswa.dashboard'); // Sesuaikan nama route dashboard Anda
            }

        } elseif ($request->role_type === 'dosen') {
            
            // Coba login sebagai dosen/prodi
            if (Auth::guard('dosen')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('dosen.dashboard'); // Sesuaikan nama route dashboard Anda
            }

        }

        // 4. Jika gagal, kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'login_error' => 'Username atau password tidak valid.',
        ])->onlyInput('username');
    }

    // 3. Memproses Logout (Fungsi yang terlewat)
    public function logout(Request $request)
    {
        // Cek guard mana yang sedang aktif, lalu logout
        if (Auth::guard('mahasiswa')->check()) {
            Auth::guard('mahasiswa')->logout();
        } elseif (Auth::guard('dosen')->check()) {
            Auth::guard('dosen')->logout();
        }

        // Hapus session agar aman
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Kembalikan ke halaman login
        return redirect('/login');
    }
}