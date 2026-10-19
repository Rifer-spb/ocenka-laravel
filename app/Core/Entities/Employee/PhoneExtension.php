<?php

namespace App\Core\Entities\Employee;

use App\Core\Attributes\TestClass;
use App\Core\Helpers\StringHelper;
use Tests\Unit\Core\Entities\Employee\PhoneExtensionTest;

#[TestClass(PhoneExtensionTest::class)]
class PhoneExtension
{
    private ?string $value;

    public function __construct(?string $value)
    {
        if ($value !== null) {
            $value = StringHelper::onlyNumbers($value);
            $intValue = (int)$value;

            if ($intValue == 0 || $value > 999) {
                throw new \DomainException('Некорректный добавочный номер.');
            }
        }

        $this->value = $value;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function hasValue(): bool
    {
        return $this->value !== null;
    }
}
