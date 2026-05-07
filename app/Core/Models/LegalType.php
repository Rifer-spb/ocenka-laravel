<?php

namespace App\Core\Models;

/**
 * @property int $id
 * @property string $name
 * @property string $short_name
 */
class LegalType extends AbstractEntity
{
    /**
     * @return LegalType[]
     */
    public static function getAll(): array
    {
        return self::all()->all();
    }
}
