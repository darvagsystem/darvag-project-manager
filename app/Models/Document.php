<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    protected $fillable = [
        'form_code',
        'title',
        'description',
        'category_id',
        'file_type',
        'file_size',
        'file_path',
        'thumbnail_path',
        'tags',
        'metadata',
        'is_template',
        'is_active',
        'download_count',
        'view_count',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'tags' => 'array',
        'metadata' => 'array',
        'is_template' => 'boolean',
        'is_active' => 'boolean',
        'download_count' => 'integer',
        'view_count' => 'integer'
    ];

    /**
     * Get the category that owns the document
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(DocumentCategory::class);
    }

    /**
     * Get the user who created the document
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the document
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get all versions of this document
     */
    public function versions(): HasMany
    {
        return $this->hasMany(DocumentVersion::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get the current version
     */
    public function currentVersion(): HasMany
    {
        return $this->hasMany(DocumentVersion::class)->where('is_current', true);
    }

    /**
     * Get the latest version
     */
    public function latestVersion(): HasMany
    {
        return $this->hasMany(DocumentVersion::class)->latest();
    }

    /**
     * Generate form code if not provided
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($document) {
            if (empty($document->form_code)) {
                $document->form_code = 'DOC-' . strtoupper(Str::random(8));
            }
        });
    }

    /**
     * Get file URL
     */
    public function getFileUrlAttribute(): string
    {
        return $this->file_path ? Storage::url($this->file_path) : '';
    }

    /**
     * Get thumbnail URL
     */
    public function getThumbnailUrlAttribute(): string
    {
        return $this->thumbnail_path ? Storage::url($this->thumbnail_path) : '';
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
     * Get file icon based on type
     */
    public function getFileIconAttribute(): string
    {
        $icons = [
            'pdf' => 'mdi-file-pdf-box',
            'doc' => 'mdi-file-word-box',
            'docx' => 'mdi-file-word-box',
            'xls' => 'mdi-file-excel-box',
            'xlsx' => 'mdi-file-excel-box',
            'ppt' => 'mdi-file-powerpoint-box',
            'pptx' => 'mdi-file-powerpoint-box',
            'txt' => 'mdi-file-document-outline',
            'zip' => 'mdi-folder-zip',
            'rar' => 'mdi-folder-zip',
            'jpg' => 'mdi-file-image',
            'jpeg' => 'mdi-file-image',
            'png' => 'mdi-file-image',
            'gif' => 'mdi-file-image',
            'bmp' => 'mdi-file-image',
            'svg' => 'mdi-file-image',
            'mp4' => 'mdi-file-video',
            'avi' => 'mdi-file-video',
            'mov' => 'mdi-file-video',
            'mp3' => 'mdi-file-music',
            'wav' => 'mdi-file-music',
            'flac' => 'mdi-file-music',
        ];

        // Try to get extension from file_type first
        $extension = strtolower($this->file_type ?? '');

        // If file_type is MIME type, extract extension
        if (strpos($extension, '/') !== false) {
            $mimeToExt = [
                'application/pdf' => 'pdf',
                'application/msword' => 'doc',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
                'application/vnd.ms-excel' => 'xls',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
                'application/vnd.ms-powerpoint' => 'ppt',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
                'text/plain' => 'txt',
                'application/zip' => 'zip',
                'application/x-rar-compressed' => 'rar',
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/gif' => 'gif',
                'video/mp4' => 'mp4',
                'audio/mpeg' => 'mp3',
            ];
            $extension = $mimeToExt[$extension] ?? '';
        }

        // If still empty, try to get extension from file_path
        if (empty($extension)) {
            $path = $this->file_path ?? '';
            $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        }

        return $icons[$extension] ?? 'mdi-file-document-outline';
    }

    /**
     * Increment download count
     */
    public function incrementDownloadCount(): void
    {
        $this->increment('download_count');
    }

    /**
     * Increment view count
     */
    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    /**
     * Search documents
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('form_code', 'like', "%{$search}%")
              ->orWhereJsonContains('tags', $search);
        });
    }

    /**
     * Filter by category
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Filter by file type
     */
    public function scopeByFileType($query, $fileType)
    {
        return $query->where('file_type', $fileType);
    }

    /**
     * Filter by tags
     */
    public function scopeByTag($query, $tag)
    {
        return $query->whereJsonContains('tags', $tag);
    }

    /**
     * Get active documents only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get templates only
     */
    public function scopeTemplates($query)
    {
        return $query->where('is_template', true);
    }

    /**
     * Order by popularity (downloads + views)
     */
    public function scopePopular($query)
    {
        return $query->orderByRaw('(download_count + view_count) DESC');
    }

    /**
     * Order by recent
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }


}
