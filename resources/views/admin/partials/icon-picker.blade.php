{{-- Icon Picker Component --}}
<div class="form-group mb-3">
    <label for="{{ $inputId ?? 'icon' }}" class="form-label">{{ $label ?? 'آیکون' }}</label>
    <div class="input-group">
        <input type="text"
               class="form-control @error($inputName ?? 'icon') is-invalid @enderror"
               id="{{ $inputId ?? 'icon' }}"
               name="{{ $inputName ?? 'icon' }}"
               value="{{ $value ?? old($inputName ?? 'icon', 'mdi mdi-folder') }}"
               placeholder="mdi mdi-folder"
               readonly>
        <button type="button" class="btn btn-outline-secondary" onclick="openIconPicker('{{ $inputId ?? 'icon' }}')">
            <i class="mdi mdi-palette"></i>
            انتخاب آیکون
        </button>
    </div>
    @error($inputName ?? 'icon')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <small class="form-text text-muted">برای انتخاب آیکون روی دکمه کلیک کنید</small>

    <!-- Icon Preview -->
    <div class="mt-2">
        <div class="icon-preview" id="{{ $inputId ?? 'icon' }}Preview" style="display: none;">
            <div class="preview-icon" id="{{ $inputId ?? 'icon' }}PreviewIcon"></div>
            <span class="preview-text" id="{{ $inputId ?? 'icon' }}PreviewText"></span>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Icon Picker Styles */
.icon-preview {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem;
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    margin-top: 0.5rem;
}

.preview-icon {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #3b82f6;
    color: white;
    border-radius: 4px;
    font-size: 14px;
}

.preview-text {
    font-size: 0.875rem;
    color: #6b7280;
}

/* Icon Picker Modal */
.icon-picker-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1050;
    display: none;
}

.icon-picker-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    border-radius: 12px;
    width: 90%;
    max-width: 600px;
    max-height: 80vh;
    overflow: hidden;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.icon-picker-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    background: #f9fafb;
}

.icon-picker-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #111827;
    margin: 0;
}

.icon-picker-body {
    padding: 1.5rem;
    max-height: 400px;
    overflow-y: auto;
}

.icon-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    gap: 0.5rem;
}

.icon-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0.75rem 0.5rem;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    background: white;
}

.icon-item:hover {
    background: #f3f4f6;
    border-color: #3b82f6;
    transform: translateY(-1px);
}

.icon-item.selected {
    background: #dbeafe;
    border-color: #3b82f6;
}

.icon-item i {
    font-size: 1.5rem;
    color: #6b7280;
    margin-bottom: 0.25rem;
}

.icon-item.selected i {
    color: #3b82f6;
}

.icon-name {
    font-size: 0.75rem;
    color: #6b7280;
    text-align: center;
    word-break: break-all;
}

.icon-picker-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #e5e7eb;
    background: #f9fafb;
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
}

.search-input {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    margin-bottom: 1rem;
    font-size: 0.875rem;
}

.search-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
</style>
@endpush

