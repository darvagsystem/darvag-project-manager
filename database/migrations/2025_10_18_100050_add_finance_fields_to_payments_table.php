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
        Schema::table('payments', function (Blueprint $table) {
            $table->enum('finance_type', ['income', 'expense'])->default('expense')->after('payment_type_id');
            $table->string('finance_category')->nullable()->after('finance_type');
            $table->boolean('is_billable')->default(false)->after('finance_category');
            $table->decimal('tax_amount', 15, 2)->nullable()->after('is_billable');
            $table->decimal('discount_amount', 15, 2)->nullable()->after('tax_amount');
            $table->decimal('net_amount', 15, 2)->nullable()->after('discount_amount');

            $table->index(['finance_type', 'finance_category']);
            $table->index('is_billable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['finance_type', 'finance_category']);
            $table->dropIndex(['is_billable']);
            $table->dropColumn([
                'finance_type',
                'finance_category',
                'is_billable',
                'tax_amount',
                'discount_amount',
                'net_amount'
            ]);
        });
    }
};
