<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $periodeAktif = Periode::aktif()->first();

        $topiks = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 9);

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
                // Masih bisa didaftar kalau kuota bimbingan asli belum penuh
                // DAN kuota reservasi (antrean, 2x kuota bimbingan) belum penuh.
                $query->whereColumn('limit_bimbingan', '>', 'limit_applied')
                      ->whereRaw('reservasi_applied < limit_bimbingan * 2');
            }

            // Eksekusi Query
            $topiks = $query->paginate(9)->withQueryString();
        }

        // Cek apakah mahasiswa sudah punya aplikasi aktif
        $hasApplication = \App\Models\Application::where('mahasiswa_id', \Illuminate\Support\Facades\Auth::guard('mahasiswa')->id())
                                     ->whereIn('status', ['APPLIED', 'APPROVED'])
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
                                     ->whereIn('status', ['APPLIED', 'APPROVED'])
                                     ->exists();
                                     
        // Cek apakah punya portofolio
        $hasPortofolio = Project::where('mahasiswa_id', $mahasiswaId)->exists();

        // Cek apakah PERNAH DITOLAK di topik INI secara spesifik
        $isRejectedFromThisTopic = Application::where('mahasiswa_id', $mahasiswaId)
                                              ->where('topik_id', $id)
                                              ->where('status', 'REJECTED')
                                              ->exists();

        // Kuota reservasi (antrean) penuh, terlepas dari kuota bimbingan masih ada atau tidak
        $reservasiPenuh = $topik->reservasi_applied >= $topik->limit_reservasi;

        return view('mahasiswa.topik.show', compact('topik', 'hasApplication', 'hasPortofolio', 'isRejectedFromThisTopic', 'reservasiPenuh'));
    }

    // 3. Memproses Pendaftaran (Apply) Topik
    public function apply(Request $request, $id)
    {
        $mahasiswaId = Auth::guard('mahasiswa')->id();
        $topik = TopikInterest::findOrFail($id);

        // Validasi 0: Topik harus milik periode yang sedang aktif dan kuotanya belum penuh
        $periodeAktif = Periode::aktif()->first();
        if (!$periodeAktif || $topik->periode_id !== $periodeAktif->periode_id) {
            return back()->with('error', 'Topik ini tidak lagi dibuka pada periode aktif saat ini.');
        }

        if ($topik->limit_applied >= $topik->limit_bimbingan) {
            return back()->with('error', 'Kuota bimbingan topik ini sudah penuh.');
        }

        // Validasi 1: Pastikan sudah punya portofolio
        if (!Project::where('mahasiswa_id', $mahasiswaId)->exists()) {
            return redirect()->route('mahasiswa.project.create')
                             ->with('error', 'Anda harus memiliki minimal 1 portofolio sebelum mendaftar topik.');
        }

        // Validasi 2: Pastikan belum apply topik lain yang sedang aktif
        $existingApp = Application::where('mahasiswa_id', $mahasiswaId)
                                  ->whereIn('status', ['APPLIED', 'APPROVED'])
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

        // Validasi 4: Kuota reservasi (antrean) belum penuh. Yang berkurang saat
        // apply adalah kuota reservasi (2x kuota bimbingan), BUKAN kuota
        // bimbingan itu sendiri -- kuota bimbingan baru berkurang saat disetujui
        // dosen (lihat ReviewController::update). Dikunci agar aman dari race
        // condition kalau ada beberapa mahasiswa apply bersamaan.
        $reservasiPenuh = DB::transaction(function () use ($id, $mahasiswaId) {
            $topik = TopikInterest::where('topik_id', $id)->lockForUpdate()->first();

            if ($topik->reservasi_applied >= $topik->limit_reservasi) {
                return true;
            }

            $topik->increment('reservasi_applied');

            Application::create([
                'mahasiswa_id' => $mahasiswaId,
                'topik_id' => $id,
                'tanggal_submit' => now(),
                'status' => 'APPLIED',
            ]);

            return false;
        });

        if ($reservasiPenuh) {
            return back()->with('error', 'Kuota reservasi (antrean) topik ini sudah penuh.');
        }

        return redirect()->route('mahasiswa.dashboard')
                         ->with('success', 'Aplikasi berhasil dikirim! Silakan tunggu review dari dosen terkait.');
    }
}