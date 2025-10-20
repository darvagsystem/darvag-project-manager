<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Archive extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'name',
        'description',
        'status',
        'is_complete',
        'completion_status',
        'created_by'
    ];

    protected $casts = [
        'completion_status' => 'array',
        'is_complete' => 'boolean'
    ];

    /**
     * Get the project that owns the archive.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user who created the archive.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the folders for the archive.
     */
    public function folders(): HasMany
    {
        return $this->hasMany(ArchiveFolder::class);
    }

    /**
     * Get the root folders for the archive.
     */
    public function rootFolders(): HasMany
    {
        return $this->hasMany(ArchiveFolder::class)->whereNull('parent_id');
    }

    /**
     * Get the files for the archive.
     */
    public function files(): HasMany
    {
        return $this->hasMany(ArchiveFile::class);
    }

    /**
     * Get all files through folders.
     */
    public function allFiles(): HasManyThrough
    {
        return $this->hasManyThrough(ArchiveFile::class, ArchiveFolder::class);
    }

    /**
     * Get the tag requirements for the project.
     */
    public function tagRequirements(): HasMany
    {
        return $this->hasMany(ProjectTagRequirement::class, 'project_id', 'project_id');
    }

    /**
     * Check if archive is complete based on required files.
     */
    public function checkCompletion(): bool
    {
        $requiredTags = $this->tagRequirements()
            ->where('is_required', true)
            ->with('tag')
            ->get();

        $completionStatus = [];
        $isComplete = true;

        foreach ($requiredTags as $requirement) {
            $hasFile = $this->files()
                ->whereJsonContains('tag_requirements', $requirement->tag_id)
                ->exists();

            $completionStatus[$requirement->tag_id] = [
                'tag_name' => $requirement->tag->name,
                'required' => true,
                'has_file' => $hasFile,
                'priority' => $requirement->priority
            ];

            if (!$hasFile) {
                $isComplete = false;
            }
        }

        $this->update([
            'completion_status' => $completionStatus,
            'is_complete' => $isComplete
        ]);

        return $isComplete;
    }

    /**
     * Get completion percentage.
     */
    public function getCompletionPercentage(): int
    {
        $requiredTags = $this->tagRequirements()->where('is_required', true)->count();

        if ($requiredTags === 0) {
            return 100;
        }

        $completedTags = 0;
        foreach ($this->completion_status ?? [] as $status) {
            if ($status['has_file']) {
                $completedTags++;
            }
        }

        return round(($completedTags / $requiredTags) * 100);
    }

    /**
     * Scope for active archives.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for complete archives.
     */
    public function scopeComplete($query)
    {
        return $query->where('is_complete', true);
    }

    /**
     * Scope for incomplete archives.
     */
    public function scopeIncomplete($query)
    {
        return $query->where('is_complete', false);
    }
}
