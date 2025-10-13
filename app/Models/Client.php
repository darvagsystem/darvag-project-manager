<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'email',
        'phone',
        'website',
        'address',
        'description',
        'status'
    ];

    /**
     * Get the projects for the client.
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get the phonebook entries for the client.
     */
    public function phonebook()
    {
        return $this->hasMany(ClientPhonebook::class);
    }

    /**
     * Get the contacts for the client.
     */
    public function contacts()
    {
        return $this->hasMany(ClientContact::class);
    }

    /**
     * Get the formatted status.
     */
    public function getFormattedStatusAttribute()
    {
        return match($this->status) {
            'active' => 'فعال',
            'inactive' => 'غیرفعال',
            default => 'نامشخص'
        };
    }

    /**
     * Scope for active clients.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for inactive clients.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
}
