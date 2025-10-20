<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing half_day records to have 4 hours working time
        DB::table('employee_attendances')
            ->where('status', 'half_day')
            ->update([
                'working_hours' => 4,
                'useful_hours' => 4,
                'overtime_hours' => 0
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse this migration
    }
};
