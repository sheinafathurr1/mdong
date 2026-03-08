<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TopikInterest;
use App\Models\Application;
use App\Models\Periode; // Pastikan import model Periode

class DosenDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('dosen')->user();

        // 1. Cari periode yang benar-benar aktif saat ini
        $periodeAktif = Periode::where('is_active', true)
                               ->whereDate('start_date', '<=', now())
                               ->whereDate('end_date', '>=', now())
                               ->latest('start_date')
                               ->first();

        $topik = null;
        $sisaLimit = 0;
        $menungguReview = 0;

        // 2. Jika ada periode aktif, baru cari topik milik dosen ini untuk periode tersebut
        if ($periodeAktif) {
            $topik = TopikInterest::where('dosen_id', $user->dosen_id)
                                  ->where('periode_id', $periodeAktif->periode_id)
                                  ->first();

            // 3. Jika topiknya sudah dibuat, hitung statistiknya
            if ($topik) {
                $sisaLimit = $topik->limit_bimbingan - $topik->limit_applied;
                
                $menungguReview = Application::where('topik_id', $topik->topik_id)
                                             ->where('status', 'APPLIED')
                                             ->count();
            }
        }

        // Kirim $periodeAktif ke view agar bisa dikelola tampilannya
        return view('dosen.dashboard', compact('user', 'topik', 'sisaLimit', 'menungguReview', 'periodeAktif'));
    }
}