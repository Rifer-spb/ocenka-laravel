<?php

namespace App\Core\Entities\Notary;

use App\Core\Entities\AbstractEntity;

/**
 * @property int $id
 * @property int $notary_id
 * @property string $phone
 */
class NotaryPhone extends AbstractEntity
{
    protected $table = 'notary_phones';
}
