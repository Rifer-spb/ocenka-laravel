<?php

namespace App\Manager\Modules\Phys\UseCases;

use App\Core\Models\User\Phys\Phys;
use App\Manager\Modules\Phys\Http\Requests\Profile\UpdateHolidayRequest;

class ProfileService
{
    public function updateHoliday(int $id, UpdateHolidayRequest $request): void
    {
        $user = Phys::findOrFail($id);
        $user->updateHoliday(
            $request->holidayFrom,
            $request->holidayTo
        );
    }
}
