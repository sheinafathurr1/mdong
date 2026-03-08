@extends('dosen.layouts.app')

@section('title', 'Daftar Bimbingan Saya')

@section('content')
<style>
    .bimbingan-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: 1px solid #e2e8f0; }
    .bimbingan-card:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05); border-color: #0f172a; }
    .role-badge-pbb1 { background-color: #0f172a; color: #ffffff; }
    .role-badge-pbb2 { background-color: #f8fafc; color: #0f172a; border: 1px solid #cbd5e1; }
</style>

<div class="mb-5">
    <h2 class="fw-extrabold text-dark mb-1">Daftar Bimbingan Saya</h2>
    <p class="text-muted">Daftar final mahasiswa Pra-TA yang berada di bawah bimbingan Anda periode ini.</p>
</div>

@if($bimbingans->isEmpty())
    <div class="card border-0 shadow-sm rounded-5 text-center py-5 mt-4">
        <div class="card-body py-5">
            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 90px; height: 90px;">
                <i class="bi bi-people fs-1 text-muted"></i>
            </div>
            <h4 class="fw-bold text-dark">Belum Ada Mahasiswa Bimbingan</h4>
            <p class="text-muted mx-auto mb-4" style="max-width: 450px;">
                Anda belum memiliki mahasiswa bimbingan yang berstatus disetujui penuh (APPROVED-FULL) sebagai Pembimbing 1 maupun Pembimbing 2.
            </p>
        </div>
    </div>
@else
    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <div class="bg-white border rounded-4 p-3 d-flex align-items-center justify-content-between shadow-sm">
                <div>
                    <div class="small text-muted fw-bold text-uppercase tracking-wide">Total Bimbingan</div>
                    <div class="fs-4 fw-black text-dark">{{ $bimbingans->count() }} <span class="fs-6 fw-medium text-muted">Mahasiswa</span></div>
                </div>
                <div class="bg-light p-3 rounded-circle"><i class="bi bi-people-fill fs-4 text-dark"></i></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-dark border rounded-4 p-3 d-flex align-items-center justify-content-between shadow-sm">
                <div>
                    <div class="small text-white-50 fw-bold text-uppercase tracking-wide">Sebagai PBB 1</div>
                    <div class="fs-4 fw-black text-white">{{ $bimbingans->where('topik.dosen_id', $dosenId)->count() }} <span class="fs-6 fw-medium text-white-50">Mahasiswa</span></div>
                </div>
                <div class="bg-white bg-opacity-10 p-3 rounded-circle"><i class="bi bi-1-circle-fill fs-4 text-white"></i></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-white border rounded-4 p-3 d-flex align-items-center justify-content-between shadow-sm">
                <div>
                    <div class="small text-muted fw-bold text-uppercase tracking-wide">Sebagai PBB 2</div>
                    <div class="fs-4 fw-black text-dark">{{ $bimbingans->where('pembimbing_2_id', $dosenId)->count() }} <span class="fs-6 fw-medium text-muted">Mahasiswa</span></div>
                </div>
                <div class="bg-light p-3 rounded-circle"><i class="bi bi-2-circle-fill fs-4 text-dark"></i></div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @foreach($bimbingans as $app)
            @php
                // Menentukan peran dosen yang sedang login di aplikasi ini
                $isPbb1 = $app->topik->dosen_id == $dosenId;
            @endphp
            
            <div class="col-lg-6 col-xl-4">
                <div class="card bimbingan-card h-100 rounded-4 bg-white overflow-hidden shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <span class="badge {{ $isPbb1 ? 'role-badge-pbb1' : 'role-badge-pbb2' }} px-3 py-2 rounded-pill fw-bold shadow-sm" style="font-size: 0.7rem;">
                                {{ $isPbb1 ? 'Sebagai PBB 1' : 'Sebagai PBB 2' }}
                            </span>
                            
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $app->mahasiswa->no_tlp) }}" target="_blank" class="btn btn-sm btn-light rounded-circle border shadow-sm" title="Hubungi WA">
                                <i class="bi bi-whatsapp text-success"></i>
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
                        
                        <div class="mb-3">
                            <div class="small text-muted fw-bold text-uppercase tracking-wide mb-1" style="font-size: 0.65rem;">Topik Penelitian</div>
                            <div class="fw-medium text-dark text-truncate-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5; font-size: 0.95rem;">
                                {{ $app->topik->nama_topik }}
                            </div>
                        </div>
                        
                        <div class="bg-light p-3 rounded-3 border mt-auto">
                            <div class="small text-muted fw-bold text-uppercase tracking-wide mb-1" style="font-size: 0.65rem;">
                                Partner Dosen Pembimbing
                            </div>
                            <div class="fw-bold text-dark small">
                                @if($isPbb1)
                                    <i class="bi bi-2-square-fill me-1 text-muted"></i> {{ $app->pembimbing2->nama ?? 'Belum Di-assign' }}
                                @else
                                    <i class="bi bi-1-square-fill me-1 text-muted"></i> {{ $app->topik->dosen->nama }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection