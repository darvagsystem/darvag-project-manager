<?php

namespace App\Livewire;

use App\Models\FileManager;
use App\Models\Project;
use App\Models\Tag;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use ZipArchive;

class FileManagerComponent extends Component
{
    use WithFileUploads;

    public $project;
    public $currentFolder;
    public $folders = [];
    public $files = [];
    public $breadcrumb = [];
    public $selectedTag = null;
    public $selectedItems = [];
    public $selectAll = false;
    public $showBulkActions = false;
    public $showUploadModal = false;
    public $showCreateFolderModal = false;
    public $showRenameModal = false;
    public $showTagModal = false;
    public $selectedFileForTags = null;
    public $uploadedFiles = [];
    public $folderName = '';
    public $folderDescription = '';
    public $folderColor = '#ffc107';
    public $fileDescription = '';
    public $newName = '';
    public $newDisplayName = '';
    public $itemToRename = null;
    public $tags = [];
    public $selectedTags = [];
    public $searchQuery = '';
    public $showDeleteModal = false;
    public $itemToDelete = null;
    public $itemTypeToDelete = null;

    public function mount($projectId = null)
    {
        $this->project = $projectId ? Project::find($projectId) : null;
        $this->loadData();
        $this->loadTags();
    }

    public function loadData()
    {
        $this->currentFolder = $this->getCurrentFolder();
        $this->breadcrumb = $this->getBreadcrumb();
        $contents = $this->getFolderContents();

        $this->folders = $contents['folders'];
        $this->files = $contents['files'];

        // فیلتر بر اساس تگ
        if ($this->selectedTag) {
            $this->files = $this->files->filter(function($file) {
                return $file->tags->contains('id', $this->selectedTag);
            });
            $this->folders = collect([]);
        }
    }

    public function loadTags()
    {
        $this->tags = Tag::orderBy('name')->get();
    }

    public function getCompatibleTags($fileId = null)
    {
        if ($fileId) {
            $file = FileManager::find($fileId);
            if ($file) {
                return $this->tags->filter(function($tag) use ($file) {
                    return $tag->isCompatibleWithFile($file);
                });
            }
        }
        return $this->tags;
    }

    public function getCurrentFolder()
    {
        return $this->currentFolder;
    }

    public function getFolderContents()
    {
        $query = FileManager::with(['uploader', 'tags']);

        if ($this->project) {
            $query->where('project_id', $this->project->id);
        } else {
            $query->whereNull('project_id');
        }

        if ($this->currentFolder) {
            $query->where('parent_id', $this->currentFolder->id);
        } else {
            $query->whereNull('parent_id');
        }

        // جستجو
        if (!empty($this->searchQuery)) {
            $query->where('name', 'like', '%' . $this->searchQuery . '%');
        }

        $folders = $query->clone()->where('is_folder', true)->orderBy('name')->get();
        $files = $query->clone()->where('is_folder', false)->orderBy('name')->get();

        return [
            'folders' => $folders,
            'files' => $files
        ];
    }

    public function getBreadcrumb()
    {
        $breadcrumb = [];
        $folder = $this->currentFolder;

        while ($folder) {
            array_unshift($breadcrumb, $folder);
            $folder = $folder->parent;
        }

        return $breadcrumb;
    }

    public function filterByTag($tagId)
    {
        $this->selectedTag = $tagId;
        $this->loadData();
    }

    public function clearFilter()
    {
        $this->selectedTag = null;
        $this->loadData();
    }

    public function openUploadModal()
    {
        $this->showUploadModal = true;
        $this->uploadedFiles = [];
        $this->fileDescription = '';
        $this->selectedTags = [];
    }

    public function openCreateFolderModal()
    {
        $this->showCreateFolderModal = true;
        $this->folderName = '';
        $this->folderDescription = '';
        $this->folderColor = '#ffc107';
        $this->selectedTags = [];
    }

