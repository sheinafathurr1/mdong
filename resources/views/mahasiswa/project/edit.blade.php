@extends('mahasiswa.layouts.app')

@section('title', 'Edit Proyek')

@section('content')
<div class="mb-4">
    <a href="{{ route('mahasiswa.project.index') }}" class="text-decoration-none text-muted mb-2 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
    </a>
    <h3 class="fw-bold text-dark">Edit Rincian Proyek</h3>
    <p class="text-muted small">Perbarui informasi karya Anda untuk hasil review yang lebih baik.</p>
</div>

<div class="card border border-light-subtle shadow-sm rounded-4">
    <div class="card-body p-4 p-md-5">
        <form action="{{ route('mahasiswa.project.update', $project->project_id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row g-4 mb-4">
                <div class="col-md-8">
                    <label class="form-label fw-bold small text-muted text-uppercase tracking-wider">Nama Proyek</label>
                    <input type="text" class="form-control form-control-lg bg-light border-0" name="nama_proyek" value="{{ old('nama_proyek', $project->nama_proyek) }}" required>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted text-uppercase tracking-wider">Tipe Proyek</label>
                    <select class="form-select form-select-lg bg-light border-0" name="tipe_proyek" required>
                        <option value="Perancangan" {{ $project->tipe_proyek == 'Perancangan' ? 'selected' : '' }}>Perancangan</option>
                        <option value="Analisa" {{ $project->tipe_proyek == 'Analisa' ? 'selected' : '' }}>Analisa</option>
                    </select>
                </div>
            </div>

            <div class="row g-4 mb-4 border-top pt-4">
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted text-uppercase tracking-wider">Teknik</label>
                    <input type="text" class="form-control bg-light border-0" name="teknik" value="{{ old('teknik', $project->teknik) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted text-uppercase tracking-wider">Metode</label>
                    <input type="text" class="form-control bg-light border-0" name="metode" value="{{ old('metode', $project->metode) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted text-uppercase tracking-wider">Material</label>
                    <input type="text" class="form-control bg-light border-0" name="material" value="{{ old('material', $project->material) }}">
                </div>
            </div>

            <div class="mb-4 border-top pt-4">
                <label class="form-label fw-bold small text-muted text-uppercase tracking-wider">Narasi / Penjelasan Proyek</label>
                <textarea class="form-control bg-light border-0" name="narasi" rows="6" required>{{ old('narasi', $project->narasi) }}</textarea>
            </div>

            <div class="text-end border-top pt-4">
                <button type="submit" class="btn btn-dark px-5 py-2 fw-bold rounded-pill shadow">
                    <i class="bi bi-check-lg me-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection