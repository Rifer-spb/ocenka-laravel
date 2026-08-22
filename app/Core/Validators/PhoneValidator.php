<?php

namespace App\Core\Validators;

/**
 * Валидатор телефонных номеров.
 *
 * Тесты @see \Tests\Unit\Core\Validators\PhoneValidatorTest
 */
class PhoneValidator
{
    /**
     * Проверяет, что номер состоит из 10 цифр (без кода страны)
     * или из 11 цифр, начинающихся с 7 или 8.
     *
     * @param int|string $phone
     * @return bool
     */
    public static function isNational(int|string $phone): bool
    {
        $phone = (string)$phone;
        $length = strlen($phone);

        return $length == 10 || ($length == 11 && in_array($phone[0], [7,8]));
    }
}
