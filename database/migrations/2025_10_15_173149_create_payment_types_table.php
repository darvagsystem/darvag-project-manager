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
        Schema::create('payment_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // نام نوع پرداخت
            $table->string('code')->unique(); // کد یکتا
            $table->text('description')->nullable(); // توضیحات
            $table->string('icon')->nullable(); // آیکون
            $table->string('color')->default('#007bff'); // رنگ
            $table->boolean('is_active')->default(true); // فعال/غیرفعال
            $table->boolean('requires_receipt')->default(true); // نیاز به فیش
            $table->integer('sort_order')->default(0); // ترتیب نمایش
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_types');
    }
};
