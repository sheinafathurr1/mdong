<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TopikInterest;
use App\Models\Periode;
use App\Models\Application;
use App\Models\Project;

class TopikController extends Controller
{
    // 1. Menampilkan Daftar Semua Topik Dosen dengan Fitur Search & Filter
    public function index(Request $request)
    {
        // Cari periode yang aktif
        $periodeAktif = \App\Models\Periode::where('is_active', true)
                               ->whereDate('start_date', '<=', now())
                               ->whereDate('end_date', '>=', now())
                               ->latest('start_date')
                               ->first();
        
        $topiks = collect(); 
        
        if ($periodeAktif) {
            // Mulai Query Builder
            $query = TopikInterest::with('dosen')
                        ->where('periode_id', $periodeAktif->periode_id);

            // FITUR PENCARIAN (Search HANYA berdasarkan Nama Topik)
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('nama_topik', 'like', '%' . $search . '%');
            }

            // FITUR FILTER (Ketersediaan Kuota)
            if ($request->filled('ketersediaan') && $request->ketersediaan === 'tersedia') {
                // Membandingkan dua kolom di database: limit_bimbingan > limit_applied
                $query->whereColumn('limit_bimbingan', '>', 'limit_applied');
            }

            // Eksekusi Query
            $topiks = $query->get();
        }

        // Cek apakah mahasiswa sudah punya aplikasi aktif
        $hasApplication = \App\Models\Application::where('mahasiswa_id', \Illuminate\Support\Facades\Auth::guard('mahasiswa')->id())
                                     ->whereIn('status', ['DRAFT', 'APPLIED', 'APPROVED-PBB1', 'APPROVED-FULL'])
                                     ->exists();

        return view('mahasiswa.topik.index', compact('topiks', 'periodeAktif', 'hasApplication'));
    }

    // 2. Menampilkan Detail Satu Topik
    public function show($id)
    {
        $topik = TopikInterest::with('dosen')->findOrFail($id);
        $mahasiswaId = Auth::guard('mahasiswa')->id();
        
        // Cek apakah punya aplikasi yang sedang berjalan/disetujui
        $hasApplication = Application::where('mahasiswa_id', $mahasiswaId)
                                     ->whereIn('status', ['DRAFT', 'APPLIED', 'APPROVED-PBB1', 'APPROVED-FULL'])
                                     ->exists();
                                     
        // Cek apakah punya portofolio
        $hasPortofolio = Project::where('mahasiswa_id', $mahasiswaId)->exists();

        // Cek apakah PERNAH DITOLAK di topik INI secara spesifik
        $isRejectedFromThisTopic = Application::where('mahasiswa_id', $mahasiswaId)
                                              ->where('topik_id', $id)
                                              ->where('status', 'REJECTED')
                                              ->exists();

        return view('mahasiswa.topik.show', compact('topik', 'hasApplication', 'hasPortofolio', 'isRejectedFromThisTopic'));
    }

    // 3. Memproses Pendaftaran (Apply) Topik
    public function apply(Request $request, $id)
    {
        $mahasiswaId = Auth::guard('mahasiswa')->id();

        // Validasi 1: Pastikan sudah punya portofolio
        if (!Project::where('mahasiswa_id', $mahasiswaId)->exists()) {
            return redirect()->route('mahasiswa.project.create')
                             ->with('error', 'Anda harus memiliki minimal 1 portofolio sebelum mendaftar topik.');
        }

        // Validasi 2: Pastikan belum apply topik lain yang sedang aktif
        $existingApp = Application::where('mahasiswa_id', $mahasiswaId)
                                  ->whereIn('status', ['APPLIED', 'APPROVED-PBB1', 'APPROVED-FULL'])
                                  ->first();
                                  
        if ($existingApp) {
            return back()->with('error', 'Anda sudah mengajukan topik. Tunggu hasil review dosen terlebih dahulu.');
        }

        // Validasi 3: Mencegah apply ulang ke topik yang pernah menolaknya
        $isRejectedFromThisTopic = Application::where('mahasiswa_id', $mahasiswaId)
                                              ->where('topik_id', $id)
                                              ->where('status', 'REJECTED')
                                              ->exists();
                                              
        if ($isRejectedFromThisTopic) {
            return back()->with('error', 'Anda sudah pernah ditolak pada topik ini. Silakan cari topik dari dosen lain.');
        }

        // Buat Aplikasi Baru
        Application::create([
            'mahasiswa_id' => $mahasiswaId,
            'topik_id' => $id,
            'tanggal_submit' => now(),
            'status' => 'APPLIED'
        ]);

        return redirect()->route('mahasiswa.dashboard')
                         ->with('success', 'Aplikasi berhasil dikirim! Silakan tunggu review dari dosen terkait.');
    }
}