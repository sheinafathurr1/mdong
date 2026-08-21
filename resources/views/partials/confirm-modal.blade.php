<div class="modal fade" id="globalConfirmModal" tabindex="-1" aria-labelledby="globalConfirmModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body p-4 pt-5 text-center">
                <div id="globalConfirmModalIconWrap" class="bg-danger-subtle text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                    <i id="globalConfirmModalIcon" class="bi bi-exclamation-triangle-fill fs-3"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2" id="globalConfirmModalTitle">Konfirmasi</h5>
                <p class="text-muted mb-0" id="globalConfirmModalMessage">Apakah Anda yakin?</p>
            </div>
            <div class="modal-footer border-0 p-4 pt-0 justify-content-center gap-2">
                <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger rounded-pill px-4 fw-bold" id="globalConfirmModalConfirmBtn">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        const modalEl = document.getElementById('globalConfirmModal');
        const modal = new bootstrap.Modal(modalEl);
        const titleEl = document.getElementById('globalConfirmModalTitle');
        const messageEl = document.getElementById('globalConfirmModalMessage');
        const confirmBtn = document.getElementById('globalConfirmModalConfirmBtn');
        const iconWrapEl = document.getElementById('globalConfirmModalIconWrap');
        const iconEl = document.getElementById('globalConfirmModalIcon');

        let targetForm = null;
        let targetButton = null;

        // Dipanggil dari onsubmit form atau onclick tombol submit, menggantikan confirm() bawaan browser.
        // Contoh: onsubmit="return confirmSubmit(this, { message: 'Hapus data ini?', confirmText: 'Ya, Hapus' })"
        window.confirmSubmit = function (el, options) {
            options = options || {};

            targetForm = el.tagName === 'FORM' ? el : el.form;
            targetButton = el.tagName === 'FORM' ? null : el;

            titleEl.textContent = options.title || 'Konfirmasi Tindakan';
            messageEl.textContent = options.message || 'Apakah Anda yakin ingin melanjutkan?';
            confirmBtn.textContent = options.confirmText || 'Ya, Lanjutkan';
            confirmBtn.className = 'btn rounded-pill px-4 fw-bold ' + (options.confirmClass || 'btn-danger');
            iconWrapEl.className = 'rounded-circle d-inline-flex align-items-center justify-content-center mb-3 ' + (options.iconWrapClass || 'bg-danger-subtle text-danger');
            iconEl.className = 'bi ' + (options.icon || 'bi-exclamation-triangle-fill') + ' fs-3';

            modal.show();
            return false; // cegah submit/aksi default bawaan browser
        };

        confirmBtn.addEventListener('click', function () {
            if (!targetForm) {
                return;
            }

            // Kalau yang memicu adalah tombol submit bernama (mis. name="status" value="APPROVED"),
            // sertakan sebagai hidden input karena form.submit() tidak menyertakan tombol yang diklik.
            if (targetButton && targetButton.name) {
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = targetButton.name;
                hidden.value = targetButton.value;
                targetForm.appendChild(hidden);
            }

            modal.hide();
            targetForm.submit();
        });

        modalEl.addEventListener('hidden.bs.modal', function () {
            targetForm = null;
            targetButton = null;
        });
    })();
</script>
