@extends('mahasiswa.layouts.app')

@section('title', 'Status Pengajuan Pra-TA')

@section('content')
<style>
    /* Styling Timeline/Stepper */
    .timeline-steps {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin: 3rem 0;
    }
    .timeline-steps::before {
        content: ''; position: absolute; top: 24px; left: 0; right: 0; height: 4px;
        background-color: #e2e8f0; z-index: 1; border-radius: 4px;
    }
    .timeline-step {
        position: relative; z-index: 2; text-align: center; width: 33.33%;
    }
    .timeline-icon {
        width: 52px; height: 52px; border-radius: 50%; background-color: #f8fafc;
        border: 4px solid #e2e8f0; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1rem; font-size: 1.5rem; color: #94a3b8; transition: all 0.3s;
    }
    .timeline-content h6 { font-weight: 800; color: #64748b; margin-bottom: 0.25rem; }
    .timeline-content p { font-size: 0.85rem; color: #94a3b8; margin-bottom: 0; }
    
    /* Active State */
    .step-active .timeline-icon {
        background-color: #000; border-color: #000; color: #fff; box-shadow: 0 0 0 6px rgba(0,0,0,0.1);
    }
    .step-active .timeline-content h6 { color: #000; }
    .step-active .timeline-content p { color: #475569; }
    
    /* Passed State */
    .step-passed .timeline-icon {
        background-color: #000; border-color: #000; color: #fff;
    }
    .step-passed .timeline-content h6 { color: #000; }
    
    /* Line Fill */
    .timeline-progress {
        position: absolute; top: 24px; left: 0; height: 4px; background-color: #000; z-index: 1; border-radius: 4px; transition: width 0.5s ease;
    }
    
    .supervisor-card { border: 1px solid #e2e8f0; transition: all 0.3s; }
    .supervisor-card:hover { border-color: #000; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
</style>

<div class="mb-5">
    <h2 class="fw-extrabold text-dark mb-1">Status Pengajuan</h2>
    <p class="text-muted">Lacak proses persetujuan dan penugasan dosen pembimbing Pra-Tugas Akhir Anda.</p>
</div>

@if(!$aplikasi)
    <div class="card border-0 shadow-sm rounded-5 text-center py-5">
        <div class="card-body py-5">
            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 90px; height: 90px;">
                <i class="bi bi-file-earmark-x fs-1 text-muted"></i>
            </div>
            <h4 class="fw-bold text-dark">Belum Ada Pengajuan</h4>
            <p class="text-muted mx-auto mb-4" style="max-width: 400px;">
                Anda belum mengirimkan aplikasi ke topik dosen mana pun. Lengkapi portofolio dan mulai eksplorasi topik.
            </p>
            <a href="{{ route('mahasiswa.topik.index') }}" class="btn btn-dark px-4 py-2 rounded-pill fw-bold shadow-sm">
                Cari Topik Dosen
            </a>
        </div>
    </div>
@else

    @php
        // Logika untuk menentukan persentase garis progress dan state ikon
        $status = $aplikasi->status;
        $progressWidth = '0%';
        $step1 = $step2 = $step3 = '';
        
        if ($status === 'REJECTED') {
            // Jika ditolak, garis merah dan berhenti di step 1
            $progressWidth = '0%';
            $step1 = 'step-active';
        } elseif ($status === 'APPLIED') {
            $progressWidth = '16%'; // Setengah jalan ke step 2
            $step1 = 'step-active';
        } elseif ($status === 'APPROVED-PBB1') {
            $progressWidth = '50%'; // Penuh ke step 2
            $step1 = 'step-passed';
            $step2 = 'step-active';
        } elseif ($status === 'APPROVED-FULL') {
            $progressWidth = '100%'; // Penuh sampai ujung
            $step1 = 'step-passed';
            $step2 = 'step-passed';
            $step3 = 'step-active';
        }
    @endphp

    <div class="card border border-light-subtle shadow-sm rounded-4 mb-5 overflow-hidden">
        <div class="card-body p-4 p-md-5">
            <h5 class="fw-bold text-dark mb-4 text-center">Jejak Proses Persetujuan</h5>
            
            @if($status === 'REJECTED')
                <div class="alert alert-danger bg-danger-subtle border-danger text-danger border-2 p-4 rounded-4 mb-4 text-center">
                    <i class="bi bi-x-circle-fill fs-1 mb-2 d-block"></i>
                    <h5 class="fw-bold mb-1">Aplikasi Ditolak</h5>
                    <p class="mb-0 small">Mohon maaf, portofolio Anda belum memenuhi kriteria dosen terkait. Silakan cari dan ajukan ke topik dosen yang lain.</p>
                </div>
                <div class="text-center">
                    <a href="{{ route('mahasiswa.topik.index') }}" class="btn btn-dark px-4 py-2 rounded-pill fw-bold">Cari Topik Baru</a>
                </div>
            @else
                <div class="timeline-steps">
                    <div class="timeline-progress" style="width: {{ $progressWidth }};"></div>
                    
                    <div class="timeline-step {{ $step1 }}">
                        <div class="timeline-icon"><i class="bi bi-send-check-fill"></i></div>
                        <div class="timeline-content">
                            <h6>Aplikasi Terkirim</h6>
                            <p>Menunggu review</p>
                        </div>
                    </div>
                    
                    <div class="timeline-step {{ $step2 }}">
                        <div class="timeline-icon"><i class="bi bi-1-circle-fill"></i></div>
                        <div class="timeline-content">
                            <h6>Disetujui PBB 1</h6>
                            <p>Diterima Dosen Topik</p>
                        </div>
                    </div>
                    
                    <div class="timeline-step {{ $step3 }}">
                        <div class="timeline-icon"><i class="bi bi-2-circle-fill"></i></div>
                        <div class="timeline-content">
                            <h6>Disetujui Penuh</h6>
                            <p>Plotting PBB 2 Selesai</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <h5 class="fw-bold text-dark mb-4">Informasi Bimbingan</h5>
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-dark text-white p-4 rounded-4 shadow-sm border border-secondary">
                <span class="badge bg-white text-dark mb-2 px-3 py-1 rounded-pill fw-bold small">Topik Pilihan</span>
                <h4 class="fw-bold mb-1">{{ $aplikasi->topik->nama_topik }}</h4>
                <div class="text-white-50 small mt-3">
                    <i class="bi bi-calendar-event me-1"></i> Diajukan pada: {{ \Carbon\Carbon::parse($aplikasi->tanggal_submit)->format('d M Y') }}
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card supervisor-card rounded-4 h-100 bg-white shadow-sm p-2">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="badge bg-dark px-3 py-2 rounded-pill fw-bold shadow-sm">Pembimbing 1</span>
                        @if($status === 'APPROVED-PBB1' || $status === 'APPROVED-FULL')
                            <i class="bi bi-check-circle-fill text-success fs-4"></i>
                        @else
                            <i class="bi bi-clock-history text-warning fs-4"></i>
                        @endif
                    </div>
                    
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-light text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold border" style="width: 50px; height: 50px; font-size: 1.2rem;">
                            {{ substr($aplikasi->topik->dosen->nama, 0, 1) }}
                        </div>
                        <div>
                            <div class="fw-bold text-dark text-truncate" style="max-width: 200px;">{{ $aplikasi->topik->dosen->nama }}</div>
                            <div class="small text-muted">Pemilik Topik</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card supervisor-card rounded-4 h-100 bg-white shadow-sm p-2">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="badge border border-dark text-dark px-3 py-2 rounded-pill fw-bold shadow-sm">Pembimbing 2</span>
                        @if($status === 'APPROVED-FULL')
                            <i class="bi bi-check-circle-fill text-success fs-4"></i>
                        @else
                            <i class="bi bi-clock-history text-warning fs-4"></i>
                        @endif
                    </div>
                    
                    @if($aplikasi->pembimbing2)
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-light text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold border" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                {{ substr($aplikasi->pembimbing2->nama, 0, 1) }}
                            </div>
                            <div>
                                <div class="fw-bold text-dark text-truncate" style="max-width: 200px;">{{ $aplikasi->pembimbing2->nama }}</div>
                                <div class="small text-muted">Di-assign oleh Prodi</div>
                            </div>
                        </div>
                    @else
                        <div class="d-flex align-items-center gap-3 opacity-50">
                            <div class="bg-light text-muted rounded-circle d-flex align-items-center justify-content-center border border-dashed" style="width: 50px; height: 50px;">
                                <i class="bi bi-person-x fs-4"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-muted">Belum Ditentukan</div>
                                <div class="small text-muted">Menunggu proses Prodi</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif

@endsection