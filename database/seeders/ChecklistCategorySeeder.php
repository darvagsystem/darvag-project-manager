<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChecklistCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultCategories = [
            [
                'name' => 'کارهای روزانه',
                'description' => 'کارهای روزمره و عادی',
                'color' => '#10B981',
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'پروژه‌ها',
                'description' => 'کارهای مربوط به پروژه‌ها',
                'color' => '#3B82F6',
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'شخصی',
                'description' => 'کارهای شخصی',
                'color' => '#8B5CF6',
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'خرید',
                'description' => 'لیست خرید و خریدهای مورد نیاز',
                'color' => '#F59E0B',
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'سفر',
                'description' => 'کارهای مربوط به سفر',
                'color' => '#EF4444',
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        \App\Models\ChecklistCategory::insert($defaultCategories);
    }
}
