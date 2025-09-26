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
        Schema::create('client_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('contact_person');
            $table->string('position');
            $table->string('department');
            $table->string('phone')->nullable();
            $table->string('mobile');
            $table->string('email')->nullable();
            $table->string('extension')->nullable();
            $table->text('address')->nullable();
            $table->text('notes')->nullable();
            $table->enum('preferred_contact', ['phone', 'mobile', 'email'])->nullable();
            $table->string('availability')->nullable();
            $table->enum('priority', ['normal', 'high', 'urgent'])->default('normal');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_contacts');
    }
};
