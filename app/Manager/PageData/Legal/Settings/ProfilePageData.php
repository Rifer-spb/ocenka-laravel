<?php

namespace App\Manager\PageData\Legal\Settings;

use App\Core\Models\LegalType;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Legal\LegalProfile;

class ProfilePageData
{
    public function execute(Legal $legal): array
    {
        $profile = $legal->profile;

        return [
            'types' => $this->getTypes(),
            'company' => $this->getCompany($profile),
        ];
    }

    private function getTypes(): array
    {
        return array_map(function (array $type) {
            return [
                'id' => $type['id'],
                'name' => $type['name'],
                'shortName' => $type['short_name'],
            ];
        }, LegalType::all()->toArray());
    }

    private function getCompany(LegalProfile $profile): array
    {
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
}
