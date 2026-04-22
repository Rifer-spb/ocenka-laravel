<?php

namespace App\Models\User\Phys;

use App\Helpers\StringHelper;
use Illuminate\Database\Eloquent\Model;

/** @property int $id */
/** @property int $user_id */
/** @property string $phone */
class PhysPhone extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'phone',
    ];

    public function setPhoneAttribute($value): void
    {
        $this->attributes['phone'] = StringHelper::onlyNumbers($value);
    }
}
