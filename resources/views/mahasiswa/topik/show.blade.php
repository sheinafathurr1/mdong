@extends('mahasiswa.layouts.app')

@section('title', 'Detail Topik Dosen')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        
        <div class="mb-4">
            <a href="{{ route('mahasiswa.topik.index') }}" class="text-decoration-none text-muted mb-3 d-inline-block hover-translate-x">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Topik
            </a>
        </div>

        @if(session('error'))
            <div class="alert alert-danger bg-danger text-white border-0 p-3 rounded-4 mb-4 d-flex align-items-center shadow-sm">
                <i class="bi bi-exclamation-octagon-fill fs-4 me-3"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        <div class="card border border-light-subtle shadow-sm rounded-4 overflow-hidden mb-5">
            <div class="bg-dark text-white p-4 p-md-5">
                <span class="badge bg-white text-dark mb-3 px-3 py-2 rounded-pill fw-bold shadow-sm">Rincian Topik</span>
                <h2 class="fw-extrabold mb-3">{{ $topik->nama_topik }}</h2>
                <div class="d-flex align-items-center">
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                <div class="mb-5">
                    <h6 class="fw-bold text-muted text-uppercase tracking-wide small mb-3">Deskripsi Topik</h6>
                    <p class="text-dark" style="line-height: 1.8;">{{ $topik->deskripsi }}</p>
                </div>

                <div class="mb-5">
                    <h6 class="fw-bold text-muted text-uppercase tracking-wide small mb-3">Persyaratan / Kriteria</h6>
                    <div class="bg-light p-4 rounded-4 border text-dark fw-medium" style="line-height: 1.6;">
                        {{ $topik->requirement ?? 'Tidak ada persyaratan khusus untuk topik ini.' }}
                    </div>
                </div>

                <div class="row g-4 mb-5 pb-4 border-bottom">
                    <div class="col-6">
                        <div class="text-muted small fw-bold text-uppercase mb-2">Total Kuota</div>
                        <div class="fs-4 fw-bold text-dark">{{ $topik->limit_bimbingan }} Mahasiswa</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small fw-bold text-uppercase mb-2">Slot Tersedia</div>
                        @php $sisa = $topik->limit_bimbingan - $topik->limit_applied; @endphp
                        <div class="fs-4 fw-bold {{ $sisa > 0 ? 'text-success' : 'text-danger' }}">{{ $sisa }} Mahasiswa</div>
                    </div>
                </div>

                <div class="text-center">
                    @if($hasApplication)
                        <div class="alert alert-light border rounded-3 p-3 text-muted fw-medium small mb-0">
                            <i class="bi bi-lock-fill me-1"></i> Anda sudah memiliki aplikasi aktif. Tidak dapat mendaftar topik lain saat ini.
                        </div>
                    @elseif($isRejectedFromThisTopic)
                        <div class="alert alert-danger border-danger rounded-3 p-3 text-danger fw-medium small mb-4">
                            <i class="bi bi-x-octagon-fill me-1"></i> Mohon maaf, portofolio Anda sebelumnya dinilai belum sesuai dengan kriteria topik ini. Anda tidak dapat mendaftar ulang pada topik yang sama.
                        </div>
                        <a href="{{ route('mahasiswa.topik.index') }}" class="btn btn-outline-danger fw-bold rounded-pill px-5 py-3">
                            <i class="bi bi-search me-1"></i> Cari Topik Lainnya
                        </a>
                    @elseif(!$hasPortofolio)
                        <div class="alert alert-warning border-warning rounded-3 p-3 text-dark fw-medium small mb-3">
                            <i class="bi bi-exclamation-triangle-fill me-1 text-warning"></i> Portofolio belum diisi. Anda wajib mengisi minimal 1 proyek sebelum mendaftar.
                        </div>
                        <a href="{{ route('mahasiswa.project.create') }}" class="btn btn-outline-dark fw-bold rounded-pill px-5 py-3">Isi Portofolio Sekarang</a>
                    @elseif($sisa <= 0)
                        <div class="alert alert-danger border-danger rounded-3 p-3 text-danger fw-medium small mb-0">
                            <i class="bi bi-x-circle-fill me-1"></i> Kuota untuk topik ini sudah penuh.
                        </div>
                    @else
                        <form action="{{ route('mahasiswa.topik.apply', $topik->topik_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mendaftar ke topik ini? Data portofolio Anda akan dikirim secara anonim ke dosen pemilik topik.')">
                            @csrf
                            <button type="submit" class="btn btn-dark btn-lg fw-bold rounded-pill px-5 py-3 shadow-lg w-100">
                                <i class="bi bi-send-check-fill me-2"></i> Apply Topik Ini
                            </button>
                        </form>
                        <div class="form-text mt-3 small text-muted">
                            Dengan mengklik apply, profil dan portofolio Anda akan masuk ke antrean review dosen.
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </div>
</div>
@endsection