<?php

namespace App\Core\Entities\User\ValueObjects;

final class LastName extends AbstractNamePart
{
    protected function getFieldName(): string
    {
        return 'Отчество';
    }
}
