<?php

namespace App\Core\Services;

use App\Core\Models\LegalType;
use App\Core\Models\User\Legal\Dto\Company;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Legal\ValueObjects\RegistryTemplate;

class LegalProfileService
{
    public function updateCompany(int $legalId, int $typeId, Company $company): void
    {
        $legal = $this->getLegal($legalId);
        $type = LegalType::findOrFail($typeId);

        $legal->updateCompany($type, $company);
    }

    public function updateRegistryTemplate(int $legalId, RegistryTemplate $template): void
    {
        $legal = $this->getLegal($legalId);
        $legal->updateRegistryTemplate($template);
    }

    private function getLegal(int $id): Legal
    {
        return Legal::findOrFail($id);
    }
}
