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
        Schema::table('projects', function (Blueprint $table) {
            // Add missing columns
            $table->enum('currency', ['IRR', 'USD', 'EUR'])->default('IRR')->after('contract_coefficient');
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal')->after('status');
            $table->string('project_manager')->nullable()->after('progress');
            $table->string('location')->nullable()->after('project_manager');
            $table->enum('category', ['construction', 'industrial', 'infrastructure', 'energy', 'petrochemical', 'other'])->nullable()->after('location');
            $table->text('notes')->nullable()->after('description');

            // Update status enum to include 'planning'
            $table->enum('status', ['planning', 'in_progress', 'completed', 'paused', 'cancelled'])->default('in_progress')->change();

            // Change date columns to string for Persian dates
            $table->string('contract_start_date')->change();
            $table->string('contract_end_date')->change();
            $table->string('actual_start_date')->nullable()->change();
            $table->string('actual_end_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Remove added columns
            $table->dropColumn(['currency', 'priority', 'project_manager', 'location', 'category', 'notes']);

            // Revert status enum
            $table->enum('status', ['in_progress', 'completed', 'paused', 'cancelled'])->default('in_progress')->change();

            // Revert date columns
            $table->date('contract_start_date')->change();
            $table->date('contract_end_date')->change();
            $table->date('actual_start_date')->nullable()->change();
            $table->date('actual_end_date')->nullable()->change();
        });
    }
};
