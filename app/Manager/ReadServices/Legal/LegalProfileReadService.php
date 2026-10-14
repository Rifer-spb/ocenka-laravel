<?php

namespace App\Manager\ReadServices\Legal;

use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Legal\LegalPhone;

class LegalProfileReadService
{
    public function getCompany(Legal $legal): array
    {
        $profile = $legal->profile;

        return [
            'typeId' => $profile->type_id,
            'fullName' => $profile->full_name,
            'shortName' => $profile->short_name,
            'abbr' => $profile->abbr,
            'address' => $profile->address,
            'dateOgrn' => $profile->date_ogrn,
            'inn' => $profile->inn,
            'kpp' => $profile->kpp,
            'ogrn' => $profile->ogrn,
        ];
    }

    public function getRegistryTemplate(Legal $legal): string
    {
        return $legal->profile->registry_template;
    }

    public function getAllPhones(Legal $legal): array
    {
        return $legal->phones->map(fn (LegalPhone $p) => [
            'id' => $p->id,
            'phone' => $p->phone,
        ])->all();
    }
}
