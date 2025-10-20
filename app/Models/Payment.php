<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'recipient_id',
        'payment_type_id',
        'payment_type', // For backward compatibility
        'amount',
        'currency',
        'payment_method',
        'description',
        'payment_date',
        'reference_number',
        'status',
        'notes',
        'created_by',
        'finance_type',
        'finance_category',
        'is_billable',
        'tax_amount',
        'discount_amount',
        'net_amount'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
        'is_billable' => 'boolean',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'net_amount' => 'decimal:2',
    ];

    // Relationships
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function recipient()
    {
        return $this->belongsTo(PaymentRecipient::class, 'recipient_id');
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
    }

    public function receipts()
    {
        return $this->hasMany(PaymentReceipt::class, 'payment_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeByProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('payment_type', $type);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('payment_date', [$startDate, $endDate]);
    }

    // Accessors
    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 0, '.', ',') . ' ' . $this->currency;
    }

    public function getStatusTextAttribute()
    {
        $statusMap = [
            'pending' => 'در انتظار',
            'completed' => 'تکمیل شده',
            'failed' => 'ناموفق',
            'cancelled' => 'لغو شده'
        ];
        return $statusMap[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colorMap = [
            'pending' => 'warning',
            'completed' => 'success',
            'failed' => 'danger',
            'cancelled' => 'secondary'
        ];
        return $colorMap[$this->status] ?? 'secondary';
    }

    // Methods
    public function markAsCompleted()
    {
        $this->update(['status' => 'completed']);
    }

    public function markAsFailed()
    {
        $this->update(['status' => 'failed']);
    }

    public function cancel()
    {
        $this->update(['status' => 'cancelled']);
    }
}
