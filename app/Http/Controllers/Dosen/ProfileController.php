<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function index()
    {
        $user = Auth::guard('dosen')->user();
        return view('dosen.profile', compact('user'));
    }

    // Memproses update profil
    public function update(Request $request)
    {
        $user = Auth::guard('dosen')->user();

        // Validasi data yang boleh diubah
        $request->validate([
            'no_tlp' => 'nullable|string|max:20',
            'link_grup' => 'nullable|url|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Catatan: Nama, Username, Email, Kode, NIP, Program Studi biasanya fix dari kampus.
        // Form upload foto hanya mengirim field 'photo', jadi field lain cuma ditimpa
        // kalau memang ikut dikirim (dari form info kontak & grup).
        if ($request->has('no_tlp')) {
            $user->no_tlp = $request->no_tlp;
        }

        if ($request->has('link_grup')) {
            $user->link_grup = $request->link_grup;
        }

        if ($request->hasFile('photo')) {
            // Hapus foto lama supaya tidak menumpuk file yatim di storage
            if ($user->visual_path) {
                Storage::disk('public')->delete($user->visual_path);
            }

            $user->visual_path = $request->file('photo')->store('profil-dosen', 'public');
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
