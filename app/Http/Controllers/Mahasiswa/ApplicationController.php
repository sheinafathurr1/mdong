<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;

class ApplicationController extends Controller
{
    public function status()
    {
        $mahasiswaId = Auth::guard('mahasiswa')->id();
        
        // Ambil aplikasi terbaru milik mahasiswa ini beserta relasinya
        $aplikasi = Application::with(['topik.dosen', 'pembimbing2'])
                               ->where('mahasiswa_id', $mahasiswaId)
                               ->latest()
                               ->first();

        return view('mahasiswa.application.status', compact('aplikasi'));
    }
}