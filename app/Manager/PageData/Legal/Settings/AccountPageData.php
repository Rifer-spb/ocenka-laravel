<?php

namespace App\Manager\PageData\Legal\Settings;

use App\Core\Entities\LegalType;
use App\Core\Entities\User\Legal\Legal;

class AccountPageData
{
    public function build(Legal $legal): array
    {
        return [
            'types' => $this->getTypes(),
            'company' => $this->getCompany($legal),
        ];
    }

    private function getTypes(): array
    {
        return LegalType
            ::orderBy('name')
            ->get()
            ->pluck('name', 'id')
            ->all();
    }

    private function getCompany(Legal $legal): array
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
}
