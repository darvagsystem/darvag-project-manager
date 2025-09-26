<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    use HasFactory;

    protected $table = 'company_settings';

    protected $fillable = [
        'company_name',
        'company_address',
        'postal_code',
        'ceo_name',
        'company_logo',
        'national_id',
        'economic_id',
        'phone',
        'email',
        'website',
        'description'
    ];

    /**
     * Get the first company settings record (singleton pattern)
     */
    public static function getSettings()
    {
        return self::first() ?? new self();
    }

    /**
     * Update or create company settings
     */
    public static function updateSettings(array $data)
    {
        $settings = self::first();
        if ($settings) {
            $settings->update($data);
        } else {
            self::create($data);
        }
        return $settings;
    }
}
