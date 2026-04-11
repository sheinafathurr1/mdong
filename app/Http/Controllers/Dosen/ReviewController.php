<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\TopikInterest;

class ReviewController extends Controller
{
    // 1. Menampilkan Daftar Antrean dan Riwayat
    public function index()
    {
        $dosenId = Auth::guard('dosen')->id();
        
        // Ambil ID semua topik milik dosen ini
        $topikIds = TopikInterest::where('dosen_id', $dosenId)->pluck('topik_id');

        // Aplikasi yang masih menunggu
        $menunggu = Application::with(['mahasiswa', 'topik'])
            ->whereIn('topik_id', $topikIds)
            ->where('status', 'APPLIED')
            ->orderBy('tanggal_submit', 'asc')
            ->get();

        // Aplikasi yang sudah diproses (Riwayat)
        $riwayat = Application::with(['mahasiswa', 'topik'])
            ->whereIn('topik_id', $topikIds)
            ->whereIn('status', ['APPROVED', 'REJECTED'])
            ->orderBy('tanggal_response', 'desc')
            ->get();

        return view('dosen.review.index', compact('menunggu', 'riwayat'));
    }

    // 2. Menampilkan Detail Portofolio Mahasiswa
    public function show($id)
    {
        $dosenId = Auth::guard('dosen')->id();
        
        $application = Application::with(['mahasiswa.projects', 'topik'])->findOrFail($id);

        // Keamanan: Pastikan aplikasi ini melamar ke topik milik dosen yang sedang login
        if ($application->topik->dosen_id !== $dosenId) {
            abort(403, 'Anda tidak memiliki akses ke aplikasi ini.');
        }

        return view('dosen.review.show', compact('application'));
    }

    // 3. Memproses Keputusan (Approve / Reject)
    public function update(Request $request, $id)
    {
        $dosenId = Auth::guard('dosen')->id();
        $application = Application::with('topik')->findOrFail($id);

        if ($application->topik->dosen_id !== $dosenId) {
            abort(403);
        }

        // 1. Validasi diubah menjadi APPROVED
        $request->validate([
            'status' => 'required|in:APPROVED,REJECTED'
        ]);

        $statusBaru = $request->status;

        // 2. Pengecekan IF diubah menjadi APPROVED
        if ($statusBaru === 'APPROVED') {
            if ($application->topik->limit_applied >= $application->topik->limit_bimbingan) {
                return back()->with('error', 'Gagal menyetujui! Kuota bimbingan topik ini sudah penuh.');
            }
            // Tambah angka limit_applied di TopikInterest
            $application->topik->increment('limit_applied');
        }

        // Simpan perubahan ke tabel Application
        $application->update([
            'status' => $statusBaru,
            'tanggal_response' => now(),
        ]);

        // 3. Pesan sukses
        $pesan = $statusBaru === 'APPROVED' ? 'Aplikasi mahasiswa berhasil disetujui!' : 'Aplikasi mahasiswa telah ditolak.';

        return redirect()->route('dosen.review.index')->with('success', $pesan);
    }
}