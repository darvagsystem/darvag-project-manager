<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'national_id',
        'registration_number',
        'economic_code',
        'phone',
        'email',
        'address',
        'website',
        'description',
        'status',
        'ceo_name',
        'ceo_national_id',
        'postal_code',
        'fax',
        'full_address',
        'registration_authority',
        'registration_date',
        'company_type',
        'capital',
        'activity_description',
        'last_sajar_sync',
    ];

    protected $casts = [
        'status' => 'string',
        'last_sajar_sync' => 'datetime',
    ];

    // Scope for active companies
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope for inactive companies
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    // Scope for suspended companies
    public function scopeSuspended($query)
    {
        return $query->where('status', 'suspended');
    }

    // Relationship with certificates
    public function certificates()
    {
        return $this->hasMany(CompanyCertificate::class);
    }

    public function contracts()
    {
        return $this->hasMany(CompanyContract::class);
    }

    // Get active certificates
    public function activeCertificates()
    {
        return $this->certificates()->active();
    }

    // Get valid certificates
    public function validCertificates()
    {
        return $this->certificates()->valid();
    }
}
