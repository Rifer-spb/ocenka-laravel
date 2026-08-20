<?php

namespace App\Core\Models\User\ValueObjects;

final class LastName extends AbstractNamePart
{
    protected function getFieldName(): string
    {
        return 'Отчество';
    }
}
