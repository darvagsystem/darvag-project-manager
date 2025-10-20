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
            $table->unsignedBigInteger('payment_type_id')->nullable()->after('recipient_id');
            $table->foreign('payment_type_id')->references('id')->on('payment_types')->onDelete('set null');
            $table->index('payment_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['payment_type_id']);
            $table->dropIndex(['payment_type_id']);
            $table->dropColumn('payment_type_id');
        });
    }
};
