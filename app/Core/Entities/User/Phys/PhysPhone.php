<?php

namespace App\Core\Entities\User\Phys;

use App\Core\Helpers\StringHelper;
use App\Core\Entities\AbstractEntity;
use Database\Factories\Core\Entities\User\Phys\PhysPhoneFactory;

/**
 * @property int $id
 * @property int $user_id
 * @property string $phone
 *
 * @method static PhysPhoneFactory factory()
 */
class PhysPhone extends AbstractEntity
{
    public $timestamps = false;

    protected $hidden = [
        'user_id',
    ];

    public function setPhoneAttribute($value): void
    {
        $this->attributes['phone'] = StringHelper::onlyNumbers($value);
    }
}
