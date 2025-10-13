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
        Schema::create('document_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // نام دسته‌بندی
            $table->string('slug')->unique(); // اسلاگ
            $table->string('code')->unique(); // کد دسته‌بندی
            $table->text('description')->nullable(); // توضیحات
            $table->string('color')->default('#6c757d'); // رنگ
            $table->string('icon')->nullable(); // آیکون
            $table->foreignId('parent_id')->nullable()->constrained('document_categories')->onDelete('cascade'); // دسته‌بندی والد
            $table->integer('sort_order')->default(0); // ترتیب
            $table->boolean('is_active')->default(true); // آیا فعال است
            $table->timestamps();

            // Indexes
            $table->index(['is_active', 'sort_order']);
            $table->index(['parent_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_categories');
    }
};
