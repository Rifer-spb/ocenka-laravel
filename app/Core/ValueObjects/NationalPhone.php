<?php

namespace App\Core\ValueObjects;

use InvalidArgumentException;

class NationalPhone
{
    private string $value;

    public function __construct(int|string $value)
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Пустой номер телефона.');
        }

        $value = preg_replace('/[^0-9]/', '', (string)$value);
        $length = strlen($value);

        if ($length < 10 || $length > 11 || ($length == 11 && !in_array($value[0], [7,8]))) {
            throw new InvalidArgumentException('Некорректный номер телефона.');
        }

        if ($length === 11 && $value[0] === '8') {
            $value = '7' . substr($value, 1);
        }

        if ($length === 10) {
            $value = '7' . $value;
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
