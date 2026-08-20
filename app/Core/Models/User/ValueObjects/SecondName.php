<?php

namespace App\Core\Models\User\ValueObjects;

final class SecondName extends AbstractNamePart
{
    protected function getFieldName(): string
    {
        return 'Фамилия';
    }
}
