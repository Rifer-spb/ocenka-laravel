<?php

namespace App\Core\Validators;

class EmailValidator
{
    /**
     * @param string $email
     * @return bool
     * @see \Tests\Unit\Core\Validators\EmailValidatorTest
     */
    public static function isEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
