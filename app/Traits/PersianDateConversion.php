<?php

namespace App\Traits;

use Carbon\Carbon;
use Morilog\Jalali\Jalalian;

trait PersianDateConversion
{
    /**
     * Convert Persian date string to Carbon instance
     */
    public function persianToCarbon($persianDate, $time = null)
    {
        if (empty($persianDate)) {
            return null;
        }

        try {
            // Parse Persian date (format: 1403/01/15 or 1403-01-15)
            $persianDate = str_replace(['-', ' '], ['/', ''], $persianDate);

            // Split date parts
            $parts = explode('/', $persianDate);
            if (count($parts) !== 3) {
                return null;
            }

            $year = (int) $parts[0];
            $month = (int) $parts[1];
            $day = (int) $parts[2];

            // Convert to Gregorian
            $jDate = Jalalian::fromJalali($year, $month, $day);

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
            return null;
        }
    }

    /**
     * Convert Carbon instance to Persian date string
     */
    public function carbonToPersian($carbon, $format = 'Y/m/d', $includeTime = false)
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
            return null;
        }
    }

    /**
     * Convert Persian datetime string to Carbon instance
     */
    public function persianDateTimeToCarbon($persianDateTime)
    {
        if (empty($persianDateTime)) {
            return null;
        }

        try {
            // Handle different formats
            $persianDateTime = str_replace(['-', 'T'], ['/', ' '], $persianDateTime);

            // Split date and time
            $parts = explode(' ', $persianDateTime);
            $date = $parts[0];
            $time = isset($parts[1]) ? $parts[1] : '00:00:00';

            return $this->persianToCarbon($date, $time);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Convert Carbon instance to Persian datetime string
     */
    public function carbonToPersianDateTime($carbon, $format = 'Y/m/d H:i')
    {
        return $this->carbonToPersian($carbon, $format, true);
    }

    /**
     * Get current Persian date
     */
    public function getCurrentPersianDate($format = 'Y/m/d')
    {
        return Jalalian::now()->format($format);
    }

    /**
     * Get current Persian datetime
     */
    public function getCurrentPersianDateTime($format = 'Y/m/d H:i:s')
    {
        return Jalalian::now()->format($format);
    }

    /**
     * Validate Persian date format
     */
    public function isValidPersianDate($persianDate)
    {
        if (empty($persianDate)) {
            return false;
        }

        try {
            $persianDate = str_replace(['-', ' '], ['/', ''], $persianDate);
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
            Jalalian::fromJalali($year, $month, $day);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
