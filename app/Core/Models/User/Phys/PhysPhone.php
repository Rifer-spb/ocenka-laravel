<?php

namespace App\Core\Models\User\Phys;

use App\Core\Helpers\StringHelper;
use App\Core\Models\AbstractEntity;

/**
 * @property int $id
 * @property int $user_id
 * @property string $phone
 */
class PhysPhone extends AbstractEntity
{
    protected $fillable = [
        'phone',
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
