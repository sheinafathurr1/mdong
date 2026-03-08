<?php

namespace App\Http\Controllers\Prodi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Dosen;

class AssignController extends Controller
{
    public function index()
    {
        // 1. Ambil aplikasi yang butuh Pembimbing 2
        $butuhAssign = Application::with(['mahasiswa', 'topik.dosen'])
            ->where('status', 'APPROVED-PBB1')
            ->orderBy('tanggal_response', 'asc')
            ->get();

        // 2. Ambil riwayat aplikasi yang sudah selesai (APPROVED-FULL)
        $riwayat = Application::with(['mahasiswa', 'topik.dosen', 'pembimbing2'])
            ->where('status', 'APPROVED-FULL')
            ->orderBy('updated_at', 'desc')
            ->get();

        // 3. Ambil daftar semua dosen untuk dropdown pilihan
        $dosens = Dosen::orderBy('nama', 'asc')->get();

        return view('dosen.prodi.assign.index', compact('butuhAssign', 'riwayat', 'dosens'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pembimbing_2_id' => 'required|exists:dosen,dosen_id'
        ]);

        $application = Application::with('topik')->findOrFail($id);

        // Validasi Ekstra: Pembimbing 2 tidak boleh sama dengan Pembimbing 1
        if ($application->topik->dosen_id == $request->pembimbing_2_id) {
            return back()->with('error', 'Pembimbing 2 tidak boleh orang yang sama dengan Pembimbing 1!');
        }

        // Update database
        $application->update([
            'pembimbing_2_id' => $request->pembimbing_2_id,
            'status' => 'APPROVED-FULL'
        ]);

        return redirect()->route('dosen.prodi.assign.index')
                         ->with('success', 'Pembimbing 2 berhasil ditugaskan. Status mahasiswa kini APPROVED-FULL.');
    }
}