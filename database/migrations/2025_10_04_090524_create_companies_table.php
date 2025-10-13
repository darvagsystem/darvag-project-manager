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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // نام شرکت
            $table->string('national_id')->unique(); // شناسه ملی شرکت
            $table->string('registration_number')->nullable(); // شماره ثبت
            $table->string('economic_code')->nullable(); // کد اقتصادی
            $table->string('phone')->nullable(); // تلفن
            $table->string('email')->nullable(); // ایمیل
            $table->text('address')->nullable(); // آدرس
            $table->string('website')->nullable(); // وب‌سایت
            $table->text('description')->nullable(); // توضیحات
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active'); // وضعیت
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
