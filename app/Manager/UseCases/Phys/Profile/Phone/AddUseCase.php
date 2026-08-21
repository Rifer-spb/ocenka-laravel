<?php

namespace App\Manager\UseCases\Phys\Profile\Phone;

use App\Core\Models\User\Phys\Phys;
use App\Core\ValueObjects\NationalPhone;

class AddUseCase
{
    public function execute(Phys $user, NationalPhone $phone) : void
    {
        $user->addPhone($phone);
    }
}
