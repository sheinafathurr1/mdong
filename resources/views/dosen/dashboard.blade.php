@extends('dosen.layouts.app')

@section('title', 'Dashboard Dosen')

@section('content')
<style>
    /* Styling khusus Dashboard Dosen */
    .welcome-banner { background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white; border-radius: 24px; position: relative; overflow: hidden; }
    .welcome-banner::after { content: ''; position: absolute; right: -5%; top: -20%; width: 300px; height: 300px; background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%); border-radius: 50%; pointer-events: none; }
    
    .stat-card { transition: all 0.3s ease; border: 1px solid #e2e8f0; border-radius: 20px; background: #ffffff; overflow: hidden; display: flex; flex-direction: column; }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px -5px rgba(0,0,0,0.05); border-color: #cbd5e1; }
    
    .icon-box-lg { width: 64px; height: 64px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; flex-shrink: 0; }
    
    .prompt-card { border: 2px dashed #cbd5e1; border-radius: 24px; background: #f8fafc; transition: all 0.3s; }
    .prompt-card:hover { border-color: #94a3b8; background: #ffffff; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05); }

    /* Animasi Notifikasi */
    @keyframes pulse-red {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }
    .pulse-animation { animation: pulse-red 2s infinite; }
</style>

<div class="welcome-banner p-4 p-md-5 mb-5 shadow-sm">
    <div class="row align-items-center position-relative" style="z-index: 2;">
        <div class="col-md-8">
            <span class="badge bg-white text-dark px-3 py-2 rounded-pill fw-bold shadow-sm mb-3" style="font-size: 0.7rem; letter-spacing: 1px;">PORTAL DOSEN</span>
            <h2 class="fw-black mb-2">Selamat datang, {{ $user->nama }}! 👋</h2>
            <p class="text-white-50 fs-6 mb-0" style="max-width: 500px; line-height: 1.6;">
                Pantau kuota bimbingan, review portofolio mahasiswa, dan kelola aktivitas Pra-Tugas Akhir Anda di sini.
            </p>
        </div>
        <div class="col-md-4 text-end d-none d-md-block">
            <i class="bi bi-person-workspace text-white-50" style="font-size: 8rem; opacity: 0.2;"></i>
        </div>
    </div>
</div>

@if(!$periodeAktif)
    <div class="alert alert-danger bg-danger-subtle border-danger border-2 p-4 p-md-5 rounded-4 mb-5 shadow-sm d-flex flex-column flex-md-row align-items-center gap-4 text-center text-md-start">
        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 shadow" style="width: 70px; height: 70px;">
            <i class="bi bi-calendar-x fs-2"></i>
        </div>
        <div>
            <h4 class="fw-black text-danger-emphasis mb-2">Sistem Pra-TA Sedang Ditutup</h4>
            <p class="text-danger-emphasis mb-0 fw-medium">
                Saat ini tidak ada periode akademik yang berstatus aktif. Anda tidak dapat membuat topik interest baru atau menerima mahasiswa bimbingan hingga Admin Prodi membuka kembali periode pendaftaran.
            </p>
        </div>
    </div>

@elseif(!$topik)
    <div class="prompt-card p-5 text-center mb-5 d-flex flex-column align-items-center justify-content-center">
        <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center mb-4 shadow-sm" style="width: 80px; height: 80px;">
            <i class="bi bi-journal-plus fs-1"></i>
        </div>
        <h3 class="fw-black text-dark mb-2">Topik Interest Belum Diatur</h3>
        <p class="text-muted mx-auto mb-4" style="max-width: 500px;">
            Periode akademik <span class="fw-bold text-dark">{{ $periodeAktif->nama_kode }}</span> sedang berlangsung. Segera tentukan topik penelitian dan kuota bimbingan Anda agar mahasiswa dapat mulai mendaftar.
        </p>
        <a href="{{ route('dosen.topik.create') }}" class="btn btn-dark btn-lg px-5 py-3 rounded-pill fw-bold shadow-lg">
            <i class="bi bi-plus-lg me-2"></i> Buat Topik Interest Sekarang
        </a>
    </div>

@else
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <h4 class="fw-black text-dark mb-0">Overview Periode: <span class="text-primary-dark">{{ $periodeAktif->nama_kode }}</span></h4>
        <span class="badge bg-success-subtle text-success border border-success rounded-pill px-3 py-2 fw-bold shadow-sm">
            <i class="bi bi-record-circle-fill me-1"></i> AKTIF
        </span>
    </div>

    <div class="row g-4 mb-5">
        
        <div class="col-md-6">
            <div class="card stat-card p-4 p-md-5">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="icon-box-lg bg-dark text-white shadow-sm">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <a href="{{ route('dosen.topik.index') }}" class="btn btn-sm btn-light border rounded-pill fw-bold text-muted px-3 transition-all hover-dark">
                        Detail Topik
                    </a>
                </div>
                
                <h6 class="text-muted fw-bold text-uppercase tracking-wide small mb-1">Keterisian Kuota Bimbingan</h6>
                <div class="d-flex align-items-baseline gap-2 mb-3">
                    <h1 class="display-4 fw-black text-dark mb-0">{{ $topik->limit_applied }}</h1>
                    <span class="fs-4 text-muted fw-bold">/ {{ $topik->limit_bimbingan }}</span>
                    <span class="ms-2 text-muted fw-medium">Mahasiswa</span>
                </div>
                
                @php $persen = ($topik->limit_bimbingan > 0) ? ($topik->limit_applied / $topik->limit_bimbingan) * 100 : 0; @endphp
                <div class="progress rounded-pill bg-light border shadow-sm mb-2" style="height: 12px;">
                    <div class="progress-bar progress-bar-striped {{ $persen >= 100 ? 'bg-danger' : 'bg-dark progress-bar-animated' }}" style="width: {{ $persen }}%;"></div>
                </div>
                
                <div class="d-flex justify-content-between text-muted small fw-medium mt-auto pt-3">
                    <span>{{ $topik->limit_applied }} Kuota Terisi</span>
                    <span class="{{ $sisaLimit <= 0 ? 'text-danger fw-bold' : '' }}">Sisa {{ $sisaLimit }} Slot</span>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card stat-card p-4 p-md-5">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="icon-box-lg {{ $menungguReview > 0 ? 'bg-warning text-dark' : 'bg-light text-muted border' }} shadow-sm">
                        <i class="bi bi-file-earmark-person-fill"></i>
                    </div>
                    @if($menungguReview > 0)
                        <span class="badge bg-danger rounded-pill px-3 py-2 shadow-sm pulse-animation fw-bold">Butuh Tindakan</span>
                    @endif
                </div>
                
                <h6 class="text-muted fw-bold text-uppercase tracking-wide small mb-1">Antrean Review Portofolio</h6>
                <div class="d-flex align-items-baseline gap-2 mb-3">
                    <h1 class="display-4 fw-black {{ $menungguReview > 0 ? 'text-dark' : 'text-muted' }} mb-0">{{ $menungguReview }}</h1>
                    <span class="fs-5 text-muted fw-medium">Pengajuan</span>
                </div>
                
                @if($menungguReview > 0)
                    <p class="text-muted small mb-4 fw-medium flex-grow-1" style="line-height: 1.6;">
                        Ada <strong class="text-dark">{{ $menungguReview }} mahasiswa</strong> yang menunggu keputusan Anda terkait kecocokan portofolio mereka dengan topik <strong class="text-dark">"{{ $topik->nama_topik }}"</strong>.
                    </p>
                    <a href="{{ route('dosen.bimbingan.index') }}" class="btn btn-dark w-100 rounded-pill py-3 fw-bold shadow-sm mt-auto">
                        Mulai Review Sekarang <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                @else
                    <p class="text-muted small mb-4 fw-medium flex-grow-1 d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-success fs-5"></i> Semua pengajuan sudah direview. Antrean Anda bersih.
                    </p>
                    <a href="{{ route('dosen.bimbingan.index') }}" class="btn btn-light border w-100 rounded-pill py-3 fw-bold text-muted mt-auto transition-all hover-dark">
                        Lihat Riwayat Review
                    </a>
                @endif
            </div>
        </div>

    </div>
@endif
@endsection