@extends('dosen.layouts.app')

@section('title', 'Review Aplikasi Mahasiswa')

@section('content')
<div class="mb-5">
    <h2 class="fw-extrabold text-dark mb-1">Review Aplikasi Masuk</h2>
    <p class="text-muted">Tinjau portofolio mahasiswa yang mendaftar ke topik Anda dan tentukan keputusan bimbingan.</p>
</div>

@if(session('success'))
    <div class="alert alert-dark bg-dark text-white border-0 p-3 rounded-4 mb-4 shadow-sm d-flex align-items-center">
        <i class="bi bi-check-circle-fill fs-4 me-3 text-success"></i>
        <div>{{ session('success') }}</div>
    </div>
@endif

<ul class="nav nav-pills mb-4 gap-2 border-bottom pb-3" id="reviewTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active rounded-pill fw-bold px-4" id="menunggu-tab" data-bs-toggle="tab" data-bs-target="#menunggu" type="button" role="tab">
            Menunggu Review 
            @if($menunggu->count() > 0)
                <span class="badge bg-danger ms-2 rounded-circle">{{ $menunggu->count() }}</span>
            @endif
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link rounded-pill fw-bold px-4" id="riwayat-tab" data-bs-toggle="tab" data-bs-target="#riwayat" type="button" role="tab">
            Riwayat Keputusan
        </button>
    </li>
</ul>

<div class="tab-content" id="reviewTabContent">
    
    <div class="tab-pane fade show active" id="menunggu" role="tabpanel">
        @if($menunggu->isEmpty())
            <div class="card border-0 shadow-sm rounded-4 text-center py-5">
                <div class="card-body py-4">
                    <i class="bi bi-inbox fs-1 text-muted mb-3 d-block"></i>
                    <h5 class="fw-bold">Antrean Kosong</h5>
                    <p class="text-muted">Belum ada mahasiswa baru yang mendaftar ke topik Anda.</p>
                </div>
            </div>
        @else
            <div class="row g-4">
                @foreach($menunggu as $app)
                    <div class="col-md-6 col-xl-4">
                        <div class="card border border-light-subtle shadow-sm rounded-4 h-100 transition-all hover-translate-y">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold small shadow-sm">
                                        <i class="bi bi-clock-history me-1"></i> Menunggu
                                    </span>
                                    <small class="text-muted fw-medium">{{ \Carbon\Carbon::parse($app->tanggal_submit)->diffForHumans() }}</small>
                                </div>
                                <h5 class="fw-bold text-dark mb-1">{{ $app->mahasiswa->nama }}</h5>
                                <p class="text-muted small fw-bold mb-3">{{ $app->mahasiswa->nim }} — {{ $app->mahasiswa->program_studi }}</p>
                                
                                <div class="bg-light p-3 rounded-3 border mb-4">
                                    <div class="small text-muted text-uppercase fw-bold mb-1" style="font-size: 0.7rem;">Mendaftar Topik:</div>
                                    <div class="fw-medium text-dark text-truncate">{{ $app->topik->nama_topik }}</div>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-top-0 p-4 pt-0">
                                <a href="{{ route('dosen.review.show', $app->application_id) }}" class="btn btn-dark w-100 rounded-pill fw-bold py-2 shadow-sm">
                                    Tinjau Portofolio <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="tab-pane fade" id="riwayat" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase tracking-wide">
                        <tr>
                            <th class="px-4 py-3">Nama Mahasiswa</th>
                            <th class="px-4 py-3">Topik</th>
                            <th class="px-4 py-3">Tanggal Review</th>
                            <th class="px-4 py-3 text-center">Status Keputusan</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($riwayat as $app)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="fw-bold text-dark">{{ $app->mahasiswa->nama }}</div>
                                    <div class="small text-muted">{{ $app->mahasiswa->nim }}</div>
                                </td>
                                <td class="px-4 py-3 fw-medium text-truncate" style="max-width: 250px;">
                                    {{ $app->topik->nama_topik }}
                                </td>
                                <td class="px-4 py-3 small text-muted">
                                    {{ \Carbon\Carbon::parse($app->tanggal_response)->format('d M Y, H:i') }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($app->status === 'APPROVED-PBB1' || $app->status === 'APPROVED-FULL')
                                        <span class="badge bg-success-subtle border border-success text-success px-3 py-2 rounded-pill fw-bold">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger-subtle border border-danger text-danger px-3 py-2 rounded-pill fw-bold">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">Belum ada riwayat review.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<style>
    .hover-translate-y:hover { transform: translateY(-5px); border-color: #0f172a !important; }
    .nav-pills .nav-link.active { background-color: #0f172a; color: white; }
    .nav-pills .nav-link:hover:not(.active) { background-color: #f1f5f9; color: #0f172a !important; }
</style>
@endsection