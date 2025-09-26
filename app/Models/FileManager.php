<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileManager extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'file_manager';

    protected $fillable = [
        'name',
        'original_name',
        'type',
        'path',
        'size',
        'mime_type',
        'parent_id',
        'project_id',
        'uploaded_by',
        'description',
        'is_folder',
        'is_template',
        'folder_color',
        'permissions',
        'download_count',
        'last_accessed_at'
    ];

    protected $casts = [
        'is_folder' => 'boolean',
        'is_template' => 'boolean',
        'permissions' => 'array',
        'last_accessed_at' => 'datetime',
        'size' => 'integer',
        'download_count' => 'integer'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'last_accessed_at'
    ];

    /**
     * Get the parent folder
     */
    public function parent()
    {
        return $this->belongsTo(FileManager::class, 'parent_id');
    }

    /**
     * Get child files and folders
     */
    public function children()
    {
        return $this->hasMany(FileManager::class, 'parent_id');
    }

    /**
     * Get only child folders
     */
    public function folders()
    {
        return $this->hasMany(FileManager::class, 'parent_id')->where('is_folder', true);
    }

    /**
     * Get only child files
     */
    public function files()
    {
        return $this->hasMany(FileManager::class, 'parent_id')->where('is_folder', false);
    }

    /**
     * Get the project this file belongs to
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user who uploaded this file
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get the full path including parent folders
     */
    public function getFullPathAttribute()
    {
        $path = collect();
        $current = $this;

        while ($current && $current->parent_id) {
            $path->prepend($current->parent->name);
            $current = $current->parent;
        }

        return $path->implode('/') . ($path->isNotEmpty() ? '/' : '') . $this->name;
    }

    /**
     * Get formatted file size
     */
    public function getFormattedSizeAttribute()
    {
        if ($this->is_folder) {
            return '-';
        }

        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get file icon based on mime type
     */
    public function getIconAttribute()
    {
        if ($this->is_folder) {
            return 'mdi-folder';
        }

        $mimeType = $this->mime_type;

        if (str_starts_with($mimeType, 'image/')) {
            return 'mdi-file-image';
        } elseif (str_starts_with($mimeType, 'video/')) {
            return 'mdi-file-video';
        } elseif (str_starts_with($mimeType, 'audio/')) {
            return 'mdi-file-music';
        } elseif ($mimeType === 'application/pdf') {
            return 'mdi-file-pdf-box';
        } elseif (in_array($mimeType, ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])) {
            return 'mdi-file-word';
        } elseif (in_array($mimeType, ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])) {
            return 'mdi-file-excel';
        } elseif (in_array($mimeType, ['application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'])) {
            return 'mdi-file-powerpoint';
        } elseif (str_contains($mimeType, 'zip') || str_contains($mimeType, 'rar') || str_contains($mimeType, 'tar')) {
            return 'mdi-file-archive';
        } elseif (str_contains($mimeType, 'text/') || str_contains($mimeType, 'json') || str_contains($mimeType, 'xml')) {
            return 'mdi-file-document-outline';
        } else {
            return 'mdi-file-outline';
        }
    }

    /**
     * Check if user can access this file
     */
    public function canAccess($userId)
    {
        if (!$this->permissions || empty($this->permissions)) {
            return true; // No restrictions
        }

        return in_array($userId, $this->permissions['users'] ?? []);
    }

    /**
     * Scope to get root folders (no parent)
     */
    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope to get folders only
     */
    public function scopeFolders($query)
    {
        return $query->where('is_folder', true);
    }

    /**
     * Scope to get files only
     */
    public function scopeFiles($query)
    {
        return $query->where('is_folder', false);
    }

    /**
     * Scope to get templates
     */
    public function scopeTemplates($query)
    {
        return $query->where('is_template', true);
    }

    /**
     * Get breadcrumb path
     */
    public function getBreadcrumb()
    {
        $breadcrumb = collect();
        $current = $this;

        while ($current) {
            $breadcrumb->prepend([
                'id' => $current->id,
                'name' => $current->name,
                'is_folder' => $current->is_folder
            ]);
            $current = $current->parent;
        }

        return $breadcrumb;
    }

    /**
     * Copy folder structure recursively
     */
    public function copyStructure($newProjectId, $newParentId = null)
    {
        // Create new folder/file
        $newItem = $this->replicate();
        $newItem->project_id = $newProjectId;
        $newItem->parent_id = $newParentId;
        $newItem->is_template = false;
        $newItem->created_at = now();
        $newItem->updated_at = now();

        // If it's a file, don't copy the actual file content for templates
        if (!$this->is_folder && $this->is_template) {
            $newItem->path = null;
            $newItem->size = 0;
        }

        $newItem->save();

        // If it's a folder, copy all children recursively
        if ($this->is_folder) {
            foreach ($this->children as $child) {
                $child->copyStructure($newProjectId, $newItem->id);
            }
        }

        return $newItem;
    }
}
