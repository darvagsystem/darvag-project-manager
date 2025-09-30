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
        'is_folder_tag'
    ];

    protected $casts = [
        'allowed_extensions' => 'array',
        'allowed_mime_types' => 'array',
        'is_folder_tag' => 'boolean'
    ];

    /**
     * فایل‌های مرتبط با این تگ
     */
    public function files()
    {
        return $this->belongsToMany(FileManager::class, 'file_manager_tag');
    }

    /**
     * بررسی اینکه آیا فایل با این تگ سازگار است یا نه
     */
    public function isCompatibleWithFile(FileManager $file)
    {
        // اگر تگ مخصوص پوشه است
        if ($this->is_folder_tag && !$file->is_folder) {
            return false;
        }

        // اگر تگ مخصوص فایل است و فایل، پوشه است
        if (!$this->is_folder_tag && $file->is_folder) {
            return false;
        }

        // اگر پسوندهای مجاز تعریف شده
        if (!empty($this->allowed_extensions)) {
            $fileExtension = strtolower(pathinfo($file->name, PATHINFO_EXTENSION));
            if (!in_array($fileExtension, $this->allowed_extensions)) {
                return false;
            }
        }

        // اگر MIME type های مجاز تعریف شده
        if (!empty($this->allowed_mime_types) && $file->mime_type) {
            if (!in_array($file->mime_type, $this->allowed_mime_types)) {
                return false;
            }
        }

        return true;
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
}
