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
        Schema::create('payment_recipients', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // employee, contractor, supplier, etc.
            $table->unsignedBigInteger('recipient_id'); // ID of the actual recipient
            $table->string('recipient_name'); // Name for display
            $table->string('recipient_code')->nullable(); // Employee code, contractor code, etc.
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('iban')->nullable();
            $table->string('card_number')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['type', 'recipient_id']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_recipients');
    }
};
