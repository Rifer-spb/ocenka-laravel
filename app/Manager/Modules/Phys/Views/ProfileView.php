<?php

namespace App\Manager\Modules\Phys\Views;

use App\Core\Models\User\Phys\Phys;

class ProfileView
{
    public function get(Phys $user): array
    {
        return [
            'profile' => $user->profile,
            'phones' => $user->phones,
        ];
    }
}
