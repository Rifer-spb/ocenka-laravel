<?php

namespace App\Manager\UseCases\Phys\Profile\Phone;

use App\Core\Models\User\Phys\Phys;

class DeleteUseCase
{
    public function execute(Phys $user, int $id): void
    {
        $user->deletePhone($id);
    }
}
