<?php

namespace App\Core\ValueObjects;

/**
 * @see \Tests\Unit\Core\ValueObjects\SiteTest
 */
class Site
{
    private string $value;

    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            throw new \DomainException('Некорректный адрес сайта.');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
