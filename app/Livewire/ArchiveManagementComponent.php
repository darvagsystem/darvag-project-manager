<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Archive;
use App\Models\ArchiveFolder;
use App\Models\ArchiveFile;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArchiveManagementComponent extends Component
{
    use WithFileUploads;

    public $archive;
    public $currentPath = '/';
    public $selectedItems = [];
    public $expandedFolders = [];
    public $viewMode = 'list'; // list, grid, details
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $search = '';
    public $showHidden = false;

    // Modal states
    public $showUploadModal = false;
    public $showCreateFolderModal = false;
    public $showRenameModal = false;
    public $showMoveModal = false;
    public $showPropertiesModal = false;

    // Upload properties removed - using controller instead

    // Create folder properties
    public $folderName = '';
    public $folderDescription = '';
    public $folderColor = '#ff9800';

    // Rename properties
    public $renameItem = null;
    public $newName = '';

    // Move properties
    public $moveItems = [];
    public $destinationFolder = null;

    // Properties
    public $propertiesItem = null;
    public $propertiesType = null;

    // Edit folder properties
    public $showEditFolderModal = false;
    public $editFolder = null;
    public $editFolderName = '';
    public $editFolderDescription = '';
    public $editFolderColor = '#ff9800';

    protected $listeners = [
        'refreshArchive' => '$refresh',
        'openItem',
        'downloadFile',
        'renameItem',
        'showProperties',
        'deleteFolder',
        'confirmDeleteFolder',
        'deleteFile',
        'confirmDeleteFile',
        'selectAll',
        'deleteSelected',
        'confirmDeleteSelected',
        'showCreateFolderModal',
        'showUploadModal',
        'editFolder' => 'editFolder',
        'editFile' => 'editFile'
    ];

    public function mount(Archive $archive)
    {
        $this->archive = $archive;
        $this->archive->load(['rootFolders.children', 'files', 'tagRequirements.tag']);
    }

    public function render()
    {
        $items = $this->getCurrentItems();
        $breadcrumbs = $this->getBreadcrumbs();
        $tags = Tag::where('is_active', true)->get();

        return view('livewire.archive-management-component', compact('items', 'breadcrumbs', 'tags'));
    }

    public function getCurrentItems()
    {
        $query = collect();

        // Get folders in current path
        $folders = $this->getFoldersInPath();
        $query = $query->merge($folders);

        // Get files in current path
        $files = $this->getFilesInPath();
        $query = $query->merge($files);

        // Apply search filter
        if ($this->search) {
            $query = $query->filter(function($item) {
                return stripos($item->name, $this->search) !== false;
            });
        }

        // Apply sorting
        $query = $query->sortBy([
            [$this->sortBy, $this->sortDirection]
        ]);

        return $query;
    }

    public function getFoldersInPath()
    {
        if ($this->currentPath === '/') {
            return $this->archive->rootFolders;
        }

        $pathParts = explode('/', trim($this->currentPath, '/'));
        $currentFolder = $this->archive->rootFolders->first();

        foreach ($pathParts as $part) {
            if ($currentFolder) {
                $currentFolder = $currentFolder->children->where('name', $part)->first();
            }
        }

        return $currentFolder ? $currentFolder->children : collect();
    }

    public function getFilesInPath()
    {
        if ($this->currentPath === '/') {
            return $this->archive->files->whereNull('folder_id');
        }

        $pathParts = explode('/', trim($this->currentPath, '/'));
        $currentFolder = $this->archive->rootFolders->first();

        foreach ($pathParts as $part) {
            if ($currentFolder) {
                $currentFolder = $currentFolder->children->where('name', $part)->first();
            }
        }

        return $currentFolder ? $currentFolder->files : collect();
    }

    public function getBreadcrumbs()
    {
        $breadcrumbs = [['name' => 'بایگانی', 'path' => '/']];

        if ($this->currentPath !== '/') {
            $pathParts = explode('/', trim($this->currentPath, '/'));
            $currentPath = '';

            foreach ($pathParts as $part) {
                $currentPath .= '/' . $part;
                $breadcrumbs[] = ['name' => $part, 'path' => $currentPath];
            }
        }

        return $breadcrumbs;
    }

    public function navigateTo($path)
    {
        $this->currentPath = $path;
        $this->selectedItems = [];

        // Expand parent folders in tree view
        if ($path !== '/') {
            $this->expandParentFolders($path);
        }
    }

    public function navigateToPath($path)
    {
        $this->navigateTo($path);
    }

    public function expandParentFolders($path)
    {
        if ($path === '/') {
            return;
        }

        $pathParts = explode('/', trim($path, '/'));
        $currentPath = '';

        foreach ($pathParts as $part) {
            $currentPath .= '/' . $part;
            $folder = ArchiveFolder::where('archive_id', $this->archive->id)
                                 ->where('path', $currentPath)
                                 ->first();

            if ($folder && !in_array($folder->id, $this->expandedFolders)) {
                $this->expandedFolders[] = $folder->id;
            }
        }
    }

    public function navigateUp()
    {
        if ($this->currentPath !== '/') {
            $pathParts = explode('/', trim($this->currentPath, '/'));
            array_pop($pathParts);
            $this->currentPath = '/' . implode('/', $pathParts);
            if ($this->currentPath === '//') {
                $this->currentPath = '/';
            }
        }
        $this->selectedItems = [];
    }

    public function selectItem($itemId, $itemType)
    {
        $key = $itemType . '_' . $itemId;

        if (in_array($key, $this->selectedItems)) {
            $this->selectedItems = array_diff($this->selectedItems, [$key]);
        } else {
            $this->selectedItems[] = $key;
        }
    }

    public function clearSelection()
    {
        $this->selectedItems = [];
    }

    public function openItem($itemId, $itemType)
    {
        if ($itemType === 'folder') {
            $folder = ArchiveFolder::find($itemId);
            if ($folder) {
                $this->currentPath = $folder->path;
                $this->selectedItems = [];
            }
        } else {
            $this->downloadFile($itemId);
        }
    }

    // Upload functionality moved to controller

    public function createFolder()
    {
        try {
            $this->validate([
                'folderName' => 'required|string|max:255',
                'folderDescription' => 'nullable|string|max:500',
                'folderColor' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/'
            ]);

            $currentFolder = $this->getCurrentFolderModel();
            $parentId = $currentFolder ? $currentFolder->id : null;

            // Check for unique name in current directory
            $existingFolder = ArchiveFolder::where('archive_id', $this->archive->id)
                ->where('parent_id', $parentId)
                ->where('name', $this->folderName)
                ->first();

            if ($existingFolder) {
                session()->flash('error', 'پوشه‌ای با این نام در این مسیر وجود دارد.');
                return;
            }

            // Build the path correctly
            if ($this->currentPath === '/') {
                $path = $this->folderName;
            } else {
                $path = trim($this->currentPath, '/') . '/' . $this->folderName;
            }

            ArchiveFolder::create([
                'archive_id' => $this->archive->id,
                'parent_id' => $parentId,
                'name' => $this->folderName,
                'path' => $path,
                'description' => $this->folderDescription,
                'color' => $this->folderColor,
                'created_by' => auth()->id()
            ]);

            $this->reset(['folderName', 'folderDescription', 'folderColor', 'showCreateFolderModal']);
            $this->dispatch('refreshArchive');

            session()->flash('success', 'پوشه با موفقیت ایجاد شد.');

        } catch (\Exception $e) {
            session()->flash('error', 'خطا در ایجاد پوشه: ' . $e->getMessage());
        }
    }

    public function getCurrentFolderId()
    {
        if ($this->currentPath === '/') {
            return null;
        }

        // Find folder by exact path match
        $currentFolder = ArchiveFolder::where('archive_id', $this->archive->id)
                                    ->where('path', $this->currentPath)
                                    ->first();

        return $currentFolder ? $currentFolder->id : null;
    }

    public function renameItem($itemId, $itemType)
    {
        $this->renameItem = ['id' => $itemId, 'type' => $itemType];

        if ($itemType === 'folder') {
            $folder = ArchiveFolder::find($itemId);
            $this->newName = $folder->name;
        } else {
            $file = ArchiveFile::find($itemId);
            $this->newName = $file->name;
        }

        $this->showRenameModal = true;
    }

    public function confirmRename()
    {
        $this->validate(['newName' => 'required|string|max:255']);

        if ($this->renameItem['type'] === 'folder') {
            $folder = ArchiveFolder::find($this->renameItem['id']);

            // Check for unique name in the same directory
            $existingFolder = ArchiveFolder::where('archive_id', $folder->archive_id)
                ->where('parent_id', $folder->parent_id)
                ->where('name', $this->newName)
                ->where('id', '!=', $folder->id)
                ->first();

            if ($existingFolder) {
                session()->flash('error', 'پوشه‌ای با این نام در این مسیر وجود دارد.');
                return;
            }

            $folder->update(['name' => $this->newName]);
        } else {
            $file = ArchiveFile::find($this->renameItem['id']);

            // Check for unique name in the same directory
            $existingFile = ArchiveFile::where('archive_id', $file->archive_id)
                ->where('folder_id', $file->folder_id)
                ->where('name', $this->newName)
                ->where('id', '!=', $file->id)
                ->first();

            if ($existingFile) {
                session()->flash('error', 'فایلی با این نام در این مسیر وجود دارد.');
                return;
            }

            $file->update(['name' => $this->newName]);
        }

        $this->reset(['renameItem', 'newName', 'showRenameModal']);
        $this->dispatch('refreshArchive');
        session()->flash('success', 'نام با موفقیت تغییر یافت.');
    }

    public function deleteFolderRecursive($folder)
    {
        foreach ($folder->files as $file) {
            $file->deleteFile();
            $file->delete();
        }

        foreach ($folder->children as $child) {
            $this->deleteFolderRecursive($child);
        }

        $folder->delete();
    }

    public function downloadFile($fileId)
    {
        $file = ArchiveFile::find($fileId);
        if ($file && $file->exists()) {
            return Storage::disk('public')->download($file->file_path, $file->original_name);
        }

        session()->flash('error', 'فایل یافت نشد.');
    }

    public function showProperties($itemId, $itemType)
    {
        if ($itemType === 'folder') {
            $this->propertiesItem = ArchiveFolder::find($itemId);
        } else {
            $this->propertiesItem = ArchiveFile::find($itemId);
        }
        $this->propertiesType = $itemType;
        $this->showPropertiesModal = true;
    }

    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
    }

    public function setSortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatedSearch()
    {
        $this->dispatch('refreshArchive');
    }

    public function getCurrentFolderModel()
    {
        if ($this->currentPath === '/') {
            return null;
        }
        // Find the folder by its full path within the archive
        return ArchiveFolder::where('archive_id', $this->archive->id)
                            ->where('path', $this->currentPath)
                            ->first();
    }

    public function getFolders(?ArchiveFolder $parentFolder)
    {
        $query = $this->archive->folders();

        if ($parentFolder) {
            $query->where('parent_id', $parentFolder->id);
        } else {
            $query->whereNull('parent_id');
        }

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        return $query->orderBy($this->sortBy, $this->sortDirection)->get();
    }

    public function getFiles(?ArchiveFolder $parentFolder)
    {
        $query = $this->archive->files();

        if ($parentFolder) {
            $query->where('folder_id', $parentFolder->id);
        } else {
            $query->whereNull('folder_id');
        }

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        return $query->orderBy($this->sortBy, $this->sortDirection)->get();
    }

    public function getItemsProperty()
    {
        $currentFolder = $this->getCurrentFolderModel();
        $folders = $this->getFolders($currentFolder);
        $files = $this->getFiles($currentFolder);
        return $folders->merge($files);
    }

    public function toggleFolder($folderId)
    {
        if (!isset($this->expandedFolders)) {
            $this->expandedFolders = [];
        }

        if (in_array($folderId, $this->expandedFolders)) {
            $this->expandedFolders = array_filter($this->expandedFolders, function($id) use ($folderId) {
                return $id != $folderId;
            });
        } else {
            $this->expandedFolders[] = $folderId;
        }
    }

    public function deleteFolder($folderId)
    {
        $folder = ArchiveFolder::find($folderId);
        if ($folder) {
            // Count files and subfolders
            $fileCount = $folder->files()->count();
            $subfolderCount = $folder->children()->count();

            $message = "آیا مطمئن هستید که می‌خواهید پوشه '{$folder->name}' را حذف کنید؟";
            if ($fileCount > 0 || $subfolderCount > 0) {
                $message .= "\n\nاین پوشه شامل {$fileCount} فایل و {$subfolderCount} زیرپوشه است و همه آن‌ها حذف خواهند شد.";
            }

            // Use JavaScript confirm instead of dispatch
            $this->js("
                if (confirm('" . addslashes($message) . "')) {
                    \$wire.call('confirmDeleteFolder', $folderId);
                }
            ");
        }
    }

    public function confirmDeleteFolder($folderId)
    {
        try {
            $folder = ArchiveFolder::find($folderId);
            if ($folder) {
                \Log::info("Deleting folder: {$folder->name} (ID: {$folderId})");
                $this->deleteFolderRecursive($folder);
                $this->archive->checkCompletion();
                $this->dispatch('refreshArchive');
                session()->flash('success', "پوشه '{$folder->name}' با موفقیت حذف شد.");
            } else {
                \Log::error("Folder not found: {$folderId}");
                session()->flash('error', 'پوشه یافت نشد.');
            }
        } catch (\Exception $e) {
            \Log::error("Error deleting folder: " . $e->getMessage());
            session()->flash('error', 'خطا در حذف پوشه: ' . $e->getMessage());
        }
    }

    public function deleteFile($fileId)
    {
        $file = ArchiveFile::find($fileId);
        if ($file) {
            $message = "آیا مطمئن هستید که می‌خواهید فایل '{$file->name}' را حذف کنید؟";

            // Use JavaScript confirm instead of dispatch
            $this->js("
                if (confirm('" . addslashes($message) . "')) {
                    \$wire.call('confirmDeleteFile', $fileId);
                }
            ");
        }
    }

    public function confirmDeleteFile($fileId)
    {
        try {
            $file = ArchiveFile::find($fileId);
            if ($file) {
                \Log::info("Deleting file: {$file->name} (ID: {$fileId})");
                $file->deleteFile();
                $file->delete();
                $this->archive->checkCompletion();
                $this->dispatch('refreshArchive');
                session()->flash('success', "فایل '{$file->name}' با موفقیت حذف شد.");
            } else {
                \Log::error("File not found: {$fileId}");
                session()->flash('error', 'فایل یافت نشد.');
            }
        } catch (\Exception $e) {
            \Log::error("Error deleting file: " . $e->getMessage());
            session()->flash('error', 'خطا در حذف فایل: ' . $e->getMessage());
        }
    }

    public function selectAll()
    {
        $items = $this->getCurrentItems();
        $this->selectedItems = [];

        foreach ($items as $item) {
            $type = $item instanceof ArchiveFolder ? 'folder' : 'file';
            $this->selectedItems[] = $type . '_' . $item->id;
        }
    }

    public function deleteSelected()
    {
        $count = count($this->selectedItems);
        $message = "آیا مطمئن هستید که می‌خواهید {$count} آیتم انتخاب شده را حذف کنید؟";

        // Use JavaScript confirm instead of dispatch
        $this->js("
            if (confirm('" . addslashes($message) . "')) {
                \$wire.call('confirmDeleteSelected');
            }
        ");
    }

    public function confirmDeleteSelected()
    {
        foreach ($this->selectedItems as $selected) {
            [$type, $id] = explode('_', $selected, 2);

            if ($type === 'folder') {
                $folder = ArchiveFolder::find($id);
                if ($folder) {
                    $this->deleteFolderRecursive($folder);
                }
            } else {
                $file = ArchiveFile::find($id);
                if ($file) {
                    $file->deleteFile();
                    $file->delete();
                }
            }
        }

        $count = count($this->selectedItems);
        $this->selectedItems = [];
        $this->archive->checkCompletion();
        $this->dispatch('refreshArchive');
        session()->flash('success', "{$count} آیتم با موفقیت حذف شد.");
    }

    public function editFolder($folderId)
    {
        $folder = ArchiveFolder::find($folderId);
        if ($folder) {
            $this->editFolder = $folder;
            $this->editFolderName = $folder->name;
            $this->editFolderDescription = $folder->description ?? '';
            $this->editFolderColor = $folder->color ?? '#ff9800';
            $this->showEditFolderModal = true;
        }
    }

    public function updateFolder()
    {
        try {
            $this->validate([
                'editFolderName' => 'required|string|max:255',
                'editFolderDescription' => 'nullable|string|max:500',
                'editFolderColor' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/'
            ]);

            if ($this->editFolder) {
                // Check for unique name in the same directory
                $existingFolder = ArchiveFolder::where('archive_id', $this->editFolder->archive_id)
                    ->where('parent_id', $this->editFolder->parent_id)
                    ->where('name', $this->editFolderName)
                    ->where('id', '!=', $this->editFolder->id)
                    ->first();

                if ($existingFolder) {
                    session()->flash('error', 'پوشه‌ای با این نام در این مسیر وجود دارد.');
                    return;
                }

                $this->editFolder->update([
                    'name' => $this->editFolderName,
                    'description' => $this->editFolderDescription,
                    'color' => $this->editFolderColor
                ]);

                $this->reset(['editFolder', 'editFolderName', 'editFolderDescription', 'editFolderColor', 'showEditFolderModal']);
                $this->dispatch('refreshArchive');
                session()->flash('success', 'پوشه با موفقیت به‌روزرسانی شد.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'خطا در به‌روزرسانی پوشه: ' . $e->getMessage());
        }
    }

    public function editFile($fileId)
    {
        // For now, just show properties for files
        $this->showProperties($fileId, 'file');
    }

    public function editSelected()
    {
        if (count($this->selectedItems) === 1) {
            $selected = $this->selectedItems[0];
            [$type, $id] = explode('_', $selected, 2);

            if ($type === 'folder') {
                $this->editFolder($id);
            } else {
                $this->editFile($id);
            }
        } else {
            session()->flash('error', 'لطفاً فقط یک آیتم را انتخاب کنید.');
        }
    }

    public function renameSelected()
    {
        if (count($this->selectedItems) === 1) {
            $selected = $this->selectedItems[0];
            [$type, $id] = explode('_', $selected, 2);
            $this->renameItem($id, $type);
        } else {
            session()->flash('error', 'لطفاً فقط یک آیتم را انتخاب کنید.');
        }
    }

    public function showPropertiesSelected()
    {
        if (count($this->selectedItems) === 1) {
            $selected = $this->selectedItems[0];
            [$type, $id] = explode('_', $selected, 2);
            $this->showProperties($id, $type);
        } else {
            session()->flash('error', 'لطفاً فقط یک آیتم را انتخاب کنید.');
        }
    }
}
