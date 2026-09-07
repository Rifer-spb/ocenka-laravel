<?php

namespace App\Manager\UseCases\Legal\Profile;

use App\Core\Models\LegalType;
use App\Core\Models\User\Legal\Dto\Company;
use App\Core\Models\User\Legal\Legal;

class UpdateCompanyUseCase
{
    public function execute(Legal $legal, int $typeId, Company $company): void
    {
        $legalType = LegalType::findOrFail($typeId);

        $legal->updateCompany($legalType, $company);
    }
}
