<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeBankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'bank_id',
        'account_number',
        'iban',
        'card_number',
        'account_holder_name',
        'is_default',
        'is_active',
        'notes'
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    // When setting an account as default, make sure no other account for the same employee is default
    public function setAsDefault()
    {
        // First, unset all other default accounts for this employee
        static::where('employee_id', $this->employee_id)
              ->where('id', '!=', $this->id)
              ->update(['is_default' => false]);

        // Then set this account as default
        $this->update(['is_default' => true]);
    }
}
