<div>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Action Buttons -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex gap-2 align-items-center">
            @if($currentFolder)
                <button type="button" class="btn btn-outline-secondary btn-sm action-btn" wire:click="goBack">
                    <i class="mdi mdi-arrow-left me-1"></i> بازگشت
                </button>
            @endif
            <button type="button" class="btn btn-primary btn-sm action-btn" wire:click="openCreateFolderModal">
                <i class="mdi mdi-folder-plus me-1"></i> ایجاد پوشه
            </button>
            <button type="button" class="btn btn-success btn-sm action-btn" wire:click="openUploadModal">
                <i class="mdi mdi-cloud-upload me-1"></i> آپلود فایل
            </button>
            <button type="button" class="btn btn-info btn-sm action-btn" wire:click="refreshData">
                <i class="mdi mdi-refresh me-1"></i> به‌روزرسانی
            </button>

            <!-- Select All Checkbox -->
            @if(count($folders) > 0 || count($files) > 0)
                <div class="select-all-inline">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" wire:model="selectAll" wire:click="toggleSelectAll" id="selectAll">
                        <label class="form-check-label" for="selectAll">
                            انتخاب همه ({{ count($folders) + count($files) }})
                        </label>
                    </div>
                </div>
            @endif
        </div>

        <!-- Bulk Actions -->
        @if($showBulkActions)
            <div class="d-flex gap-2 align-items-center">
                <span class="text-muted small">{{ count($selectedItems) }} آیتم انتخاب شده</span>
                <button type="button" class="btn btn-warning btn-sm action-btn" wire:click="bulkDownload">
                    <i class="mdi mdi-download me-1"></i> دانلود ZIP
                </button>
                <button type="button" class="btn btn-danger btn-sm action-btn" wire:click="bulkDelete"
                        onclick="return confirm('آیا مطمئن هستید که می‌خواهید آیتم‌های انتخاب شده را حذف کنید؟')">
                    <i class="mdi mdi-delete me-1"></i> حذف دسته‌ای
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm action-btn" wire:click="clearSelection">
                    <i class="mdi mdi-close me-1"></i> لغو انتخاب
                </button>
            </div>
        @endif

        <div class="d-flex align-items-center gap-2">
            <div class="input-group input-group-sm" style="width: 200px;">
                <span class="input-group-text">
                    <i class="mdi mdi-magnify"></i>
                </span>
                <input type="text" class="form-control" placeholder="جستجو فایل..." wire:model="searchQuery" wire:keyup="searchFiles">
            </div>

            <select class="form-select form-select-sm" style="width: auto;" wire:model="selectedTag" wire:change="filterByTag($event.target.value)">
                <option value="">همه تگ‌ها</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>

            @if($selectedTag)
                <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="clearFilter">
                    <i class="mdi mdi-close me-1"></i> حذف فیلتر
                </button>
            @endif
        </div>
    </div>

    <!-- Breadcrumb -->
    @if(count($breadcrumb) > 0)
        <div class="breadcrumb-nav mb-3">
            <a wire:click="goBack" style="cursor: pointer;">
                <i class="mdi mdi-home"></i> ریشه
            </a>
            @foreach($breadcrumb as $folder)
                <span class="separator">/</span>
                <a wire:click="enterFolder({{ $folder->id }})" style="cursor: pointer;">
                    {{ $folder->display_name }}
                </a>
            @endforeach
        </div>
    @endif

    <!-- Files Grid -->
    <div class="file-grid-container">
        @if(count($folders) > 0 || count($files) > 0)

            <div class="file-grid">
            <!-- Folders -->
            @foreach($folders as $folder)
                <div class="folder-item" wire:key="folder-{{ $folder->id }}"
                     style="cursor: pointer;">
                    <!-- Selection Checkbox -->
                    <div class="item-checkbox">
                        <input type="checkbox"
                               class="form-check-input"
                               wire:click.stop="toggleItemSelection({{ $folder->id }})"
                               @if(in_array($folder->id, $selectedItems)) checked @endif>
                    </div>

                    <!-- Folder Content -->
                    <div class="folder-content" wire:click="enterFolder({{ $folder->id }})">
                        <div class="folder-icon" style="color: {{ $folder->folder_color ?? '#ffc107' }}">
                            <i class="mdi mdi-folder"></i>
                        </div>
                        <div class="file-name" title="{{ $folder->display_name }}">
                            {{ $folder->display_name }}
                        </div>
                        @if($folder->hasDisplayName())
                            <div class="file-original-name" title="نام اصلی: {{ $folder->name }}">
                                {{ $folder->name }}
                            </div>
                        @endif
                        <div class="file-size">پوشه</div>
                        @if($folder->tags && $folder->tags->count() > 0)
                            <div class="file-tags">
                                @foreach($folder->tags as $tag)
                                    <span class="tag" style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}; border: 1px solid {{ $tag->color }}40;">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="file-actions">
                        <button type="button" class="btn btn-sm btn-outline-warning" wire:click.stop="openRenameModal({{ $folder->id }})" title="تغییر نام">
                            <i class="mdi mdi-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary" wire:click.stop="openTagModal({{ $folder->id }})" title="مدیریت تگ‌ها">
                            <i class="mdi mdi-tag-plus"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" wire:click="deleteItem({{ $folder->id }}, 'folder')" title="حذف پوشه">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </div>
                </div>
            @endforeach

            <!-- Files -->
            @foreach($files as $file)
                <div class="file-item" wire:key="file-{{ $file->id }}">
                    <!-- Selection Checkbox -->
                    <div class="item-checkbox">
                        <input type="checkbox"
                               class="form-check-input"
                               wire:click.stop="toggleItemSelection({{ $file->id }})"
                               @if(in_array($file->id, $selectedItems)) checked @endif>
                    </div>

                    <!-- File Content -->
                    <a href="{{ route('panel.file-manager.download', $file->id) }}" class="file-download-link" title="دانلود {{ $file->name }}">
                        <div class="file-icon">
                            <i class="mdi {{ $this->getFileIcon($file->mime_type) }}"></i>
                        </div>
                        <div class="file-name" title="{{ $file->display_name }}">
                            {{ $file->display_name }}
                        </div>
                        @if($file->hasDisplayName())
                            <div class="file-original-name" title="نام اصلی: {{ $file->name }}">
                                {{ $file->name }}
                            </div>
                        @endif
                        <div class="file-size">{{ $this->formatFileSize($file->size) }}</div>
                        <div class="file-date">{{ $file->created_at->format('Y/m/d') }}</div>
                        @if($file->tags && $file->tags->count() > 0)
                            <div class="file-tags">
                                @foreach($file->tags as $tag)
                                    <span class="tag" style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}; border: 1px solid {{ $tag->color }}40;">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </a>
                    <div class="file-actions">
                        <button type="button" class="btn btn-sm btn-outline-warning" wire:click="openRenameModal({{ $file->id }})" title="تغییر نام">
                            <i class="mdi mdi-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary" wire:click="openTagModal({{ $file->id }})" title="مدیریت تگ‌ها">
                            <i class="mdi mdi-tag-plus"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" wire:click="deleteItem({{ $file->id }}, 'file')" title="حذف فایل">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </div>
                </div>
            @endforeach
            </div>
        @else
            <div class="empty-folder">
                @if($selectedTag)
                    <div class="empty-state-content">
                        <div class="empty-state-icon mb-4">
                            <i class="mdi mdi-tag-outline"></i>
                        </div>
                        <h4 class="empty-state-title">هیچ فایلی با این تگ یافت نشد</h4>
                        <p class="empty-state-description">فایل‌هایی با تگ انتخاب شده در این پوشه وجود ندارد</p>
                        <button type="button" class="btn btn-outline-primary btn-lg" wire:click="clearFilter">
                            <i class="mdi mdi-close me-2"></i> حذف فیلتر
                        </button>
                    </div>
                @else
                    <div class="empty-state-content">
                        <div class="empty-state-icon mb-4">
                            <i class="mdi mdi-folder-open-outline"></i>
                        </div>
                        <h4 class="empty-state-title">این پوشه خالی است</h4>
                        <p class="empty-state-description">فایل یا پوشه‌ای در اینجا وجود ندارد</p>
                        <div class="empty-state-actions">
                            <button type="button" class="btn btn-primary btn-lg me-3" wire:click="openUploadModal">
                                <i class="mdi mdi-cloud-upload me-2"></i> آپلود فایل
                            </button>
                            <button type="button" class="btn btn-outline-success btn-lg" wire:click="openCreateFolderModal">
                                <i class="mdi mdi-folder-plus me-2"></i> ایجاد پوشه
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <!-- Upload Modal -->
    @if($showUploadModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg">
                <div class="modal-content upload-modal">
                    <div class="modal-header">
                        <div class="d-flex align-items-center">
                            <div class="upload-icon me-3">
                                <i class="mdi mdi-cloud-upload"></i>
                            </div>
                            <div>
                                <h5 class="modal-title mb-0">آپلود فایل‌ها</h5>
                                <small class="text-muted">فایل‌های خود را انتخاب و آپلود کنید</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close" wire:click="$set('showUploadModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <div class="upload-area mb-4">
                            <div class="upload-zone" onclick="document.getElementById('fileInput').click()">
                                <i class="mdi mdi-cloud-upload upload-zone-icon"></i>
                                <h6 class="upload-zone-title">فایل‌ها را اینجا بکشید یا کلیک کنید</h6>
                                <p class="upload-zone-text">چندین فایل را همزمان انتخاب کنید</p>
                                <input type="file" id="fileInput" class="d-none" wire:model="uploadedFiles" multiple>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="mdi mdi-text me-1"></i> توضیحات (اختیاری)
                            </label>
                            <textarea class="form-control" wire:model="fileDescription" rows="3" placeholder="توضیحات مربوط به فایل‌ها..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="mdi mdi-tag me-1"></i> تگ‌ها (اختیاری)
                            </label>
                            <div class="alert alert-info">
                                <i class="mdi mdi-information me-2"></i>
                                <strong>نکته:</strong> فقط تگ‌های سازگار با فایل‌های انتخاب شده اعمال خواهند شد. تگ‌های ناسازگار نادیده گرفته می‌شوند.
                            </div>
                            <div class="tag-selection">
                                @foreach($tags as $tag)
                                    @if(!$tag->is_folder_tag)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" wire:model="selectedTags" value="{{ $tag->id }}" id="file_tag_{{ $tag->id }}">
                                            <label class="form-check-label" for="file_tag_{{ $tag->id }}" style="color: {{ $tag->color }}">
                                                {{ $tag->name }}
                                                @if($tag->allowed_extensions || $tag->allowed_mime_types)
                                                    <small class="text-muted">({{ $tag->getAllowedExtensionsText() }})</small>
                                                @endif
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" wire:click="$set('showUploadModal', false)">
                            <i class="mdi mdi-close me-1"></i> انصراف
                        </button>
                        <button type="button" class="btn btn-primary btn-lg" wire:click="uploadFiles">
                            <i class="mdi mdi-cloud-upload me-2"></i> آپلود فایل‌ها
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Create Folder Modal -->
    @if($showCreateFolderModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ایجاد پوشه جدید</h5>
                        <button type="button" class="btn-close" wire:click="$set('showCreateFolderModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">نام پوشه</label>
                            <input type="text" class="form-control" wire:model="folderName" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">توضیحات (اختیاری)</label>
                            <textarea class="form-control" wire:model="folderDescription" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">رنگ پوشه</label>
                            <select class="form-select" wire:model="folderColor">
                                <option value="#ffc107">زرد</option>
                                <option value="#28a745">سبز</option>
                                <option value="#dc3545">قرمز</option>
                                <option value="#007bff">آبی</option>
                                <option value="#6f42c1">بنفش</option>
                                <option value="#fd7e14">نارنجی</option>
                                <option value="#20c997">فیروزه‌ای</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">تگ‌ها (اختیاری)</label>
                            <div class="alert alert-info">
                                <i class="mdi mdi-information me-2"></i>
                                <strong>نکته:</strong> فقط تگ‌های مخصوص پوشه‌ها قابل انتخاب هستند.
                            </div>
                            <div class="tag-selection">
                                @foreach($tags as $tag)
                                    @if($tag->is_folder_tag)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" wire:model="selectedTags" value="{{ $tag->id }}" id="folder_tag_{{ $tag->id }}">
                                            <label class="form-check-label" for="folder_tag_{{ $tag->id }}" style="color: {{ $tag->color }}">
                                                {{ $tag->name }}
                                                @if($tag->allowed_extensions || $tag->allowed_mime_types)
                                                    <small class="text-muted">({{ $tag->getAllowedExtensionsText() }})</small>
                                                @endif
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showCreateFolderModal', false)">انصراف</button>
                        <button type="button" class="btn btn-primary" wire:click="createFolder">ایجاد پوشه</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Tag Modal -->
    @if($showTagModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">مدیریت تگ‌های فایل</h5>
                        <button type="button" class="btn-close" wire:click="$set('showTagModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">تگ‌های سازگار</label>
                            <div class="tag-selection">
                                @php
                                    $compatibleTags = $this->getCompatibleTags($selectedFileForTags->id ?? null);
                                @endphp

                                @if($compatibleTags->count() > 0)
                                    @foreach($compatibleTags as $tag)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" wire:model="selectedTags" value="{{ $tag->id }}" id="tag_{{ $tag->id }}">
                                            <label class="form-check-label" for="tag_{{ $tag->id }}" style="color: {{ $tag->color }}">
                                                {{ $tag->name }}
                                                @if($tag->allowed_extensions || $tag->allowed_mime_types)
                                                    <small class="text-muted">({{ $tag->getAllowedExtensionsText() }})</small>
                                                @endif
                                            </label>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-warning">
                                        <i class="mdi mdi-alert-circle me-2"></i>
                                        هیچ تگ سازگاری برای این فایل وجود ندارد
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if($selectedFileForTags)
                            <div class="mb-3">
                                <div class="alert alert-info">
                                    <strong>اطلاعات فایل:</strong><br>
                                    <small>
                                        نام: {{ $selectedFileForTags->name }}<br>
                                        نوع: {{ $selectedFileForTags->is_folder ? 'پوشه' : 'فایل' }}<br>
                                        @if(!$selectedFileForTags->is_folder && $selectedFileForTags->mime_type)
                                            MIME: {{ $selectedFileForTags->mime_type }}<br>
                                        @endif
                                        @if(!$selectedFileForTags->is_folder)
                                            پسوند: {{ strtolower(pathinfo($selectedFileForTags->name, PATHINFO_EXTENSION)) ?: 'ندارد' }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showTagModal', false)">انصراف</button>
                        <button type="button" class="btn btn-primary" wire:click="saveFileTags">ذخیره</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Rename Modal -->
    @if($showRenameModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">تغییر نام {{ $itemToRename && $itemToRename->is_folder ? 'پوشه' : 'فایل' }}</h5>
                        <button type="button" class="btn-close" wire:click="cancelRename"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">نام اصلی (برای سیستم)</label>
                            <input type="text" class="form-control" wire:model="newName" required>
                            <div class="form-text">این نام برای سیستم استفاده می‌شود و باید منحصر به فرد باشد</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">نام نمایشی (اختیاری)</label>
                            <input type="text" class="form-control" wire:model="newDisplayName" placeholder="نام دلخواه برای نمایش">
                            <div class="form-text">اگر خالی باشد، نام اصلی نمایش داده می‌شود</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="cancelRename">انصراف</button>
                        <button type="button" class="btn btn-primary" wire:click="renameItem">ذخیره تغییرات</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">تأیید حذف</h5>
                        <button type="button" class="btn-close" wire:click="cancelDelete"></button>
                    </div>
                    <div class="modal-body">
                        <p>آیا مطمئن هستید که می‌خواهید این {{ $itemTypeToDelete === 'folder' ? 'پوشه' : 'فایل' }} را حذف کنید؟</p>
                        <p class="text-danger small">این عمل قابل بازگشت نیست.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="cancelDelete">انصراف</button>
                        <button type="button" class="btn btn-danger" wire:click="confirmDelete">حذف</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

