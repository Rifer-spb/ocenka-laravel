<?php

namespace App\Core\Models\Legal;

use App\Core\Models\AbstractEntity;

/**
 * @property int $id
 * @property int $type_id
 * @property string $full_name
 * @property string $short_name
 * @property string $abbr
 * @property string $geo
 * @property string $date_ogrn
 * @property int $inn
 * @property int $kpp
 * @property int $ogrn
 * @property bool $registry_h1
 * @property string $registry_template
 * @property string $token_mango
 * @property string $updated_at
 */
class LegalProfile extends AbstractEntity
{
    public $timestamps = false;
    protected $fillable = [
        'id',
    ];
}
