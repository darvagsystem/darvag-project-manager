<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRecipient extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'recipient_id',
        'recipient_name',
        'recipient_code',
        'bank_name',
        'account_number',
        'iban',
        'card_number',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function payments()
    {
        return $this->hasMany(Payment::class, 'recipient_id');
    }

    public function bankAccounts()
    {
        if ($this->type === 'employee') {
            return $this->hasMany(EmployeeBankAccount::class, 'employee_id', 'recipient_id');
        }
        // Return a fake relationship that returns empty results
        return $this->hasMany(EmployeeBankAccount::class, 'employee_id', 'recipient_id')->whereRaw('1 = 0');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Accessors
    public function getDisplayNameAttribute()
    {
        return $this->recipient_name . ($this->recipient_code ? " ({$this->recipient_code})" : '');
    }

    public function getBankInfoAttribute()
    {
        $info = [];
        if ($this->bank_name) $info[] = $this->bank_name;
        if ($this->account_number) $info[] = "حساب: {$this->account_number}";
        if ($this->iban) $info[] = "شبا: {$this->iban}";
        if ($this->card_number) $info[] = "کارت: {$this->card_number}";

        return implode(' - ', $info);
    }

    // Static methods for creating recipients
    public static function createFromEmployee(Employee $employee, $bankAccount = null)
    {
        return self::create([
            'type' => 'employee',
            'recipient_id' => $employee->id,
            'recipient_name' => $employee->full_name,
            'recipient_code' => $employee->employee_code,
            'bank_name' => $bankAccount?->bank_name,
            'account_number' => $bankAccount?->account_number,
            'iban' => $bankAccount?->iban,
            'card_number' => $bankAccount?->card_number,
        ]);
    }
}
