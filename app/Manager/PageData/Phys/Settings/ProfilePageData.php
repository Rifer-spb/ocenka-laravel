<?php

namespace App\Manager\PageData\Phys\Settings;

use App\Core\Models\User\Phys\Phys;

class ProfilePageData
{
    public function execute(Phys $phys): array
    {
        return [
            'profile' => $phys->profile,
            'phones' => $phys->phones,
        ];
    }
}
