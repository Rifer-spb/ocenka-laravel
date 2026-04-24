<?php

namespace App\Manager\Modules\Phys\Actions\Profile;

use App\Core\Models\User\Phys\Phys;
use App\Manager\Modules\Phys\Http\Requests\Profile\UpdateHolidayRequest;

class UpdateHolidayAction
{
    public function update(Phys $user, UpdateHolidayRequest $request): void
    {
        $user->updateHoliday(
            $request->get('holidayFrom'),
            $request->get('holidayTo'),
        );
    }
}
