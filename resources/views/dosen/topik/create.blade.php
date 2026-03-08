@extends('dosen.layouts.app')

@section('title', 'Buat Topik Interest')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
        
        <div class="mb-5 text-center">
            <a href="{{ route('dosen.dashboard') }}" class="text-decoration-none text-muted mb-3 d-inline-block hover-translate-x">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Panel
            </a>
            <h2 class="fw-extrabold text-dark mb-2">Buat Topik Interest</h2>
            <p class="text-muted">Tentukan fokus penelitian dan kuota bimbingan Anda untuk periode akademik saat ini.</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
            <div class="bg-dark text-white p-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-calendar-check fs-3 text-white-50"></i>
                    <div>
                        <div class="small text-uppercase tracking-wide fw-bold text-white-50" style="font-size: 0.7rem;">Periode Aktif</div>
                        <div class="fw-bold fs-5">{{ $periodeAktif->nama_kode }}</div>
                    </div>
                </div>
                <span class="badge bg-white text-dark rounded-pill px-3 py-2 fw-bold shadow-sm">Siap Dipublikasi</span>
            </div>

            <div class="card-body p-4 p-md-5">
                <form action="{{ route('dosen.topik.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="periode_id" value="{{ $periodeAktif->periode_id }}">

                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase tracking-wide">Judul Topik / Fokus Penelitian <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg bg-light border-0 shadow-none" name="nama_topik" required placeholder="Contoh: Inovasi Material Kriya Tekstil Ramah Lingkungan">
                        <div class="form-text mt-2 small text-muted"><i class="bi bi-info-circle me-1"></i> Maksimal penamaan untuk judul topik 7 kata</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase tracking-wide">Deskripsi Topik <span class="text-danger">*</span></label>
                        <textarea class="form-control bg-light border-0 shadow-none" name="deskripsi" rows="5" required placeholder="Jelaskan secara detail arah penelitian, output yang diharapkan, atau ruang lingkup topik ini..."></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase tracking-wide">Syarat / Requirement Khusus (Opsional)</label>
                        <textarea class="form-control bg-light border-0 shadow-none" name="requirement" rows="3" placeholder="Contoh: Mahasiswa harus menguasai software 3D Blender, IPK minimal 3.0, dsb..."></textarea>
                        <div class="form-text mt-2 small text-muted"><i class="bi bi-info-circle me-1"></i> Kosongkan jika topik ini terbuka untuk semua kriteria mahasiswa.</div>
                    </div>

                    <div class="mb-5 pb-4 border-bottom">
                        <label class="form-label fw-bold text-muted small text-uppercase tracking-wide">Target Kuota Bimbingan <span class="text-danger">*</span></label>
                        <div class="d-flex align-items-center gap-3">
                            <input type="number" class="form-control form-control-lg bg-light border-0 shadow-none text-center fw-bold" name="limit_bimbingan" style="max-width: 120px;" min="1" value="5" required>
                            <span class="text-muted fw-medium">Mahasiswa per periode</span>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-dark btn-lg fw-bold rounded-pill shadow-lg py-3">
                            <i class="bi bi-send-fill me-2"></i> Publikasikan Topik
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection