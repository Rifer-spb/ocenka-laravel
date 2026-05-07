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

    protected $casts = [
        'date_ogrn' => 'date',
    ];

    public function updateCompany(Company $company): void
    {
        $this->type_id = $company->typeId;
        $this->full_name = $company->fullName;
        $this->short_name = $company->shortName;
        $this->abbr = $company->abbr;
        $this->address = $company->address;
        $this->inn = $company->inn;
        $this->kpp = $company->kpp;
        $this->ogrn = $company->ogrn;
        $this->date_ogrn = $company->dateOgrn;
    }

    public function type(): HasOne|LegalType
    {
        return $this->hasOne(LegalType::class, 'id', 'type_id');
    }
}
