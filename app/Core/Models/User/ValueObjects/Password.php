<?php

namespace App\Core\Models\User\ValueObjects;

use InvalidArgumentException;

class Password
{
    private int $minLength = 8;
    private int $maxLength = 50;
    private string $value;

    public function __construct(string $password)
    {
        $password = trim($password);
        $length = strlen($password);

        if ($length < $this->minLength) {
            throw new InvalidArgumentException("Пароль должен быть не менее {$this->minLength} символов.");
        }

        if ($length > $this->maxLength) {
            throw new InvalidArgumentException("Пароль не может быть длиннее {$this->maxLength} символов.");
        }

        $this->value = $password;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
