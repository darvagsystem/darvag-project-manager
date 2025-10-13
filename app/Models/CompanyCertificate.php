<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompanyCertificate extends Model
{
    protected $fillable = [
        'company_id',
        'sajar_company_id',
        'certificate_id',
        'certificate_type_id',
        'certificate_type_name',
        'certificate_status_name',
        'certificate_status_id',
        'registration_province_id',
        'registration_province_name',
        'tax_number',
        'province_name',
        'issue_date',
        'expire_date',
        'is_active',
        'last_synced_at',
    ];

    protected $casts = [
        'issue_date' => 'integer',
        'expire_date' => 'integer',
        'is_active' => 'boolean',
        'last_synced_at' => 'datetime',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function fields(): HasMany
    {
        return $this->hasMany(CompanyCertificateField::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $typeId)
    {
        return $query->where('certificate_type_id', $typeId);
    }

    public function scopeValid($query)
    {
        $currentDate = now()->format('Ymd');
        return $query->where('expire_date', '>', $currentDate);
    }
}
