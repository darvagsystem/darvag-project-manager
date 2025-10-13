<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'subject',
        'message',
        'status',
        'admin_notes',
        'read_at',
        'replied_at'
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'replied_at' => 'datetime',
    ];

    // Subject options
    const SUBJECTS = [
        'consultation' => 'مشاوره پروژه',
        'quotation' => 'درخواست پیش‌فاکتور',
        'support' => 'پشتیبانی',
        'complaint' => 'شکایت',
        'other' => 'سایر'
    ];

    // Status options
    const STATUSES = [
        'new' => 'جدید',
        'read' => 'خوانده شده',
        'replied' => 'پاسخ داده شده',
        'closed' => 'بسته شده'
    ];

    // Getters
    public function getSubjectNameAttribute()
    {
        return self::SUBJECTS[$this->subject] ?? 'نامشخص';
    }

    public function getStatusNameAttribute()
    {
        return self::STATUSES[$this->status] ?? 'نامشخص';
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'new' => 'danger',
            'read' => 'warning',
            'replied' => 'success',
            'closed' => 'secondary',
            default => 'secondary'
        };
    }

    public function getIsReadAttribute()
    {
        return !is_null($this->read_at);
    }

    public function getIsRepliedAttribute()
    {
        return !is_null($this->replied_at);
    }

    // Scopes
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    // Methods
    public function markAsRead()
    {
        $this->update([
            'status' => 'read',
            'read_at' => now()
        ]);
    }

    public function markAsReplied()
    {
        $this->update([
            'status' => 'replied',
            'replied_at' => now()
        ]);
    }

    public function markAsClosed()
    {
        $this->update([
            'status' => 'closed'
        ]);
    }
}
