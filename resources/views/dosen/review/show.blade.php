@extends('dosen.layouts.app')

@section('title', 'Tinjau Portofolio')

@section('content')
<div class="mb-4">
    <a href="{{ route('dosen.review.index') }}" class="text-decoration-none text-muted mb-3 d-inline-block hover-translate-x">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Antrean
    </a>
</div>

@if(session('error'))
    <div class="alert alert-danger border-0 p-3 rounded-4 mb-4 shadow-sm d-flex align-items-center">
        <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-danger"></i>
        <div class="fw-bold text-dark">{{ session('error') }}</div>
    </div>
@endif

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border border-light-subtle shadow-sm rounded-4 position-sticky" style="top: 100px;">
            <div class="card-body p-4 p-md-5 text-center border-bottom">
                
                @if($application->mahasiswa->visual_path)
                    <img src="{{ asset('storage/' . $application->mahasiswa->visual_path) }}" alt="Foto Profil" class="rounded-circle object-fit-cover shadow-sm mx-auto mb-4" width="100" height="100" style="border: 3px solid #f8fafc;">
                @else
                    <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4 shadow-sm" style="width: 100px; height: 100px; font-size: 2.5rem; font-weight: bold; border: 3px solid #f8fafc;">
                        {{ substr($application->mahasiswa->nama, 0, 1) }}
                    </div>
                @endif
                
                <h4 class="fw-bold text-dark mb-1">{{ $application->mahasiswa->nama }}</h4>
                <p class="text-muted mb-4">{{ $application->mahasiswa->nim }} — {{ $application->mahasiswa->program_studi }}</p>
                
                <div class="d-flex justify-content-center gap-2 mb-3">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $application->mahasiswa->no_tlp) }}" target="_blank" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-bold">
                        <i class="bi bi-whatsapp me-1"></i> Hubungi
                    </a>
                    
                    <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#profilModal">
                        <i class="bi bi-person-vcard me-1"></i> Lihat Profil
                    </button>
                </div>
            </div>
            
            <div class="card-body p-4 p-md-5 bg-light rounded-bottom-4">
                <h6 class="fw-bold text-uppercase small text-muted mb-3 text-center">Keputusan Review</h6>
                
                @if($application->status === 'APPLIED')
                    <form action="{{ route('dosen.review.update', $application->application_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="d-grid gap-3">
                            <button type="submit" name="status" value="APPROVED-PBB1" class="btn btn-dark py-3 rounded-pill fw-bold shadow-sm" onclick="return confirm('Setujui mahasiswa ini menjadi bimbingan Anda? Kuota akan terpotong 1.')">
                                <i class="bi bi-check-circle-fill me-2"></i> Terima Aplikasi
                            </button>
                            
                            <button type="submit" name="status" value="REJECTED" class="btn btn-outline-danger py-2 rounded-pill fw-bold bg-white" onclick="return confirm('Tolak aplikasi ini? Mahasiswa akan dapat mendaftar ke dosen lain.')">
                                <i class="bi bi-x-circle me-1"></i> Tolak Aplikasi
                            </button>
                        </div>
                    </form>
                @else
                    <div class="text-center">
                        <span class="badge {{ $application->status === 'REJECTED' ? 'bg-danger' : 'bg-success' }} fs-6 px-4 py-2 rounded-pill">
                            Status: {{ $application->status }}
                        </span>
                        <p class="small text-muted mt-3 mb-0">Aplikasi ini sudah direview pada {{ \Carbon\Carbon::parse($application->tanggal_response)->format('d M Y') }}.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <h4 class="fw-extrabold text-dark mb-4">Portofolio Karya</h4>
        
        @if($application->mahasiswa->projects->isEmpty())
            <div class="alert alert-warning border-warning rounded-4 p-4 shadow-sm text-center">
                <i class="bi bi-exclamation-triangle-fill fs-3 text-warning mb-2 d-block"></i>
                <div class="fw-bold text-dark">Portofolio Kosong</div>
                <p class="mb-0 text-muted small">Mahasiswa ini belum mengunggah proyek apa pun ke dalam sistem.</p>
            </div>
        @else
            @foreach($application->mahasiswa->projects as $index => $proj)
                <div class="card border border-light-subtle shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="bg-dark text-white px-4 py-3 d-flex justify-content-between align-items-center">
                        <div class="fw-bold">
                            <span class="text-white-50 me-2">#{{ $index + 1 }}</span> {{ $proj->nama_proyek }}
                        </div>
                        <span class="badge bg-white text-dark rounded-pill shadow-sm">{{ $proj->tipe_proyek }}</span>
                    </div>
                    
                    <div class="card-body p-4 p-md-5">
                        <div class="row g-4 mb-4 pb-4 border-bottom">
                            <div class="col-md-4">
                                <div class="text-muted small fw-bold text-uppercase mb-1">Teknik</div>
                                <div class="fw-medium text-dark">{{ $proj->teknik ?: '-' }}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-muted small fw-bold text-uppercase mb-1">Metode</div>
                                <div class="fw-medium text-dark">{{ $proj->metode ?: '-' }}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-muted small fw-bold text-uppercase mb-1">Material</div>
                                <div class="fw-medium text-dark">{{ $proj->material ?: '-' }}</div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="text-muted small fw-bold text-uppercase mb-2">Narasi & Penjelasan</div>
                            <p class="text-dark mb-0" style="line-height: 1.8;">{{ $proj->narasi }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<div class="modal fade" id="profilModal" tabindex="-1" aria-labelledby="profilModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-dark text-white border-0 p-4">
                <h5 class="modal-title fw-bold d-flex align-items-center" id="profilModalLabel">
                    <i class="bi bi-person-badge fs-4 me-2 text-white-50"></i> Profil Lengkap Mahasiswa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-5 bg-light p-4 p-md-5 text-center border-end">
                        @if($application->mahasiswa->visual_path)
                            <img src="{{ asset('storage/' . $application->mahasiswa->visual_path) }}" alt="Foto Profil" class="rounded-circle object-fit-cover shadow-sm mb-3" width="120" height="120" style="border: 4px solid #ffffff;">
                        @else
                            <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 shadow-sm" style="width: 120px; height: 120px; font-size: 3rem; font-weight: bold; border: 4px solid #ffffff;">
                                {{ substr($application->mahasiswa->nama, 0, 1) }}
                            </div>
                        @endif
                        <h5 class="fw-bold text-dark mb-1">{{ $application->mahasiswa->nama }}</h5>
                        <p class="text-muted mb-0">{{ $application->mahasiswa->nim }}</p>
                        <hr class="my-4">
                        <div class="text-start">
                            <div class="mb-3">
                                <small class="text-muted fw-bold d-block text-uppercase" style="font-size: 0.7rem;">Program Studi</small>
                                <span class="fw-bold text-dark">{{ $application->mahasiswa->program_studi }}</span>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted fw-bold d-block text-uppercase" style="font-size: 0.7rem;">Angkatan</small>
                                <span class="fw-bold text-dark">{{ $application->mahasiswa->angkatan }}</span>
                            </div>
                            <div>
                                <small class="text-muted fw-bold d-block text-uppercase" style="font-size: 0.7rem;">Kelas</small>
                                <span class="fw-bold text-dark">{{ $application->mahasiswa->kelas ?? 'Belum Diatur' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7 p-4 p-md-5">
                        <h6 class="fw-bold text-dark mb-4 border-bottom pb-2">Informasi Kontak & Akun</h6>
                        
                        <div class="row g-4">
                            <div class="col-12">
                                <small class="text-muted fw-bold d-block text-uppercase mb-1" style="font-size: 0.7rem;"><i class="bi bi-envelope me-1"></i> Email Kampus</small>
                                <div class="fw-medium text-dark">{{ $application->mahasiswa->email }}</div>
                            </div>
                            
                            <div class="col-12">
                                <small class="text-muted fw-bold d-block text-uppercase mb-1" style="font-size: 0.7rem;"><i class="bi bi-person me-1"></i> Username Sistem</small>
                                <div class="fw-medium text-dark">{{ $application->mahasiswa->username }}</div>
                            </div>

                            <div class="col-12">
                                <small class="text-muted fw-bold d-block text-uppercase mb-1" style="font-size: 0.7rem;"><i class="bi bi-telephone me-1"></i> Nomor Telepon / WA</small>
                                <div class="fw-medium text-dark">{{ $application->mahasiswa->no_tlp ?? 'Belum diisi' }}</div>
                            </div>

                            <div class="col-12">
                                <small class="text-muted fw-bold d-block text-uppercase mb-1" style="font-size: 0.7rem;"><i class="bi bi-link-45deg me-1"></i> Tautan Sosmed / LinkedIn</small>
                                @if($application->mahasiswa->url_sosmed)
                                    <a href="{{ $application->mahasiswa->url_sosmed }}" target="_blank" class="fw-bold text-primary text-decoration-none">
                                        Kunjungi Tautan <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 0.8rem;"></i>
                                    </a>
                                @else
                                    <div class="fw-medium text-muted fst-italic">Belum ditambahkan</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer bg-light border-0 p-3">
                <button type="button" class="btn btn-dark rounded-pill px-4" data-bs-dismiss="modal">Tutup Profil</button>
            </div>
        </div>
    </div>
</div>
@endsection