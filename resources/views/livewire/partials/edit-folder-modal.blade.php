@if($showEditFolderModal && $editFolder)
<div class="modal-backdrop" wire:click="$set('showEditFolderModal', false)">
    <div class="modal-container" wire:click.stop>
        <div class="modal-header">
            <h5 class="modal-title">
                <i class="mdi mdi-folder-edit me-2"></i>ویرایش پوشه
            </h5>
            <button type="button" class="btn-close" wire:click="$set('showEditFolderModal', false)">
                <i class="mdi mdi-close"></i>
            </button>
        </div>

        <div class="modal-body">
            <form wire:submit.prevent="updateFolder">
                <div class="mb-3">
                    <label for="editFolderName" class="form-label">نام پوشه</label>
                    <input type="text" class="form-control" id="editFolderName" wire:model="editFolderName" required>
                    @error('editFolderName') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label for="editFolderDescription" class="form-label">توضیحات (اختیاری)</label>
                    <textarea class="form-control" id="editFolderDescription" wire:model="editFolderDescription" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label for="editFolderColor" class="form-label">رنگ پوشه</label>
                    <div class="color-picker">
                        <input type="color" class="form-control color-input" id="editFolderColor" wire:model.live="editFolderColor">
                        <div class="color-presets">
                            <div class="color-preset" style="background-color: #ff9800;" data-color="#ff9800" title="نارنجی"></div>
                            <div class="color-preset" style="background-color: #2196f3;" data-color="#2196f3" title="آبی"></div>
                            <div class="color-preset" style="background-color: #4caf50;" data-color="#4caf50" title="سبز"></div>
                            <div class="color-preset" style="background-color: #f44336;" data-color="#f44336" title="قرمز"></div>
                            <div class="color-preset" style="background-color: #9c27b0;" data-color="#9c27b0" title="بنفش"></div>
                            <div class="color-preset" style="background-color: #ffc107;" data-color="#ffc107" title="زرد"></div>
                            <div class="color-preset" style="background-color: #795548;" data-color="#795548" title="قهوه‌ای"></div>
                            <div class="color-preset" style="background-color: #607d8b;" data-color="#607d8b" title="آبی خاکستری"></div>
                        </div>
                    </div>
                    @error('editFolderColor') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </form>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" wire:click="$set('showEditFolderModal', false)">
                انصراف
            </button>
            <button type="button" class="btn btn-primary" wire:click="updateFolder">
                <i class="mdi mdi-content-save me-1"></i>ذخیره تغییرات
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Color preset functionality for edit folder modal
    const editColorPresets = document.querySelectorAll('#editFolderColor').length > 0 ?
        document.querySelectorAll('#editFolderColor ~ .color-presets .color-preset') : [];

    editColorPresets.forEach(preset => {
        preset.addEventListener('click', function() {
            const color = this.getAttribute('data-color');
            const colorInput = document.getElementById('editFolderColor');
            if (colorInput) {
                colorInput.value = color;
                colorInput.dispatchEvent(new Event('input', { bubbles: true }));
            }
        });
    });
});
</script>
@endif

<style>
.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-container {
    background: white;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    max-width: 400px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #e0e0e0;
}

.modal-title {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.btn-close {
    background: none;
    border: none;
    font-size: 20px;
    color: #666;
    cursor: pointer;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-close:hover {
    color: #333;
}

.modal-body {
    padding: 20px;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 20px;
    border-top: 1px solid #e0e0e0;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #333;
}

.form-control {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    transition: border-color 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: #1976d2;
    box-shadow: 0 0 0 2px rgba(25, 118, 210, 0.2);
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}

.btn-primary {
    background: #1976d2;
    color: white;
}

.btn-primary:hover {
    background: #1565c0;
}

.text-danger {
    color: #dc3545;
    font-size: 12px;
}

.color-picker {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.color-input {
    width: 100%;
    height: 40px;
    border: 1px solid #ddd;
    border-radius: 6px;
    cursor: pointer;
}

.color-presets {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.color-preset {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.2s;
}

.color-preset:hover {
    transform: scale(1.1);
    border-color: #333;
}

.color-preset.selected {
    border-color: #1976d2;
    box-shadow: 0 0 0 2px rgba(25, 118, 210, 0.2);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Color preset selection for edit modal
    const editColorPresets = document.querySelectorAll('#editFolderModal .color-preset');
    const editColorInput = document.getElementById('editFolderColor');

    if (editColorPresets.length > 0 && editColorInput) {
        editColorPresets.forEach(preset => {
            preset.addEventListener('click', function() {
                const color = this.getAttribute('data-color');
                editColorInput.value = color;
                editColorInput.dispatchEvent(new Event('input'));

                // Update visual selection
                editColorPresets.forEach(p => p.classList.remove('selected'));
                this.classList.add('selected');
            });
        });

        // Update preset selection when color input changes
        editColorInput.addEventListener('input', function() {
            const selectedColor = this.value;
            editColorPresets.forEach(preset => {
                if (preset.getAttribute('data-color') === selectedColor) {
                    editColorPresets.forEach(p => p.classList.remove('selected'));
                    preset.classList.add('selected');
                }
            });
        });

        // Initialize selection
        const initialColor = editColorInput.value;
        editColorPresets.forEach(preset => {
            if (preset.getAttribute('data-color') === initialColor) {
                preset.classList.add('selected');
            }
        });
    }
});
</script>
