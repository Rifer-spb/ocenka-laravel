<?php

namespace App\Core\Entities\User\Legal\ValueObjects;

use App\Core\Attributes\TestClass;
use Tests\Unit\Core\Entities\User\Legal\ValueObjects\RegistryTemplateTest;

#[TestClass(RegistryTemplateTest::class)]
class RegistryTemplate
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);

        if ($value === '') {
            throw new \DomainException('Указан пустой шаблон.');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
