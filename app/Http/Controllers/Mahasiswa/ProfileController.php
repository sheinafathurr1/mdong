<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'photo' => 'nullable|image|max:2048',
        ]);

        // Simpan pembaruan ke database
        // Catatan: Nama, NIM, Kelas, Angkatan, Email biasanya fix dari kampus
        // Form upload foto hanya mengirim field 'photo', jadi no_tlp/url_sosmed
        // cuma ditimpa kalau field-nya memang ikut dikirim (dari form kontak).
        if ($request->has('no_tlp')) {
            $user->no_tlp = $request->no_tlp;
        }

        if ($request->has('url_sosmed')) {
            $user->url_sosmed = $request->url_sosmed;
        }

        if ($request->hasFile('photo')) {
            // Hapus foto lama supaya tidak menumpuk file yatim di storage
            if ($user->visual_path) {
                Storage::disk('public')->delete($user->visual_path);
            }

            $user->visual_path = $request->file('photo')->store('profil-mahasiswa', 'public');
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}