<?php

namespace App\Core\ValueObjects;

use Illuminate\Support\Str;
use InvalidArgumentException;

class Email
{
    private string $value;

    public function __construct(string $email)
    {
        $email = Str::lower(trim($email));

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
