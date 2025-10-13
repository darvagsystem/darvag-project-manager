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
        Schema::create('document_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('documents')->onDelete('cascade'); // سند
            $table->string('version_number'); // شماره نسخه
            $table->string('version_name')->nullable(); // نام نسخه
            $table->text('changelog')->nullable(); // تغییرات نسخه
            $table->string('file_path'); // مسیر فایل
            $table->string('file_name'); // نام فایل
            $table->string('file_type'); // نوع فایل
            $table->bigInteger('file_size'); // اندازه فایل
            $table->string('file_hash')->nullable(); // هش فایل
            $table->boolean('is_current')->default(false); // آیا نسخه فعلی است
            $table->boolean('is_active')->default(true); // آیا فعال است
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // ایجاد کننده
            $table->timestamps();

            // Indexes
            $table->index(['document_id', 'is_current']);
            $table->index(['document_id', 'created_at']);
            $table->index(['file_hash']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_versions');
    }
};
