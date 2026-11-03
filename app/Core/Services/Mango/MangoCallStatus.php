<?php

namespace App\Core\Services\Mango;

class MangoCallStatus
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value < 0 || $value > 1) {
            throw new \DomainException('Некорректный статус звонка из mango office.');
        }

        $this->value = $value;
    }

    public function isMissed(): int
    {
        return $this->value === 0;
    }
}
