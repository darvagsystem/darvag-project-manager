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
        Schema::create('project_incomes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->string('title'); // عنوان درآمد
            $table->text('description')->nullable(); // توضیحات
            $table->decimal('amount', 15, 2); // مبلغ
            $table->string('currency', 3)->default('IRR'); // واحد پول
            $table->date('income_date'); // تاریخ درآمد
            $table->string('income_type'); // نوع درآمد (invoice, advance, milestone, etc.)
            $table->string('status')->default('pending'); // وضعیت (pending, received, partial, cancelled)
            $table->string('reference_number')->nullable(); // شماره مرجع (شماره فاکتور، etc.)
            $table->text('notes')->nullable(); // یادداشت‌ها
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->index(['project_id', 'income_date']);
            $table->index(['status', 'income_date']);
            $table->index('income_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_incomes');
    }
};
