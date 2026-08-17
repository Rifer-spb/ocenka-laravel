<?php

namespace App\Manager\Modules\Phys\UseCases;

use App\Core\Models\User\Phys\Phys;
use App\Manager\Modules\Phys\Http\Requests\Profile\AddPhoneRequest;
use App\Manager\Modules\Phys\Http\Requests\Profile\UpdateHolidayRequest;
use App\Manager\Modules\Phys\Http\Requests\Profile\UpdateNameRequest;

class ProfileService
{
    public function addPhone(int $id, AddPhoneRequest $request): void
    {
        $user = Phys::findOrFail($id);
        $user->addPhone($request->phone);
    }

    public function deletePhone(int $userId, int $phoneId): void
    {
        $user = Phys::findOrFail($userId);
        $user->deletePhone($phoneId);
    }

    public function updateHoliday(int $id, UpdateHolidayRequest $request): void
    {
        $user = Phys::findOrFail($id);
        $user->updateHoliday(
            $request->holidayFrom,
            $request->holidayTo
        );
    }
}
