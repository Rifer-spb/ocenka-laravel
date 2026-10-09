<?php

namespace App\Core\Entities\Notary;

use App\Core\Entities\AbstractEntity;
use Database\Factories\Core\Entities\Notary\NotaryEmailFactory;

/**
 * @property int $id
 * @property int $notary_id
 * @property string $email
 * @property bool $use_for_notify слать ли на эту почту уведомления или нет
 *
 * @method static NotaryEmailFactory factory
 */
class NotaryEmail extends AbstractEntity
{
    protected $table = 'notary_emails';
}
