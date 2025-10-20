<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\TagCategory;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run()
    {
        // Create tag categories
        $categories = [
            [
                'name' => 'بایگانی',
                'description' => 'تگ‌های مربوط به بایگانی',
                'color' => '#6c757d',
                'is_required' => false,
                'sort_order' => 1
            ],
            [
                'name' => 'مستندات',
                'description' => 'تگ‌های مربوط به مستندات',
                'color' => '#007bff',
                'is_required' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'قراردادها',
                'description' => 'تگ‌های مربوط به قراردادها',
                'color' => '#28a745',
                'is_required' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'گزارشات',
                'description' => 'تگ‌های مربوط به گزارشات',
                'color' => '#ffc107',
                'is_required' => false,
                'sort_order' => 4
            ]
        ];

        $createdCategories = [];
        foreach ($categories as $categoryData) {
            $category = TagCategory::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($categoryData['name'])],
                $categoryData
            );
            $createdCategories[$categoryData['name']] = $category->id;
        }

        // Create tags
        $tags = [
            // بایگانی
            [
                'name' => 'مهم',
                'color' => '#dc3545',
                'description' => 'مستندات مهم',
                'category_name' => 'بایگانی',
                'is_folder_tag' => false,
                'is_active' => true,
                'allowed_extensions' => ['pdf', 'doc', 'docx'],
                'allowed_mime_types' => ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']
            ],
            [
                'name' => 'عادی',
                'color' => '#6c757d',
                'description' => 'مستندات عادی',
                'category_name' => 'بایگانی',
                'is_folder_tag' => false,
                'is_active' => true
            ],
            [
                'name' => 'آرشیو',
                'color' => '#17a2b8',
                'description' => 'مستندات آرشیوی',
                'category_name' => 'بایگانی',
                'is_folder_tag' => true,
                'is_active' => true
            ],

            // مستندات
            [
                'name' => 'قرارداد اصلی',
                'color' => '#007bff',
                'description' => 'قرارداد اصلی پروژه',
                'category_name' => 'مستندات',
                'is_folder_tag' => false,
                'is_active' => true,
                'allowed_extensions' => ['pdf'],
                'allowed_mime_types' => ['application/pdf']
            ],
            [
                'name' => 'ضمیمه',
                'color' => '#28a745',
                'description' => 'ضمیمه قرارداد',
                'category_name' => 'مستندات',
                'is_folder_tag' => false,
                'is_active' => true
            ],
            [
                'name' => 'تغییرات',
                'color' => '#ffc107',
                'description' => 'تغییرات قرارداد',
                'category_name' => 'مستندات',
                'is_folder_tag' => false,
                'is_active' => true
            ],

            // قراردادها
            [
                'name' => 'قرارداد کار',
                'color' => '#28a745',
                'description' => 'قرارداد کار',
                'category_name' => 'قراردادها',
                'is_folder_tag' => false,
                'is_active' => true
            ],
            [
                'name' => 'قرارداد پیمان',
                'color' => '#17a2b8',
                'description' => 'قرارداد پیمان',
                'category_name' => 'قراردادها',
                'is_folder_tag' => false,
                'is_active' => true
            ],

            // گزارشات
            [
                'name' => 'گزارش ماهانه',
                'color' => '#ffc107',
                'description' => 'گزارش ماهانه',
                'category_name' => 'گزارشات',
                'is_folder_tag' => false,
                'is_active' => true
            ],
            [
                'name' => 'گزارش نهایی',
                'color' => '#dc3545',
                'description' => 'گزارش نهایی',
                'category_name' => 'گزارشات',
                'is_folder_tag' => false,
                'is_active' => true
            ]
        ];

        foreach ($tags as $tagData) {
            $categoryId = $createdCategories[$tagData['category_name']];
            unset($tagData['category_name']);
            $tagData['category_id'] = $categoryId;

            Tag::firstOrCreate(
                ['name' => $tagData['name'], 'category_id' => $tagData['category_id']],
                $tagData
            );
        }
    }
}
