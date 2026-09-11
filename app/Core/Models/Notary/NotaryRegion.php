<?php

namespace App\Core\Models\Notary;

use App\Core\Models\AbstractEntity;

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
}
