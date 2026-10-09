<?php

namespace App\Core\Entities\User\Legal;

use App\Core\Entities\AbstractEntity;

/**
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $server
 * @property string $secret_key
 * @property int $qr
 */
class LegalPayment extends AbstractEntity
{
    public $timestamps = false;
    protected $fillable = [
        'id',
    ];
}
