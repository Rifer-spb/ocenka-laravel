<?php

namespace App\Manager\Modules\Phys\Actions\Profile;

use App\Core\Models\User\Phys\Phys;

class GetProfileAction
{
    public function get(Phys $user): array
    {
        return [
            'profile' => $user->profile,
            'phones' => $user->phones,
        ];
    }
}
