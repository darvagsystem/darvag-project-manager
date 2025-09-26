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
        Schema::table('employees', function (Blueprint $table) {
            // Drop the enum columns and recreate them with correct values
            $table->dropColumn(['marital_status', 'education', 'status']);
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->nullable();
            $table->enum('education', ['illiterate', 'elementary', 'middle_school', 'high_school', 'diploma', 'associate', 'bachelor', 'master', 'phd'])->nullable();
            $table->enum('status', ['active', 'vacation', 'inactive', 'terminated'])->default('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['marital_status', 'education', 'status']);
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed']);
            $table->enum('education', ['illiterate', 'primary', 'middle_school', 'high_school', 'diploma', 'associate', 'bachelor', 'master', 'phd']);
            $table->enum('status', ['active', 'inactive', 'resigned', 'fired'])->default('active');
        });
    }
};
