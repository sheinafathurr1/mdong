@extends('dosen.layouts.app')

@section('title', 'Topik Interest Saya')

@section('content')
<style>
    /* Styling Accordion Premium */
    .custom-accordion .accordion-item { border: 1px solid #e2e8f0; border-radius: 16px !important; margin-bottom: 1rem; overflow: hidden; background: #ffffff; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02); transition: all 0.3s ease; }
    .custom-accordion .accordion-item:hover { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); border-color: #cbd5e1; }
    .custom-accordion .accordion-button { padding: 1.25rem 1.5rem; background-color: transparent; border: none; box-shadow: none; gap: 1rem; }
    .custom-accordion .accordion-button:not(.collapsed) { background-color: #f8fafc; color: #0f172a; border-bottom: 1px solid #e2e8f0; }
    .custom-accordion .accordion-button::after { filter: grayscale(100%) opacity(50%); transition: all 0.3s; }
    .custom-accordion .accordion-button:not(.collapsed)::after { filter: none; }
    
    /* Inactive State Styling */
    .accordion-inactive { opacity: 0.8; background-color: #f8fafc !important; }
    .accordion-inactive .accordion-button { color: #64748b; }
</style>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
    <div>
        <h2 class="fw-extrabold text-dark mb-1">Topik Interest Saya</h2>
        <p class="text-muted mb-0">Kelola fokus penelitian dan kuota bimbingan Anda dari waktu ke waktu.</p>
    </div>
    
    @if($canCreate)
        <a href="{{ route('dosen.topik.create') }}" class="btn btn-dark px-4 py-2 rounded-pill fw-bold shadow-sm">
            <i class="bi bi-plus-lg me-2"></i> Buat Topik Baru
        </a>
    @else
        <button class="btn btn-light border text-muted px-4 py-2 rounded-pill fw-bold" disabled title="{{ $pesanBlokir }}">
            <i class="bi bi-lock-fill me-2"></i> Pembuatan Topik Ditutup
        </button>
    @endif
</div>

@if(session('error'))
    <div class="alert alert-danger bg-danger-subtle text-danger border-danger border-2 p-3 rounded-4 mb-4 shadow-sm d-flex align-items-center">
        <i class="bi bi-exclamation-octagon-fill fs-4 me-3"></i>
        <div class="fw-bold">{{ session('error') }}</div>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success bg-success-subtle text-success border-success border-2 p-3 rounded-4 mb-4 shadow-sm d-flex align-items-center">
        <i class="bi bi-check-circle-fill fs-4 me-3"></i>
        <div class="fw-bold">{{ session('success') }}</div>
    </div>
@endif

<div class="accordion custom-accordion" id="accordionTopik">
    @forelse($topiks as $index => $topik)
        @php
            // Logika pengecekan status periode secara real-time
            $now = \Carbon\Carbon::now();
            $isAktif = $topik->periode->is_active && $now->between($topik->periode->start_date, $topik->periode->end_date);
            
            // Biarkan accordion terbuka otomatis HANYA jika itu topik aktif
            $isOpen = $isAktif; 
        @endphp

        <div class="accordion-item {{ !$isAktif ? 'accordion-inactive' : '' }}">
            <h2 class="accordion-header" id="heading-{{ $topik->topik_id }}">
                <button class="accordion-button {{ $isOpen ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $topik->topik_id }}" aria-expanded="{{ $isOpen ? 'true' : 'false' }}" aria-controls="collapse-{{ $topik->topik_id }}">
                    
                    <div class="d-flex align-items-center justify-content-between w-100 pe-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center border shadow-sm" style="width: 42px; height: 42px;">
                                <i class="bi {{ $isAktif ? 'bi-journal-check text-success' : 'bi-archive-fill text-muted' }} fs-5"></i>
                            </div>
                            
                            <div>
                                <h5 class="fw-bold mb-1 {{ $isAktif ? 'text-dark' : 'text-muted' }} m-0" style="line-height: 1.2;">
                                    {{ $topik->nama_topik }}
                                </h5>
                                <div class="mt-1 d-flex align-items-center gap-2">
                                    <span class="badge {{ $isAktif ? 'bg-dark' : 'bg-secondary' }} rounded-pill" style="font-size: 0.65rem;">
                                        Periode: {{ $topik->periode->nama_kode ?? 'Tidak Diketahui' }}
                                    </span>
                                    @if($isAktif) 
                                        <span class="badge bg-success-subtle text-success border border-success rounded-pill" style="font-size: 0.65rem;"><i class="bi bi-record-circle-fill me-1"></i> AKTIF</span>
                                    @else
                                        <span class="text-muted small fw-medium" style="font-size: 0.75rem;">(Riwayat)</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="d-none d-md-block text-end">
                            <div class="small fw-bold {{ $isAktif ? 'text-dark' : 'text-muted' }}">Kuota: {{ $topik->limit_applied }}/{{ $topik->limit_bimbingan }}</div>
                        </div>
                    </div>

                </button>
            </h2>

            <div id="collapse-{{ $topik->topik_id }}" class="accordion-collapse collapse {{ $isOpen ? 'show' : '' }}" aria-labelledby="heading-{{ $topik->topik_id }}" data-bs-parent="#accordionTopik">
                <div class="accordion-body p-4 p-md-5">
                    
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="mb-4">
                                <h6 class="text-muted fw-bold text-uppercase tracking-wide small mb-2"><i class="bi bi-body-text me-1"></i> Deskripsi Topik</h6>
                                <p class="text-dark mb-0" style="line-height: 1.7;">{{ $topik->deskripsi }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <h6 class="text-muted fw-bold text-uppercase tracking-wide small mb-2"><i class="bi bi-list-check me-1"></i> Persyaratan / Kriteria Mahasiswa</h6>
                                <div class="bg-light p-3 rounded-3 border text-dark fw-medium small" style="line-height: 1.6;">
                                    {{ $topik->requirement ?? 'Tidak ada persyaratan khusus untuk topik ini.' }}
                                </div>
                            </div>

                            <div class="pt-3 border-top mt-4">
                                @if($isAktif)
                                    <a href="{{ route('dosen.topik.edit', $topik->topik_id) }}" class="btn btn-dark rounded-pill px-4 py-2 fw-bold shadow-sm">
                                        <i class="bi bi-pencil-square me-2"></i> Edit Topik Ini
                                    </a>
                                @else
                                    <button class="btn btn-light text-muted border rounded-pill px-4 py-2 fw-bold" disabled>
                                        <i class="bi bi-lock-fill me-2"></i> Terkunci (Riwayat)
                                    </button>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="bg-light p-4 rounded-4 border text-center h-100 d-flex flex-column justify-content-center">
                                <div class="text-muted fw-bold text-uppercase tracking-wide small mb-3">Keterisian Kuota</div>
                                
                                <h1 class="display-4 fw-black {{ $isAktif ? 'text-dark' : 'text-secondary' }} mb-0">
                                    {{ $topik->limit_applied }} <span class="fs-4 text-muted">/ {{ $topik->limit_bimbingan }}</span>
                                </h1>
                                
                                <div class="progress mt-3 mb-2 rounded-pill shadow-sm" style="height: 10px;">
                                    @php $persen = ($topik->limit_bimbingan > 0) ? ($topik->limit_applied / $topik->limit_bimbingan) * 100 : 0; @endphp
                                    <div class="progress-bar progress-bar-striped {{ $isAktif ? 'bg-dark progress-bar-animated' : 'bg-secondary' }}" style="width: {{ $persen }}%;"></div>
                                </div>
                                <span class="small text-muted fw-medium">{{ $topik->limit_applied }} Mahasiswa Disetujui</span>
                                
                                @if($isAktif && $topik->limit_applied >= $topik->limit_bimbingan)
                                    <div class="mt-3 badge bg-danger text-white rounded-pill py-2 px-3 shadow-sm">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i> Kuota Penuh
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @empty
        <div class="card border-0 shadow-sm rounded-5 py-5 text-center mt-4">
            <div class="card-body py-5">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4 border" style="width: 80px; height: 80px;">
                    <i class="bi bi-journal-x fs-1 text-muted"></i>
                </div>
                <h4 class="fw-bold text-dark">Belum Ada Topik</h4>
                <p class="text-muted mx-auto mb-4" style="max-width: 450px;">
                    Anda belum pernah mempublikasikan topik interest. Jika periode akademik sedang aktif, silakan buat topik baru.
                </p>
                @if($canCreate)
                    <a href="{{ route('dosen.topik.create') }}" class="btn btn-dark px-4 py-2 rounded-pill fw-bold">
                        Mulai Buat Topik
                    </a>
                @endif
            </div>
        </div>
    @endforelse
</div>
@endsection