<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class ArchiveFile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'archive_id',
        'folder_id',
        'name',
        'original_name',
        'file_path',
        'file_name',
        'file_size',
        'mime_type',
        'extension',
        'description',
        'is_required',
        'tag_requirements',
        'uploaded_by'
    ];

    protected $casts = [
        'tag_requirements' => 'array',
        'is_required' => 'boolean'
    ];

    /**
     * Get the archive that owns the file.
     */
    public function archive(): BelongsTo
    {
        return $this->belongsTo(Archive::class);
    }

    /**
     * Get the folder that contains the file.
     */
    public function folder(): BelongsTo
    {
        return $this->belongsTo(ArchiveFolder::class, 'folder_id');
    }

    /**
     * Get the user who uploaded the file.
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get the tags associated with this file.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'archive_file_tags', 'archive_file_id', 'tag_id');
    }

    /**
     * Get the file URL.
     */
    public function getUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }

    /**
     * Get the file size in human readable format.
     */
    public function getHumanSizeAttribute(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Check if file exists on disk.
     */
    public function exists(): bool
    {
        return Storage::exists($this->file_path);
    }

    /**
     * Delete the file from disk.
     */
    public function deleteFile(): bool
    {
        if ($this->exists()) {
            return Storage::delete($this->file_path);
        }

        return true;
    }

    /**
     * Get file icon based on extension.
     */
    public function getIconAttribute(): string
    {
        $extension = strtolower($this->extension);

        $icons = [
            'pdf' => 'mdi-file-pdf',
            'doc' => 'mdi-file-word',
            'docx' => 'mdi-file-word',
            'xls' => 'mdi-file-excel',
            'xlsx' => 'mdi-file-excel',
            'ppt' => 'mdi-file-powerpoint',
            'pptx' => 'mdi-file-powerpoint',
            'jpg' => 'mdi-file-image',
            'jpeg' => 'mdi-file-image',
            'png' => 'mdi-file-image',
            'gif' => 'mdi-file-image',
            'txt' => 'mdi-file-document',
            'zip' => 'mdi-file-zip',
            'rar' => 'mdi-file-zip',
            'mp4' => 'mdi-file-video',
            'avi' => 'mdi-file-video',
            'mp3' => 'mdi-file-music',
            'wav' => 'mdi-file-music',
        ];

        return $icons[$extension] ?? 'mdi-file';
    }

    /**
     * Scope for required files.
     */
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }

    /**
     * Scope for files with specific tag.
     */
    public function scopeWithTag($query, $tagId)
    {
        return $query->whereJsonContains('tag_requirements', $tagId);
    }
}
