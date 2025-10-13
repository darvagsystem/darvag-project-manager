<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TaskStage;

class TaskStageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stages = [
            [
                'name' => 'درخواست',
                'slug' => 'request',
                'description' => 'مرحله اولیه درخواست کار',
                'color' => '#6c757d',
                'icon' => 'mdi-file-document-outline',
                'sort_order' => 1,
                'is_initial' => true,
                'is_final' => false,
                'requires_approval' => false,
                'allowed_transitions' => [2, 3] // می‌تواند به بررسی یا رد برود
            ],
            [
                'name' => 'بررسی',
                'slug' => 'review',
                'description' => 'بررسی و ارزیابی درخواست',
                'color' => '#ffc107',
                'icon' => 'mdi-magnify',
                'sort_order' => 2,
                'is_initial' => false,
                'is_final' => false,
                'requires_approval' => true,
                'allowed_transitions' => [3, 4, 5] // می‌تواند رد، تأیید یا نیاز به اطلاعات بیشتر
            ],
            [
                'name' => 'رد شده',
                'slug' => 'rejected',
                'description' => 'درخواست رد شده است',
                'color' => '#dc3545',
                'icon' => 'mdi-close-circle',
                'sort_order' => 3,
                'is_initial' => false,
                'is_final' => true,
                'requires_approval' => false,
                'allowed_transitions' => [1] // می‌تواند دوباره درخواست شود
            ],
            [
                'name' => 'نیاز به اطلاعات',
                'slug' => 'needs_info',
                'description' => 'نیاز به اطلاعات بیشتر',
                'color' => '#17a2b8',
                'icon' => 'mdi-information',
                'sort_order' => 4,
                'is_initial' => false,
                'is_final' => false,
                'requires_approval' => false,
                'allowed_transitions' => [1, 2, 5] // می‌تواند به درخواست، بررسی یا تأیید برود
            ],
            [
                'name' => 'تأیید شده',
                'slug' => 'approved',
                'description' => 'درخواست تأیید شده و آماده اجرا',
                'color' => '#28a745',
                'icon' => 'mdi-check-circle',
                'sort_order' => 5,
                'is_initial' => false,
                'is_final' => false,
                'requires_approval' => false,
                'allowed_transitions' => [6, 7] // می‌تواند شروع یا برنامه‌ریزی شود
            ],
            [
                'name' => 'در حال برنامه‌ریزی',
                'slug' => 'planning',
                'description' => 'برنامه‌ریزی و آماده‌سازی برای اجرا',
                'color' => '#007bff',
                'icon' => 'mdi-calendar-clock',
                'sort_order' => 6,
                'is_initial' => false,
                'is_final' => false,
                'requires_approval' => false,
                'allowed_transitions' => [7, 8, 5] // می‌تواند شروع، مسدود یا برگشت به تأیید
            ],
            [
                'name' => 'در حال اجرا',
                'slug' => 'in_progress',
                'description' => 'کار در حال اجرا است',
                'color' => '#fd7e14',
                'icon' => 'mdi-play-circle',
                'sort_order' => 7,
                'is_initial' => false,
                'is_final' => false,
                'requires_approval' => false,
                'allowed_transitions' => [8, 9, 10] // می‌تواند مسدود، تست یا تکمیل شود
            ],
            [
                'name' => 'مسدود شده',
                'slug' => 'blocked',
                'description' => 'کار مسدود شده است',
                'color' => '#6f42c1',
                'icon' => 'mdi-pause-circle',
                'sort_order' => 8,
                'is_initial' => false,
                'is_final' => false,
                'requires_approval' => false,
                'allowed_transitions' => [7, 3] // می‌تواند ادامه یا رد شود
            ],
            [
                'name' => 'در حال تست',
                'slug' => 'testing',
                'description' => 'کار در حال تست و بررسی نهایی',
                'color' => '#20c997',
                'icon' => 'mdi-test-tube',
                'sort_order' => 9,
                'is_initial' => false,
                'is_final' => false,
                'requires_approval' => true,
                'allowed_transitions' => [11, 7, 8] // می‌تواند تکمیل، برگشت به اجرا یا مسدود شود
            ],
            [
                'name' => 'تکمیل شده',
                'slug' => 'completed',
                'description' => 'کار با موفقیت تکمیل شده است',
                'color' => '#28a745',
                'icon' => 'mdi-check-circle-outline',
                'sort_order' => 10,
                'is_initial' => false,
                'is_final' => true,
                'requires_approval' => false,
                'allowed_transitions' => [] // مرحله نهایی
            ],
            [
                'name' => 'نیاز به اصلاح',
                'slug' => 'needs_revision',
                'description' => 'کار نیاز به اصلاح دارد',
                'color' => '#ff6b6b',
                'icon' => 'mdi-alert-circle',
                'sort_order' => 11,
                'is_initial' => false,
                'is_final' => false,
                'requires_approval' => false,
                'allowed_transitions' => [7, 3] // می‌تواند دوباره اجرا یا رد شود
            ]
        ];

        foreach ($stages as $stage) {
            TaskStage::create($stage);
        }
    }
}
