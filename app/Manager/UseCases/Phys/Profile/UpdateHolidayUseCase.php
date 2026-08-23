<?php

namespace App\Manager\UseCases\Phys\Profile;

use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\Phys\ValueObjects\Holiday;

class UpdateHolidayUseCase
{
    public function execute(Phys $user, Holiday $holiday): void
    {
        $user->updateHoliday($holiday);
    }
}