    public function uploadFiles()
    {
        $this->validate([
            'uploadedFiles.*' => 'file|max:20480',
            'fileDescription' => 'nullable|string',
            'selectedTags' => 'nullable|array',
            'selectedTags.*' => 'exists:tags,id'
        ]);

        try {
            foreach ($this->uploadedFiles as $file) {
                $path = $file->store('file-manager', 'public');

                $fileRecord = FileManager::create([
                    'name' => $file->getClientOriginalName(),
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'type' => 'file',
                    'is_folder' => false,
                    'parent_id' => $this->currentFolder?->id,
                    'project_id' => $this->project?->id,
                    'description' => $this->fileDescription,
                    'uploaded_by' => auth()->id()
                ]);

                // بررسی محدودیت‌های تگ‌ها قبل از اعمال
                if (!empty($this->selectedTags)) {
                    $incompatibleTags = [];
                    $compatibleTags = [];

                    foreach ($this->selectedTags as $tagId) {
                        $tag = \App\Models\Tag::find($tagId);
                        if ($tag && $tag->isCompatibleWithFile($fileRecord)) {
                            $compatibleTags[] = $tagId;
                        } else {
                            $incompatibleTags[] = $tag->name ?? 'نامشخص';
                        }
                    }

                    // اعمال فقط تگ‌های سازگار
                    if (!empty($compatibleTags)) {
                        $fileRecord->tags()->attach($compatibleTags);
                    }

                    // نمایش پیام برای تگ‌های ناسازگار
                    if (!empty($incompatibleTags)) {
                        session()->flash('warning', 'تگ‌های زیر با فایل "' . $file->getClientOriginalName() . '" سازگار نیستند و اعمال نشدند: ' . implode(', ', $incompatibleTags));
                    }
                }
            }

            $this->showUploadModal = false;
            $this->loadData();
            session()->flash('success', 'فایل‌ها با موفقیت آپلود شدند');
        } catch (\Exception $e) {
            session()->flash('error', 'خطا در آپلود فایل‌ها: ' . $e->getMessage());
        }
    }

    public function createFolder()
    {
        $this->validate([
            'folderName' => 'required|string|max:255',
            'folderDescription' => 'nullable|string',
            'folderColor' => 'nullable|string',
            'selectedTags' => 'nullable|array',
            'selectedTags.*' => 'exists:tags,id'
        ]);

        try {
            $folder = FileManager::create([
                'name' => $this->folderName,
                'type' => 'folder',
                'is_folder' => true,
                'parent_id' => $this->currentFolder?->id,
                'project_id' => $this->project?->id,
                'description' => $this->folderDescription,
                'folder_color' => $this->folderColor,
                'uploaded_by' => auth()->id()
            ]);

            // بررسی محدودیت‌های تگ‌ها قبل از اعمال
            if (!empty($this->selectedTags)) {
                $incompatibleTags = [];
                $compatibleTags = [];

                foreach ($this->selectedTags as $tagId) {
                    $tag = \App\Models\Tag::find($tagId);
                    if ($tag && $tag->isCompatibleWithFile($folder)) {
                        $compatibleTags[] = $tagId;
                    } else {
                        $incompatibleTags[] = $tag->name ?? 'نامشخص';
                    }
                }

                // اعمال فقط تگ‌های سازگار
                if (!empty($compatibleTags)) {
                    $folder->tags()->attach($compatibleTags);
                }

                // نمایش پیام برای تگ‌های ناسازگار
                if (!empty($incompatibleTags)) {
                    session()->flash('warning', 'تگ‌های زیر با پوشه "' . $this->folderName . '" سازگار نیستند و اعمال نشدند: ' . implode(', ', $incompatibleTags));
                }
            }

            $this->showCreateFolderModal = false;
            $this->loadData();
            session()->flash('success', 'پوشه با موفقیت ایجاد شد');
        } catch (\Exception $e) {
            session()->flash('error', 'خطا در ایجاد پوشه: ' . $e->getMessage());
        }
    }

    public function downloadFile($fileId)
    {
        $file = FileManager::findOrFail($fileId);

        if (!Storage::disk('public')->exists($file->path)) {
            abort(404, 'فایل مورد نظر یافت نشد');
        }

        return Storage::disk('public')->download($file->path, $file->original_name);
    }

    public function openTagModal($fileId)
    {
        $this->selectedFileForTags = FileManager::with('tags')->findOrFail($fileId);
        $this->selectedTags = $this->selectedFileForTags->tags->pluck('id')->toArray();
        $this->showTagModal = true;
    }

    public function saveFileTags()
    {
        if (!$this->selectedFileForTags) {
            return;
        }

        // بررسی محدودیت‌های تگ‌ها
        $incompatibleTags = [];
        foreach ($this->selectedTags as $tagId) {
            $tag = \App\Models\Tag::find($tagId);
            if ($tag && !$tag->isCompatibleWithFile($this->selectedFileForTags)) {
                $incompatibleTags[] = $tag->name;
            }
        }

        if (!empty($incompatibleTags)) {
            session()->flash('error', 'تگ‌های زیر با این فایل سازگار نیستند: ' . implode(', ', $incompatibleTags));
            return;
        }

        $this->selectedFileForTags->tags()->sync($this->selectedTags);
        $this->showTagModal = false;
        $this->loadData();
        session()->flash('success', 'تگ‌های فایل به‌روزرسانی شد');
    }

