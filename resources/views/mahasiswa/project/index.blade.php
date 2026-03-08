@extends('mahasiswa.layouts.app')

@section('title', 'Portofolio Proyek')

@section('content')
<style>
    .portfolio-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: 1px solid #f1f5f9; background: #ffffff; }
    .portfolio-card:hover { transform: translateY(-8px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02) !important; border-color: #000; }
    .type-badge { font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; padding: 6px 12px; border-radius: 50px; }
    .project-meta { font-size: 0.85rem; color: #64748b; display: flex; align-items: center; gap: 8px; margin-bottom: 0.5rem; }
    .project-meta i { color: #000; }
    .narasi-preview { color: #475569; font-size: 0.9rem; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
</style>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="fw-extrabold text-dark mb-1">Portofolio Saya</h2>
        <p class="text-muted mb-0">Total <span class="fw-bold text-dark">{{ $projects->count() }}</span> karya telah terdaftar dalam sistem.</p>
    </div>
    
    @if(!$isLocked)
        <a href="{{ route('mahasiswa.project.create') }}" class="btn btn-dark px-4 py-2 rounded-pill fw-bold shadow-sm">
            <i class="bi bi-plus-lg me-2"></i> Susun Portofolio
        </a>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-dark bg-dark text-white border-0 p-3 rounded-4 mb-4 shadow-sm d-flex align-items-center">
        <i class="bi bi-check-circle-fill fs-4 me-3 text-success"></i>
        <div>{{ session('success') }}</div>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger border-0 p-3 rounded-4 mb-4 shadow-sm d-flex align-items-center">
        <i class="bi bi-exclamation-octagon-fill fs-4 me-3 text-danger"></i>
        <div class="fw-bold text-dark">{{ session('error') }}</div>
    </div>
@endif

@if($isLocked)
    <div class="alert alert-warning bg-warning-subtle border-warning border-2 p-4 rounded-4 mb-5 shadow-sm d-flex align-items-center">
        <i class="bi bi-lock-fill fs-1 me-4 text-warning"></i>
        <div>
            <h5 class="fw-bold text-dark mb-1">Portofolio Terkunci (Read-Only)</h5>
            <p class="mb-0 text-dark small">Anda sedang dalam proses pengajuan Topik Pra-TA atau telah disetujui. Selama masa ini, Anda tidak dapat menambah, mengubah, atau menghapus data portofolio agar dosen pembimbing dapat melakukan review dengan data yang konsisten.</p>
        </div>
    </div>
@endif

@if($projects->isEmpty())
    <div class="card border-0 shadow-sm rounded-5 py-5 text-center">
        <div class="card-body py-5">
            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                <i class="bi bi-collection fs-1 text-muted"></i>
            </div>
            <h4 class="fw-bold text-dark">Portofolio Kosong</h4>
            <p class="text-muted mx-auto mb-4" style="max-width: 400px;">
                Dosen pembimbing membutuhkan data portofolio Anda untuk melakukan review. Mari tambahkan beberapa proyek terbaik Anda.
            </p>
            @if(!$isLocked)
                <a href="{{ route('mahasiswa.project.create') }}" class="btn btn-dark px-4 py-2 rounded-pill fw-bold">
                    Mulai Susun Sekarang
                </a>
            @endif
        </div>
    </div>
@else
    <div class="row g-4">
        @foreach($projects as $proj)
            <div class="col-lg-4 col-md-6">
                <div class="card portfolio-card h-100 rounded-4 shadow-sm overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="type-badge {{ $proj->tipe_proyek == 'Perancangan' ? 'bg-dark text-white' : 'bg-light text-dark border' }}">
                                {{ $proj->tipe_proyek }}
                            </span>
                            
                            @if(!$isLocked)
                                <div class="dropdown">
                                    <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                        <li><a class="dropdown-item" href="{{ route('mahasiswa.project.edit', $proj->project_id) }}"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('mahasiswa.project.destroy', $proj->project_id) }}" method="POST" onsubmit="return confirm('Hapus proyek ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i> Hapus</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <h5 class="fw-bold text-dark mb-4 lh-base">{{ $proj->nama_proyek }}</h5>
                        
                        <div class="mb-4">
                            <div class="project-meta">
                                <i class="bi bi-cpu"></i> 
                                <span>Teknik: <strong>{{ $proj->teknik ?: '-' }}</strong></span>
                            </div>
                            <div class="project-meta">
                                <i class="bi bi-box-seam"></i> 
                                <span>Material: <strong>{{ $proj->material ?: '-' }}</strong></span>
                            </div>
                        </div>

                        <p class="narasi-preview mb-0">
                            {{ $proj->narasi }}
                        </p>
                    </div>
                    
                    @if(!$isLocked)
                        <div class="card-footer bg-white border-top-0 p-4 pt-0">
                            <a href="{{ route('mahasiswa.project.edit', $proj->project_id) }}" class="btn btn-sm btn-outline-dark w-100 rounded-pill fw-bold py-2">
                                Edit Rincian
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endif

@if(!$isLocked && $projects->count() > 0)
    <div class="mt-5 p-4 bg-dark text-white shadow-sm rounded-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <h5 class="fw-bold mb-1">Sudah Selesai Menyusun?</h5>
            <p class="text-white-50 small mb-0">Pastikan semua data sudah benar sebelum Anda mendaftar ke Topik Dosen.</p>
        </div>
        <a href="{{ route('mahasiswa.topik.index') }}" class="btn btn-light btn-sm px-4 py-2 rounded-pill fw-bold text-dark">
            Cari Topik TA <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
@endif
@endsection