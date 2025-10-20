@if($showRenameModal)
<div class="modal-backdrop" wire:click="$set('showRenameModal', false)">
    <div class="modal-container" wire:click.stop>
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="mdi mdi-pencil me-2"></i>تغییر نام
                </h5>
                <button type="button" class="btn-close" wire:click="$set('showRenameModal', false)"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">نام جدید <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('newName') is-invalid @enderror"
                           wire:model="newName" placeholder="نام جدید را وارد کنید...">
                    @error('newName')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="alert alert-warning">
                    <i class="mdi mdi-alert me-2"></i>
                    توجه: تغییر نام ممکن است بر روی لینک‌ها و مراجع تأثیر بگذارد.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="$set('showRenameModal', false)">
                    <i class="mdi mdi-close me-1"></i>انصراف
                </button>
                <button type="button" class="btn btn-primary" wire:click="confirmRename"
                        @if(empty($newName)) disabled @endif>
                    <i class="mdi mdi-check me-1"></i>تأیید تغییر نام
                </button>
            </div>
        </div>
    </div>
@endif
