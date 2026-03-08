<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function index()
    {
        $user = Auth::guard('mahasiswa')->user();
        return view('mahasiswa.profile', compact('user'));
    }

    // Memproses update profil
    public function update(Request $request)
    {
        $user = Auth::guard('mahasiswa')->user();

        // Validasi data yang boleh diubah
        $request->validate([
            'no_tlp' => 'nullable|string|max:20',
            'url_sosmed' => 'nullable|url|max:255',
        ]);

        // Simpan pembaruan ke database
        // Catatan: Nama, NIM, Kelas, Angkatan, Email biasanya fix dari kampus
        $user->no_tlp = $request->no_tlp;
        $user->url_sosmed = $request->url_sosmed;
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}