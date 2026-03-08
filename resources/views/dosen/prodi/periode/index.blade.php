@extends('dosen.layouts.app')

@section('title', 'Setting Periode Akademik')

@section('content')
<style>
    /* Premium Page Header */
    .page-header { background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); padding: 2.5rem; border-radius: 24px; border: 1px solid #ffffff; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); margin-bottom: 2.5rem; position: relative; overflow: hidden; }
    .page-header::after { content: ''; position: absolute; right: -5%; top: -20%; width: 300px; height: 300px; background: radial-gradient(circle, rgba(15,23,42,0.03) 0%, transparent 70%); border-radius: 50%; pointer-events: none; }
    
    /* Modern Table Styling */
    .table-modern { border-collapse: separate; border-spacing: 0 12px; margin-top: -12px; }
    .table-modern thead th { border-bottom: none; font-size: 0.75rem; font-weight: 800; color: #64748b; letter-spacing: 1px; padding: 0 1.5rem 0.5rem; }
    .table-modern tbody tr { background-color: #ffffff; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02); transition: all 0.3s ease; border-radius: 16px; }
    .table-modern tbody tr:hover { transform: translateY(-3px); box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.08); z-index: 10; position: relative; }
    .table-modern tbody td { padding: 1.25rem 1.5rem; border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    .table-modern tbody td:first-child { border-left: 1px solid #f1f5f9; border-top-left-radius: 16px; border-bottom-left-radius: 16px; }
    .table-modern tbody td:last-child { border-right: 1px solid #f1f5f9; border-top-right-radius: 16px; border-bottom-right-radius: 16px; }
    
    /* Custom iOS-like Toggle Switch */
    .custom-switch .form-check-input { width: 3em; height: 1.6em; background-color: #cbd5e1; border-color: transparent; background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e"); transition: background-position .15s ease-in-out; cursor: pointer; }
    .custom-switch .form-check-input:focus { border-color: transparent; box-shadow: 0 0 0 0.25rem rgba(15, 23, 42, 0.1); }
    .custom-switch .form-check-input:checked { background-color: #0f172a; border-color: #0f172a; }
    .switch-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; margin-left: 8px; transition: color 0.3s; }
    .is-active-text { color: #0f172a; }
    .is-inactive-text { color: #94a3b8; }

    /* Soft Badges */
    .badge-soft-success { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .badge-soft-warning { background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
    .badge-soft-danger { background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
    .badge-soft-secondary { background-color: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }

    /* Icon Buttons */
    .btn-icon { width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; padding: 0; border-radius: 10px; transition: all 0.2s; }
</style>

<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4">
    <div style="z-index: 2;">
        <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge bg-dark text-white px-3 py-2 rounded-pill fw-bold shadow-sm" style="font-size: 0.7rem; letter-spacing: 1px;">MODUL PRODI</span>
            <span class="badge bg-white text-dark px-3 py-2 rounded-pill fw-bold shadow-sm border" style="font-size: 0.7rem;">MANAJEMEN WAKTU</span>
        </div>
        <h2 class="fw-black text-dark mb-1" style="font-weight: 900; font-size: 2rem;">Periode Akademik</h2>
        <p class="text-muted mb-0 fw-medium">Kendalikan jendela waktu pendaftaran dan operasional Pra-TA.</p>
    </div>
    <div style="z-index: 2;">
        <button class="btn btn-dark btn-lg rounded-pill fw-bold shadow-lg px-4" data-bs-toggle="modal" data-bs-target="#modalTambahPeriode">
            <i class="bi bi-plus-circle-fill me-2"></i> Buat Periode Baru
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success bg-success-subtle border-success border-2 p-3 rounded-4 mb-4 shadow-sm d-flex align-items-center">
        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;"><i class="bi bi-check-lg"></i></div>
        <div class="fw-bold text-success-emphasis">{{ session('success') }}</div>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger bg-danger-subtle border-danger border-2 p-3 rounded-4 mb-4 shadow-sm">
        <ul class="mb-0 ps-3 text-danger-emphasis fw-medium">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="table-responsive px-1 pb-3">
    <table class="table table-modern w-100 mb-0">
        <thead>
            <tr>
                <th class="text-uppercase">Detail Periode</th>
                <th class="text-uppercase">Durasi / Timeline</th>
                <th class="text-uppercase text-center">Status Sistem</th>
                <th class="text-uppercase">Kontrol Master</th>
                <th class="text-uppercase text-end">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($periodes as $index => $periode)
                @php
                    $now = \Carbon\Carbon::now();
                    $start = \Carbon\Carbon::parse($periode->start_date);
                    $end = \Carbon\Carbon::parse($periode->end_date);
                    
                    if (!$periode->is_active) {
                        $status = 'NON-AKTIF';
                        $badgeClass = 'badge-soft-danger';
                        $iconClass = 'bi-x-circle-fill text-danger';
                    } elseif ($now->between($start, $end)) {
                        $status = 'AKTIF';
                        $badgeClass = 'badge-soft-success';
                        $iconClass = 'bi-play-circle-fill text-success';
                    } elseif ($now->lt($start)) {
                        $status = 'MENDATANG';
                        $badgeClass = 'badge-soft-warning';
                        $iconClass = 'bi-clock-fill text-warning';
                    } else {
                        $status = 'SELESAI';
                        $badgeClass = 'badge-soft-secondary';
                        $iconClass = 'bi-check-circle-fill text-secondary';
                    }
                @endphp
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center border" style="width: 45px; height: 45px;">
                                <i class="bi bi-calendar-event fs-4 text-dark"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">{{ $periode->nama_kode }}</h6>
                                @if($index === 0) 
                                    <span class="badge bg-dark text-white rounded-pill px-2 py-1" style="font-size: 0.6rem;">TERBARU</span>
                                @else
                                    <span class="text-muted small" style="font-size: 0.75rem;">Riwayat</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    
                    <td>
                        <div class="d-flex flex-column gap-1">
                            <div class="small fw-bold text-dark"><i class="bi bi-arrow-right-circle text-muted me-1"></i> {{ $start->format('d M Y') }}</div>
                            <div class="small fw-bold text-dark"><i class="bi bi-flag text-muted me-1"></i> {{ $end->format('d M Y') }}</div>
                        </div>
                    </td>
                    
                    <td class="text-center">
                        <span class="badge {{ $badgeClass }} px-3 py-2 rounded-pill fw-bold shadow-sm d-inline-flex align-items-center gap-2">
                            <i class="bi {{ $iconClass }}"></i> {{ $status }}
                        </span>
                    </td>
                    
                    <td>
                        <form action="{{ route('dosen.prodi.periode.toggle', $periode->periode_id) }}" method="POST" class="m-0">
                            @csrf @method('PATCH')
                            <div class="form-check form-switch custom-switch d-flex align-items-center m-0 p-0">
                                <input class="form-check-input m-0 shadow-sm" type="checkbox" role="switch" onchange="this.form.submit()" {{ $periode->is_active ? 'checked' : '' }}>
                                <span class="switch-label {{ $periode->is_active ? 'is-active-text' : 'is-inactive-text' }}">
                                    {{ $periode->is_active ? 'ON' : 'OFF' }}
                                </span>
                            </div>
                        </form>
                    </td>
                    
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <button class="btn btn-light btn-icon border shadow-sm" data-bs-toggle="modal" data-bs-target="#modalEditPeriode-{{ $periode->periode_id }}" title="Edit Periode">
                                <i class="bi bi-pencil-square text-dark"></i>
                            </button>
                            <form action="{{ route('dosen.prodi.periode.destroy', $periode->periode_id) }}" method="POST" onsubmit="return confirm('Peringatan Ekstrem: Hapus periode ini? Ini dapat merusak data Topik dan Bimbingan yang terhubung.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-icon shadow-sm bg-opacity-10 text-danger border-0" style="background-color: #fee2e2;" title="Hapus Permanen">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                <div class="modal fade" id="modalEditPeriode-{{ $periode->periode_id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                            <div class="modal-header bg-white border-bottom p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-dark text-white rounded-3 p-2 d-flex align-items-center justify-content-center"><i class="bi bi-pencil-square fs-5"></i></div>
                                    <h5 class="modal-title fw-black text-dark mb-0">Edit Periode</h5>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('dosen.prodi.periode.update', $periode->periode_id) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-body p-4 p-md-5 bg-light text-start">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-muted small text-uppercase tracking-wide">Nama / Kode Periode</label>
                                        <input type="text" class="form-control form-control-lg border-0 shadow-sm fw-bold text-dark" name="nama_kode" value="{{ $periode->nama_kode }}" required>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-muted small text-uppercase tracking-wide">Tanggal Mulai</label>
                                            <input type="date" class="form-control form-control-lg border-0 shadow-sm" name="start_date" value="{{ $periode->start_date }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-muted small text-uppercase tracking-wide">Tanggal Akhir</label>
                                            <input type="date" class="form-control form-control-lg border-0 shadow-sm" name="end_date" value="{{ $periode->end_date }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer bg-white border-top p-4">
                                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-dark rounded-pill px-5 fw-bold shadow-sm">Simpan Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3 border" style="width: 80px; height: 80px;">
                            <i class="bi bi-calendar-x fs-1 text-muted"></i>
                        </div>
                        <h5 class="fw-bold text-dark">Data Kosong</h5>
                        <p class="text-muted">Belum ada periode akademik yang ditambahkan.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="modal fade" id="modalTambahPeriode" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-dark text-white border-0 p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white text-dark rounded-3 p-2 d-flex align-items-center justify-content-center"><i class="bi bi-calendar-plus fs-5"></i></div>
                    <h5 class="modal-title fw-black mb-0">Buat Periode Baru</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('dosen.prodi.periode.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4 p-md-5 bg-light">
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase tracking-wide">Nama / Kode Periode <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg border-0 shadow-sm fw-bold" name="nama_kode" placeholder="Contoh: Ganjil 2026/2027" required>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small text-uppercase tracking-wide">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-lg border-0 shadow-sm" name="start_date" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small text-uppercase tracking-wide">Tanggal Berakhir <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-lg border-0 shadow-sm" name="end_date" required>
                        </div>
                    </div>
                    <div class="mt-4 p-3 bg-white border rounded-3 shadow-sm d-flex gap-3">
                        <i class="bi bi-info-circle-fill text-dark fs-4"></i>
                        <div class="small text-muted fw-medium">Sistem akan otomatis mendeteksi periode mana yang aktif berdasarkan rentang waktu yang Anda tetapkan. Anda bisa mematikannya secara manual nanti.</div>
                    </div>
                </div>
                <div class="modal-footer bg-white border-0 p-4">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-dark rounded-pill px-5 fw-bold shadow-lg">Buat Periode</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection