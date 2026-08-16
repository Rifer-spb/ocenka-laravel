<?php

namespace App\Core\Models\User\ValueObjects;

use InvalidArgumentException;

class Password
{
    private string $value;

    public function __construct(string $password)
    {
        if (strlen($password) < 8) {
            throw new InvalidArgumentException('Пароль должен быть не менее 8 символов.');
        }

        $this->value = $password;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
