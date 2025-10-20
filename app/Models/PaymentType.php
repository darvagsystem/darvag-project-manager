<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'icon',
        'color',
        'is_active',
        'requires_receipt',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'requires_receipt' => 'boolean',
    ];

    // Relationships
    public function payments()
    {
        return $this->hasMany(Payment::class, 'payment_type_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // Accessors
    public function getIconHtmlAttribute()
    {
        if ($this->icon) {
            return '<i class="' . $this->icon . '" style="color: ' . $this->color . '"></i>';
        }
        return '<i class="fas fa-credit-card" style="color: ' . $this->color . '"></i>';
    }

    public function getBadgeHtmlAttribute()
    {
        return '<span class="badge" style="background-color: ' . $this->color . '; color: white;">' .
               $this->name . '</span>';
    }

    // Static methods
    public static function getActiveTypes()
    {
        return self::active()->ordered()->get();
    }

    public static function getDefaultTypes()
    {
        return [
            [
                'name' => 'حقوق',
                'code' => 'salary',
                'description' => 'پرداخت حقوق ماهانه پرسنل',
                'icon' => 'fas fa-money-bill-wave',
                'color' => '#28a745',
                'requires_receipt' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'پاداش',
                'code' => 'bonus',
                'description' => 'پاداش و مزایای پرسنل',
                'icon' => 'fas fa-gift',
                'color' => '#ffc107',
                'requires_receipt' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'پیش‌پرداخت',
                'code' => 'advance',
                'description' => 'پیش‌پرداخت قبل از انجام کار',
                'icon' => 'fas fa-hand-holding-usd',
                'color' => '#17a2b8',
                'requires_receipt' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'هزینه',
                'code' => 'expense',
                'description' => 'هزینه‌های عملیاتی پروژه',
                'icon' => 'fas fa-receipt',
                'color' => '#6f42c1',
                'requires_receipt' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'قراردادی',
                'code' => 'contract',
                'description' => 'پرداخت به پیمانکاران و قراردادی‌ها',
                'icon' => 'fas fa-handshake',
                'color' => '#fd7e14',
                'requires_receipt' => true,
                'sort_order' => 5
            ],
            [
                'name' => 'نقدی',
                'code' => 'cash',
                'description' => 'پرداخت نقدی',
                'icon' => 'fas fa-coins',
                'color' => '#20c997',
                'requires_receipt' => false,
                'sort_order' => 6
            ]
        ];
    }
}
