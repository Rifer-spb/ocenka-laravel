<?php

namespace App\Core\Models\User\Phys;

use App\Core\Helpers\StringHelper;
use App\Core\Models\AbstractEntity;
use Database\Factories\Core\Models\User\Phys\PhysPhoneFactory;

/**
 * @property int $id
 * @property int $user_id
 * @property string $phone
 *
 * @method static PhysPhoneFactory factory()
 */
class PhysPhone extends AbstractEntity
{
    protected $fillable = [
        'phone',
        'user_id',
    ];
    public $timestamps = false;

    protected $hidden = [
        'user_id',
    ];

    public function setPhoneAttribute($value): void
    {
        $this->attributes['phone'] = StringHelper::onlyNumbers($value);
    }
}
