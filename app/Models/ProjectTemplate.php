<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'created_by',
        'folder_structure'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'folder_structure' => 'array'
    ];

    /**
     * Get the user who created this template
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the root folders for this template
     */
    public function rootFolders()
    {
        return $this->hasMany(FileManager::class, 'project_id')
            ->where('is_template', true)
            ->whereNull('parent_id');
    }

    /**
     * Apply this template to a project
     */
    public function applyToProject($projectId)
    {
        foreach ($this->rootFolders as $rootFolder) {
            $rootFolder->copyStructure($projectId);
        }
    }
}
