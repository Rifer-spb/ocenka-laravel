<?php

namespace App\Core\Validators;

class PhoneValidator
{
    public static function isNational(int|string $phone): bool
    {
        $phone = (string)$phone;
        $length = strlen($phone);

        return $length == 10 || ($length == 11 && in_array($phone[0], [7,8]));
    }
}
