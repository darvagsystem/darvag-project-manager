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
        Schema::create('archive_folders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('archive_id')->constrained('archives')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('archive_folders')->onDelete('cascade');
            $table->string('name'); // نام پوشه
            $table->string('path'); // مسیر کامل پوشه
            $table->text('description')->nullable(); // توضیحات پوشه
            $table->integer('sort_order')->default(0); // ترتیب نمایش
            $table->boolean('is_required')->default(false); // آیا پوشه الزامی است؟
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['archive_id', 'parent_id']);
            $table->index(['archive_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archive_folders');
    }
};
