<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EmployeeDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'document_type',
        'document_name',
        'file_path',
        'file_name',
        'file_extension',
        'file_size',
        'issue_date',
        'expiry_date',
        'notes'
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getFileSizeHumanAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getFileUrlAttribute()
    {
        return Storage::disk('public')->url($this->file_path);
    }

    public function getDocumentTypeNameAttribute()
    {
        $types = [
            'national_card' => 'کارت ملی',
            'birth_certificate' => 'شناسنامه',
            'education_certificate' => 'مدرک تحصیلی',
            'military_service' => 'کارت پایان خدمت',
            'insurance_booklet' => 'دفترچه بیمه',
            'work_permit' => 'مجوز کار',
            'driver_license' => 'گواهی‌نامه رانندگی',
            'health_certificate' => 'گواهی سلامت',
            'training_certificate' => 'گواهی آموزشی',
            'other' => 'سایر'
        ];

        return $types[$this->document_type] ?? $this->document_type;
    }

    public static function getDocumentTypes()
    {
        return [
            'national_card' => 'کارت ملی',
            'birth_certificate' => 'شناسنامه',
            'education_certificate' => 'مدرک تحصیلی',
            'military_service' => 'کارت پایان خدمت',
            'insurance_booklet' => 'دفترچه بیمه',
            'work_permit' => 'مجوز کار',
            'driver_license' => 'گواهی‌نامه رانندگی',
            'health_certificate' => 'گواهی سلامت',
            'training_certificate' => 'گواهی آموزشی',
            'other' => 'سایر'
        ];
    }
}
