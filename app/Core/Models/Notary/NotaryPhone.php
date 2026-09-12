<?php

namespace App\Core\Models\Notary;

use App\Core\Models\AbstractEntity;

/**
 * @property int $id
 * @property int $notary_id
 * @property string $phone
 */
class NotaryPhone extends AbstractEntity
{
    protected $fillable = [
        'notary_id',
        'phone',
    ];
    protected $table = 'notary_phones';
}
