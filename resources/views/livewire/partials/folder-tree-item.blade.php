@php
    $isExpanded = in_array($folder->id, $expandedFolders ?? []);
    $isSelected = in_array('folder_' . $folder->id, $selectedItems ?? []);
    $level = $level ?? 0;
@endphp

<div class="tree-item {{ $isSelected ? 'selected' : '' }} {{ $currentPath === $folder->path ? 'current' : '' }}"
     style="padding-left: {{ $level * 20 + 8 }}px;"
     wire:click="navigateTo('{{ $folder->path }}')"
     title="{{ $folder->name }}">

    <div class="tree-toggle" wire:click.stop="toggleFolder({{ $folder->id }})">
        @if($folder->children->count() > 0)
            <i class="mdi mdi-chevron-{{ $isExpanded ? 'down' : 'right' }}"></i>
        @endif
    </div>

    <div class="tree-icon" style="color: {{ $folder->color ?? '#ff9800' }};">
        <i class="mdi mdi-folder{{ $isSelected ? '' : '-outline' }}"></i>
    </div>

    <span class="tree-name">{{ $folder->name }}</span>

    @if($folder->is_required)
        <span class="badge bg-danger ms-1">الزامی</span>
    @endif
</div>

@if($isExpanded)
    @foreach($folder->children as $child)
        @include('livewire.partials.folder-tree-item', ['folder' => $child, 'level' => $level + 1])
    @endforeach
@endif
