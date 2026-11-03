<?php

namespace App\Core\Entities\Call;

use App\Core\Attributes\TestClass;
use Tests\Unit\Core\Entities\Call\MangoCallIdTest;

#[TestClass(MangoCallIdTest::class)]
class MangoCallId
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);

        if (empty($value)) {
            throw new \DomainException('Идентификатор звонка не передан.');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
