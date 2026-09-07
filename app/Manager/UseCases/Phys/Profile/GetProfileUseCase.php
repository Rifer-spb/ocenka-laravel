<?php

namespace App\Manager\UseCases\Phys\Profile;

use App\Core\Models\User\Phys\Phys;

class GetProfileUseCase
{
    public function execute(Phys $phys): array
    {
        return [
            'profile' => $phys->profile,
            'phones' => $phys->phones,
        ];
    }
}
