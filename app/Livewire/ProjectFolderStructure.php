<?php

namespace App\Livewire;

use App\Models\FileManager;
use App\Models\Project;
use Livewire\Component;

class ProjectFolderStructure extends Component
{
    public $project;
    public $expandedFolders = [];
    public $folderStats = [];

    public function mount($projectId)
    {
        $this->project = Project::findOrFail($projectId);
        $this->loadFolderStats();
    }

    public function loadFolderStats()
    {
        $this->folderStats = $this->getFolderStats();
    }

    public function getFolderStats()
    {
        $folders = FileManager::where('project_id', $this->project->id)
            ->where('is_folder', true)
            ->get();

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
        return FileManager::where('project_id', $this->project->id)
            ->where('parent_id', $folderId)
            ->where('is_folder', false)
            ->count();
    }

    public function getSubfolderCount($folderId)
    {
        return FileManager::where('project_id', $this->project->id)
            ->where('parent_id', $folderId)
            ->where('is_folder', true)
            ->count();
    }

    public function getTotalSize($folderId)
    {
        $files = FileManager::where('project_id', $this->project->id)
            ->where('parent_id', $folderId)
            ->where('is_folder', false)
            ->get();

        return $files->sum('size');
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
        return FileManager::where('project_id', $this->project->id)
            ->where('is_folder', true)
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();
    }

    public function getSubfolders($parentId)
    {
        return FileManager::where('project_id', $this->project->id)
            ->where('is_folder', true)
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