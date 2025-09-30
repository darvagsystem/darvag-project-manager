<div class="folder-structure-container">
    @if($this->getRootFolders()->count() > 0)
        <div class="folder-tree">
            @foreach($this->getRootFolders() as $folder)
                @include('livewire.partials.folder-item', ['folder' => $folder, 'level' => 0])
            @endforeach
        </div>
    @else
        <div class="empty-structure">
            <div class="empty-icon">
                <i class="mdi mdi-folder-outline"></i>
            </div>
            <h6>هیچ پوشه‌ای در این پروژه وجود ندارد</h6>
            <p class="text-muted">برای شروع، اولین پوشه را در فایل منیجر ایجاد کنید</p>
            <a href="{{ route('projects.filemanager.index', $project->id) }}" class="btn btn-primary btn-sm">
                <i class="mdi mdi-folder-plus me-1"></i>
                ایجاد پوشه
            </a>
        </div>
    @endif
</div>