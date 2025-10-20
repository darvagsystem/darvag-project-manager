@php
    $isSelected = in_array('file_' . $file->id, $selectedItems ?? []);
@endphp

<div class="file-item {{ $isSelected ? 'selected' : '' }}"
     data-item-id="{{ $file->id }}"
     data-item-type="file"
     wire:click="selectItem({{ $file->id }}, 'file')"
     wire:dblclick="openItem({{ $file->id }}, 'file')">

    <div class="file-icon">
        <i class="mdi {{ $file->icon }}"></i>
    </div>

    <div class="file-name">
        {{ $file->name }}
        @if($file->is_required)
            <span class="badge bg-danger ms-1">الزامی</span>
        @endif
        @if($file->description)
            <small class="text-muted d-block">{{ $file->description }}</small>
        @endif
    </div>

    @if($viewMode === 'details')
        <div class="file-size">{{ $file->human_size }}</div>
        <div class="file-type">{{ strtoupper($file->extension) }}</div>
        <div class="file-date">{{ \App\Helpers\DateHelper::toPersianDateTime($file->created_at) }}</div>
    @endif

    <div class="file-actions">
        <button class="btn btn-sm btn-outline-primary"
                wire:click.stop="downloadFile({{ $file->id }})"
                title="دانلود">
            <i class="mdi mdi-download"></i>
        </button>
        <button class="btn btn-sm btn-outline-info"
                wire:click.stop="showProperties({{ $file->id }}, 'file')"
                title="ویژگی‌ها">
            <i class="mdi mdi-information"></i>
        </button>
        <button class="btn btn-sm btn-outline-warning"
                wire:click.stop="renameItem({{ $file->id }}, 'file')"
                title="تغییر نام">
            <i class="mdi mdi-pencil"></i>
        </button>
        <button class="btn btn-sm btn-outline-danger"
                wire:click.stop="deleteFile({{ $file->id }})"
                title="حذف">
            <i class="mdi mdi-delete"></i>
        </button>
    </div>
</div>
