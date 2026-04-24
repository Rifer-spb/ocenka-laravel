<?php

namespace App\Core\Models\User\Phys;

use App\Core\Helpers\StringHelper;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $phone
 */
class PhysPhone extends Model
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
