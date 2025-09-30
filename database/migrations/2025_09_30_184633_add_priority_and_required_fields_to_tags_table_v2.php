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
        if (!Schema::hasColumn('tags', 'priority')) {
            Schema::table('tags', function (Blueprint $table) {
                $table->enum('priority', ['critical', 'high', 'medium', 'low', 'optional'])->default('medium')->after('is_folder_tag');
            });
        }
        
        if (!Schema::hasColumn('tags', 'is_required')) {
            Schema::table('tags', function (Blueprint $table) {
                $table->boolean('is_required')->default(false)->after('priority');
            });
        }
        
        if (!Schema::hasColumn('tags', 'required_for_projects')) {
            Schema::table('tags', function (Blueprint $table) {
                $table->json('required_for_projects')->nullable()->after('is_required');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn(['priority', 'is_required', 'required_for_projects']);
        });
    }
};
