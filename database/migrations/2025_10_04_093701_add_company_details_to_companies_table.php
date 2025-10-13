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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('ceo_name')->nullable(); // نام مدیر عامل
            $table->string('ceo_national_id')->nullable(); // کد ملی مدیر عامل
            $table->string('postal_code')->nullable(); // کد پستی
            $table->string('fax')->nullable(); // فکس
            $table->text('full_address')->nullable(); // آدرس کامل
            $table->string('registration_authority')->nullable(); // مرجع ثبت
            $table->string('registration_date')->nullable(); // تاریخ ثبت
            $table->string('company_type')->nullable(); // نوع شرکت
            $table->string('capital')->nullable(); // سرمایه
            $table->text('activity_description')->nullable(); // شرح فعالیت
            $table->timestamp('last_sajar_sync')->nullable(); // آخرین همگام‌سازی از ساجر
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn([
                'ceo_name',
                'ceo_national_id',
                'postal_code',
                'fax',
                'full_address',
                'registration_authority',
                'registration_date',
                'company_type',
                'capital',
                'activity_description',
                'last_sajar_sync'
            ]);
        });
    }
};
