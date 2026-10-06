<?php

namespace App\Core\Entities\User\ValueObjects;

final class SecondName extends AbstractNamePart
{
    protected function getFieldName(): string
    {
        return 'Фамилия';
    }
}