@push('scripts')
<script>
// Global icon picker functions
window.openIconPicker = function(inputId) {
    const icons = [
        'mdi-folder', 'mdi-folder-open', 'mdi-folder-multiple', 'mdi-folder-account',
        'mdi-file-document', 'mdi-file-document-multiple', 'mdi-file-pdf-box',
        'mdi-file-word-box', 'mdi-file-excel-box', 'mdi-file-powerpoint-box',
        'mdi-account-group', 'mdi-briefcase', 'mdi-chart-line', 'mdi-cog',
        'mdi-home', 'mdi-school', 'mdi-hospital', 'mdi-bank', 'mdi-car',
        'mdi-phone', 'mdi-email', 'mdi-calendar', 'mdi-clock', 'mdi-star',
        'mdi-oil', 'mdi-construction', 'mdi-office-building', 'mdi-shield-check',
        'mdi-account', 'mdi-account-multiple', 'mdi-account-supervisor', 'mdi-account-tie',
        'mdi-briefcase-account', 'mdi-briefcase-outline', 'mdi-briefcase-variant',
        'mdi-chart-bar', 'mdi-chart-pie', 'mdi-chart-arc', 'mdi-chart-box',
        'mdi-cog-outline', 'mdi-cog-box', 'mdi-settings', 'mdi-settings-outline',
        'mdi-home-outline', 'mdi-home-variant', 'mdi-home-group',
        'mdi-school-outline', 'mdi-school-variant', 'mdi-graduation-cap',
        'mdi-hospital-box', 'mdi-hospital-building', 'mdi-medical-bag',
        'mdi-bank-outline', 'mdi-bank-transfer', 'mdi-credit-card',
        'mdi-car-outline', 'mdi-car-sports', 'mdi-truck', 'mdi-bus',
        'mdi-phone-outline', 'mdi-phone-in-talk', 'mdi-phone-message',
        'mdi-email-outline', 'mdi-email-multiple', 'mdi-email-open',
        'mdi-calendar-outline', 'mdi-calendar-multiple', 'mdi-calendar-check',
        'mdi-clock-outline', 'mdi-clock-in', 'mdi-clock-out', 'mdi-timer',
        'mdi-star-outline', 'mdi-star-half', 'mdi-star-circle',
        'mdi-oil-level', 'mdi-oil-temperature', 'mdi-gas-station',
        'mdi-construction', 'mdi-hard-hat', 'mdi-toolbox', 'mdi-wrench',
        'mdi-office-building', 'mdi-office-building-outline', 'mdi-city',
        'mdi-shield-check', 'mdi-shield-outline', 'mdi-shield-account',
        'mdi-database', 'mdi-database-outline', 'mdi-server', 'mdi-cloud',
        'mdi-cloud-outline', 'mdi-cloud-upload', 'mdi-cloud-download',
        'mdi-lock', 'mdi-lock-outline', 'mdi-lock-open', 'mdi-key',
        'mdi-eye', 'mdi-eye-outline', 'mdi-eye-off', 'mdi-eye-off-outline',
        'mdi-pencil', 'mdi-pencil-outline', 'mdi-pencil-box', 'mdi-edit',
        'mdi-delete', 'mdi-delete-outline', 'mdi-delete-forever',
        'mdi-plus', 'mdi-plus-outline', 'mdi-plus-circle', 'mdi-plus-box',
        'mdi-minus', 'mdi-minus-outline', 'mdi-minus-circle', 'mdi-minus-box',
        'mdi-check', 'mdi-check-outline', 'mdi-check-circle', 'mdi-check-box',
        'mdi-close', 'mdi-close-outline', 'mdi-close-circle', 'mdi-close-box',
        'mdi-arrow-left', 'mdi-arrow-right', 'mdi-arrow-up', 'mdi-arrow-down',
        'mdi-chevron-left', 'mdi-chevron-right', 'mdi-chevron-up', 'mdi-chevron-down',
        'mdi-menu', 'mdi-menu-open', 'mdi-menu-down', 'mdi-menu-up',
        'mdi-dots-horizontal', 'mdi-dots-vertical', 'mdi-dots-grid',
        'mdi-magnify', 'mdi-magnify-plus', 'mdi-magnify-minus',
        'mdi-filter', 'mdi-filter-outline', 'mdi-filter-remove',
        'mdi-sort', 'mdi-sort-ascending', 'mdi-sort-descending',
        'mdi-refresh', 'mdi-reload', 'mdi-sync', 'mdi-sync-off',
        'mdi-download', 'mdi-download-outline', 'mdi-upload', 'mdi-upload-outline',
        'mdi-share', 'mdi-share-outline', 'mdi-share-variant',
        'mdi-link', 'mdi-link-off', 'mdi-link-variant', 'mdi-link-variant-off',
        'mdi-copy', 'mdi-content-copy', 'mdi-content-cut', 'mdi-content-paste',
        'mdi-undo', 'mdi-redo', 'mdi-undo-variant', 'mdi-redo-variant',
        'mdi-save', 'mdi-save-outline', 'mdi-content-save', 'mdi-content-save-outline',
        'mdi-open-in-new', 'mdi-open-in-app', 'mdi-exit-to-app',
        'mdi-fullscreen', 'mdi-fullscreen-exit', 'mdi-fullscreen-exit-outline',
        'mdi-maximize', 'mdi-minimize', 'mdi-resize', 'mdi-fit-to-screen',
        'mdi-view-grid', 'mdi-view-list', 'mdi-view-module', 'mdi-view-dashboard',
        'mdi-table', 'mdi-table-large', 'mdi-table-edit', 'mdi-table-plus',
        'mdi-chart-gantt', 'mdi-chart-timeline', 'mdi-chart-scatter-plot',
        'mdi-chart-histogram', 'mdi-chart-line-variant', 'mdi-chart-areaspline',
        'mdi-chart-bubble', 'mdi-chart-donut', 'mdi-chart-donut-variant',
        'mdi-chart-waterfall', 'mdi-chart-box-plus', 'mdi-chart-box-outline',
        'mdi-chart-multiline', 'mdi-chart-multiple', 'mdi-chart-sankey',
        'mdi-chart-sankey-variant', 'mdi-chart-scatter-plot-hexbin',
        'mdi-chart-timeline-variant', 'mdi-chart-timeline-variant-shimmer',
        'mdi-chart-tree', 'mdi-chart-treemap', 'mdi-chart-variant',
        'mdi-chart-variant-outline', 'mdi-chart-waffle', 'mdi-chart-waffle-outline'
    ];

    // Create modal
    const modal = document.createElement('div');
    modal.className = 'icon-picker-modal';
    modal.innerHTML = `
        <div class="icon-picker-content">
            <div class="icon-picker-header">
                <h3 class="icon-picker-title">انتخاب آیکون</h3>
            </div>
            <div class="icon-picker-body">
                <input type="text" class="search-input" placeholder="جستجو در آیکون‌ها..." id="iconSearch">
                <div class="icon-grid" id="iconGrid">
                    ${icons.map(icon => `
                        <div class="icon-item" data-icon="mdi ${icon}">
                            <i class="mdi ${icon}"></i>
                            <span class="icon-name">${icon}</span>
                        </div>
                    `).join('')}
                </div>
            </div>
            <div class="icon-picker-footer">
                <button type="button" class="btn btn-secondary" onclick="closeIconPicker()">انصراف</button>
                <button type="button" class="btn btn-primary" onclick="selectIcon('${inputId}')">انتخاب</button>
            </div>
        </div>
    `;

    document.body.appendChild(modal);
    modal.style.display = 'block';

    // Search functionality
    const searchInput = document.getElementById('iconSearch');
    const iconGrid = document.getElementById('iconGrid');
    let selectedIcon = null;

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const iconItems = iconGrid.querySelectorAll('.icon-item');

        iconItems.forEach(item => {
            const iconName = item.querySelector('.icon-name').textContent.toLowerCase();
            if (iconName.includes(searchTerm)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Icon selection
    iconGrid.addEventListener('click', function(e) {
        const iconItem = e.target.closest('.icon-item');
        if (iconItem) {
            // Remove previous selection
            iconGrid.querySelectorAll('.icon-item').forEach(item => {
                item.classList.remove('selected');
            });

            // Select current item
            iconItem.classList.add('selected');
            selectedIcon = iconItem.dataset.icon;
        }
    });

    // Store selected icon globally
    window.selectedIcon = selectedIcon;
};

window.closeIconPicker = function() {
    const modal = document.querySelector('.icon-picker-modal');
    if (modal) {
        modal.remove();
    }
};

window.selectIcon = function(inputId) {
    const modal = document.querySelector('.icon-picker-modal');
    const selectedItem = modal.querySelector('.icon-item.selected');

    if (selectedItem) {
        const iconValue = selectedItem.dataset.icon;
        document.getElementById(inputId).value = iconValue;
        updateIconPreview(inputId, iconValue);
    }

    closeIconPicker();
};

window.updateIconPreview = function(inputId, iconValue) {
    const preview = document.getElementById(inputId + 'Preview');
    const previewIcon = document.getElementById(inputId + 'PreviewIcon');
    const previewText = document.getElementById(inputId + 'PreviewText');

    if (preview && previewIcon && previewText) {
        if (iconValue) {
            preview.style.display = 'flex';
            previewIcon.innerHTML = `<i class="${iconValue}"></i>`;
            previewText.textContent = iconValue;
        } else {
            preview.style.display = 'none';
        }
    }
};

// Initialize preview on page load
document.addEventListener('DOMContentLoaded', function() {
    // Find all icon inputs and initialize their previews
    document.querySelectorAll('input[id$="icon"]').forEach(input => {
        if (input.value) {
            updateIconPreview(input.id, input.value);
        }
    });
});
</script>
@endpush
