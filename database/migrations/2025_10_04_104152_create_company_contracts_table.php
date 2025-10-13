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
        Schema::create('company_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('contract_number')->unique(); // شماره قرارداد
            $table->string('contract_title'); // عنوان قرارداد
            $table->text('description')->nullable(); // توضیحات
            $table->decimal('amount', 15, 2)->nullable(); // مبلغ قرارداد
            $table->string('currency', 3)->default('IRR'); // ارز
            $table->date('start_date')->nullable(); // تاریخ شروع
            $table->date('end_date')->nullable(); // تاریخ پایان
            $table->enum('status', ['draft', 'active', 'completed', 'cancelled', 'suspended'])->default('draft');
            $table->string('contract_type')->nullable(); // نوع قرارداد
            $table->string('contract_category')->nullable(); // دسته‌بندی قرارداد
            $table->string('external_id')->nullable(); // شناسه در سامانه جامع قراردادها
            $table->json('external_data')->nullable(); // داده‌های اضافی از سامانه خارجی
            $table->timestamp('last_synced_at')->nullable(); // آخرین همگام‌سازی
            $table->timestamps();

            $table->index(['company_id', 'status']);
            $table->index(['contract_number']);
            $table->index(['external_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_contracts');
    }
};
