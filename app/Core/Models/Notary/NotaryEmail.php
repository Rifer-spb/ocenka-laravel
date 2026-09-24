<?php

namespace App\Core\Models\Notary;

use App\Core\Models\AbstractEntity;
use Database\Factories\Core\Models\Notary\NotaryEmailFactory;

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
    protected $fillable = [
        'email',
        'notary_id'
    ];
    protected $table = 'notary_emails';
}
