@php
    $isExpanded = $this->isFolderExpanded($folder->id);
    $stats = $this->folderStats[$folder->id] ?? null;
    $subfolders = $this->getSubfolders($folder->id);
@endphp

<div class="folder-item" wire:key="folder-{{ $folder->id }}">
    <div class="folder-header {{ $isExpanded ? 'expanded' : '' }}"
         wire:click="toggleFolder({{ $folder->id }})">
        <i class="mdi mdi-folder {{ $isExpanded ? 'mdi-folder-open' : 'mdi-folder' }} folder-icon"></i>

        <div class="folder-info">
            <div class="folder-name">{{ $folder->display_name ?: $folder->name }}</div>
            @if($stats)
                <div class="folder-stats">
                    <div class="stat-item">
                        <i class="mdi mdi-file stat-icon"></i>
                        <span>{{ $stats['file_count'] }} فایل</span>
                    </div>
                    <div class="stat-item">
                        <i class="mdi mdi-folder stat-icon"></i>
                        <span>{{ $stats['subfolder_count'] }} پوشه</span>
                    </div>
                    @if($stats['total_size'] > 0)
                        <div class="stat-item">
                            <i class="mdi mdi-weight stat-icon"></i>
                            <span>{{ $this->formatFileSize($stats['total_size']) }}</span>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        @if($subfolders->count() > 0)
            <i class="mdi mdi-chevron-{{ $isExpanded ? 'down' : 'right' }} chevron-icon"></i>
        @endif
    </div>

    @if($isExpanded && $subfolders->count() > 0)
        <div class="folder-children">
            @foreach($subfolders as $subfolder)
                @include('livewire.partials.folder-item', ['folder' => $subfolder, 'level' => $level + 1])
            @endforeach
        </div>
    @endif
</div>
