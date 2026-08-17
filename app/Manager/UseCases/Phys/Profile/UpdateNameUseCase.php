<?php

namespace App\Manager\UseCases\Phys\Profile;

use App\Core\Models\User\Phys\Phys;

class UpdateNameUseCase
{
    public function execute(Phys $phys, string $firstName, string $secondName, string $lastName): void
    {
        $phys->updateName($firstName, $secondName, $lastName);
    }
}
