<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $defaultTypes = [
            [
                'name' => 'حقوق',
                'code' => 'salary',
                'description' => 'پرداخت حقوق ماهانه پرسنل',
                'icon' => 'fas fa-money-bill-wave',
                'color' => '#28a745',
                'requires_receipt' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'پاداش',
                'code' => 'bonus',
                'description' => 'پاداش و مزایای پرسنل',
                'icon' => 'fas fa-gift',
                'color' => '#ffc107',
                'requires_receipt' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'پیش‌پرداخت',
                'code' => 'advance',
                'description' => 'پیش‌پرداخت قبل از انجام کار',
                'icon' => 'fas fa-hand-holding-usd',
                'color' => '#17a2b8',
                'requires_receipt' => true,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'هزینه',
                'code' => 'expense',
                'description' => 'هزینه‌های عملیاتی پروژه',
                'icon' => 'fas fa-receipt',
                'color' => '#6f42c1',
                'requires_receipt' => true,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'قراردادی',
                'code' => 'contract',
                'description' => 'پرداخت به پیمانکاران و قراردادی‌ها',
                'icon' => 'fas fa-handshake',
                'color' => '#fd7e14',
                'requires_receipt' => true,
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'نقدی',
                'code' => 'cash',
                'description' => 'پرداخت نقدی',
                'icon' => 'fas fa-coins',
                'color' => '#20c997',
                'requires_receipt' => false,
                'sort_order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('payment_types')->insert($defaultTypes);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('payment_types')->truncate();
    }
};
