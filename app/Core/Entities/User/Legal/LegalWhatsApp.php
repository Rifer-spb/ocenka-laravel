<?php

namespace App\Core\Entities\User\Legal;

use App\Core\Entities\AbstractEntity;

/**
 * @property int $id
 * @property string $api_url
 * @property string $api_key
 * @property string $api_id
 * @property int $phone
 */
class LegalWhatsApp extends AbstractEntity
{
    protected $table = 'legal_whatsapp';
    public $timestamps = false;
}
