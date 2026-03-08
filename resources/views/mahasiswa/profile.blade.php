@extends('mahasiswa.layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">Profil Saya</h3>
</div>

@if(session('success'))
    <div class="alert alert-dark bg-dark text-white border-0 alert-dismissible fade show rounded-3 mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border border-light-subtle shadow-sm rounded-4 h-100">
            <div class="card-body p-4 text-center">
                <div class="mb-4">
                    @if($user->visual_path)
                        <img src="{{ asset('storage/' . $user->visual_path) }}" alt="Foto Profil" class="rounded-circle object-fit-cover shadow-sm" width="120" height="120">
                    @else
                        <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center mx-auto shadow-sm" style="width: 120px; height: 120px; font-size: 2.5rem; font-weight: bold;">
                            {{ substr($user->nama, 0, 1) }}
                        </div>
                    @endif
                </div>
                
                <h4 class="fw-bold mb-1">{{ $user->nama }}</h4>
                <p class="text-muted mb-3">{{ $user->nim }}</p>

                <div class="bg-light rounded-3 p-3 text-start mb-3 border">
                    <div class="mb-2">
                        <small class="text-muted fw-bold d-block text-uppercase" style="font-size: 0.7rem;">Program Studi</small>
                        <span class="fw-medium text-dark">{{ $user->program_studi }}</span>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted fw-bold d-block text-uppercase" style="font-size: 0.7rem;">Kelas</small>
                        <span class="fw-medium text-dark">{{ $user->kelas ?? '-' }}</span>
                    </div>
                    <div>
                        <small class="text-muted fw-bold d-block text-uppercase" style="font-size: 0.7rem;">Angkatan</small>
                        <span class="fw-medium text-dark">{{ $user->angkatan }}</span>
                    </div>
                </div>
                <div class="small text-muted">
                    <i class="bi bi-info-circle me-1"></i> Data akademik terhubung dengan sistem kampus dan tidak dapat diubah secara manual.
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border border-light-subtle shadow-sm rounded-4 h-100">
            <div class="card-body p-4 p-md-5">
                <h5 class="fw-bold mb-4">Informasi Kontak & Sosial</h5>
                
                <form action="{{ route('mahasiswa.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium text-muted small">Email Kampus</label>
                            <input type="email" class="form-control bg-light border-0" value="{{ $user->email }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium text-muted small">Username</label>
                            <input type="text" class="form-control bg-light border-0" value="{{ $user->username }}" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="no_tlp" class="form-label fw-medium small">Nomor Telepon / WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="no_tlp" name="no_tlp" value="{{ old('no_tlp', $user->no_tlp) }}" placeholder="Contoh: 08123456789" required>
                            @error('no_tlp') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="url_sosmed" class="form-label fw-medium small">Link Portfolio / LinkedIn / Instagram</label>
                            <input type="url" class="form-control" id="url_sosmed" name="url_sosmed" value="{{ old('url_sosmed', $user->url_sosmed) }}" placeholder="https://...">
                            @error('url_sosmed') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end border-top pt-4 mt-2">
                        <button type="submit" class="btn btn-dark px-4 py-2 fw-medium rounded-3">
                            <i class="bi bi-save me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection