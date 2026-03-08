@extends('dosen.layouts.app')

@section('title', 'Assign Pembimbing 2')

@section('content')
<div class="mb-5">
    <span class="badge bg-dark text-white mb-2 px-3 py-2 rounded-pill fw-bold shadow-sm">Area Admin Prodi</span>
    <h2 class="fw-extrabold text-dark mb-1">Penugasan Pembimbing 2</h2>
    <p class="text-muted">Tentukan dosen Pembimbing 2 bagi mahasiswa yang aplikasinya telah disetujui oleh Pembimbing 1.</p>
</div>

@if(session('success'))
    <div class="alert alert-dark bg-dark text-white border-0 p-3 rounded-4 mb-4 shadow-sm d-flex align-items-center">
        <i class="bi bi-check-circle-fill fs-4 me-3 text-success"></i>
        <div>{{ session('success') }}</div>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger border-0 p-3 rounded-4 mb-4 shadow-sm d-flex align-items-center">
        <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-danger"></i>
        <div class="fw-bold">{{ session('error') }}</div>
    </div>
@endif

<ul class="nav nav-pills mb-4 gap-2 border-bottom pb-3" id="assignTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active rounded-pill fw-bold px-4" id="perlu-assign-tab" data-bs-toggle="tab" data-bs-target="#perlu-assign" type="button" role="tab">
            Perlu Penugasan 
            @if($butuhAssign->count() > 0)
                <span class="badge bg-danger ms-2 rounded-circle">{{ $butuhAssign->count() }}</span>
            @endif
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link rounded-pill fw-bold px-4 " id="riwayat-tab" data-bs-toggle="tab" data-bs-target="#riwayat" type="button" role="tab">
            Riwayat Penugasan
        </button>
    </li>
</ul>

<div class="tab-content" id="assignTabContent">
    
    <div class="tab-pane fade show active" id="perlu-assign" role="tabpanel">
        <div class="card border border-light-subtle shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase tracking-wide">
                        <tr>
                            <th class="px-4 py-4">Mahasiswa</th>
                            <th class="px-4 py-4">Topik & Pembimbing 1</th>
                            <th class="px-4 py-4 text-center">Status</th>
                            <th class="px-4 py-4 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($butuhAssign as $app)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="fw-bold text-dark">{{ $app->mahasiswa->nama }}</div>
                                    <div class="small text-muted">{{ $app->mahasiswa->nim }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="fw-medium text-dark text-truncate" style="max-width: 250px;">{{ $app->topik->nama_topik }}</div>
                                    <div class="small text-muted"><i class="bi bi-person-fill me-1"></i> PBB 1: {{ $app->topik->dosen->nama }}</div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="badge bg-info-subtle border border-info text-info-emphasis px-3 py-2 rounded-pill fw-bold small shadow-sm">
                                        Menunggu PBB 2
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-end">
                                    <button class="btn btn-dark btn-sm rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAssign-{{ $app->application_id }}">
                                        Pilih Dosen <i class="bi bi-arrow-right ms-1"></i>
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="modalAssign-{{ $app->application_id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                        <div class="modal-header bg-dark text-white border-0 p-4">
                                            <h5 class="modal-title fw-bold"><i class="bi bi-person-plus-fill me-2 text-white-50"></i> Assign Pembimbing 2</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('dosen.prodi.assign.update', $app->application_id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="modal-body p-4 p-md-5 bg-light text-start">
                                                
                                                <div class="mb-4 bg-white p-3 rounded-3 border">
                                                    <small class="text-muted fw-bold d-block text-uppercase mb-1" style="font-size: 0.7rem;">Mahasiswa</small>
                                                    <div class="fw-bold text-dark">{{ $app->mahasiswa->nama }}</div>
                                                    <hr class="my-2 text-muted">
                                                    <small class="text-muted fw-bold d-block text-uppercase mb-1" style="font-size: 0.7rem;">Pembimbing 1</small>
                                                    <div class="fw-bold text-dark">{{ $app->topik->dosen->nama }}</div>
                                                </div>

                                                <label class="form-label fw-bold text-muted small text-uppercase tracking-wide">Pilih Pembimbing 2 <span class="text-danger">*</span></label>
                                                <select class="form-select form-select-lg border-0 shadow-sm fw-medium text-dark" name="pembimbing_2_id" required>
                                                    <option value="" selected disabled>-- Pilih Dosen --</option>
                                                    @foreach($dosens as $dosen)
                                                        @if($dosen->dosen_id != $app->topik->dosen_id)
                                                            <option value="{{ $dosen->dosen_id }}">{{ $dosen->nama }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <div class="form-text mt-2 small text-muted">
                                                    Dosen yang telah menjadi Pembimbing 1 tidak akan muncul di daftar pilihan ini.
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-white border-0 p-4">
                                                <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm">Konfirmasi Assign</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bi bi-person-check fs-1 d-block mb-3"></i>
                                    Tidak ada mahasiswa yang menunggu penugasan PBB 2.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="riwayat" role="tabpanel">
        <div class="card border border-light-subtle shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase tracking-wide">
                        <tr>
                            <th class="px-4 py-4">Mahasiswa</th>
                            <th class="px-4 py-4">Pembimbing 1</th>
                            <th class="px-4 py-4">Pembimbing 2</th>
                            <th class="px-4 py-4 text-center">Status Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($riwayat as $app)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="fw-bold text-dark">{{ $app->mahasiswa->nama }}</div>
                                    <div class="small text-muted">{{ $app->mahasiswa->nim }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="fw-medium text-dark"><i class="bi bi-1-circle-fill text-muted me-1"></i> {{ $app->topik->dosen->nama }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="fw-medium text-dark"><i class="bi bi-2-circle-fill text-muted me-1"></i> {{ $app->pembimbing2->nama ?? '-' }}</div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="badge bg-success text-white px-3 py-2 rounded-pill fw-bold shadow-sm">
                                        <i class="bi bi-check2-all me-1"></i> APPROVED-FULL
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">Belum ada riwayat penugasan yang selesai.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<style>
    .nav-pills .nav-link.active { background-color: #0f172a; color: white; }
    .nav-pills .nav-link:hover:not(.active) { background-color: #f1f5f9; color: #0f172a !important; }
</style>
@endsection