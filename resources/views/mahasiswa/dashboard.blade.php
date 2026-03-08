@extends('mahasiswa.layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<style>
    .stat-card { transition: all 0.3s ease; border: 1px solid #e5e7eb; position: relative; overflow: hidden; }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
    .welcome-banner { background: linear-gradient(135deg, #0f172a 0%, #334155 100%); color: white; border-radius: 20px; }
    .status-badge { padding: 6px 16px; border-radius: 50px; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; }
</style>

<div class="mb-4">
    <h3 class="fw-extrabold mb-0">Overview Dashboard</h3>
</div>

<div class="welcome-banner p-5 mb-5 shadow-sm">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h2 class="fw-bold mb-2">Hai, {{ explode(' ', $user->nama)[0] }}! 👋</h2>
            <p class="text-white-50 fs-5 mb-4">Pastikan portofoliomu sudah lengkap sebelum mendaftar ke topik dosen pilihanmu.</p>
            <div class="d-flex gap-2">
                <a href="{{ route('mahasiswa.project.index') }}" class="btn btn-light fw-bold px-4 py-2 rounded-pill shadow-sm">
                    Lihat Portofolio
                </a>
                <a href="{{ route('mahasiswa.topik.index') }}" class="btn btn-outline-light fw-bold px-4 py-2 rounded-pill">
                    Cari Topik TA
                </a>
            </div>
        </div>
        <div class="col-md-4 text-end d-none d-md-block">
            <i class="bi bi-person-workspace text-white-50" style="font-size: 7rem; opacity: 0.3;"></i>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card stat-card rounded-4 h-100 bg-white">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="bg-dark text-white rounded-3 p-2">
                        <i class="bi bi-collection-fill fs-4"></i>
                    </div>
                </div>
                <div class="text-muted small fw-bold text-uppercase mb-1">Portofolio Saya</div>
                <div class="fs-2 fw-bold text-dark">{{ $totalProject }} <span class="fs-5 fw-medium text-muted">Proyek</span></div>
                
                @if(!$aplikasi || $aplikasi->status === 'REJECTED')
                    <a href="{{ route('mahasiswa.project.create') }}" class="text-dark small fw-bold text-decoration-none mt-2 d-inline-block">
                        Tambah Proyek <i class="bi bi-plus-circle ms-1"></i>
                    </a>
                @else
                    <span class="text-muted small fw-medium mt-2 d-inline-block">
                        <i class="bi bi-lock-fill me-1"></i> Portofolio Terkunci
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card stat-card rounded-4 h-100 bg-white border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="text-muted small fw-bold text-uppercase mb-3 d-flex justify-content-between">
                    <span>Status Pengajuan Terkini</span>
                    @if($aplikasi)
                        <a href="{{ route('mahasiswa.application.status') }}" class="text-dark text-decoration-none"><i class="bi bi-box-arrow-up-right me-1"></i> Lacak Status</a>
                    @endif
                </div>
                
                @if($aplikasi)
                    @if($aplikasi->status === 'APPROVED-FULL')
                        <div class="alert alert-success bg-success-subtle border-success border-2 p-4 rounded-4 mb-0">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill fs-3 text-success me-3"></i>
                                <div>
                                    <h5 class="fw-bold text-dark mb-0">Selamat! Pra-TA Disetujui</h5>
                                    <span class="small text-success fw-bold">Status: APPROVED-FULL</span>
                                </div>
                            </div>
                            <div class="bg-white p-3 rounded-3 border">
                                <div class="small text-muted text-uppercase fw-bold mb-1" style="font-size: 0.7rem;">Topik Penelitian</div>
                                <div class="fw-bold text-dark mb-3">{{ $aplikasi->topik->nama_topik }}</div>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="small text-muted text-uppercase fw-bold mb-1" style="font-size: 0.7rem;">Pembimbing 1</div>
                                        <div class="fw-medium text-dark"><i class="bi bi-person-fill me-1 text-muted"></i> {{ $aplikasi->topik->dosen->nama }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="small text-muted text-uppercase fw-bold mb-1" style="font-size: 0.7rem;">Pembimbing 2</div>
                                        <div class="fw-medium text-dark"><i class="bi bi-person-check-fill me-1 text-muted"></i> {{ $aplikasi->pembimbing2->nama ?? 'Belum Diatur' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @else
                        <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-4 border">
                            <div>
                                <div class="fw-bold text-dark">{{ $aplikasi->topik->nama_topik }}</div>
                                <div class="small text-muted">Dosen: {{ $aplikasi->topik->dosen->nama }}</div>
                            </div>
                            <div class="text-end">
                                @php
                                    $statusClasses = [
                                        'DRAFT' => 'bg-secondary text-white',
                                        'APPLIED' => 'bg-primary text-white',
                                        'APPROVED-PBB1' => 'bg-info text-dark',
                                        'REJECTED' => 'bg-danger text-white'
                                    ];
                                @endphp
                                <span class="badge {{ $statusClasses[$aplikasi->status] }} px-3 py-2 rounded-pill fw-bold shadow-sm">
                                    {{ $aplikasi->status }}
                                </span>
                                @if($aplikasi->status === 'APPROVED-PBB1')
                                    <div class="small text-muted mt-1" style="font-size: 0.7rem;">Menunggu plotting PBB 2</div>
                                @elseif($aplikasi->status === 'REJECTED')
                                    <div class="small text-danger mt-1 fw-bold" style="font-size: 0.7rem;">
                                        <a href="{{ route('mahasiswa.topik.index') }}" class="text-danger text-decoration-none">Cari Topik Lain <i class="bi bi-arrow-right"></i></a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                @else
                    <div class="text-center py-4 bg-light rounded-4 border border-dashed">
                        <i class="bi bi-search fs-2 text-muted mb-2 d-block"></i>
                        <p class="text-muted mb-3 small fw-medium">Anda belum mengajukan topik pendaftaran.</p>
                        <a href="{{ route('mahasiswa.topik.index') }}" class="btn btn-sm btn-dark px-4 py-2 rounded-pill fw-bold">Eksplorasi Topik TA</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- <div class="row mt-4 g-4">
    <div class="col-md-12">
        <div class="card border-0 rounded-4 shadow-sm">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-light p-3 rounded-circle text-dark">
                        <i class="bi bi-info-lg fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-bold text-uppercase">Informasi Akademik</div>
                        <div class="fw-bold fs-5">{{ $user->nim }} — {{ $user->program_studi }}</div>
                    </div>
                </div>
                <div class="text-end d-none d-md-block">
                    <div class="text-muted small">Kelas</div>
                    <div class="fw-bold">{{ $user->kelas ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

@if($riwayatAplikasi->count() > 0)
<div class="row mt-4 mb-5">
    <div class="col-md-12">
        <div class="card border-0 rounded-4 shadow-sm overflow-hidden">
            <div class="card-header bg-white border-bottom p-4">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-clock-history me-2 text-muted"></i>Riwayat Pengajuan Topik</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small text-uppercase tracking-wide">
                            <tr>
                                <th class="px-4 py-3">Topik & Pembimbing 1</th>
                                <th class="px-4 py-3">Tanggal Pengajuan</th>
                                <th class="px-4 py-3">Tanggal Update</th>
                                <th class="px-4 py-3 text-end">Status Akhir</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @foreach($riwayatAplikasi as $riwayat)
                                @php
                                    $badgeColor = [
                                        'DRAFT' => 'bg-secondary text-white',
                                        'APPLIED' => 'bg-primary text-white',
                                        'APPROVED-PBB1' => 'bg-info text-dark',
                                        'APPROVED-FULL' => 'bg-success text-white',
                                        'REJECTED' => 'bg-danger text-white'
                                    ];
                                @endphp
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="fw-bold text-dark text-truncate" style="max-width: 350px;">{{ $riwayat->topik->nama_topik }}</div>
                                        <div class="small text-muted"><i class="bi bi-person-fill me-1"></i> {{ $riwayat->topik->dosen->nama }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-muted small fw-medium">
                                        {{ \Carbon\Carbon::parse($riwayat->tanggal_submit)->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-muted small fw-medium">
                                        {{ $riwayat->tanggal_response ? \Carbon\Carbon::parse($riwayat->tanggal_response)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <span class="badge {{ $badgeColor[$riwayat->status] }} px-3 py-2 rounded-pill shadow-sm">
                                            {{ $riwayat->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection