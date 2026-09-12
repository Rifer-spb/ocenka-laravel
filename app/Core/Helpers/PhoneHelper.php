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
}
