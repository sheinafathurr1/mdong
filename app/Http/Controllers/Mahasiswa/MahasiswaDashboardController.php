<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Application; // Pastikan model ini sudah ada nantinya

class MahasiswaDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('mahasiswa')->user();

        // Menghitung total proyek portofolio mahasiswa ini
        $totalProject = Project::where('mahasiswa_id', $user->mahasiswa_id)->count();

        // Mengambil SEMUA riwayat aplikasi, diurutkan dari yang paling baru
        $riwayatAplikasi = Application::where('mahasiswa_id', $user->mahasiswa_id)
                    ->with(['topik.dosen', 'pembimbing2'])
                    ->orderBy('tanggal_submit', 'desc')
                    ->get();

        // Mengambil aplikasi terbaru (berada di urutan pertama dari riwayat)
        $aplikasi = $riwayatAplikasi->first();

        return view('mahasiswa.dashboard', compact('user', 'totalProject', 'aplikasi', 'riwayatAplikasi'));
    }
}