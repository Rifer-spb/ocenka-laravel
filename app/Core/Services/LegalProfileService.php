<?php

namespace App\Core\Services;

use App\Core\Entities\User\Legal\Dto\Company;
use App\Core\Entities\User\Legal\ValueObjects\RegistryTemplate;
use App\Core\Finders\LegalFinder;
use App\Core\Finders\LegalTypeFinder;

class LegalProfileService
{
    /**
     * @throws \Throwable
     */
    public function updateCompany(int $legalId, int $typeId, Company $company): void
    {
        $legal = LegalFinder::getById($legalId);
        $type = LegalTypeFinder::getById($typeId);

        $legal->updateCompany($type, $company);
    }

    /**
     * @throws \Throwable
     */
    public function updateRegistryTemplate(int $legalId, RegistryTemplate $template): void
    {
        $legal = LegalFinder::getById($legalId);
        $legal->updateRegistryTemplate($template);
    }
}
