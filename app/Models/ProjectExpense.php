<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectExpense extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'amount',
        'currency',
        'expense_date',
        'expense_type',
        'category',
        'status',
        'reference_number',
        'notes',
        'created_by'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date',
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
        return $query->where('expense_type', $type);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('expense_date', [$startDate, $endDate]);
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
            'approved' => 'تایید شده',
            'paid' => 'پرداخت شده',
            'cancelled' => 'لغو شده'
        ];
        return $statusMap[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colorMap = [
            'pending' => 'warning',
            'approved' => 'info',
            'paid' => 'success',
            'cancelled' => 'danger'
        ];
        return $colorMap[$this->status] ?? 'secondary';
    }

    public function getTypeTextAttribute()
    {
        $typeMap = [
            'material' => 'مواد',
            'labor' => 'دستمزد',
            'equipment' => 'تجهیزات',
            'transportation' => 'حمل و نقل',
            'utilities' => 'آب و برق',
            'rent' => 'اجاره',
            'other' => 'سایر'
        ];
        return $typeMap[$this->expense_type] ?? $this->expense_type;
    }

    public function getCategoryTextAttribute()
    {
        $categoryMap = [
            'operational' => 'عملیاتی',
            'administrative' => 'اداری',
            'marketing' => 'بازاریابی',
            'maintenance' => 'نگهداری',
            'other' => 'سایر'
        ];
        return $categoryMap[$this->category] ?? $this->category;
    }
}
