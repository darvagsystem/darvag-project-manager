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
        Schema::create('archives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('name'); // نام بایگانی (معمولاً همان نام پروژه)
            $table->text('description')->nullable(); // توضیحات بایگانی
            $table->string('status')->default('active'); // active, archived, locked
            $table->boolean('is_complete')->default(false); // آیا بایگانی کامل است؟
            $table->json('completion_status')->nullable(); // وضعیت تکمیل فایل‌های الزامی
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['project_id', 'status']);
            $table->unique('project_id'); // هر پروژه فقط یک بایگانی دارد
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archives');
    }
};
