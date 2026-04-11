@extends('mahasiswa.layouts.app')

@section('title', 'Status Pengajuan Pra-TA')

@section('content')
<style>
    /* Animasi Masuk */
    .fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

    /* Empty State Premium */
    .empty-state-card { border: 2px dashed #cbd5e1; background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%); transition: all 0.3s; }
    .empty-state-card:hover { border-color: #94a3b8; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05); transform: translateY(-3px); }

    /* Timeline Modern */
    .timeline-wrapper { position: relative; max-width: 600px; margin: 3rem auto 2rem; padding: 0 2rem; }
    .timeline-steps { display: flex; justify-content: space-between; position: relative; }
    
    /* Garis Dasar Abu-abu */
    .timeline-steps::before {
        content: ''; position: absolute; top: 28px; left: 0; right: 0; height: 6px;
        background-color: #f1f5f9; z-index: 1; border-radius: 10px;
    }
    
    /* Garis Progres Berjalan */
    .timeline-progress {
        position: absolute; top: 28px; left: 0; height: 6px; 
        background: linear-gradient(90deg, #0f172a 0%, #3b82f6 100%);
        z-index: 1; border-radius: 10px; transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .timeline-step { position: relative; z-index: 2; text-align: center; width: 140px; }
    
    .timeline-icon {
        width: 60px; height: 60px; border-radius: 50%; background-color: #ffffff;
        border: 4px solid #f1f5f9; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1rem; font-size: 1.5rem; color: #cbd5e1; transition: all 0.5s ease;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }
    
    .timeline-content h6 { font-weight: 800; color: #94a3b8; margin-bottom: 0.3rem; white-space: nowrap; position: absolute; left: 50%; transform: translateX(-50%); transition: color 0.3s; }
    .timeline-content p { font-size: 0.85rem; color: #cbd5e1; margin-top: 1.5rem; white-space: nowrap; position: absolute; left: 50%; transform: translateX(-50%); font-weight: 500; }
    
    /* State: Sedang Aktif (Animasi Pulse) */
    .step-active .timeline-icon { 
        background-color: #0f172a; border-color: #ffffff; color: #fff; 
        box-shadow: 0 0 0 8px rgba(15, 23, 42, 0.1); 
        animation: pulse-ring 2s infinite cubic-bezier(0.215, 0.61, 0.355, 1);
    }
    .step-active .timeline-content h6 { color: #0f172a; }
    .step-active .timeline-content p { color: #64748b; font-weight: 600; }
    
    /* State: Sudah Dilewati */
    .step-passed .timeline-icon { background-color: #0f172a; border-color: #0f172a; color: #fff; box-shadow: 0 4px 10px rgba(15, 23, 42, 0.2); }
    .step-passed .timeline-content h6 { color: #0f172a; }
    .step-passed .timeline-content p { color: #64748b; }

    @keyframes pulse-ring {
        0% { box-shadow: 0 0 0 0 rgba(15, 23, 42, 0.2); }
        70% { box-shadow: 0 0 0 15px rgba(15, 23, 42, 0); }
        100% { box-shadow: 0 0 0 0 rgba(15, 23, 42, 0); }
    }

    /* Kartu Topik Gradient */
    .topic-card { 
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); 
        position: relative; overflow: hidden; 
    }
    .topic-card::after { 
        content: ''; position: absolute; right: -10%; bottom: -20%; width: 250px; height: 250px; 
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%); border-radius: 50%; pointer-events: none; 
    }

    /* Kartu Dosen */
    .supervisor-card { border: 1px solid #e2e8f0; transition: all 0.3s; background: #ffffff; }
    .supervisor-card:hover { border-color: #cbd5e1; transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05); }
    
    .status-badge-custom { padding: 8px 16px; border-radius: 50px; font-weight: 800; font-size: 0.75rem; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 6px; }
</style>

<div class="mb-5 fade-in-up">
    <span class="badge bg-dark text-white px-3 py-2 rounded-pill fw-bold shadow-sm mb-3" style="font-size: 0.7rem; letter-spacing: 1px;">TRACKING SYSTEM</span>
    <h2 class="fw-black text-dark mb-2" style="font-size: 2.2rem;">Status Pengajuan</h2>
    <p class="text-muted fs-6" style="max-width: 600px;">Pantau secara *real-time* proses persetujuan portofolio dan penetapan dosen pembimbing Pra-Tugas Akhir Anda.</p>
</div>

@if(!$aplikasi)
    <div class="card empty-state-card rounded-5 text-center py-5 fade-in-up" style="animation-delay: 0.1s;">
        <div class="card-body py-5">
            <div class="bg-white border rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow-sm" style="width: 100px; height: 100px;">
                <i class="bi bi-folder-x fs-1 text-muted"></i>
            </div>
            <h3 class="fw-black text-dark mb-3">Belum Ada Pengajuan Aktif</h3>
            <p class="text-muted mx-auto mb-4 fs-6" style="max-width: 450px; line-height: 1.6;">
                Anda belum mengirimkan aplikasi ke topik dosen mana pun. Lengkapi portofolio karya Anda dan temukan topik yang sesuai dengan minat Anda.
            </p>
            <a href="{{ route('mahasiswa.topik.index') }}" class="btn btn-dark btn-lg px-5 py-3 rounded-pill fw-bold shadow-lg transition-all hover-lift">
                Eksplorasi Topik Dosen <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
@else

    @php
        $status = $aplikasi->status;
        $progressWidth = '0%';
        $step1 = $step2 = '';
        
        if ($status === 'REJECTED') {
            $progressWidth = '0%';
            $step1 = 'step-active';
        } elseif ($status === 'APPLIED') {
            $progressWidth = '0%'; 
            $step1 = 'step-active';
        } elseif ($status === 'APPROVED') {
            $progressWidth = '100%'; 
            $step1 = 'step-passed';
            $step2 = 'step-active';
        }
    @endphp

    <div class="card border-0 shadow-sm rounded-4 mb-5 overflow-hidden fade-in-up" style="animation-delay: 0.1s;">
        <div class="card-body p-4 p-md-5 bg-white">
            
            @if($status === 'REJECTED')
                <div class="alert alert-danger bg-danger-subtle border-danger text-danger border-2 p-4 p-md-5 rounded-4 text-center">
                    <div class="bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px;">
                        <i class="bi bi-x-lg fs-1"></i>
                    </div>
                    <h4 class="fw-black mb-2">Aplikasi Belum Diterima</h4>
                    <p class="mb-4 text-danger-emphasis mx-auto" style="max-width: 500px; line-height: 1.6;">
                        Mohon maaf, setelah meninjau portofolio Anda, dosen terkait memutuskan bahwa kualifikasi belum sesuai dengan kebutuhan topik ini. Jangan patah semangat!
                    </p>
                    <a href="{{ route('mahasiswa.topik.index') }}" class="btn btn-danger px-5 py-3 rounded-pill fw-bold shadow-sm">
                        Cari Topik Lainnya
                    </a>
                </div>
            @else
                <h5 class="fw-black text-dark mb-4 text-center text-uppercase tracking-wide" style="font-size: 0.85rem; letter-spacing: 1.5px; color: #94a3b8 !important;">Jejak Proses Persetujuan</h5>
                
                <div class="timeline-wrapper pb-5 pt-3">
                    <div class="timeline-steps">
                        <div class="timeline-progress" style="width: {{ $progressWidth }};"></div>
                        
                        <div class="timeline-step {{ $step1 }}">
                            <div class="timeline-icon"><i class="bi bi-send-check-fill"></i></div>
                            <div class="timeline-content">
                                <h6>Aplikasi Terkirim</h6>
                                <p>Menunggu review dosen</p>
                            </div>
                        </div>
                        
                        <div class="timeline-step {{ $step2 }}">
                            <div class="timeline-icon"><i class="bi bi-patch-check-fill"></i></div>
                            <div class="timeline-content">
                                <h6>Disetujui Dosen</h6>
                                <p>Siap bimbingan</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <h5 class="fw-black text-dark mb-4 fade-in-up" style="animation-delay: 0.2s;">Detail Bimbingan</h5>
    <div class="row g-4 fade-in-up" style="animation-delay: 0.3s;">
        
        <div class="col-md-6">
            <div class="topic-card p-4 p-md-5 rounded-4 shadow-sm h-100 d-flex flex-column justify-content-center border-0 text-white">
                <div class="d-flex align-items-center gap-2 mb-4 align-self-start">
                    <span class="badge bg-white text-dark px-3 py-2 rounded-pill fw-bold shadow-sm" style="font-size: 0.7rem;">TOPIK PILIHAN</span>
                </div>
                
                <h3 class="fw-black mb-3" style="line-height: 1.4; font-size: 1.5rem;">{{ $aplikasi->topik->nama_topik }}</h3>
                
                <div class="mt-auto pt-4 border-top border-light border-opacity-25 d-flex align-items-center justify-content-between">
                    <div class="text-white-50 small fw-medium">
                        <i class="bi bi-calendar2-check-fill me-2 text-white"></i> Diajukan: {{ \Carbon\Carbon::parse($aplikasi->tanggal_submit)->format('d M Y') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card supervisor-card rounded-4 h-100 p-2 p-md-3">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <span class="text-muted fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Dosen Pembimbing</span>
                        
                        @if($status === 'APPROVED')
                            <div class="status-badge-custom bg-success-subtle text-success border border-success">
                                <span class="spinner-grow spinner-grow-sm text-success" style="width: 8px; height: 8px;" role="status"></span>
                                DITETAPKAN
                            </div>
                        @else
                            <div class="status-badge-custom bg-warning-subtle text-warning-emphasis border border-warning">
                                <i class="bi bi-hourglass-split"></i> MENUNGGU
                            </div>
                        @endif
                    </div>
                    
                    <div class="d-flex align-items-center gap-4 mb-4">
                        @if($aplikasi->topik->dosen->visual_path)
                            <img src="{{ asset('storage/' . $aplikasi->topik->dosen->visual_path) }}" alt="Avatar" class="rounded-4 object-fit-cover border shadow-sm" style="width: 75px; height: 75px;">
                        @else
                            <div class="bg-dark text-white rounded-4 d-flex align-items-center justify-content-center fw-black shadow-sm" style="width: 75px; height: 75px; font-size: 2rem;">
                                {{ substr($aplikasi->topik->dosen->nama, 0, 1) }}
                            </div>
                        @endif
                        
                        <div>
                            <h5 class="fw-black text-dark mb-1 text-truncate" style="max-width: 250px;" title="{{ $aplikasi->topik->dosen->nama }}">{{ $aplikasi->topik->dosen->nama }}</h5>
                            <div class="badge bg-light text-secondary border rounded-pill px-3 py-1 fw-bold">{{ $aplikasi->topik->dosen->kode ?? 'Dosen Prodi Kriya' }}</div>
                        </div>
                    </div>
                    
                    <div class="mt-auto">
                        @if($status === 'APPROVED')
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $aplikasi->topik->dosen->no_tlp ?? '') }}" target="_blank" class="btn btn-dark w-100 rounded-pill py-3 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 transition-all hover-lift">
                                <i class="bi bi-whatsapp text-success fs-5"></i> Hubungi via WhatsApp
                            </a>
                        @else
                            <button class="btn btn-light border w-100 rounded-pill py-3 fw-bold text-muted d-flex align-items-center justify-content-center gap-2" disabled>
                                <i class="bi bi-lock-fill"></i> Kontak Terkunci
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endif

@endsection