@extends('dosen.layouts.app')

@section('title', 'Edit Topik Interest')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
        
        <div class="mb-5 text-center">
            <a href="{{ route('dosen.topik.index') }}" class="text-decoration-none text-muted mb-3 d-inline-block hover-translate-x">
                <i class="bi bi-arrow-left me-1"></i> Batal & Kembali
            </a>
            <h2 class="fw-extrabold text-dark mb-2">Edit Topik Interest</h2>
            <p class="text-muted">Perbarui rincian atau sesuaikan kuota bimbingan Anda.</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
            <div class="bg-light border-bottom p-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-calendar-check fs-4 text-muted"></i>
                    <div>
                        <div class="small text-uppercase tracking-wide fw-bold text-muted" style="font-size: 0.7rem;">Periode</div>
                        <div class="fw-bold text-dark">{{ $topik->periode->nama_kode ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                <form action="{{ route('dosen.topik.update', $topik->topik_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase tracking-wide">Judul Topik <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg bg-light border-0" name="nama_topik" value="{{ old('nama_topik', $topik->nama_topik) }}" required>
                        <div class="form-text mt-2 small text-muted"><i class="bi bi-info-circle me-1"></i> Maksimal penamaan untuk judul topik 7 kata</div>
                    </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase tracking-wide">Deskripsi Topik <span class="text-danger">*</span></label>
                        <textarea class="form-control bg-light border-0" name="deskripsi" rows="5" required>{{ old('deskripsi', $topik->deskripsi) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase tracking-wide">Syarat Khusus (Opsional)</label>
                        <textarea class="form-control bg-light border-0" name="requirement" rows="3">{{ old('requirement', $topik->requirement) }}</textarea>
                    </div>

                    <div class="mb-5 pb-4 border-bottom">
                        <label class="form-label fw-bold text-muted small text-uppercase tracking-wide">Target Kuota Bimbingan <span class="text-danger">*</span></label>
                        <div class="d-flex align-items-center gap-3">
                            <input type="number" class="form-control form-control-lg bg-light border-0 text-center fw-bold" name="limit_bimbingan" style="max-width: 120px;" min="{{ $topik->limit_applied > 0 ? $topik->limit_applied : 1 }}" value="{{ old('limit_bimbingan', $topik->limit_bimbingan) }}" required>
                            <span class="text-muted fw-medium">Mahasiswa per periode</span>
                        </div>
                        <div class="form-text mt-2 small text-muted"><i class="bi bi-info-circle me-1"></i> Limit bimbingan tidak bisa diatur lebih kecil dari jumlah mahasiswa yang sudah Anda setujui ({{ $topik->limit_applied }} orang).</div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-dark btn-lg fw-bold rounded-pill shadow">
                            <i class="bi bi-save me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection