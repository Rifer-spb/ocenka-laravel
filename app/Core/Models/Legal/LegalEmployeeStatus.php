<?php

namespace App\Core\Models\Legal;

enum LegalEmployeeStatus: int
{
    case WAIT = 0;
    case ACTIVE = 1;
    case FIRED = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::WAIT => 'Ожидает подтверждения',
            self::ACTIVE => 'Подтверждена',
            self::FIRED => 'Прекращена',
        };
    }
}
