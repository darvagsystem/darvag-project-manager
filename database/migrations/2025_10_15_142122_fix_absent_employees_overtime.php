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
        // Fix existing records where absent employees have overtime hours
        \DB::table('employee_attendances')
            ->where('status', 'absent')
            ->update([
                'working_hours' => 0,
                'overtime_hours' => 0,
                'useful_hours' => 0,
                'check_in_time' => null,
                'check_out_time' => null,
                'updated_at' => now()
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
