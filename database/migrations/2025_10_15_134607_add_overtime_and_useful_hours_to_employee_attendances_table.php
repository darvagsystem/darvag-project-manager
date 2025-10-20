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
        Schema::table('employee_attendances', function (Blueprint $table) {
            $table->decimal('overtime_hours', 5, 2)->default(0)->after('working_hours')->comment('ساعات اضافه کاری');
            $table->decimal('useful_hours', 5, 2)->default(8)->after('overtime_hours')->comment('ساعات مفید (8 + اضافه کاری)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_attendances', function (Blueprint $table) {
            $table->dropColumn(['overtime_hours', 'useful_hours']);
        });
    }
};
