{{-- Simple Modal Component --}}
<div class="modal fade" id="simpleModal" tabindex="-1" aria-labelledby="simpleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" id="modalHeader">
                <h5 class="modal-title" id="modalTitle">
                    <i id="modalIcon" class="me-2"></i>
                    <span id="modalTitleText">پیام</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">
                <div class="text-center">
                    <i id="modalBodyIcon" style="font-size: 3rem;"></i>
                    <p id="modalMessage" class="mt-3 mb-0"></p>
                </div>
            </div>
            <div class="modal-footer" id="modalFooter" style="display: none;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelBtn">انصراف</button>
                <button type="button" class="btn" id="confirmBtn">تأیید</button>
            </div>
        </div>
    </div>
</div>

<script>
// Simple Modal Manager
window.SimpleModal = {
    modal: null,

    init() {
        this.modal = new bootstrap.Modal(document.getElementById('simpleModal'));
    },

    message(config) {
        this.init();

        // Set header
        const header = document.getElementById('modalHeader');
        const titleText = document.getElementById('modalTitleText');
        const icon = document.getElementById('modalIcon');

        header.className = 'modal-header bg-info text-white';
        titleText.textContent = config.title || 'پیام';
        icon.className = config.icon || 'mdi mdi-information';

        // Set body
        const bodyIcon = document.getElementById('modalBodyIcon');
        const message = document.getElementById('modalMessage');

        bodyIcon.className = config.icon || 'mdi mdi-information';
        bodyIcon.style.color = config.color || '#6c757d';
        message.innerHTML = config.message || '';

        // Hide footer
        document.getElementById('modalFooter').style.display = 'none';

        // Show modal
        this.modal.show();
    },

    confirm(config) {
        this.init();

        // Set header
        const header = document.getElementById('modalHeader');
        const titleText = document.getElementById('modalTitleText');
        const icon = document.getElementById('modalIcon');

        header.className = 'modal-header bg-warning text-dark';
        titleText.textContent = config.title || 'تأیید';
        icon.className = config.icon || 'mdi mdi-help-circle';

        // Set body
        const bodyIcon = document.getElementById('modalBodyIcon');
        const message = document.getElementById('modalMessage');

        bodyIcon.className = config.icon || 'mdi mdi-help-circle';
        bodyIcon.style.color = config.color || '#ffc107';
        message.innerHTML = config.message || '';

        // Show footer
        const footer = document.getElementById('modalFooter');
        const cancelBtn = document.getElementById('cancelBtn');
        const confirmBtn = document.getElementById('confirmBtn');

        footer.style.display = 'block';
        cancelBtn.textContent = config.cancelText || 'انصراف';
        confirmBtn.textContent = config.confirmText || 'تأیید';
        confirmBtn.className = `btn ${config.confirmButtonClass || 'btn-warning'}`;

        // Set up callbacks
        confirmBtn.onclick = () => {
            this.modal.hide();
            if (config.onConfirm) {
                config.onConfirm();
            }
        };

        cancelBtn.onclick = () => {
            this.modal.hide();
            if (config.onCancel) {
                config.onCancel();
            }
        };

        // Show modal
        this.modal.show();

        // Return promise
        return new Promise((resolve) => {
            const originalConfirm = confirmBtn.onclick;
            const originalCancel = cancelBtn.onclick;

            confirmBtn.onclick = () => {
                this.modal.hide();
                resolve(true);
            };

            cancelBtn.onclick = () => {
                this.modal.hide();
                resolve(false);
            };
        });
    },

    loading(config) {
        this.init();

        // Set header
        const header = document.getElementById('modalHeader');
        const titleText = document.getElementById('modalTitleText');
        const icon = document.getElementById('modalIcon');

        header.className = 'modal-header bg-secondary text-white';
        titleText.textContent = config.title || 'در حال پردازش';
        icon.className = 'mdi mdi-loading mdi-spin';

        // Set body
        const bodyIcon = document.getElementById('modalBodyIcon');
        const message = document.getElementById('modalMessage');

        bodyIcon.className = 'mdi mdi-loading mdi-spin';
        bodyIcon.style.color = '#6c757d';
        message.innerHTML = config.message || 'لطفاً صبر کنید...';

        // Hide footer
        document.getElementById('modalFooter').style.display = 'none';

        // Show modal
        this.modal.show();
    },

    hide() {
        if (this.modal) {
            this.modal.hide();
        }
    }
};

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    SimpleModal.init();
});
</script>
