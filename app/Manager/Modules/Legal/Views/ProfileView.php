<?php

namespace App\Manager\Modules\Legal\Views;

use App\Core\Models\LegalType;
use App\Core\Models\User\Legal\Legal;

class ProfileView
{
    public function get(Legal $legal): array
    {
        $profile = $legal->profile;

        return [
            'types' => array_map(function (array $type) {
                return [
                    'id' => $type['id'],
                    'name' => $type['name'],
                    'shortName' => $type['short_name'],
                ];
            }, LegalType::all()->toArray()),
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
            ],
        ];
    }
}
