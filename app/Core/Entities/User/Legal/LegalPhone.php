<?php

namespace App\Core\Entities\User\Legal;

use App\Core\Entities\AbstractEntity;
use App\Core\Helpers\StringHelper;

/**
 * @property int $id
 * @property int $legal_id
 * @property string $phone
 */
class LegalPhone extends AbstractEntity
{
    public $timestamps = false;

    public function setPhoneAttribute($value): void
    {
        $this->attributes['phone'] = StringHelper::onlyNumbers($value);
    }
}
