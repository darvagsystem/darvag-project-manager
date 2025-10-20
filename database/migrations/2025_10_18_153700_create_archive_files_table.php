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
        Schema::create('archive_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('archive_id')->constrained('archives')->onDelete('cascade');
            $table->foreignId('folder_id')->nullable()->constrained('archive_folders')->onDelete('cascade');
            $table->string('name'); // نام فایل
            $table->string('original_name'); // نام اصلی فایل
            $table->string('file_path'); // مسیر فایل در سیستم
            $table->string('file_name'); // نام فایل در سیستم
            $table->bigInteger('file_size'); // حجم فایل
            $table->string('mime_type'); // نوع فایل
            $table->string('extension'); // پسوند فایل
            $table->text('description')->nullable(); // توضیحات فایل
            $table->boolean('is_required')->default(false); // آیا فایل الزامی است؟
            $table->json('tag_requirements')->nullable(); // تگ‌های الزامی برای این فایل
            $table->foreignId('uploaded_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['archive_id', 'folder_id']);
            $table->index(['archive_id', 'is_required']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archive_files');
    }
};
