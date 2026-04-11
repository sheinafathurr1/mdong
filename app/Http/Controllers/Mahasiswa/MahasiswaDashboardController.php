<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Application; 

class MahasiswaDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('mahasiswa')->user();

        // 1. Menghitung total proyek portofolio mahasiswa ini
        $projectCount = Project::where('mahasiswa_id', $user->mahasiswa_id)->count();

        // 2. Mengambil aplikasi terbaru (Sudah BERSIH dari pembimbing2)
        $latestApp = Application::with(['topik.dosen'])
                    ->where('mahasiswa_id', $user->mahasiswa_id)
                    ->orderBy('tanggal_submit', 'desc')
                    ->first();

        // 3. Kirim data ke view dashboard
        return view('mahasiswa.dashboard', compact('user', 'projectCount', 'latestApp'));
    }
}