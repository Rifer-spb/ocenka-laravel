<?php

namespace App\Core\Models\Legal;

use App\Core\Models\AbstractEntity;

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
