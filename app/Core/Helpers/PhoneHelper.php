<?php

namespace App\Core\Helpers;

use App\Core\Validators\PhoneValidator;

class PhoneHelper
{
    public static function parseToNationalFormat(int|string $phone): ?string
    {
        $phone = StringHelper::onlyNumbers($phone);

        if (!PhoneValidator::isNational($phone)) {
            return null;
        }

        $length = strlen($phone);

        if ($length == 10) {
            $phone = '7' . $phone;
        } elseif ($phone[0] == 8) {
            $phone[0] = 7;
        }

        return $phone;
    }

    public static function toViewFormat(string|int $phone): string
    {
        if (strlen((string) $phone) == 11) {
            preg_match('/(\d{1})(\d{3})(\d{3})(\d{2})(\d{2})/', (string) $phone, $matches);
            return '+' . $matches[1] . ' (' . $matches[2] . ') ' . $matches[3] . '-' . $matches[4] . '-' . $matches[5];
        }
        return (string) $phone;
    }
}
