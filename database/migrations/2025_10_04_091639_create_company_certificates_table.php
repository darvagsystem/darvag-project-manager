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
        Schema::create('company_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->integer('sajar_company_id'); // CompanyID از API ساجر
            $table->integer('certificate_id'); // CertificateID از API ساجر
            $table->integer('certificate_type_id'); // CertificateTypeID
            $table->string('certificate_type_name'); // CertificateTypeName
            $table->string('certificate_status_name'); // CertificateStatusName
            $table->integer('certificate_status_id'); // CertificateStatusID
            $table->integer('registration_province_id'); // RegistrationProvinceID
            $table->string('registration_province_name'); // RegistrationProvinceName
            $table->string('tax_number'); // TaxNumber
            $table->string('province_name'); // ProvinceName
            $table->integer('issue_date'); // IssueDate
            $table->integer('expire_date'); // ExpireDate
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();

            $table->unique(['company_id', 'certificate_id']);
            $table->index(['sajar_company_id', 'certificate_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_certificates');
    }
};
