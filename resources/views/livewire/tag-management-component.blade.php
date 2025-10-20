<div>
    <!-- Search and Filter Controls -->
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="mdi mdi-magnify"></i>
                </span>
                <input type="text" class="form-control" wire:model.live="search" placeholder="جستجو در تگ‌ها...">
            </div>
        </div>
        <div class="col-md-4">
            <select class="form-select" wire:model.live="categoryFilter">
                <option value="">همه دسته‌بندی‌ها</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100" wire:click="openCreateModal">
                <i class="mdi mdi-plus"></i> تگ جدید
            </button>
        </div>
    </div>

    <!-- Selection Controls -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge bg-info">{{ count($selectedTags) }} تگ انتخاب شده</span>
                </div>
                <div>
                    <button class="btn btn-sm btn-outline-primary me-2" wire:click="selectAll">
                        انتخاب همه
                    </button>
                    <button class="btn btn-sm btn-outline-secondary" wire:click="deselectAll">
                        لغو انتخاب همه
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tags Grid -->
    <div class="row">
        @foreach($tags as $tag)
            <div class="col-md-3 col-lg-2 mb-3">
                <div class="card tag-card {{ in_array($tag->id, $selectedTags) ? 'selected' : '' }}"
                     wire:click="toggleTag({{ $tag->id }})"
                     style="cursor: pointer; transition: all 0.2s;">
                    <div class="card-body text-center p-2">
                        <div class="mb-2">
                            <span class="badge" style="background-color: {{ $tag->color }}; color: white; font-size: 12px; padding: 4px 8px;">
                                {{ $tag->name }}
                            </span>
                        </div>
                        <small class="text-muted d-block">{{ $tag->category->name ?? 'بدون دسته' }}</small>
                        <div class="mt-2">
                            <button class="btn btn-sm btn-outline-primary"
                                    wire:click.stop="openEditModal({{ $tag->id }})"
                                    title="ویرایش">
                                <i class="mdi mdi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger"
                                    wire:click.stop="deleteTag({{ $tag->id }})"
                                    onclick="return confirm('آیا مطمئن هستید؟')"
                                    title="حذف">
                                <i class="mdi mdi-delete"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $tags->links() }}
    </div>

    <!-- Create/Edit Modal -->
    @if($showModal)
        <div class="modal-backdrop show" wire:click="closeModal">
            <div class="modal-dialog modal-lg" wire:click.stop>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="mdi mdi-tag me-2"></i>
                            {{ $editingTag ? 'ویرایش تگ' : 'ایجاد تگ جدید' }}
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="saveTag">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">نام تگ <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('tagName') is-invalid @enderror"
                                               wire:model="tagName" required>
                                        @error('tagName')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">رنگ <span class="text-danger">*</span></label>
                                        <input type="color" class="form-control form-control-color"
                                               wire:model="tagColor" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">دسته‌بندی <span class="text-danger">*</span></label>
                                <select class="form-select @error('tagCategoryId') is-invalid @enderror"
                                        wire:model="tagCategoryId" required>
                                    <option value="">انتخاب دسته‌بندی</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('tagCategoryId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">توضیحات</label>
                                <textarea class="form-control" wire:model="tagDescription" rows="3"></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">پسوندهای مجاز</label>
                                        <input type="text" class="form-control"
                                               wire:model="allowedExtensions"
                                               placeholder="مثال: pdf, doc, docx">
                                        <small class="form-text text-muted">با کاما جدا کنید</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">MIME Types مجاز</label>
                                        <input type="text" class="form-control"
                                               wire:model="allowedMimeTypes"
                                               placeholder="مثال: application/pdf, image/jpeg">
                                        <small class="form-text text-muted">با کاما جدا کنید</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" wire:model="isFolderTag">
                                        <label class="form-check-label">تگ پوشه</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" wire:model="isActive">
                                        <label class="form-check-label">فعال</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">
                            <i class="mdi mdi-close"></i> انصراف
                        </button>
                        <button type="button" class="btn btn-primary" wire:click="saveTag">
                            <i class="mdi mdi-check"></i> {{ $editingTag ? 'به‌روزرسانی' : 'ایجاد' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Hidden inputs for selected tags -->
    @foreach($selectedTags as $tagId)
        <input type="hidden" name="required_tags[]" value="{{ $tagId }}">
    @endforeach

    <style>
    .tag-card {
        border: 2px solid transparent;
        transition: all 0.2s ease;
    }

    .tag-card:hover {
        border-color: #007bff;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .tag-card.selected {
        border-color: #28a745;
        background-color: #f8f9fa;
    }

    .modal-backdrop {
        background-color: rgba(0,0,0,0.5);
    }

    .badge {
        font-weight: 500;
    }
    </style>
</div>
