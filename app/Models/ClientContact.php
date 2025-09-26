<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'contact_person',
        'position',
        'department',
        'phone',
        'mobile',
        'email',
        'extension',
        'address',
        'notes',
        'preferred_contact',
        'availability',
        'priority',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the client that owns the contact.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Scope a query to only include active contacts.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get the contact's full name with position.
     */
    public function getFullNameAttribute()
    {
        return $this->contact_person . ' - ' . $this->position;
    }

    /**
     * Get the preferred contact method.
     */
    public function getPreferredContactMethodAttribute()
    {
        switch ($this->preferred_contact) {
            case 'phone':
                return 'تلفن ثابت';
            case 'mobile':
                return 'موبایل';
            case 'email':
                return 'ایمیل';
            default:
                return 'نامشخص';
        }
    }

    /**
     * Get the priority label.
     */
    public function getPriorityLabelAttribute()
    {
        switch ($this->priority) {
            case 'high':
                return 'بالا';
            case 'urgent':
                return 'فوری';
            default:
                return 'عادی';
        }
    }

    /**
     * Get the status label.
     */
    public function getStatusLabelAttribute()
    {
        return $this->status === 'active' ? 'فعال' : 'غیرفعال';
    }
}
