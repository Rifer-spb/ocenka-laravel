<?php

namespace App\Manager\Modules\Phys\Actions\Profile;

use App\Core\Models\User\Phys\Phys;
use App\Manager\Modules\Phys\Http\Requests\Profile\AddPhoneRequest;

class AddPhoneAction
{
    public function add(Phys $user, AddPhoneRequest $request): void
    {
        $user->addPhone($request->phone);
    }
}
