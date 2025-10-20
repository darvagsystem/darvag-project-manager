@php
    $isSelected = in_array('folder_' . $folder->id, $selectedItems ?? []);
@endphp

<div class="folder-item {{ $isSelected ? 'selected' : '' }}"
     data-item-id="{{ $folder->id }}"
     data-item-type="folder"
     wire:click="selectItem({{ $folder->id }}, 'folder')"
     wire:dblclick="openItem({{ $folder->id }}, 'folder')">

    <div class="file-icon">
        <i class="mdi mdi-folder{{ $isSelected ? '' : '-outline' }}"></i>
    </div>

    <div class="file-name">
        {{ $folder->name }}
        @if($folder->is_required)
            <span class="badge bg-danger ms-1">الزامی</span>
        @endif
    </div>

    @if($viewMode === 'details')
        <div class="file-size">-</div>
        <div class="file-type">پوشه</div>
        <div class="file-date">{{ \App\Helpers\DateHelper::toPersianDateTime($folder->created_at) }}</div>
    @endif

    <div class="file-actions">
        <button class="btn btn-sm btn-outline-primary"
                wire:click.stop="showProperties({{ $folder->id }}, 'folder')"
                title="ویژگی‌ها">
            <i class="mdi mdi-information"></i>
        </button>
        <button class="btn btn-sm btn-outline-warning"
                wire:click.stop="renameItem({{ $folder->id }}, 'folder')"
                title="تغییر نام">
            <i class="mdi mdi-pencil"></i>
        </button>
        <button class="btn btn-sm btn-outline-danger"
                wire:click.stop="deleteFolder({{ $folder->id }})"
                title="حذف">
            <i class="mdi mdi-delete"></i>
        </button>
    </div>
</div>
