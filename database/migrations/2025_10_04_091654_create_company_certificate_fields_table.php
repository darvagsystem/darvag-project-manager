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
        Schema::create('company_certificate_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_certificate_id')->constrained()->onDelete('cascade');
            $table->integer('certificate_field_id'); // CertificateFieldID از API ساجر
            $table->string('certificate_field_name'); // CertificateFieldName
            $table->integer('certificate_field_grade'); // CertificateFieldGrade
            $table->integer('allowed_work_capacity'); // AllowedWorkCapacity
            $table->bigInteger('allowed_rated_capacity'); // AllowedRatedCapacity
            $table->integer('busy_work_capacity'); // BusyWorkCapacity
            $table->bigInteger('busy_rated_capacity'); // BusyRatedCapacity
            $table->integer('free_work_capacity'); // FreeWorkCapacity
            $table->bigInteger('free_rated_capacity'); // FreeRatedCapacity
            $table->integer('certificate_type_id'); // CertificateTypeID
            $table->integer('score'); // Score
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();

            $table->unique(['company_certificate_id', 'certificate_field_id'], 'ccf_cert_field_unique');
            $table->index(['certificate_field_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_certificate_fields');
    }
};
