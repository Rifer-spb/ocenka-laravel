<?php

namespace App\Manager\Modules\Phys\Actions\Profile;

use App\Core\Models\User\Phys\Phys;

class DeletePhoneAction
{
    public function delete(Phys $user, int $phoneId): void
    {
        $user->deletePhone($phoneId);
    }
}
