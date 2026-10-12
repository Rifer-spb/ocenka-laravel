<?php

namespace App\Core\Entities\Employee;

use App\Core\Helpers\StringHelper;

class PhoneExtension
{
    private ?string $value;

    public function __construct(?string $value)
    {
        if ($value !== null) {
            $value = trim($value);
            $value = StringHelper::onlyNumbers($value);

            if (strlen($value) > 5) {
                throw new \DomainException('Некорректный добавочный номер.');
            }
        }

        $this->value = empty($value) ? null : $value;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }
}
