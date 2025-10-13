<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PersianDate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            return; // Allow empty values (use required rule separately)
        }

        // Clean the input first
        $cleanValue = preg_replace('/[^\d\/\:\s]/', '', $value);

        if (!\App\Services\PersianDateService::isValidPersianDate($cleanValue)) {
            $fail('فرمت تاریخ وارد شده صحیح نیست. فرمت صحیح: 1403/01/15 یا 1403/01/15 14:30');
        }
    }
}
