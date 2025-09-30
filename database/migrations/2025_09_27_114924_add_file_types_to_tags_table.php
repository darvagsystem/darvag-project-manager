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
        Schema::table('tags', function (Blueprint $table) {
            $table->json('allowed_extensions')->nullable()->after('description');
            $table->json('allowed_mime_types')->nullable()->after('allowed_extensions');
            $table->boolean('is_folder_tag')->default(false)->after('allowed_mime_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn(['allowed_extensions', 'allowed_mime_types', 'is_folder_tag']);
        });
    }
};