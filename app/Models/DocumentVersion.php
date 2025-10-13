<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class DocumentVersion extends Model
{
    protected $fillable = [
        'document_id',
        'version_number',
        'version_name',
        'changelog',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'file_hash',
        'is_current',
        'is_active',
        'created_by'
    ];

    protected $casts = [
        'is_current' => 'boolean',
        'is_active' => 'boolean',
        'file_size' => 'integer'
    ];

    /**
     * Get the document that owns this version
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    /**
     * Get the user who created this version
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get file URL
     */
    public function getFileUrlAttribute(): string
    {
        return $this->file_path ? Storage::url($this->file_path) : '';
    }

    /**
     * Get file size in human readable format
     */
    public function getFileSizeHumanAttribute(): string
    {
        if (!$this->file_size) return 'نامشخص';

        $bytes = (int) $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Set as current version
     */
    public function setAsCurrent(): void
    {
        // Remove current flag from other versions
        static::where('document_id', $this->document_id)
              ->where('id', '!=', $this->id)
              ->update(['is_current' => false]);

        // Set this version as current
        $this->update(['is_current' => true]);
    }

    /**
     * Get active versions only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get current version
     */
    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }

    /**
     * Order by version number
     */
    public function scopeOrderByVersion($query)
    {
        return $query->orderByRaw('CAST(version_number AS UNSIGNED) DESC');
    }
}
