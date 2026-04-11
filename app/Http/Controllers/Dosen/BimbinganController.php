<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\TopikInterest;

class BimbinganController extends Controller
{
    public function index()
    {
        $dosenId = Auth::guard('dosen')->id();

        // Cari ID Topik di mana dosen ini adalah pembuatnya
        $topikIds = TopikInterest::where('dosen_id', $dosenId)->pluck('topik_id');

        // Ambil semua mahasiswa yang sudah resmi disetujui (APPROVED)
        $bimbingans = Application::with(['mahasiswa', 'topik'])
            ->where('status', 'APPROVED')
            ->whereIn('topik_id', $topikIds)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('dosen.bimbingan.index', compact('bimbingans'));
    }
}