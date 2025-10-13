<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentCategory;
use Illuminate\Support\Str;

class DocumentCategorySampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing categories (only if no documents exist)
        if (DocumentCategory::count() > 0) {
            $this->command->info('Categories already exist. Skipping seeding.');
            return;
        }

        $categories = [
            [
                'name' => 'شرکت نفت و گاز شرق',
                'icon' => 'mdi mdi-oil',
                'color' => '#ef4444',
                'children' => [
                    [
                        'name' => 'واحد حسابداری',
                        'icon' => 'mdi mdi-calculator',
                        'children' => [
                            ['name' => 'گزارش‌های مالی ماهانه', 'icon' => 'mdi mdi-chart-line'],
                            ['name' => 'بودجه‌بندی', 'icon' => 'mdi mdi-cash-multiple'],
                            ['name' => 'کنترل هزینه‌ها', 'icon' => 'mdi mdi-currency-usd'],
                        ]
                    ],
                    [
                        'name' => 'واحد منابع انسانی',
                        'icon' => 'mdi mdi-account-group',
                        'children' => [
                            ['name' => 'فرم‌های استخدام', 'icon' => 'mdi mdi-account-plus'],
                            ['name' => 'قراردادهای کار', 'icon' => 'mdi mdi-file-sign'],
                            ['name' => 'ارزیابی عملکرد', 'icon' => 'mdi mdi-star'],
                        ]
                    ],
                    [
                        'name' => 'واحد فنی',
                        'icon' => 'mdi mdi-cog',
                        'children' => [
                            ['name' => 'گزارش‌های فنی', 'icon' => 'mdi mdi-file-document'],
                            ['name' => 'نقشه‌ها و طرح‌ها', 'icon' => 'mdi mdi-drawing'],
                            ['name' => 'استانداردها', 'icon' => 'mdi mdi-check-decagram'],
                        ]
                    ],
                    [
                        'name' => 'واحد امنیت',
                        'icon' => 'mdi mdi-shield-check',
                        'children' => [
                            ['name' => 'دستورالعمل‌های امنیتی', 'icon' => 'mdi mdi-security'],
                            ['name' => 'گزارش‌های حوادث', 'icon' => 'mdi mdi-alert'],
                            ['name' => 'آموزش‌های امنیتی', 'icon' => 'mdi mdi-school'],
                        ]
                    ]
                ]
            ],
            [
                'name' => 'پروژه‌های عمرانی',
                'icon' => 'mdi mdi-construction',
                'color' => '#22c55e',
                'children' => [
                    [
                        'name' => 'پروژه‌های ساختمانی',
                        'icon' => 'mdi mdi-home',
                        'children' => [
                            ['name' => 'پلان‌های معماری', 'icon' => 'mdi mdi-drawing'],
                            ['name' => 'محاسبات سازه', 'icon' => 'mdi mdi-calculator'],
                            ['name' => 'تأسیسات', 'icon' => 'mdi mdi-pipe'],
                        ]
                    ],
                    [
                        'name' => 'پروژه‌های راه‌سازی',
                        'icon' => 'mdi mdi-road',
                        'children' => [
                            ['name' => 'نقشه‌های مسیر', 'icon' => 'mdi mdi-map'],
                            ['name' => 'محاسبات ترافیک', 'icon' => 'mdi mdi-car'],
                            ['name' => 'بررسی‌های زیست‌محیطی', 'icon' => 'mdi mdi-leaf'],
                        ]
                    ]
                ]
            ],
            [
                'name' => 'مدارک اداری',
                'icon' => 'mdi mdi-office-building',
                'color' => '#3b82f6',
                'children' => [
                    [
                        'name' => 'نامه‌های اداری',
                        'icon' => 'mdi mdi-email',
                        'children' => [
                            ['name' => 'نامه‌های داخلی', 'icon' => 'mdi mdi-email-outline'],
                            ['name' => 'نامه‌های خارجی', 'icon' => 'mdi mdi-email-open'],
                            ['name' => 'مکاتبات رسمی', 'icon' => 'mdi mdi-file-document-outline'],
                        ]
                    ],
                    [
                        'name' => 'قراردادها',
                        'icon' => 'mdi mdi-file-sign',
                        'children' => [
                            ['name' => 'قراردادهای پیمانکاری', 'icon' => 'mdi mdi-handshake'],
                            ['name' => 'قراردادهای خرید', 'icon' => 'mdi mdi-shopping'],
                            ['name' => 'قراردادهای خدمات', 'icon' => 'mdi mdi-cog'],
                        ]
                    ]
                ]
            ]
        ];

        foreach ($categories as $categoryData) {
            $this->createCategory($categoryData);
        }
    }

    private function createCategory($data, $parentId = null, $level = 0)
    {
        $category = DocumentCategory::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? null,
            'icon' => $data['icon'] ?? 'mdi mdi-folder',
            'color' => $data['color'] ?? '#6b7280',
            'parent_id' => $parentId,
            'sort_order' => $level,
            'is_active' => true,
        ]);

        // Generate code after creation
        $code = $this->generateCode($category);
        $category->update(['code' => $code]);

        // Create children
        if (isset($data['children'])) {
            foreach ($data['children'] as $childData) {
                $this->createCategory($childData, $category->id, $level + 1);
            }
        }

        return $category;
    }

    private function generateCode($category)
    {
        if (!$category->parent_id) {
            return str_pad($category->id, 2, '0', STR_PAD_LEFT);
        }

        $parent = $category->parent;
        $siblings = DocumentCategory::where('parent_id', $category->parent_id)
                                  ->where('id', '<=', $category->id)
                                  ->count();

        return $parent->code . '.' . str_pad($siblings, 2, '0', STR_PAD_LEFT);
    }
}
