@extends('mahasiswa.layouts.app')

@section('title', 'Cari Topik Dosen')

@section('content')
<style>
    .topic-card { transition: all 0.3s ease; border: 1px solid #e5e7eb; cursor: pointer; }
    .topic-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px -5px rgba(0,0,0,0.1); border-color: #000; }
    .dosen-avatar { width: 45px; height: 45px; background: #000; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem; }
    .search-bar-container { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 50px; padding: 5px; transition: all 0.3s ease; }
    .search-bar-container:focus-within { border-color: #0f172a; box-shadow: 0 0 0 4px rgba(15,23,42,0.05); }
    .search-input { border: none !important; box-shadow: none !important; background: transparent !important; }
</style>

<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3">
    <div>
        <h2 class="fw-extrabold text-dark mb-1">Eksplorasi Topik Dosen</h2>
        <p class="text-muted mb-0">Temukan topik penelitian yang sesuai dengan minat Anda untuk periode {{ $periodeAktif->nama_kode ?? 'saat ini' }}.</p>
    </div>
</div>

@if($hasApplication)
    <div class="alert alert-dark bg-dark text-white border-0 p-4 rounded-4 mb-4 shadow-sm d-flex align-items-center">
        <i class="bi bi-info-circle-fill fs-3 me-3 text-warning"></i>
        <div>
            <h6 class="fw-bold mb-1">Anda Sedang Dalam Proses Pengajuan</h6>
            <p class="mb-0 small text-white-50">Anda sudah mengajukan aplikasi ke salah satu topik. Anda dapat melihat topik lain di bawah ini, namun opsi "Apply" akan dikunci hingga ada keputusan dari dosen terkait.</p>
        </div>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4 mb-5 bg-white">
    <div class="card-body p-2 p-md-3">
        <form action="{{ route('mahasiswa.topik.index') }}" method="GET" class="m-0">
            <div class="row g-2 align-items-center">
                <div class="col-md-7 col-lg-8">
                    <div class="search-bar-container d-flex align-items-center px-3">
                        <i class="bi bi-search text-muted fs-5"></i>
                        <input type="text" name="search" class="form-control form-control-lg search-input fs-6" placeholder="Cari berdasarkan kata kunci topik..." value="{{ request('search') }}">
                        @if(request('search'))
                            <a href="{{ route('mahasiswa.topik.index', ['ketersediaan' => request('ketersediaan')]) }}" class="text-muted text-decoration-none py-1 px-2"><i class="bi bi-x-circle-fill"></i></a>
                        @endif
                    </div>
                </div>
                
                <div class="col-md-3 col-lg-2">
                    <select name="ketersediaan" class="form-select form-select-lg border-0 bg-light rounded-pill fs-6 fw-medium text-dark px-4" style="cursor: pointer;" onchange="this.form.submit()">
                        <option value="semua" {{ request('ketersediaan') != 'tersedia' ? 'selected' : '' }}>Semua Kuota</option>
                        <option value="tersedia" {{ request('ketersediaan') == 'tersedia' ? 'selected' : '' }}>Masih Tersedia</option>
                    </select>
                </div>
                
                <div class="col-md-2 col-lg-2 d-grid">
                    <button type="submit" class="btn btn-dark btn-lg rounded-pill fw-bold shadow-sm fs-6">
                        Cari Topik
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@if($topiks->isEmpty())
    <div class="card border-0 shadow-sm rounded-5 text-center py-5">
        <div class="card-body py-5">
            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4 border" style="width: 90px; height: 90px;">
                <i class="bi bi-search fs-1 text-muted"></i>
            </div>
            
            @if(request('search') || request('ketersediaan') == 'tersedia')
                <h4 class="fw-bold text-dark">Pencarian Tidak Ditemukan</h4>
                <p class="text-muted mx-auto mb-4" style="max-width: 400px;">
                    Tidak ada topik yang cocok dengan kata kunci <strong>"{{ request('search') }}"</strong> atau filter yang Anda terapkan.
                </p>
                <a href="{{ route('mahasiswa.topik.index') }}" class="btn btn-outline-dark px-4 py-2 rounded-pill fw-bold">
                    Reset Pencarian
                </a>
            @else
                <h4 class="fw-bold text-dark">Belum Ada Topik Terbuka</h4>
                <p class="text-muted mx-auto mb-0" style="max-width: 400px;">
                    Dosen belum mempublikasikan topik interest untuk periode akademik saat ini.
                </p>
            @endif
        </div>
    </div>
@else
    @if(request('search') || request('ketersediaan') == 'tersedia')
        <div class="mb-3 text-muted small fw-bold">
            Menampilkan {{ $topiks->count() }} hasil pencarian
        </div>
    @endif

    <div class="row g-4">
        @foreach($topiks as $topik)
            <div class="col-lg-6 col-xl-4">
                <a href="{{ route('mahasiswa.topik.show', $topik->topik_id) }}" class="text-decoration-none">
                    <div class="card topic-card h-100 rounded-4 bg-white p-2 shadow-sm d-flex flex-column">
                        <div class="card-body p-4 d-flex flex-column">
                            
                            
                            <h5 class="fw-bold text-dark mb-3" style="line-height: 1.4;">{{ $topik->nama_topik }}</h5>
                            <p class="text-muted small mb-4 text-truncate-3" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.6;">
                                {{ $topik->deskripsi }}
                            </p>
                            
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-auto">
                                @php $sisa = $topik->limit_bimbingan - $topik->limit_applied; @endphp
                                <span class="badge {{ $sisa > 0 ? 'bg-light text-dark border' : 'bg-danger text-white' }} px-3 py-2 rounded-pill fw-medium shadow-sm">
                                    @if($sisa > 0)
                                        <i class="bi bi-people-fill me-1"></i> Sisa {{ $sisa }} Slot
                                    @else
                                        <i class="bi bi-x-circle-fill me-1"></i> Kuota Penuh
                                    @endif
                                </span>
                                <span class="text-dark fw-bold small">Lihat Detail <i class="bi bi-arrow-right ms-1"></i></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endif
@endsection