    public function refreshData()
    {
        $this->loadData();
        session()->flash('success', 'داده‌ها به‌روزرسانی شد');
    }

    public function searchFiles()
    {
        $this->loadData();
    }

    public function deleteItem($itemId, $type)
    {
        try {
            \Log::info('Delete item called with ID: ' . $itemId . ', Type: ' . $type);
            $this->itemToDelete = $itemId;
            $this->itemTypeToDelete = $type;
            $this->showDeleteModal = true;
            \Log::info('Delete modal should be shown now');
        } catch (\Exception $e) {
            \Log::error('Error in deleteItem: ' . $e->getMessage());
            session()->flash('error', 'خطا در حذف آیتم: ' . $e->getMessage());
        }
    }

    public function confirmDelete()
    {
        if ($this->itemToDelete && $this->itemTypeToDelete) {
            try {
                \Log::info('Attempting to delete item: ' . $this->itemToDelete);
                $item = FileManager::findOrFail($this->itemToDelete);
                \Log::info('Item found: ' . $item->name . ' (is_folder: ' . ($item->is_folder ? 'true' : 'false') . ')');

                // If it's a folder, delete all children first
                if ($item->is_folder) {
                    \Log::info('Deleting folder recursively');
                    $this->deleteFolderRecursively($item);
                } else {
                    \Log::info('Deleting file');
                    // Delete the physical file if it exists
                    if ($item->path && \Storage::disk('public')->exists($item->path)) {
                        \Storage::disk('public')->delete($item->path);
                        \Log::info('Physical file deleted: ' . $item->path);
                    }
                    $item->forceDelete(); // Force delete instead of soft delete
                    \Log::info('Database record deleted');
                }

                $this->showDeleteModal = false;
                $this->loadData();
                session()->flash('success', 'آیتم با موفقیت حذف شد');
                \Log::info('Delete completed successfully');
            } catch (\Exception $e) {
                \Log::error('Delete error: ' . $e->getMessage());
                session()->flash('error', 'خطا در حذف آیتم: ' . $e->getMessage());
            }
        }
    }

    private function deleteFolderRecursively($folder)
    {
        \Log::info('Deleting folder recursively: ' . $folder->name);

        // Get all children (both folders and files)
        $children = FileManager::where('parent_id', $folder->id)->get();
        \Log::info('Found ' . $children->count() . ' children in folder: ' . $folder->name);

        foreach ($children as $child) {
            if ($child->is_folder) {
                \Log::info('Deleting child folder: ' . $child->name);
                $this->deleteFolderRecursively($child);
            } else {
                \Log::info('Deleting child file: ' . $child->name);
                // Delete the physical file if it exists
                if ($child->path && \Storage::disk('public')->exists($child->path)) {
                    \Storage::disk('public')->delete($child->path);
                    \Log::info('Physical file deleted: ' . $child->path);
                }
                $child->forceDelete();
                \Log::info('Child file database record deleted');
            }
        }

        // Delete the folder itself
        \Log::info('Deleting folder itself: ' . $folder->name);
        $folder->forceDelete();
        \Log::info('Folder database record deleted');
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->itemToDelete = null;
        $this->itemTypeToDelete = null;
    }

    public function openRenameModal($itemId)
    {
        $this->itemToRename = FileManager::findOrFail($itemId);
        $this->newName = $this->itemToRename->name;
        $this->newDisplayName = $this->itemToRename->attributes['display_name'] ?? $this->itemToRename->name;
        $this->showRenameModal = true;
    }

    public function renameItem()
    {
        $this->validate([
            'newName' => 'required|string|max:255',
            'newDisplayName' => 'nullable|string|max:255'
        ]);

        try {
            $this->itemToRename->update([
                'name' => $this->newName,
                'display_name' => $this->newDisplayName ?: null
            ]);

            $this->showRenameModal = false;
            $this->loadData();
            session()->flash('success', 'نام با موفقیت تغییر یافت');
        } catch (\Exception $e) {
            session()->flash('error', 'خطا در تغییر نام: ' . $e->getMessage());
        }
    }

    public function cancelRename()
    {
        $this->showRenameModal = false;
        $this->itemToRename = null;
        $this->newName = '';
        $this->newDisplayName = '';
    }

    public function toggleSelectAll()
    {
        $this->selectAll = !$this->selectAll;

        if ($this->selectAll) {
            $this->selectedItems = collect($this->folders)->pluck('id')->merge(
                collect($this->files)->pluck('id')
            )->toArray();
        } else {
            $this->selectedItems = [];
        }

        $this->updateBulkActionsVisibility();
    }

    public function toggleItemSelection($itemId)
    {
        if (in_array($itemId, $this->selectedItems)) {
            $this->selectedItems = array_filter($this->selectedItems, function($id) use ($itemId) {
                return $id != $itemId;
            });
        } else {
            $this->selectedItems[] = $itemId;
        }

        $this->selectedItems = array_values($this->selectedItems);
        $this->updateBulkActionsVisibility();
    }

    public function updateBulkActionsVisibility()
    {
        $this->showBulkActions = count($this->selectedItems) > 0;
    }

    public function bulkDelete()
    {
        if (empty($this->selectedItems)) {
            return;
        }

        try {
            $deletedCount = 0;
            foreach ($this->selectedItems as $itemId) {
                $item = FileManager::find($itemId);
                if ($item) {
                    // If it's a folder, delete all children first
                    if ($item->is_folder) {
                        $this->deleteFolderRecursively($item);
                    } else {
                        // Delete the physical file if it exists
                        if ($item->path && \Storage::disk('public')->exists($item->path)) {
                            \Storage::disk('public')->delete($item->path);
                        }
                        $item->forceDelete();
                    }
                    $deletedCount++;
                }
            }

            $this->selectedItems = [];
            $this->selectAll = false;
            $this->showBulkActions = false;
            $this->loadData();

            session()->flash('success', "{$deletedCount} آیتم با موفقیت حذف شد");
        } catch (\Exception $e) {
            session()->flash('error', 'خطا در حذف آیتم‌ها: ' . $e->getMessage());
        }
    }

    public function bulkDownload()
    {
        if (empty($this->selectedItems)) {
            return;
        }

        try {
            $files = FileManager::whereIn('id', $this->selectedItems)
                ->where('is_folder', false)
                ->get();

            if ($files->isEmpty()) {
                session()->flash('error', 'هیچ فایلی برای دانلود انتخاب نشده است');
                return;
            }

            // Create temporary ZIP file
            $zipFileName = 'selected_files_' . time() . '.zip';
            $tempPath = storage_path('app/temp/' . $zipFileName);

            // Ensure temp directory exists
            if (!file_exists(storage_path('app/temp'))) {
                mkdir(storage_path('app/temp'), 0755, true);
            }

            $zip = new ZipArchive();
            if ($zip->open($tempPath, ZipArchive::CREATE) !== TRUE) {
                throw new \Exception('Cannot create ZIP file');
            }

            foreach ($files as $file) {
                if (Storage::disk('public')->exists($file->path)) {
                    $filePath = Storage::disk('public')->path($file->path);
                    $fileName = $file->display_name ?: $file->name;

                    // Add file to ZIP
                    $zip->addFile($filePath, $fileName);
                }
            }

            $zip->close();

            // Return file download
            return response()->download($tempPath, $zipFileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            session()->flash('error', 'خطا در ایجاد فایل ZIP: ' . $e->getMessage());
        }
    }

    public function clearSelection()
    {
        $this->selectedItems = [];
        $this->selectAll = false;
        $this->showBulkActions = false;
    }

    public function enterFolder($folderId)
    {
        $this->currentFolder = FileManager::findOrFail($folderId);
        $this->loadData();
        $this->dispatch('folder-changed', folderId: $folderId);
    }

    public function goBack()
    {
        if ($this->currentFolder && $this->currentFolder->parent) {
            $this->currentFolder = $this->currentFolder->parent;
        } else {
            $this->currentFolder = null;
        }
        $this->loadData();
    }

    public function getFileIcon($mimeType)
    {
        if (!$mimeType) {
            return 'mdi-file';
        }

        if (str_starts_with($mimeType, 'image/')) {
            return 'mdi-image';
        } elseif (str_starts_with($mimeType, 'video/')) {
            return 'mdi-video';
        } elseif (str_starts_with($mimeType, 'audio/')) {
            return 'mdi-music';
        } elseif (str_starts_with($mimeType, 'text/')) {
            return 'mdi-file-document';
        } elseif ($mimeType === 'application/pdf') {
            return 'mdi-file-pdf';
        } elseif (in_array($mimeType, ['application/zip', 'application/x-rar-compressed'])) {
            return 'mdi-archive';
        } else {
            return 'mdi-file';
        }
    }

    public function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' B';
        }
    }

    public function render()
    {
        return view('livewire.file-manager-component');
    }
}
