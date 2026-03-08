@extends('mahasiswa.layouts.app')

@section('title', 'Susun Portofolio')

@section('content')
<style>
    /* Styling Premium Form & Accordion */
    .form-floating > .form-control, .form-floating > .form-select { border: 2px solid #f1f5f9; border-radius: 12px; background-color: #f8fafc; transition: all 0.3s; font-weight: 500; color: #0f172a; }
    .form-floating > .form-control:focus, .form-floating > .form-select:focus { border-color: #0f172a; background-color: #ffffff; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05); }
    .form-floating > label { color: #94a3b8; font-weight: 600; }
    
    .custom-accordion .accordion-item { border: 1px solid #e2e8f0; border-radius: 16px !important; margin-bottom: 1.5rem; overflow: hidden; background: #ffffff; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02); transition: all 0.3s ease; }
    .custom-accordion .accordion-item:hover { box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.05); border-color: #cbd5e1; }
    .custom-accordion .accordion-button { padding: 1.25rem 1.5rem; background-color: #f8fafc; border: none; box-shadow: none; font-weight: 800; color: #0f172a; }
    .custom-accordion .accordion-button:not(.collapsed) { background-color: #ffffff; border-bottom: 1px dashed #e2e8f0; }
    
    /* Decorative Header */
    .form-header-bg { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border-radius: 24px; padding: 3rem 2rem; color: white; margin-bottom: -2rem; position: relative; overflow: hidden; }
    .form-header-bg::after { content: ''; position: absolute; right: 0; top: 0; width: 200px; height: 100%; background: url("data:image/svg+xml,%3Csvg width='20' height='20' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'%3E%3Ccircle cx='3' cy='3' r='3'/%3E%3Ccircle cx='13' cy='13' r='3'/%3E%3C/g%3E%3C/svg%3E"); }
</style>

<div class="mb-5">
    <a href="{{ route('mahasiswa.project.index') }}" class="text-decoration-none text-muted mb-3 d-inline-flex align-items-center fw-bold transition-all hover-translate-x" style="font-size: 0.9rem;">
        <i class="bi bi-arrow-left me-2"></i> Batal & Kembali
    </a>
</div>

<div class="form-header-bg shadow-sm">
    <div class="row position-relative" style="z-index: 2;">
        <div class="col-md-8">
            <span class="badge bg-white text-dark px-3 py-2 rounded-pill fw-bold mb-3 shadow-sm" style="font-size: 0.7rem;">BUILD YOUR PORTFOLIO</span>
            <h2 class="fw-black mb-2">Ceritakan Karya Terbaikmu</h2>
            <p class="text-white-50 mb-0 fw-medium">Tambahkan satu atau beberapa proyek sekaligus. Data ini akan direview oleh dosen secara anonim.</p>
        </div>
    </div>
</div>

<div class="container-fluid px-0" style="margin-top: 4rem;">
    @if($errors->any())
        <div class="alert alert-danger bg-danger-subtle border-danger border-2 p-4 rounded-4 mb-4 shadow-sm">
            <div class="fw-bold text-danger-emphasis mb-2"><i class="bi bi-exclamation-triangle-fill me-2"></i>Terdapat kesalahan pada isian Anda:</div>
            <ul class="mb-0 small text-danger">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('mahasiswa.project.store') }}" method="POST" id="portfolioForm">
        @csrf
        
        <div class="accordion custom-accordion" id="dynamic-fields-container">
            
            <div class="accordion-item" id="project-item-0">
                <h2 class="accordion-header" id="heading-0">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-0" aria-expanded="true" aria-controls="collapse-0">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-black" style="width: 35px; height: 35px; font-size: 1rem;">1</div>
                            <span>Rincian Proyek Baru</span>
                        </div>
                    </button>
                </h2>
                <div id="collapse-0" class="accordion-collapse collapse show" aria-labelledby="heading-0" data-bs-parent="#dynamic-fields-container">
                    <div class="accordion-body p-4 p-md-5">
                        <div class="row g-4">
                            <div class="col-md-8">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="nama_proyek[]" placeholder="Nama Proyek" required>
                                    <label>Judul / Nama Proyek <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select" name="tipe_proyek[]" required>
                                        <option value="" selected disabled>Pilih Tipe...</option>
                                        <option value="Perancangan">Perancangan (Desain)</option>
                                        <option value="Analisa">Analisa (Kajian)</option>
                                    </select>
                                    <label>Kategori Proyek <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="teknik[]" placeholder="Teknik">
                                    <label>Teknik Pengerjaan</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="metode[]" placeholder="Metode">
                                    <label>Metode / Pendekatan</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="material[]" placeholder="Material">
                                    <label>Material Utama</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" name="narasi[]" placeholder="Ceritakan detail..." style="height: 150px; resize: none;" required></textarea>
                                    <label>Narasi / Penjelasan Proyek <span class="text-danger">*</span></label>
                                </div>
                                <div class="form-text mt-2 small text-muted"><i class="bi bi-info-circle me-1"></i> Jelaskan latar belakang, proses, dan hasil akhir dari karya ini.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center bg-white p-4 rounded-4 border shadow-sm mb-5">
            <button type="button" id="add-project-btn" class="btn btn-outline-dark rounded-pill px-4 py-2 fw-bold mb-3 mb-md-0 border-2">
                <i class="bi bi-plus-circle me-2"></i> Tambah Proyek Lainnya
            </button>
            
            <button type="submit" class="btn btn-dark btn-lg rounded-pill px-5 fw-bold shadow-lg">
                <i class="bi bi-cloud-arrow-up-fill me-2"></i> Simpan Portofolio
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let projectIndex = 1;
        const container = document.getElementById('dynamic-fields-container');
        const addBtn = document.getElementById('add-project-btn');

        addBtn.addEventListener('click', function () {
            // Tutup accordion yang sedang terbuka (opsional, agar rapi)
            const openCollapses = container.querySelectorAll('.collapse.show');
            openCollapses.forEach(collapse => {
                const bsCollapse = new bootstrap.Collapse(collapse, { toggle: false });
                bsCollapse.hide();
            });

            // Buat Accordion Item Baru
            const newField = document.createElement('div');
            newField.className = 'accordion-item';
            newField.id = `project-item-${projectIndex}`;
            newField.style.opacity = '0';
            newField.style.transform = 'translateY(15px)';
            newField.style.transition = 'all 0.4s ease';
            
            newField.innerHTML = `
                <h2 class="accordion-header" id="heading-${projectIndex}">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-${projectIndex}" aria-expanded="true" aria-controls="collapse-${projectIndex}">
                        <div class="d-flex align-items-center justify-content-between w-100 pe-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-black" style="width: 35px; height: 35px; font-size: 1rem;">${projectIndex + 1}</div>
                                <span>Rincian Proyek Tambahan</span>
                            </div>
                        </div>
                    </button>
                </h2>
                <div id="collapse-${projectIndex}" class="accordion-collapse collapse show" aria-labelledby="heading-${projectIndex}" data-bs-parent="#dynamic-fields-container">
                    <div class="accordion-body p-4 p-md-5">
                        <div class="row g-4">
                            <div class="col-md-8">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="nama_proyek[]" placeholder="Nama Proyek" required>
                                    <label>Judul / Nama Proyek <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select" name="tipe_proyek[]" required>
                                        <option value="" selected disabled>Pilih Tipe...</option>
                                        <option value="Perancangan">Perancangan (Desain)</option>
                                        <option value="Analisa">Analisa (Kajian)</option>
                                    </select>
                                    <label>Kategori Proyek <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="teknik[]" placeholder="Teknik">
                                    <label>Teknik Pengerjaan</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="metode[]" placeholder="Metode">
                                    <label>Metode / Pendekatan</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="material[]" placeholder="Material">
                                    <label>Material Utama</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" name="narasi[]" placeholder="Ceritakan detail..." style="height: 150px; resize: none;" required></textarea>
                                    <label>Narasi / Penjelasan Proyek <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            
                            <div class="col-12 text-end mt-4 pt-3 border-top">
                                <button type="button" class="btn btn-outline-danger rounded-pill px-4 fw-bold" onclick="removeProject(${projectIndex})">
                                    <i class="bi bi-trash3 me-2"></i> Hapus Proyek Ini
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            container.appendChild(newField);
            projectIndex++;

            // Trigger animasi muncul
            setTimeout(() => {
                newField.style.opacity = '1';
                newField.style.transform = 'translateY(0)';
            }, 50);
        });

        // Global function untuk menghapus accordion item
        window.removeProject = function(id) {
            const item = document.getElementById(`project-item-${id}`);
            if (item) {
                // Animasi menghilang
                item.style.opacity = '0';
                item.style.transform = 'scale(0.95)';
                setTimeout(() => item.remove(), 300);
            }
        };
    });
</script>
@endpush