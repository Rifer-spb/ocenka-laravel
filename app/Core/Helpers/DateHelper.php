<?php

namespace App\Core\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function toDatetime(null|string|Carbon $date, string $format = 'd.m.Y H:i'): ?string
    {
        if (! $date) {
            return null;
        }

        if ($date instanceof Carbon) {
            return $date->format($format);
        }

        return Carbon::parse($date)->format($format);
    }
}
