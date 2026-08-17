<?php

namespace App\Core\ValueObjects;

use InvalidArgumentException;

class Email
{
    private string $value;

    public function __construct(string $email)
    {
        $email = trim($email);

        if ($email === '') {
            throw new InvalidArgumentException('Не указан e-mail.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Некорректный e-mail: {$email}");
        }

        $this->value = $email;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
