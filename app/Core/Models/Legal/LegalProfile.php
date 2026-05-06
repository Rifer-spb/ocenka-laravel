<?php

namespace App\Core\Models\Legal;

use App\Core\Models\AbstractEntity;
use App\Core\Models\LegalType;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $type_id
 * @property string $full_name
 * @property string $short_name
 * @property string $abbr
 * @property string $address
 * @property string $geo
 * @property string $date_ogrn
 * @property int $inn
 * @property int $kpp
 * @property int $ogrn
 * @property bool $registry_h1
 * @property string $registry_template
 * @property string $token_mango
 * @property string $updated_at
 * @property LegalType $type
 */
class LegalProfile extends AbstractEntity
{
    public $timestamps = false;

    protected $fillable = [
        'id',
    ];

    public function type(): HasOne|LegalType
    {
        return $this->hasOne(LegalType::class, 'id', 'type_id');
    }
}
