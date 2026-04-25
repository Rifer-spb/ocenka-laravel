<?php

namespace App\Manager\Modules\Phys\Readers;

use App\Core\Models\User\Phys\Phys;

class ProfileGetter
{
    public function get(Phys $user): array
    {
        return [
            'profile' => $user->profile,
            'phones' => $user->phones,
        ];
    }
}
