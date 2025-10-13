<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyContract extends Model
{
    protected $fillable = [
        'company_id',
        'contract_number',
        'contract_title',
        'description',
        'amount',
        'currency',
        'start_date',
        'end_date',
        'status',
        'contract_type',
        'contract_category',
        'external_id',
        'external_data',
        'last_synced_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'external_data' => 'array',
        'last_synced_at' => 'datetime',
    ];

    /**
     * رابطه با شرکت
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * اسکوپ برای قراردادهای فعال
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * اسکوپ برای قراردادهای تکمیل شده
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * فرمت مبلغ با جداکننده هزارگان
     */
    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 0, '.', ',');
    }

    /**
     * وضعیت فارسی
     */
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'draft' => 'پیش‌نویس',
            'active' => 'فعال',
            'completed' => 'تکمیل شده',
            'cancelled' => 'لغو شده',
            'suspended' => 'معلق',
            default => 'نامشخص'
        };
    }
}
