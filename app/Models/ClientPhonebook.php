<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientPhonebook extends Model
{
    use HasFactory;

    protected $table = 'client_phonebook';

    protected $fillable = [
        'client_id',
        'region',
        'department',
        'unit',
        'person_name',
        'position',
        'phone',
        'mobile',
        'notes',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the client that owns the phonebook entry.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Scope a query to only include active entries.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for searching by person name, phone, or position.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('person_name', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%")
              ->orWhere('mobile', 'like', "%{$search}%")
              ->orWhere('position', 'like', "%{$search}%")
              ->orWhere('department', 'like', "%{$search}%")
              ->orWhere('unit', 'like', "%{$search}%");
        });
    }

    /**
     * Get the full hierarchy path.
     */
    public function getHierarchyPathAttribute()
    {
        $path = [];

        if ($this->region) {
            $path[] = $this->region;
        }

        if ($this->department) {
            $path[] = $this->department;
        }

        if ($this->unit) {
            $path[] = $this->unit;
        }

        return implode(' > ', $path);
    }

    /**
     * Get the display name with position.
     */
    public function getDisplayNameAttribute()
    {
        $name = $this->person_name;

        if ($this->position) {
            $name .= " ({$this->position})";
        }

        return $name;
    }
}
