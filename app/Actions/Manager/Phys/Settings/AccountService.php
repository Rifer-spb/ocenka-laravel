<?php

namespace App\Actions\Manager\Phys\Settings;

use App\Http\Requests\Manager\Phys\Settings\Account\AddPhoneRequest;
use App\Http\Requests\Manager\Phys\Settings\Account\NameRequest;
use App\Models\User\Phys\Phys;

class AccountService
{
    public function getData(Phys $user): array
    {
        return [
            'profile' => $user->profile,
            'phones' => $user->phones,
        ];
    }

    public function updateName(Phys $user, NameRequest $request): void
    {
        $user->updateName(
            $request->firstName,
            $request->secondName,
            $request->lastName
        );
    }

    public function addPhone(Phys $user, AddPhoneRequest $request): void
    {
        $user->addPhone($request->phone);
    }

    public function deletePhone(Phys $user, int $phoneId): void
    {
        $user->deletePhone($phoneId);
    }
}
