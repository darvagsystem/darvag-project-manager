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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // عنوان کار
            $table->text('description')->nullable(); // توضیحات
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium'); // اولویت
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending'); // وضعیت
            $table->enum('type', ['task', 'reminder', 'meeting', 'deadline'])->default('task'); // نوع کار
            $table->date('due_date')->nullable(); // تاریخ موعد
            $table->time('due_time')->nullable(); // زمان موعد
            $table->integer('estimated_hours')->nullable(); // ساعت تخمینی
            $table->integer('actual_hours')->nullable(); // ساعت واقعی
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('cascade'); // پروژه مربوطه
            $table->foreignId('assigned_to')->nullable()->constrained('employees')->onDelete('set null'); // واگذار شده به
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // ایجاد شده توسط
            $table->json('tags')->nullable(); // تگ‌ها
            $table->text('notes')->nullable(); // یادداشت‌ها
            $table->boolean('is_reminder')->default(false); // آیا یادآوری است
            $table->timestamp('reminder_at')->nullable(); // زمان یادآوری
            $table->boolean('is_recurring')->default(false); // آیا تکرار شونده است
            $table->json('recurring_settings')->nullable(); // تنظیمات تکرار
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
