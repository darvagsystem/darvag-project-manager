<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Services\PersianDateService;

class DateHelper
{
    /**
     * Format Carbon instance to Persian date
     */
    public static function toPersian($carbon, $format = 'Y/m/d H:i', $includeTime = true)
    {
        if (!$carbon instanceof Carbon) {
            return null;
        }

        return PersianDateService::carbonToPersian($carbon, $format, $includeTime);
    }

    /**
     * Format Carbon instance to Persian date (date only)
     */
    public static function toPersianDate($carbon, $format = 'Y/m/d')
    {
        if (!$carbon instanceof Carbon) {
            return null;
        }

        return PersianDateService::carbonToPersian($carbon, $format, false);
    }

    /**
     * Format Carbon instance to Persian datetime
     */
    public static function toPersianDateTime($carbon, $format = 'Y/m/d H:i')
    {
        if (!$carbon instanceof Carbon) {
            return null;
        }

        return PersianDateService::carbonToPersian($carbon, $format, true);
    }

    /**
     * Format Carbon instance to Persian datetime with seconds
     */
    public static function toPersianDateTimeFull($carbon, $format = 'Y/m/d H:i:s')
    {
        return self::toPersian($carbon, $format, true);
    }

    /**
     * Get current Persian date
     */
    public static function now($format = 'Y/m/d H:i')
    {
        return PersianDateService::getCurrentPersianDateTime($format);
    }

    /**
     * Get current Persian date (date only)
     */
    public static function nowDate($format = 'Y/m/d')
    {
        return PersianDateService::getCurrentPersianDate($format);
    }
}
