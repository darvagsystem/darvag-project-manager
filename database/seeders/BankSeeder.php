<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bank;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            ['name' => 'بانک ملی ایران', 'is_active' => true],
            ['name' => 'بانک سپه', 'is_active' => true],
            ['name' => 'بانک کشاورزی', 'is_active' => true],
            ['name' => 'بانک صنعت و معدن', 'is_active' => true],
            ['name' => 'بانک تجارت', 'is_active' => true],
            ['name' => 'بانک صادرات ایران', 'is_active' => true],
            ['name' => 'بانک ملت', 'is_active' => true],
            ['name' => 'بانک پارسیان', 'is_active' => true],
            ['name' => 'بانک پاسارگاد', 'is_active' => true],
            ['name' => 'بانک سامان', 'is_active' => true],
            ['name' => 'بانک اقتصاد نوین', 'is_active' => true],
            ['name' => 'بانک دی', 'is_active' => true],
            ['name' => 'بانک سینا', 'is_active' => true],
            ['name' => 'بانک شهر', 'is_active' => true],
            ['name' => 'بانک گردشگری', 'is_active' => true],
            ['name' => 'بانک قرض‌الحسنه مهر ایران', 'is_active' => true],
            ['name' => 'بانک انصار', 'is_active' => true],
            ['name' => 'بانک آینده', 'is_active' => true],
            ['name' => 'بانک کارآفرین', 'is_active' => true],
            ['name' => 'بانک ایران زمین', 'is_active' => true],
            ['name' => 'بانک خاورمیانه', 'is_active' => true],
            ['name' => 'بانک کوثر', 'is_active' => true],
            ['name' => 'بانک مهر اقتصاد', 'is_active' => true],
            ['name' => 'بانک پست بانک ایران', 'is_active' => true],
            ['name' => 'بانک توسعه تعاون', 'is_active' => true],
            ['name' => 'بانک قوامین', 'is_active' => true],
            ['name' => 'بانک حکمت ایرانیان', 'is_active' => true],
            ['name' => 'بانک آریا', 'is_active' => true],
            ['name' => 'بانک کیش', 'is_active' => true],
            ['name' => 'بانک تات', 'is_active' => true],
        ];

        foreach ($banks as $bank) {
            Bank::create($bank);
        }
    }
}
