<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TopikInterest;
use App\Models\Periode;

class TopikInterestController extends Controller
{
    // 1. Menampilkan daftar topik dan mengecek izin pembuatan topik baru
    public function index()
    {
        $dosenId = Auth::guard('dosen')->id();
        
        $topiks = TopikInterest::with('periode')
                    ->where('dosen_id', $dosenId)
                    ->get()
                    ->sortByDesc(function($topik) {
                        return $topik->periode->start_date ?? '0000-00-00'; 
                    });

        // Cek Periode Aktif
        $periodeAktif = \App\Models\Periode::where('is_active', true)
                               ->whereDate('start_date', '<=', now())
                               ->whereDate('end_date', '>=', now())
                               ->latest('start_date')
                               ->first();

        $canCreate = false;
        $pesanBlokir = 'Tidak ada periode akademik yang sedang aktif.';

        if ($periodeAktif) {
            // Cek apakah dosen sudah buat topik di periode ini
            $topikAda = TopikInterest::where('dosen_id', $dosenId)
                                     ->where('periode_id', $periodeAktif->periode_id)
                                     ->exists();
            if (!$topikAda) {
                $canCreate = true;
            } else {
                $pesanBlokir = 'Anda sudah memiliki 1 topik pada periode aktif ini.';
            }
        }

        return view('dosen.topik.index', compact('topiks', 'canCreate', 'pesanBlokir'));
    }

    // 2. Menampilkan Form Tambah Topik (Proteksi Akses URL)
    public function create()
    {
        $periodeAktif = \App\Models\Periode::where('is_active', true)
                               ->whereDate('start_date', '<=', now())
                               ->whereDate('end_date', '>=', now())
                               ->latest('start_date')
                               ->first();

        if (!$periodeAktif) {
            return redirect()->route('dosen.topik.index')->with('error', 'Pembuatan topik ditutup. Tidak ada periode akademik yang sedang aktif saat ini.');
        }

        $topikAda = TopikInterest::where('dosen_id', Auth::guard('dosen')->id())
                                 ->where('periode_id', $periodeAktif->periode_id)
                                 ->exists();
                                 
        if ($topikAda) {
            return redirect()->route('dosen.topik.index')->with('error', 'Akses ditolak. Anda sudah membuat topik untuk periode aktif ini. Maksimal 1 topik per periode.');
        }

        return view('dosen.topik.create', compact('periodeAktif'));
    }

    // 3. Menyimpan Topik ke Database (Proteksi Form Resubmission)
    public function store(Request $request)
    {
        $periodeAktif = \App\Models\Periode::where('is_active', true)
                               ->whereDate('start_date', '<=', now())
                               ->whereDate('end_date', '>=', now())
                               ->latest('start_date')
                               ->first();

        if (!$periodeAktif || $request->periode_id != $periodeAktif->periode_id) {
            return redirect()->route('dosen.topik.index')->with('error', 'Gagal menyimpan. Periode tidak valid atau sudah ditutup.');
        }

        $topikAda = TopikInterest::where('dosen_id', Auth::guard('dosen')->id())
                                 ->where('periode_id', $periodeAktif->periode_id)
                                 ->exists();

        if ($topikAda) {
            return redirect()->route('dosen.topik.index')->with('error', 'Gagal menyimpan. Anda sudah memiliki topik pada periode ini.');
        }

        $request->validate([
            'periode_id' => 'required|exists:periode,periode_id',
            'nama_topik' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'requirement' => 'nullable|string',
            'limit_bimbingan' => 'required|integer|min:1',
        ]);

        TopikInterest::create([
            'dosen_id' => Auth::guard('dosen')->id(),
            'periode_id' => $request->periode_id,
            'nama_topik' => $request->nama_topik,
            'deskripsi' => $request->deskripsi,
            'requirement' => $request->requirement,
            'limit_bimbingan' => $request->limit_bimbingan,
            'limit_applied' => 0,
        ]);

        return redirect()->route('dosen.dashboard')->with('success', 'Topik Interest berhasil dipublikasikan!');
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $topik = TopikInterest::with('periode')
                    ->where('topik_id', $id)
                    ->where('dosen_id', Auth::guard('dosen')->id())
                    ->firstOrFail();

        // VALIDASI: Cek apakah periode topik ini masih aktif
        $now = now();
        $isPeriodeAktif = $topik->periode->is_active && $now->between($topik->periode->start_date, $topik->periode->end_date);
        
        if (!$isPeriodeAktif) {
            return redirect()->route('dosen.topik.index')->with('error', 'Akses ditolak. Topik ini sudah menjadi riwayat karena periodenya telah berakhir atau dinonaktifkan.');
        }

        return view('dosen.topik.edit', compact('topik'));
    }

    // Memproses update data
    public function update(Request $request, $id)
    {
        $topik = TopikInterest::with('periode')
                    ->where('topik_id', $id)
                    ->where('dosen_id', Auth::guard('dosen')->id())
                    ->firstOrFail();

        // VALIDASI: Cek apakah periode topik ini masih aktif
        $now = now();
        $isPeriodeAktif = $topik->periode->is_active && $now->between($topik->periode->start_date, $topik->periode->end_date);
        
        if (!$isPeriodeAktif) {
            return redirect()->route('dosen.topik.index')->with('error', 'Update dibatalkan. Topik ini sudah menjadi riwayat.');
        }

        $request->validate([
            'nama_topik' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'requirement' => 'nullable|string',
            'limit_bimbingan' => 'required|integer|min:1',
        ]);

        $topik->update($request->only(['nama_topik', 'deskripsi', 'requirement', 'limit_bimbingan']));

        return redirect()->route('dosen.topik.index')->with('success', 'Topik Interest berhasil diperbarui!');
    }
    

}