<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectIncome extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'amount',
        'currency',
        'income_date',
        'income_type',
        'status',
        'reference_number',
        'notes',
        'created_by'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'income_date' => 'date',
    ];

    // Relationships
    public function project()
    {
        return $this->belongsTo(Project::class);
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
        return $query->where('income_type', $type);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('income_date', [$startDate, $endDate]);
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
            'received' => 'دریافت شده',
            'partial' => 'جزئی',
            'cancelled' => 'لغو شده'
        ];
        return $statusMap[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colorMap = [
            'pending' => 'warning',
            'received' => 'success',
            'partial' => 'info',
            'cancelled' => 'danger'
        ];
        return $colorMap[$this->status] ?? 'secondary';
    }

    public function getTypeTextAttribute()
    {
        $typeMap = [
            'invoice' => 'فاکتور',
            'advance' => 'پیش‌پرداخت',
            'milestone' => 'مرحله‌ای',
            'final' => 'نهایی',
            'other' => 'سایر'
        ];
        return $typeMap[$this->income_type] ?? $this->income_type;
    }
}
