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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('form_code')->unique(); // کد فرم
            $table->string('title'); // عنوان سند
            $table->text('description')->nullable(); // توضیحات
            $table->foreignId('category_id')->nullable()->constrained('document_categories')->onDelete('set null'); // دسته‌بندی
            $table->string('file_type')->nullable(); // نوع فایل
            $table->bigInteger('file_size')->nullable(); // اندازه فایل
            $table->string('file_path')->nullable(); // مسیر فایل
            $table->string('thumbnail_path')->nullable(); // مسیر تصویر کوچک
            $table->json('tags')->nullable(); // برچسب‌ها
            $table->json('metadata')->nullable(); // متادیتا
            $table->boolean('is_template')->default(false); // آیا قالب است
            $table->boolean('is_active')->default(true); // آیا فعال است
            $table->integer('download_count')->default(0); // تعداد دانلود
            $table->integer('view_count')->default(0); // تعداد مشاهده
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // ایجاد کننده
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null'); // به‌روزرسانی کننده
            $table->timestamps();

            // Indexes
            $table->index(['is_active', 'is_template']);
            $table->index(['category_id', 'is_active']);
            $table->index(['file_type', 'is_active']);
            $table->index(['created_by', 'is_active']);
            $table->index(['download_count', 'view_count']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
