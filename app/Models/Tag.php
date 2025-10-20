<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'color',
        'description',
        'allowed_extensions',
        'allowed_mime_types',
        'is_folder_tag',
        'is_active',
        'category_id'
    ];

    protected $casts = [
        'allowed_extensions' => 'array',
        'allowed_mime_types' => 'array',
        'is_folder_tag' => 'boolean',
        'is_active' => 'boolean'
    ];

    /**
     * دسته‌بندی این تگ
     */
    public function category()
    {
        return $this->belongsTo(TagCategory::class, 'category_id');
    }


    /**
     * دریافت لیست پسوندهای مجاز به صورت متن
     */
    public function getAllowedExtensionsText()
    {
        if (empty($this->allowed_extensions)) {
            return 'همه';
        }
        return implode(', ', $this->allowed_extensions);
    }

    /**
     * دریافت لیست MIME type های مجاز به صورت متن
     */
    public function getAllowedMimeTypesText()
    {
        if (empty($this->allowed_mime_types)) {
            return 'همه';
        }
        return implode(', ', $this->allowed_mime_types);
    }

    /**
     * بررسی اینکه آیا این تگ برای پروژه الزامی است
     */
    public function isRequiredForProject(Project $project)
    {
        if (!$this->category) {
            return false;
        }

        return $this->category->isRequiredForProject($project);
    }

    /**
     * Scope برای تگ‌های با دسته‌بندی خاص
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope برای تگ‌های الزامی
     */
    public function scopeRequired($query)
    {
        return $query->whereHas('category', function($q) {
            $q->where('is_required', true);
        });
    }

    /**
     * Scope برای تگ‌های فعال
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * فایل‌هایی که این تگ را دارند
     */
    public function files()
    {
        return $this->belongsToMany(ArchiveFile::class, 'archive_file_tags', 'tag_id', 'archive_file_id');
    }
}
