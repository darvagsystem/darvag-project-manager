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
        Schema::create('file_managers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('original_name')->nullable();
            $table->enum('type', ['file', 'folder'])->default('file');
            $table->string('path')->nullable();
            $table->bigInteger('size')->default(0);
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_folder')->default(false);
            $table->boolean('is_template')->default(false);
            $table->string('folder_color')->nullable();
            $table->json('permissions')->nullable();
            $table->integer('download_count')->default(0);
            $table->timestamp('last_accessed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['parent_id']);
            $table->index(['project_id']);
            $table->index(['uploaded_by']);
            $table->index(['is_folder']);
            $table->index(['is_template']);
            $table->index(['type']);

            // Foreign key constraints
            $table->foreign('parent_id')->references('id')->on('file_managers')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_managers');
    }
};
