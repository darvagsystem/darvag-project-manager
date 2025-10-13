{{-- Dynamic Modal Component --}}
<div id="dynamicModal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" :class="modalSize">
        <div class="modal-content">
            <div class="modal-header" :class="headerClass">
                <h5 class="modal-title" v-if="modalTitle || title">
                    <i :class="modalIcon || titleIcon" v-if="modalIcon || titleIcon"></i>
                    @{{ modalTitle || title }}
                </h5>
                <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div v-if="type === 'form'">
                    <form @submit.prevent="submitForm" :id="formId">
                        <div v-for="field in formFields" :key="field.name" class="mb-3">
                            <label :for="field.name" class="form-label" v-if="field.label">
                                @{{ field.label }}
                                <span class="text-danger" v-if="field.required">*</span>
                            </label>

                            <!-- Text Input -->
                            <input v-if="field.type === 'text' || field.type === 'email' || field.type === 'password'"
                                   :type="field.type"
                                   :id="field.name"
                                   :name="field.name"
                                   :class="['form-control', field.error ? 'is-invalid' : '']"
                                   :placeholder="field.placeholder"
                                   :required="field.required"
                                   v-model="formData[field.name]">

                            <!-- Textarea -->
                            <textarea v-else-if="field.type === 'textarea'"
                                      :id="field.name"
                                      :name="field.name"
                                      :class="['form-control', field.error ? 'is-invalid' : '']"
                                      :placeholder="field.placeholder"
                                      :required="field.required"
                                      :rows="field.rows || 3"
                                      v-model="formData[field.name]"></textarea>

                            <!-- Select -->
                            <select v-else-if="field.type === 'select'"
                                    :id="field.name"
                                    :name="field.name"
                                    :class="['form-select', field.error ? 'is-invalid' : '']"
                                    :required="field.required"
                                    v-model="formData[field.name]">
                                <option value="">@{{ field.placeholder || 'انتخاب کنید' }}</option>
                                <option v-for="option in field.options" :key="option.value" :value="option.value">
                                    @{{ option.label }}
                                </option>
                            </select>

                            <!-- Checkbox -->
                            <div v-else-if="field.type === 'checkbox'" class="form-check">
                                <input :id="field.name"
                                       :name="field.name"
                                       type="checkbox"
                                       :class="['form-check-input', field.error ? 'is-invalid' : '']"
                                       v-model="formData[field.name]">
                                <label :for="field.name" class="form-check-label">
                                    @{{ field.label }}
                                </label>
                            </div>

                            <!-- Radio Group -->
                            <div v-else-if="field.type === 'radio'" class="form-check-group">
                                <div v-for="option in field.options" :key="option.value" class="form-check">
                                    <input :id="field.name + '_' + option.value"
                                           :name="field.name"
                                           type="radio"
                                           :value="option.value"
                                           :class="['form-check-input', field.error ? 'is-invalid' : '']"
                                           v-model="formData[field.name]">
                                    <label :for="field.name + '_' + option.value" class="form-check-label">
                                        @{{ option.label }}
                                    </label>
                                </div>
                            </div>

                            <!-- Error Message -->
                            <div v-if="field.error" class="invalid-feedback">
                                @{{ field.error }}
                            </div>

                            <!-- Help Text -->
                            <small v-if="field.help" class="form-text text-muted">
                                @{{ field.help }}
                            </small>
                        </div>
                    </form>
                </div>

                <div v-else-if="modalType === 'message' || type === 'message'">
                    <div class="text-center">
                        <i :class="modalIcon || messageIcon" :style="{ fontSize: '3rem', color: modalColor || messageColor }"></i>
                        <p class="mt-3 mb-0" v-html="modalMessage || message"></p>
                    </div>
                </div>

                <div v-else-if="modalType === 'confirm' || type === 'confirm'">
                    <div class="text-center">
                        <i :class="modalIcon || messageIcon" :style="{ fontSize: '3rem', color: modalColor || messageColor }"></i>
                        <p class="mt-3 mb-0" v-html="modalMessage || message"></p>
                    </div>
                </div>

                <div v-else-if="modalType === 'loading' || type === 'loading'">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">در حال بارگذاری...</span>
                        </div>
                        <p class="mt-3 mb-0">@{{ modalMessage || message || 'در حال بارگذاری...' }}</p>
                    </div>
                </div>
            </div>

            <div class="modal-footer" v-if="showFooter && (modalType === 'confirm' || type === 'confirm')">
                <button type="button" class="btn btn-secondary" @click="closeModal" v-if="showCancel">
                    <i class="mdi mdi-close me-1"></i>
                    @{{ cancelText }}
                </button>
                <button type="button"
                        :class="['btn', confirmButtonClass]"
                        @click="confirmAction"
                        :disabled="loading">
                    <i :class="confirmButtonIcon" v-if="confirmButtonIcon"></i>
                    <span v-if="loading">در حال پردازش...</span>
                    <span v-else>@{{ confirmText }}</span>
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.modal {
    z-index: 1055;
}

