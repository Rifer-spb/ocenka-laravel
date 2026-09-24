<?php

namespace App\Core\Models\Notary;

/**
 * @see \Tests\Unit\Core\Models\Notary\NotariatIdTest
 */
class NotariatId
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new \DomainException('Значение notariatId не может быть 0 или отрицательным.');
        }

        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
