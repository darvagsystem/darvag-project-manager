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
        Schema::create('project_expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->string('title'); // عنوان هزینه
            $table->text('description')->nullable(); // توضیحات
            $table->decimal('amount', 15, 2); // مبلغ
            $table->string('currency', 3)->default('IRR'); // واحد پول
            $table->date('expense_date'); // تاریخ هزینه
            $table->string('expense_type'); // نوع هزینه (material, labor, equipment, etc.)
            $table->string('category'); // دسته‌بندی (operational, administrative, etc.)
            $table->string('status')->default('pending'); // وضعیت (pending, approved, paid, cancelled)
            $table->string('reference_number')->nullable(); // شماره مرجع
            $table->text('notes')->nullable(); // یادداشت‌ها
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->index(['project_id', 'expense_date']);
            $table->index(['status', 'expense_date']);
            $table->index(['expense_type', 'category']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_expenses');
    }
};
