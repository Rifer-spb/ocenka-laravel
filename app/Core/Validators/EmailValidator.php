<?php

namespace App\Core\Validators;

class EmailValidator
{
    public static function isEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
