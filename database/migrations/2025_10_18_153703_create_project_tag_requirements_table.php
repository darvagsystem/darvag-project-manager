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
        Schema::create('project_tag_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('tag_id')->constrained('tags')->onDelete('cascade');
            $table->boolean('is_required')->default(true); // آیا این تگ برای پروژه الزامی است؟
            $table->text('description')->nullable(); // توضیحات الزام
            $table->integer('priority')->default(1); // اولویت (1=بالا، 2=متوسط، 3=پایین)
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['project_id', 'tag_id']); // هر پروژه فقط یک بار می‌تواند یک تگ را الزامی کند
            $table->index(['project_id', 'is_required']);
            $table->index(['tag_id', 'is_required']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_tag_requirements');
    }
};
