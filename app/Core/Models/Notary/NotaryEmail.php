<?php

namespace App\Core\Models\Notary;

use App\Core\Models\AbstractEntity;

/**
 * @property int $id
 * @property int $notary_id
 * @property string $email
 * @property bool $use_for_notify слать ли на эту почту уведомления или нет
 */
class NotaryEmail extends AbstractEntity
{
    protected $table = 'notary_emails';
}
