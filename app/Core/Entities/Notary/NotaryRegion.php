<?php

namespace App\Core\Entities\Notary;

use App\Core\Entities\AbstractEntity;

/**
 * @property int $id
 * @property int $notariat_region_id id региона во внешнем сервисе notariat.ru
 * @property string $name название региона
 * @property string $group_name название нотариальной палаты
 * @property int $code код региона
 */
class NotaryRegion extends AbstractEntity
{
    protected $table = 'notary_regions';

    const ID_SAINT_PETERSBURG = 63;

    public static function createNew(): self
    {
        return self::create([
            'notariat_region_id'
        ]);
    }
}
