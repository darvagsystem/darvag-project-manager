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
        Schema::create('employee_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('project_employee_id')->constrained()->onDelete('cascade');
            $table->date('attendance_date'); // Gregorian date for database storage
            $table->string('persian_date'); // Persian date for display
            $table->enum('status', ['present', 'absent', 'late', 'half_day', 'vacation', 'sick_leave'])->default('present');
            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();
            $table->integer('working_hours')->nullable(); // in minutes
            $table->text('notes')->nullable();
            $table->timestamps();

            // Ensure unique attendance per employee per project per date
            $table->unique(['project_id', 'employee_id', 'attendance_date'], 'emp_att_proj_emp_date_unique');

            // Indexes for better performance
            $table->index(['project_id', 'attendance_date']);
            $table->index(['employee_id', 'attendance_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_attendances');
    }
};
