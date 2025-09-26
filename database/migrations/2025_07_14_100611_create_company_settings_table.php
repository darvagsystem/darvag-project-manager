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
        Schema::create('company_settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->default('شرکت کاخ‌سازان داروگ');
            $table->text('company_address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('ceo_name')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('national_id')->nullable();
            $table->string('economic_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('company_settings')->insert([
            'company_name' => 'شرکت کاخ‌سازان داروگ',
            'company_address' => 'مشهد، خیابان امام رضا، پلاک 123',
            'postal_code' => '9185113456',
            'ceo_name' => 'احمد محمدی',
            'phone' => '051-38234567',
            'email' => 'info@darvag.com',
            'website' => 'www.darvag.com',
            'description' => 'پیشرو در صنعت ساختمان و مهندسی با بیش از 15 سال سابقه درخشان',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_settings');
    }
};
