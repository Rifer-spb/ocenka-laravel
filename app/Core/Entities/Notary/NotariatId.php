<?php

namespace App\Core\Entities\Notary;

use App\Core\Attributes\TestClass;
use Tests\Unit\Core\Entities\Notary\NotariatIdTest;

#[TestClass(NotariatIdTest::class)]
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
