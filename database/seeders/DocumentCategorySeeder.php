<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentCategory;

class DocumentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'فرم‌های استخدام',
                'slug' => 'employment-forms',
                'description' => 'فرم‌های مربوط به استخدام و منابع انسانی',
                'icon' => 'mdi-account-plus',
                'color' => '#10b981',
                'sort_order' => 1,
                'children' => [
                    [
                        'name' => 'فرم درخواست شغل',
                        'slug' => 'job-application-forms',
                        'description' => 'فرم‌های درخواست شغل و رزومه',
                        'icon' => 'mdi-file-document-edit',
                        'color' => '#10b981',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'فرم مصاحبه',
                        'slug' => 'interview-forms',
                        'description' => 'فرم‌های مصاحبه و ارزیابی',
                        'icon' => 'mdi-account-search',
                        'color' => '#10b981',
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'فرم قرارداد',
                        'slug' => 'contract-forms',
                        'description' => 'فرم‌های قرارداد و توافقنامه',
                        'icon' => 'mdi-file-sign',
                        'color' => '#10b981',
                        'sort_order' => 3,
                    ],
                ]
            ],
            [
                'name' => 'فرم‌های مالی',
                'slug' => 'financial-forms',
                'description' => 'فرم‌های مربوط به امور مالی و حسابداری',
                'icon' => 'mdi-cash-multiple',
                'color' => '#f59e0b',
                'sort_order' => 2,
                'children' => [
                    [
                        'name' => 'فرم درخواست پرداخت',
                        'slug' => 'payment-request-forms',
                        'description' => 'فرم‌های درخواست پرداخت و تسویه',
                        'icon' => 'mdi-credit-card',
                        'color' => '#f59e0b',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'فرم فاکتور',
                        'slug' => 'invoice-forms',
                        'description' => 'فرم‌های فاکتور و صورتحساب',
                        'icon' => 'mdi-receipt',
                        'color' => '#f59e0b',
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'فرم گزارش مالی',
                        'slug' => 'financial-report-forms',
                        'description' => 'فرم‌های گزارش‌گیری مالی',
                        'icon' => 'mdi-chart-line',
                        'color' => '#f59e0b',
                        'sort_order' => 3,
                    ],
                ]
            ],
            [
                'name' => 'فرم‌های پروژه',
                'slug' => 'project-forms',
                'description' => 'فرم‌های مربوط به مدیریت پروژه',
                'icon' => 'mdi-folder-multiple',
                'color' => '#3b82f6',
                'sort_order' => 3,
                'children' => [
                    [
                        'name' => 'فرم شروع پروژه',
                        'slug' => 'project-initiation-forms',
                        'description' => 'فرم‌های شروع و راه‌اندازی پروژه',
                        'icon' => 'mdi-play-circle',
                        'color' => '#3b82f6',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'فرم گزارش پیشرفت',
                        'slug' => 'progress-report-forms',
                        'description' => 'فرم‌های گزارش پیشرفت پروژه',
                        'icon' => 'mdi-chart-timeline-variant',
                        'color' => '#3b82f6',
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'فرم خاتمه پروژه',
                        'slug' => 'project-closure-forms',
                        'description' => 'فرم‌های خاتمه و تحویل پروژه',
                        'icon' => 'mdi-check-circle',
                        'color' => '#3b82f6',
                        'sort_order' => 3,
                    ],
                ]
            ],
            [
                'name' => 'فرم‌های کیفیت',
                'slug' => 'quality-forms',
                'description' => 'فرم‌های کنترل کیفیت و استانداردها',
                'icon' => 'mdi-shield-check',
                'color' => '#8b5cf6',
                'sort_order' => 4,
                'children' => [
                    [
                        'name' => 'فرم بازرسی',
                        'slug' => 'inspection-forms',
                        'description' => 'فرم‌های بازرسی و کنترل کیفیت',
                        'icon' => 'mdi-magnify',
                        'color' => '#8b5cf6',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'فرم تست',
                        'slug' => 'test-forms',
                        'description' => 'فرم‌های تست و آزمایش',
                        'icon' => 'mdi-test-tube',
                        'color' => '#8b5cf6',
                        'sort_order' => 2,
                    ],
                ]
            ],
            [
                'name' => 'فرم‌های عمومی',
                'slug' => 'general-forms',
                'description' => 'فرم‌های عمومی و متفرقه',
                'icon' => 'mdi-file-document-multiple',
                'color' => '#6b7280',
                'sort_order' => 5,
                'children' => [
                    [
                        'name' => 'فرم درخواست',
                        'slug' => 'request-forms',
                        'description' => 'فرم‌های درخواست عمومی',
                        'icon' => 'mdi-file-document-edit',
                        'color' => '#6b7280',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'فرم گزارش',
                        'slug' => 'report-forms',
                        'description' => 'فرم‌های گزارش‌گیری عمومی',
                        'icon' => 'mdi-chart-box',
                        'color' => '#6b7280',
                        'sort_order' => 2,
                    ],
                ]
            ],
        ];

        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);

            $category = DocumentCategory::create($categoryData);

            foreach ($children as $childData) {
                $childData['parent_id'] = $category->id;
                DocumentCategory::create($childData);
            }
        }
    }
}
