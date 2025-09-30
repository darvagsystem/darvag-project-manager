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
        Schema::create('file_manager_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('file_manager_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();

            $table->foreign('file_manager_id')->references('id')->on('file_manager')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->unique(['file_manager_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_manager_tag');
    }
};
