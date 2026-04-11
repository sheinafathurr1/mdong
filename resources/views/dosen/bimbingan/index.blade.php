@extends('dosen.layouts.app')

@section('title', 'Daftar Bimbingan Saya')

@section('content')
<style>
    .bimbingan-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: 1px solid #e2e8f0; }
    .bimbingan-card:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05); border-color: #0f172a; }
</style>

<div class="mb-5 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h2 class="fw-extrabold text-dark mb-1">Daftar Bimbingan Saya</h2>
        <p class="text-muted mb-0">Daftar final mahasiswa Pra-TA yang berada di bawah bimbingan Anda.</p>
    </div>
    
    <div class="bg-white border rounded-pill px-4 py-2 d-inline-flex align-items-center shadow-sm">
        <i class="bi bi-people-fill text-dark me-2"></i>
        <span class="fw-bold text-dark me-2">{{ $bimbingans->count() }}</span>
        <span class="small text-muted fw-medium">Mahasiswa</span>
    </div>
</div>

@if($bimbingans->isEmpty())
    <div class="card border-0 shadow-sm rounded-5 text-center py-5 mt-4 bg-white">
        <div class="card-body py-5">
            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 90px; height: 90px;">
                <i class="bi bi-people fs-1 text-muted"></i>
            </div>
            <h4 class="fw-bold text-dark">Belum Ada Mahasiswa Bimbingan</h4>
            <p class="text-muted mx-auto mb-4" style="max-width: 450px;">
                Anda belum memiliki mahasiswa bimbingan yang berstatus resmi (APPROVED). Silakan proses antrean pengajuan pada menu Review.
            </p>
            <a href="{{ route('dosen.review.index') }}" class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm">
                Cek Antrean Review
            </a>
        </div>
    </div>
@else
    <div class="row g-4">
        @foreach($bimbingans as $app)
            <div class="col-lg-6 col-xl-4">
                <div class="card bimbingan-card h-100 rounded-4 bg-white overflow-hidden shadow-sm">
                    <div class="card-body p-4 d-flex flex-column">
                        
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <span class="badge bg-dark px-3 py-2 rounded-pill fw-bold shadow-sm" style="font-size: 0.7rem;">
                                Mahasiswa Bimbingan
                            </span>
                            
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $app->mahasiswa->no_tlp ?? '') }}" target="_blank" class="btn btn-sm btn-light rounded-circle border shadow-sm d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" title="Hubungi WA">
                                <i class="bi bi-whatsapp text-success fs-6"></i>
                            </a>
                        </div>
                        
                        <div class="d-flex align-items-center gap-3 mb-4 pb-4 border-bottom">
                            @if($app->mahasiswa->visual_path)
                                <img src="{{ asset('storage/' . $app->mahasiswa->visual_path) }}" alt="Foto" class="rounded-circle object-fit-cover shadow-sm border" width="60" height="60">
                            @else
                                <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm border" style="width: 60px; height: 60px; font-size: 1.5rem; font-weight: bold;">
                                    {{ substr($app->mahasiswa->nama, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <h5 class="fw-bold text-dark mb-1 text-truncate" style="max-width: 200px;" title="{{ $app->mahasiswa->nama }}">{{ $app->mahasiswa->nama }}</h5>
                                <div class="small text-muted fw-bold">{{ $app->mahasiswa->nim }}</div>
                            </div>
                        </div>
                        
                        <div class="mb-2 mt-auto">
                            <div class="small text-muted fw-bold text-uppercase tracking-wide mb-1" style="font-size: 0.65rem;">Topik Penelitian</div>
                            <div class="fw-medium text-dark" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5; font-size: 0.95rem;">
                                {{ $app->topik->nama_topik }}
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection