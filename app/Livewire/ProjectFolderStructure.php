<?php

namespace App\Livewire;

use App\Models\Archive;
use App\Models\ArchiveFolder;
use App\Models\ArchiveFile;
use App\Models\Project;
use Livewire\Component;

class ProjectFolderStructure extends Component
{
    public $project;
    public $archive;
    public $expandedFolders = [];
    public $folderStats = [];
    public $viewMode = 'list';

    public function mount($projectId)
    {
        $this->project = Project::findOrFail($projectId);
        $this->archive = $this->project->archive;
        $this->loadFolderStats();
    }

    public function loadFolderStats()
    {
        $this->folderStats = $this->getFolderStats();
    }

    public function getFolderStats()
    {
        if (!$this->archive) {
            return [];
        }

        $folders = ArchiveFolder::where('archive_id', $this->archive->id)->get();
        $stats = [];

        foreach ($folders as $folder) {
            $stats[$folder->id] = [
                'folder' => $folder,
                'file_count' => $this->getFileCount($folder->id),
                'subfolder_count' => $this->getSubfolderCount($folder->id),
                'total_size' => $this->getTotalSize($folder->id)
            ];
        }

        return $stats;
    }

    public function getFileCount($folderId)
    {
        if (!$this->archive) {
            return 0;
        }

        return ArchiveFile::where('archive_id', $this->archive->id)
            ->where('folder_id', $folderId)
            ->count();
    }

    public function getSubfolderCount($folderId)
    {
        if (!$this->archive) {
            return 0;
        }

        return ArchiveFolder::where('archive_id', $this->archive->id)
            ->where('parent_id', $folderId)
            ->count();
    }

    public function getTotalSize($folderId)
    {
        if (!$this->archive) {
            return 0;
        }

        $files = ArchiveFile::where('archive_id', $this->archive->id)
            ->where('folder_id', $folderId)
            ->get();

        return $files->sum('file_size');
    }

    public function toggleFolder($folderId)
    {
        if (in_array($folderId, $this->expandedFolders)) {
            $this->expandedFolders = array_filter($this->expandedFolders, function($id) use ($folderId) {
                return $id != $folderId;
            });
        } else {
            $this->expandedFolders[] = $folderId;
        }
    }

    public function isFolderExpanded($folderId)
    {
        return in_array($folderId, $this->expandedFolders);
    }

    public function getRootFolders()
    {
        if (!$this->archive) {
            return collect();
        }

        return ArchiveFolder::where('archive_id', $this->archive->id)
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();
    }

    public function getSubfolders($parentId)
    {
        if (!$this->archive) {
            return collect();
        }

        return ArchiveFolder::where('archive_id', $this->archive->id)
            ->where('parent_id', $parentId)
            ->orderBy('name')
            ->get();
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
        return view('livewire.project-folder-structure');
    }
}
