@extends('mahasiswa.layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<style>
    /* Styling Banner & Card */
    .welcome-banner { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; border-radius: 24px; position: relative; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.1); }
    .welcome-banner::after { content: ''; position: absolute; right: -5%; top: -20%; width: 300px; height: 300px; background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%); border-radius: 50%; pointer-events: none; }
    
    .dashboard-card { transition: all 0.3s ease; border: 1px solid #e2e8f0; border-radius: 20px; background: #ffffff; overflow: hidden; }
    .dashboard-card:hover { transform: translateY(-3px); box-shadow: 0 15px 30px -5px rgba(0,0,0,0.05); border-color: #cbd5e1; }
    
    .icon-box-lg { width: 64px; height: 64px; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; flex-shrink: 0; }

    /* Alert Status Canggih */
    .status-alert { border-radius: 20px; border-left: 6px solid; padding: 1.5rem 2rem; position: relative; overflow: hidden; }
    .status-alert::before { content: ''; position: absolute; right: -20px; top: -20px; width: 100px; height: 100px; border-radius: 50%; opacity: 0.1; }
    
    .status-applied { background-color: #fffbeb; border-color: #f59e0b; }
    .status-applied::before { background-color: #f59e0b; }
    .status-applied .icon-bg { background-color: rgba(245, 158, 11, 0.2); color: #d97706; }
    
    .status-approved { background-color: #f0fdf4; border-color: #10b981; }
    .status-approved::before { background-color: #10b981; }
    .status-approved .icon-bg { background-color: rgba(16, 185, 129, 0.2); color: #059669; }
    
    .status-rejected { background-color: #fef2f2; border-color: #ef4444; }
    .status-rejected::before { background-color: #ef4444; }
    .status-rejected .icon-bg { background-color: rgba(239, 68, 68, 0.2); color: #dc2626; }
</style>

<div class="welcome-banner p-4 p-md-5 mb-4 mb-xl-5">
    <div class="row align-items-center position-relative" style="z-index: 2;">
        <div class="col-md-8">
            <span class="badge bg-white text-dark px-3 py-2 rounded-pill fw-bold shadow-sm mb-3" style="font-size: 0.7rem; letter-spacing: 1px;">PORTAL MAHASISWA</span>
            <h2 class="fw-black mb-2">Halo, {{ explode(' ', $user->nama)[0] }}! 🚀</h2>
            <p class="text-white-50 fs-6 mb-0" style="max-width: 500px; line-height: 1.6;">
                Persiapkan portofolio karya terbaikmu, temukan topik penelitian yang menantang, dan raih persetujuan Dosen Pembimbing untuk memulai Tugas Akhir.
            </p>
        </div>
        <div class="col-md-4 text-end d-none d-md-block">
            <i class="bi bi-mortarboard text-white-50" style="font-size: 8rem; opacity: 0.2;"></i>
        </div>
    </div>
</div>

@if(!$latestApp)
    <div class="card dashboard-card border-dashed mb-5 p-4 p-md-5 text-center bg-light border-0" style="border: 2px dashed #cbd5e1 !important;">
        <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow-sm" style="width: 80px; height: 80px;">
            <i class="bi bi-rocket-takeoff fs-1 text-dark"></i>
        </div>
        <h4 class="fw-bold text-dark mb-2">Mulai Perjalanan Pra-TA Anda</h4>
        <p class="text-muted mx-auto mb-4" style="max-width: 500px;">
            Anda belum memiliki pengajuan topik yang aktif. Langkah pertama adalah menyusun portofolio karya, lalu mulai mengeksplorasi topik yang ditawarkan oleh Dosen Prodi.
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('mahasiswa.project.create') }}" class="btn btn-outline-dark rounded-pill px-4 py-2 fw-bold border-2">
                <i class="bi bi-folder-plus me-2"></i> Isi Portofolio
            </a>
            <a href="{{ route('mahasiswa.topik.index') }}" class="btn btn-dark rounded-pill px-4 py-2 fw-bold shadow-sm">
                Cari Topik Interest <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>

@elseif($latestApp->status == 'APPLIED')
    <div class="status-alert status-applied mb-5 shadow-sm">
        <div class="d-flex flex-column flex-md-row align-items-md-center gap-4">
            <div class="icon-bg rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 70px; height: 70px;">
                <span class="spinner-border spinner-border-sm fs-4" style="width: 2rem; height: 2rem; border-width: 0.25em;" role="status"></span>
            </div>
            <div>
                <h5 class="fw-black text-dark mb-1">Pengajuan Sedang Direview</h5>
                <p class="text-dark opacity-75 mb-0 fw-medium">
                    Portofolio Anda untuk topik <strong>"{{ $latestApp->topik->nama_topik }}"</strong> sedang dievaluasi oleh dosen terkait. Harap bersabar menunggu hasil keputusan.
                </p>
            </div>
            <div class="ms-md-auto mt-3 mt-md-0">
                <a href="{{ route('mahasiswa.application.status') }}" class="btn btn-dark btn-sm rounded-pill px-4 py-2 fw-bold shadow-sm text-nowrap">Cek Detail Status</a>
            </div>
        </div>
    </div>

@elseif($latestApp->status == 'APPROVED')
    <div class="status-alert status-approved mb-5 shadow-sm">
        <div class="d-flex flex-column flex-md-row align-items-md-center gap-4">
            <div class="icon-bg rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 70px; height: 70px;">
                <i class="bi bi-check-circle-fill fs-2"></i>
            </div>
            <div>
                <span class="badge bg-white text-success border border-success rounded-pill px-3 py-1 mb-2 fw-bold" style="font-size: 0.7rem;">DITERIMA & FINAL</span>
                <h5 class="fw-black text-dark mb-1">Selamat! Pembimbing Ditetapkan</h5>
                <p class="text-dark opacity-75 mb-0 fw-medium">
                    Anda telah resmi diterima pada topik <strong>"{{ $latestApp->topik->nama_topik }}"</strong>. Anda kini dapat mulai bimbingan Tugas Akhir.
                </p>
            </div>
            <div class="ms-md-auto mt-3 mt-md-0 text-md-end">
                <div class="small text-muted fw-bold text-uppercase tracking-wide mb-1" style="font-size: 0.65rem;">Dosen Pembimbing</div>
                <div class="fw-bold text-dark bg-white px-3 py-2 rounded-3 border shadow-sm d-inline-block">
                    <i class="bi bi-person-workspace me-2 text-success"></i>{{ $latestApp->dosen->nama ?? 'Dosen' }}
                </div>
            </div>
        </div>
    </div>

@elseif($latestApp->status == 'REJECTED')
    <div class="status-alert status-rejected mb-5 shadow-sm">
        <div class="d-flex flex-column flex-md-row align-items-md-center gap-4">
            <div class="icon-bg rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 70px; height: 70px;">
                <i class="bi bi-x-circle-fill fs-2"></i>
            </div>
            <div>
                <h5 class="fw-black text-dark mb-1">Pengajuan Ditolak</h5>
                <p class="text-dark opacity-75 mb-0 fw-medium">
                    Maaf, pengajuan Anda untuk topik <strong>"{{ $latestApp->topik->nama_topik }}"</strong> belum dapat diterima oleh dosen. Jangan menyerah, silakan mendaftar ke topik lain!
                </p>
            </div>
            <div class="ms-md-auto mt-3 mt-md-0">
                <a href="{{ route('mahasiswa.topik.index') }}" class="btn btn-danger rounded-pill px-4 py-2 fw-bold shadow-sm text-nowrap">
                    Cari Topik Lain <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
@endif

<div class="row g-4 mb-4">
    
    <div class="col-md-6">
        <div class="card dashboard-card h-100 p-4">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div class="icon-box-lg bg-light text-dark border">
                    <i class="bi bi-folder-fill"></i>
                </div>
                <a href="{{ route('mahasiswa.project.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill fw-bold">Kelola Karya</a>
            </div>
            <h5 class="fw-bold text-dark mb-1">Portofolio Saya</h5>
            <div class="d-flex align-items-center gap-2 mb-3">
                <h2 class="fw-black text-dark mb-0">{{ $projectCount }}</h2>
                <span class="text-muted fw-medium">Karya Diunggah</span>
            </div>
            <p class="text-muted small fw-medium mb-0">
                Portofolio ini akan dikirimkan secara anonim *(Blind Review)* saat Anda melamar sebuah topik interest.
            </p>
            
            @if($projectCount == 0)
                <div class="mt-3 pt-3 border-top">
                    <span class="text-danger small fw-bold"><i class="bi bi-exclamation-triangle-fill me-1"></i> Portofolio masih kosong. Wajib diisi!</span>
                </div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="card dashboard-card h-100 p-4" style="background: #f8fafc;">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div class="icon-box-lg bg-dark text-white shadow-sm">
                    <i class="bi bi-info-circle-fill"></i>
                </div>
            </div>
            <h5 class="fw-bold text-dark mb-2">Panduan Pra-TA</h5>
            <ul class="list-unstyled text-muted small fw-medium mb-0" style="line-height: 1.8;">
                <li class="d-flex align-items-start mb-2"><i class="bi bi-1-circle-fill text-dark me-2 mt-1"></i> Lengkapi portofolio perancangan atau analisis.</li>
                <li class="d-flex align-items-start mb-2"><i class="bi bi-2-circle-fill text-dark me-2 mt-1"></i> Pilih maksimal 1 (satu) topik interest dosen.</li>
                <li class="d-flex align-items-start mb-2"><i class="bi bi-3-circle-fill text-dark me-2 mt-1"></i> Identitas Dosen disembunyikan sampai Anda diterima.</li>
                <li class="d-flex align-items-start"><i class="bi bi-4-circle-fill text-dark me-2 mt-1"></i> Keputusan Dosen mutlak dan tidak dapat diganggu gugat.</li>
            </ul>
        </div>
    </div>

</div>
@endsection