.modal-backdrop {
    z-index: 1050;
}

.form-check-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-check-group .form-check {
    margin-bottom: 0;
}

.modal-header {
    border-bottom: 1px solid #dee2e6;
}

.modal-footer {
    border-top: 1px solid #dee2e6;
}

.btn-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    font-weight: bold;
    color: #6c757d;
    cursor: pointer;
}

.btn-close:hover {
    color: #000;
}

.spinner-border {
    width: 3rem;
    height: 3rem;
}

/* Animation for modal */
.modal.fade .modal-dialog {
    transition: transform 0.3s ease-out;
    transform: translate(0, -50px);
}

.modal.show .modal-dialog {
    transform: none;
}

/* Custom modal sizes */
.modal-sm .modal-dialog {
    max-width: 300px;
}

.modal-lg .modal-dialog {
    max-width: 800px;
}

.modal-xl .modal-dialog {
    max-width: 1140px;
}
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script>
// Global Modal Manager
window.ModalManager = {
    instance: null,

    init() {
        if (!this.instance) {
            const { createApp } = Vue;
            this.instance = createApp({
                data() {
                    return {
                        show: false,
                        type: 'message',
                        title: '',
                        titleIcon: '',
                        message: '',
                        messageIcon: 'mdi mdi-information',
                        messageColor: '#6c757d',
                        size: 'modal-md',
                        showFooter: true,
                        showCancel: true,
                        cancelText: 'انصراف',
                        confirmText: 'تأیید',
                        confirmButtonClass: 'btn-primary',
                        confirmButtonIcon: '',
                        loading: false,
                        formId: 'dynamicForm',
                        formFields: [],
                        formData: {},
                        onConfirm: null,
                        onCancel: null,
                        onFormSubmit: null,
                        // Add missing properties
                        modalType: 'message',
                        modalTitle: '',
                        modalMessage: '',
                        modalIcon: 'mdi mdi-information',
                        modalColor: '#6c757d',
                        modalSize: 'modal-md'
                    }
                },

                computed: {
                    modalSize() {
                        return `modal-${this.size}`;
                    },

                    headerClass() {
                        const classes = {
                            'message': 'bg-info text-white',
                            'confirm': 'bg-warning text-dark',
                            'success': 'bg-success text-white',
                            'error': 'bg-danger text-white',
                            'warning': 'bg-warning text-dark',
                            'form': 'bg-primary text-white',
                            'loading': 'bg-secondary text-white'
                        };
                        return classes[this.type] || 'bg-light text-dark';
                    }
                },

                methods: {
                    showModal(config) {
                        // Reset form data
                        this.formData = {};

                        // Set configuration
                        Object.assign(this, {
                            show: true,
                            loading: false,
                            ...config
                        });

                        // Initialize form data
                        if (this.type === 'form' && this.formFields) {
                            this.formFields.forEach(field => {
                                this.formData[field.name] = field.value || '';
                            });
                        }

                        // Show modal
                        this.$nextTick(() => {
                            const modal = document.getElementById('dynamicModal');
                            const bsModal = new bootstrap.Modal(modal);
                            bsModal.show();
                        });
                    },

                    closeModal() {
                        this.show = false;
                        const modal = document.getElementById('dynamicModal');
                        const bsModal = bootstrap.Modal.getInstance(modal);
                        if (bsModal) {
                            bsModal.hide();
                        }

                        if (this.onCancel) {
                            this.onCancel();
                        }
                    },

                    confirmAction() {
                        if (this.type === 'form' || this.modalType === 'form') {
                            this.submitForm();
                        } else {
                            if (this.onConfirm) {
                                this.onConfirm();
                            } else {
                                this.closeModal();
                            }
                        }
                    },

                    submitForm() {
                        if (this.onFormSubmit) {
                            this.loading = true;
                            this.onFormSubmit(this.formData, (success, errors) => {
                                this.loading = false;
                                if (success) {
                                    this.closeModal();
                                } else {
                                    // Show validation errors
                                    this.formFields.forEach(field => {
                                        field.error = errors[field.name] || null;
                                    });
                                }
                            });
                        }
                    }
                }
            });

            this.instance.mount('#dynamicModal');
        }
    },

    // Show message modal
    message(config) {
        this.init();

        // Set up the modal data
        this.instance.modalType = 'message';
        this.instance.modalTitle = config.title || 'پیام';
        this.instance.modalMessage = config.message;
        this.instance.modalIcon = config.icon || 'mdi mdi-information';
        this.instance.modalColor = config.color || '#6c757d';
        this.instance.modalSize = config.size || 'modal-md';
        this.instance.showFooter = false;

        // Show modal after a short delay to ensure Vue updates
        setTimeout(() => {
            this.showModal();
        }, 10);
    },

    // Show confirmation modal
    confirm(config) {
        this.init();
        return new Promise((resolve) => {
            // Set up the modal data
            this.instance.modalType = 'confirm';
            this.instance.modalTitle = config.title || 'تأیید';
            this.instance.modalMessage = config.message;
            this.instance.modalIcon = config.icon || 'mdi mdi-help-circle';
            this.instance.modalColor = config.color || '#ffc107';
            this.instance.modalSize = config.size || 'modal-md';
            this.instance.confirmText = config.confirmText || 'تأیید';
            this.instance.cancelText = config.cancelText || 'انصراف';
            this.instance.confirmButtonClass = config.confirmButtonClass || 'btn-warning';

            // Set up callbacks
            this.instance.onConfirm = () => {
                this.hide();
                resolve(true);
            };
            this.instance.onCancel = () => {
                this.hide();
                resolve(false);
            };

            // Show modal after a short delay to ensure Vue updates
            setTimeout(() => {
                this.showModal();
            }, 10);
        });
    },

    // Show form modal
    form(config) {
        this.init();
        return new Promise((resolve) => {
            this.instance.showModal({
                type: 'form',
                title: config.title || 'فرم',
                formFields: config.fields || [],
                size: config.size || 'modal-lg',
                confirmText: config.confirmText || 'ذخیره',
                cancelText: config.cancelText || 'انصراف',
                onFormSubmit: (formData, callback) => {
                    if (config.onSubmit) {
                        config.onSubmit(formData, callback);
                    }
                },
                onCancel: () => resolve(null),
                ...config
            });
        });
    },

    // Show loading modal
    loading(config) {
        this.init();

        // Set up the modal data
        this.instance.modalType = 'loading';
        this.instance.modalTitle = config.title || 'در حال پردازش';
        this.instance.modalMessage = config.message || 'لطفاً صبر کنید...';
        this.instance.modalSize = config.size || 'modal-sm';
        this.instance.showFooter = false;

        // Show modal after a short delay to ensure Vue updates
        setTimeout(() => {
            this.showModal();
        }, 10);
    },

    // Show modal
    showModal() {
        if (this.instance) {
            // Show Bootstrap modal
            const modalElement = document.getElementById('dynamicModal');
            if (modalElement) {
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            }
        }
    },

    // Hide modal
    hide() {
        const modalElement = document.getElementById('dynamicModal');
        if (modalElement) {
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
            }
        }
    }
};

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    ModalManager.init();
});
</script>
@endpush
