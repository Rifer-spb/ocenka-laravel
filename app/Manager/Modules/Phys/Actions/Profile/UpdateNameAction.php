<?php

namespace App\Manager\Modules\Phys\Actions\Profile;

use App\Core\Models\User\Phys\Phys;
use App\Manager\Modules\Phys\Http\Requests\Profile\UpdateNameRequest;

class UpdateNameAction
{
    public function update(Phys $user, UpdateNameRequest $request): void
    {
        $user->updateName(
            $request->get('firstName'),
            $request->get('secondName'),
            $request->get('lastName'),
        );
    }
}
