<?php

namespace App\Core\Entities\Call;

class MangoCallId
{
    private string $value;

    public function __construct(string $value)
    {
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
