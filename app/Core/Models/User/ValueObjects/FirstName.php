<?php

namespace App\Core\Models\User\ValueObjects;

final class FirstName extends AbstractNamePart
{
    protected function getFieldName(): string
    {
        return 'Имя';
    }
}
