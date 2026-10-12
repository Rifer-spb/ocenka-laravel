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
            $value = trim($value);
            $value = StringHelper::onlyNumbers($value);

            if ($value == '0' || strlen($value) > 5) {
                throw new \DomainException('Некорректный добавочный номер.');
            }
        }

        $this->value = empty($value) ? null : trim($value, '0');
    }

    public function getValue(): ?string
    {
        return $this->value;
    }
}
