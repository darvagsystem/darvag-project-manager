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
        'priority',
        'is_required',
        'required_for_projects'
    ];

    protected $casts = [
        'allowed_extensions' => 'array',
        'allowed_mime_types' => 'array',
        'is_folder_tag' => 'boolean',
        'is_required' => 'boolean',
        'required_for_projects' => 'array'
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

    /**
     * دریافت متن اولویت
     */
    public function getPriorityText()
    {
        return match($this->priority) {
            'critical' => 'بحرانی',
            'high' => 'بالا',
            'medium' => 'متوسط',
            'low' => 'پایین',
            'optional' => 'اختیاری',
            default => 'متوسط'
        };
    }

    /**
     * دریافت کلاس CSS برای اولویت
     */
    public function getPriorityClass()
    {
        return match($this->priority) {
            'critical' => 'danger',
            'high' => 'warning',
            'medium' => 'info',
            'low' => 'secondary',
            'optional' => 'light',
            default => 'info'
        };
    }

    /**
     * بررسی اینکه آیا این تگ برای پروژه الزامی است
     */
    public function isRequiredForProject(Project $project)
    {
        if (!$this->is_required) {
            return false;
        }

        // اگر تگ برای همه پروژه‌ها الزامی است
        if (empty($this->required_for_projects)) {
            return true;
        }

        // بررسی دسته‌بندی پروژه
        return in_array($project->category, $this->required_for_projects);
    }

    /**
     * Scope برای تگ‌های الزامی
     */
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }

    /**
     * Scope برای تگ‌های با اولویت خاص
     */
    public function scopePriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope برای تگ‌های بحرانی
     */
    public function scopeCritical($query)
    {
        return $query->where('priority', 'critical');
    }
}
