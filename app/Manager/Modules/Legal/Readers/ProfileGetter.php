<?php

namespace App\Manager\Modules\Legal\Readers;

use App\Core\Models\User\Legal\Legal;

class ProfileGetter
{
    public function get(Legal $legal): array
    {
        $profile = $legal->profile;

        return [
            'company' => [
                'typeId' => $profile->type_id,
                'fullName' => $profile->full_name,
                'shortName' => $profile->short_name,
                'abbr' => $profile->abbr,
                'address' => $profile->address,
                'dateOgrn' => $profile->date_ogrn,
                'inn' => $profile->inn,
                'kpp' => $profile->kpp,
                'ogrn' => $profile->ogrn,
            ]
        ];
    }
}
