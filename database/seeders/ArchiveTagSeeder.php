<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TagCategory;
use App\Models\Tag;

class ArchiveTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create archive category
        $category = TagCategory::firstOrCreate([
            'name' => 'بایگانی'
        ], [
            'description' => 'تگ‌های مربوط به بایگانی پروژه‌ها',
            'is_required' => false
        ]);

        // Create archive tags
        $tags = [
            ['name' => 'قرارداد', 'color' => '#007bff', 'description' => 'قراردادهای پروژه'],
            ['name' => 'نقشه', 'color' => '#28a745', 'description' => 'نقشه‌های فنی و معماری'],
            ['name' => 'فاکتور', 'color' => '#ffc107', 'description' => 'فاکتورها و مدارک مالی'],
            ['name' => 'گزارش', 'color' => '#17a2b8', 'description' => 'گزارش‌های پیشرفت و عملکرد'],
            ['name' => 'عکس', 'color' => '#6c757d', 'description' => 'عکس‌های پروژه'],
            ['name' => 'مکاتبات', 'color' => '#343a40', 'description' => 'مکاتبات و نامه‌ها'],
            ['name' => 'مجوز', 'color' => '#dc3545', 'description' => 'مجوزها و پروانه‌ها'],
            ['name' => 'نقشه‌برداری', 'color' => '#28a745', 'description' => 'نقشه‌برداری و نقشه‌کشی']
        ];

        foreach ($tags as $tagData) {
            Tag::firstOrCreate([
                'name' => $tagData['name']
            ], [
                'color' => $tagData['color'],
                'description' => $tagData['description'],
                'is_active' => true,
                'category_id' => $category->id
            ]);
        }
    }
}
