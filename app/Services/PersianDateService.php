<?php

namespace App\Services;

use Carbon\Carbon;
use Morilog\Jalali\Jalalian;

class PersianDateService
{
    /**
     * Convert Persian date to Carbon for database storage
     */
    public static function persianToCarbon($persianDate, $time = null)
    {
        if (empty($persianDate)) {
            return null;
        }

        try {
            // Clean and normalize the input
            $persianDate = str_replace(['-', ' '], ['/', ''], trim($persianDate));

            // Split date parts
            $parts = explode('/', $persianDate);
            if (count($parts) !== 3) {
                return null;
            }

            $year = (int) $parts[0];
            $month = (int) $parts[1];
            $day = (int) $parts[2];

            // Validate Persian date
            if ($year < 1300 || $year > 1500 || $month < 1 || $month > 12 || $day < 1 || $day > 31) {
                return null;
            }

            // Convert to Gregorian
            $jDate = new Jalalian($year, $month, $day);

            // Add time if provided
            if ($time) {
                $timeParts = explode(':', $time);
                $hour = isset($timeParts[0]) ? (int) $timeParts[0] : 0;
                $minute = isset($timeParts[1]) ? (int) $timeParts[1] : 0;
                $second = isset($timeParts[2]) ? (int) $timeParts[2] : 0;

                return $jDate->toCarbon()->setTime($hour, $minute, $second);
            }

            return $jDate->toCarbon();
        } catch (\Exception $e) {
            \Log::error('Persian date conversion error: ' . $e->getMessage(), [
                'persian_date' => $persianDate,
                'time' => $time
            ]);
            return null;
        }
    }

    /**
     * Convert Carbon instance to Persian date for display
     */
    public static function carbonToPersian($carbon, $format = 'Y/m/d', $includeTime = false)
    {
        if (!$carbon instanceof Carbon) {
            return null;
        }

        try {
            $jDate = Jalalian::fromCarbon($carbon);

            if ($includeTime) {
                return $jDate->format($format . ' H:i:s');
            }

            return $jDate->format($format);
        } catch (\Exception $e) {
            \Log::error('Carbon to Persian conversion error: ' . $e->getMessage(), [
                'carbon' => $carbon
            ]);
            return null;
        }
    }

    /**
     * Convert Persian datetime string to Carbon instance
     */
    public static function persianDateTimeToCarbon($persianDateTime)
    {
        if (empty($persianDateTime)) {
            return null;
        }

        try {
            // Handle different formats (1403/01/15 14:30 or 1403-01-15T14:30)
            $persianDateTime = str_replace(['-', 'T'], ['/', ' '], $persianDateTime);

            // Split date and time
            $parts = explode(' ', $persianDateTime);
            $date = $parts[0];
            $time = isset($parts[1]) ? $parts[1] : '00:00:00';

            return self::persianToCarbon($date, $time);
        } catch (\Exception $e) {
            \Log::error('Persian datetime conversion error: ' . $e->getMessage(), [
                'persian_datetime' => $persianDateTime
            ]);
            return null;
        }
    }

    /**
     * Convert Carbon instance to Persian datetime string
     */
    public static function carbonToPersianDateTime($carbon, $format = 'Y/m/d H:i')
    {
        return self::carbonToPersian($carbon, $format, true);
    }

    /**
     * Get current Persian date
     */
    public static function getCurrentPersianDate($format = 'Y/m/d')
    {
        return Jalalian::now()->format($format);
    }

    /**
     * Get current Persian datetime
     */
    public static function getCurrentPersianDateTime($format = 'Y/m/d H:i:s')
    {
        return Jalalian::now()->format($format);
    }

    /**
     * Validate Persian date format
     */
    public static function isValidPersianDate($persianDate)
    {
        if (empty($persianDate)) {
            return false;
        }

        try {
            $persianDate = str_replace(['-', ' '], ['/', ''], trim($persianDate));
            $parts = explode('/', $persianDate);

            if (count($parts) !== 3) {
                return false;
            }

            $year = (int) $parts[0];
            $month = (int) $parts[1];
            $day = (int) $parts[2];

            // Basic validation
            if ($year < 1300 || $year > 1500 || $month < 1 || $month > 12 || $day < 1 || $day > 31) {
                return false;
            }

            // Try to create Jalalian instance
            new Jalalian($year, $month, $day);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Format Persian date for input fields
     */
    public static function formatForInput($carbon, $includeTime = false)
    {
        if (!$carbon instanceof Carbon) {
            return '';
        }

        $format = $includeTime ? 'Y/m/d H:i' : 'Y/m/d';
        return self::carbonToPersian($carbon, $format, $includeTime);
    }

    /**
     * Parse Persian date from input
     */
    public static function parseFromInput($input, $includeTime = false)
    {
        if (empty($input)) {
            return null;
        }

        if ($includeTime) {
            return self::persianDateTimeToCarbon($input);
        }

        return self::persianToCarbon($input);
    }

    /**
     * Convert Persian date to Gregorian date string
     */
    public static function persianToGregorian($persianDate)
    {
        $carbon = self::persianToCarbon($persianDate);
        
        if (!$carbon) {
            throw new \InvalidArgumentException('Invalid Persian date format: ' . $persianDate);
        }

        return $carbon->format('Y-m-d');
    }

    /**
     * Convert Gregorian date string to Persian date
     */
    public static function gregorianToPersian($gregorianDate, $format = 'Y/m/d')
    {
        if (empty($gregorianDate)) {
            return null;
        }

        try {
            $carbon = Carbon::parse($gregorianDate);
            return self::carbonToPersian($carbon, $format);
        } catch (\Exception $e) {
            \Log::error('Gregorian to Persian conversion error: ' . $e->getMessage(), [
                'gregorian_date' => $gregorianDate
            ]);
            return null;
        }
    }
}
