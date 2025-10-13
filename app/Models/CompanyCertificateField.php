<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyCertificateField extends Model
{
    protected $fillable = [
        'company_certificate_id',
        'certificate_field_id',
        'certificate_field_name',
        'certificate_field_grade',
        'allowed_work_capacity',
        'allowed_rated_capacity',
        'busy_work_capacity',
        'busy_rated_capacity',
        'free_work_capacity',
        'free_rated_capacity',
        'certificate_type_id',
        'score',
        'last_synced_at',
    ];

    protected $casts = [
        'allowed_rated_capacity' => 'integer',
        'busy_rated_capacity' => 'integer',
        'free_rated_capacity' => 'integer',
        'last_synced_at' => 'datetime',
    ];

    public function certificate(): BelongsTo
    {
        return $this->belongsTo(CompanyCertificate::class);
    }

    public function scopeByField($query, $fieldId)
    {
        return $query->where('certificate_field_id', $fieldId);
    }

    public function scopeByGrade($query, $grade)
    {
        return $query->where('certificate_field_grade', $grade);
    }
}
