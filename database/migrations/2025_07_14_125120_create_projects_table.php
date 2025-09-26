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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('client_id');
            $table->string('contract_number')->unique();
            $table->decimal('initial_estimate', 15, 2);
            $table->decimal('final_amount', 15, 2);
            $table->decimal('contract_coefficient', 5, 2);
            $table->string('department');
            $table->date('contract_start_date');
            $table->date('contract_end_date');
            $table->date('actual_start_date')->nullable();
            $table->date('actual_end_date')->nullable();
            $table->enum('status', ['in_progress', 'completed', 'paused', 'cancelled'])->default('in_progress');
            $table->integer('progress')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
