<?php

namespace App\Manager\UseCases\Phys\Profile;

use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\ValueObjects\FirstName;
use App\Core\Models\User\ValueObjects\LastName;
use App\Core\Models\User\ValueObjects\SecondName;

/**
 * Тесты @see \Integration\Manager\UseCases\Phys\Profile\UpdateNameTest
 */
class UpdateNameUseCase
{
    public function execute(Phys $phys, FirstName $firstName, SecondName $secondName, LastName $lastName): void
    {
        $phys->updateName($firstName, $secondName, $lastName);
    }
}
