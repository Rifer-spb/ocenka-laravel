<?php

namespace App\Core\Entities\User\ValueObjects;

final class FirstName extends AbstractNamePart
{
    protected function getFieldName(): string
    {
        return 'Имя';
    }
}
