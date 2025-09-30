<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TagCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'sort_order',
        'is_required',
        'required_for_projects'
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'required_for_projects' => 'array'
    ];

    /**
     * تگ‌های این دسته‌بندی
     */
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    /**
     * ایجاد slug خودکار
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * بررسی اینکه آیا این دسته‌بندی برای پروژه الزامی است
     */
    public function isRequiredForProject(Project $project)
    {
        if (!$this->is_required) {
            return false;
        }

        // اگر دسته‌بندی برای همه پروژه‌ها الزامی است
        if (empty($this->required_for_projects)) {
            return true;
        }

        // بررسی دسته‌بندی پروژه
        return in_array($project->category, $this->required_for_projects);
    }

    /**
     * Scope برای دسته‌بندی‌های الزامی
     */
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }

    /**
     * Scope برای مرتب‌سازی
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}