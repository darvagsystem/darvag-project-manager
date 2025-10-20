<?php

namespace Database\Seeders;

use App\Models\TaskCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'توسعه نرم‌افزار',
                'description' => 'وظایف مربوط به توسعه و برنامه‌نویسی نرم‌افزار',
                'color' => '#3B82F6',
                'icon' => 'fas fa-code',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'طراحی',
                'description' => 'وظایف مربوط به طراحی UI/UX و گرافیک',
                'color' => '#10B981',
                'icon' => 'fas fa-paint-brush',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'تست و کیفیت',
                'description' => 'وظایف مربوط به تست نرم‌افزار و کنترل کیفیت',
                'color' => '#F59E0B',
                'icon' => 'fas fa-bug',
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'name' => 'مستندسازی',
                'description' => 'وظایف مربوط به نوشتن مستندات فنی و کاربری',
                'color' => '#8B5CF6',
                'icon' => 'fas fa-file-alt',
                'sort_order' => 4,
                'is_active' => true
            ],
            [
                'name' => 'پشتیبانی',
                'description' => 'وظایف مربوط به پشتیبانی و نگهداری سیستم',
                'color' => '#EF4444',
                'icon' => 'fas fa-headset',
                'sort_order' => 5,
                'is_active' => true
            ],
            [
                'name' => 'مدیریت پروژه',
                'description' => 'وظایف مربوط به مدیریت و هماهنگی پروژه',
                'color' => '#06B6D4',
                'icon' => 'fas fa-project-diagram',
                'sort_order' => 6,
                'is_active' => true
            ],
            [
                'name' => 'تحقیق و توسعه',
                'description' => 'وظایف مربوط به تحقیق و توسعه فناوری‌های جدید',
                'color' => '#84CC16',
                'icon' => 'fas fa-flask',
                'sort_order' => 7,
                'is_active' => true
            ],
            [
                'name' => 'عملیات',
                'description' => 'وظایف عملیاتی و اجرایی روزانه',
                'color' => '#F97316',
                'icon' => 'fas fa-cogs',
                'sort_order' => 8,
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            TaskCategory::create($category);
        }
    }
}
