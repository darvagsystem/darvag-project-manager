<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArchiveFolder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'archive_id',
        'parent_id',
        'name',
        'path',
        'description',
        'color',
        'sort_order',
        'is_required',
        'created_by'
    ];

    protected $casts = [
        'is_required' => 'boolean'
    ];

    /**
     * Get the archive that owns the folder.
     */
    public function archive(): BelongsTo
    {
        return $this->belongsTo(Archive::class);
    }

    /**
     * Get the parent folder.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ArchiveFolder::class, 'parent_id');
    }

    /**
     * Get the child folders.
     */
    public function children(): HasMany
    {
        return $this->hasMany(ArchiveFolder::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Get the files in this folder.
     */
    public function files(): HasMany
    {
        return $this->hasMany(ArchiveFile::class, 'folder_id')->orderBy('name');
    }

    /**
     * Get the user who created the folder.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the full path including parent folders.
     */
    public function getFullPathAttribute(): string
    {
        $path = $this->name;
        $parent = $this->parent;

        while ($parent) {
            $path = $parent->name . '/' . $path;
            $parent = $parent->parent;
        }

        return $path;
    }

    /**
     * Get all descendants recursively.
     */
    public function getAllDescendants()
    {
        $descendants = collect();

        foreach ($this->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($child->getAllDescendants());
        }

        return $descendants;
    }

    /**
     * Scope for root folders.
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope for required folders.
     */
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }
}
