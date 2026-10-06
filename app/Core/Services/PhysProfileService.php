<?php

namespace App\Core\Services;

use App\Core\Entities\User\Phys\Phys;
use App\Core\Entities\User\Phys\ValueObjects\Holiday;
use App\Core\Entities\User\ValueObjects\FirstName;
use App\Core\Entities\User\ValueObjects\LastName;
use App\Core\Entities\User\ValueObjects\SecondName;
use App\Core\Finders\PhysFinder;
use App\Core\ValueObjects\NationalPhone;

class PhysProfileService
{
    public function updateName(int $physId, FirstName $firstName, SecondName $secondName, LastName $lastName): void
    {
        $phys = $this->getPhys($physId);
        $phys->updateName($firstName, $secondName, $lastName);
    }

    public function addPhone(int $physId, NationalPhone $phone): void
    {
        $phys = $this->getPhys($physId);
        $phys->addPhone($phone);
    }

    public function deletePhone(int $physId, int $phoneId): void
    {
        $phys = $this->getPhys($physId);
        $phys->deletePhone($phoneId);
    }

    public function updateHoliday(int $physId, Holiday $holiday): void
    {
        $phys = $this->getPhys($physId);
        $phys->updateHoliday($holiday);
    }

    private function getPhys(int $id): Phys
    {
        return PhysFinder::getById($id);
    }
}
