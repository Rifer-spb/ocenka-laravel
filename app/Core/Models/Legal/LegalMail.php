<?php

namespace App\Core\Models\Legal;

use App\Core\Models\AbstractEntity;

/**
 * @property int $id
 * @property string $server
 * @property string $login
 * @property string $password
 * @property int $port
 * @property string $encryption
 * @property string $from_email
 * @property string $from_name
 */
class LegalMail extends AbstractEntity
{
    public $timestamps = false;
    protected $fillable = [
        'id',
    ];
}
