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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('recipient_id'); // payment_recipients.id
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('IRR');
            $table->string('payment_method'); // bank_transfer, cash, check, etc.
            $table->string('payment_type'); // salary, bonus, advance, expense, etc.
            $table->text('description')->nullable();
            $table->date('payment_date');
            $table->string('reference_number')->nullable(); // Bank reference, check number, etc.
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('recipient_id')->references('id')->on('payment_recipients')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->index(['project_id', 'payment_date']);
            $table->index(['recipient_id', 'payment_date']);
            $table->index('status');
            $table->index('payment_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
