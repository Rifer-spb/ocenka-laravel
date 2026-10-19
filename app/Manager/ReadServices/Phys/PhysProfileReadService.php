<?php

namespace App\Manager\ReadServices\Phys;

use App\Core\Entities\User\Phys\Phys;

class PhysProfileReadService
{
    public function getProfile(Phys $phys): array
    {
        return $phys->profile->toArray();
    }

    public function getPhones(Phys $phys): array
    {
        return $phys->phones->all();
    }
}
