<?php

namespace App\Core\Models\Notary;

use App\Core\Models\AbstractEntity;

/**
 * @property int $id
 * @property int $notary_id
 * @property int $user_id
 * @property string $date_created
 * @property string $text
 */
class NotaryLog extends AbstractEntity
{
    protected $table = 'notary_log';
}
