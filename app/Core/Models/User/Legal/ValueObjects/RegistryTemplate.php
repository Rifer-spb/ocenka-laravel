<?php

namespace App\Core\Models\User\Legal\ValueObjects;

class RegistryTemplate
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);

        if (!$value) {
            throw new \DomainException('Указан пустой шаблон.');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
