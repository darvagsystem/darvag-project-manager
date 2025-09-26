<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function employeeBankAccounts()
    {
        return $this->hasMany(EmployeeBankAccount::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
