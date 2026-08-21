<?php

namespace App\Core\ValueObjects;

use App\Core\Helpers\StringHelper;
use App\Core\Validators\PhoneValidator;
use InvalidArgumentException;

class NationalPhone
{
    private string $value;

    public function __construct(int|string $value)
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Пустой номер телефона.');
        }

        $value = StringHelper::onlyNumbers((string)$value);
        $length = strlen($value);

        if (!PhoneValidator::isNational($value)) {
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
