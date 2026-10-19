<?php

namespace App\Core\Services;

use App\Core\Attributes\TestClass;
use App\Core\Entities\User\Legal\LegalPhone;
use App\Core\Entities\User\Legal\ValueObjects\Company;
use App\Core\Entities\User\Legal\ValueObjects\RegistryTemplate;
use App\Core\Finders\LegalFinder;
use App\Core\Finders\LegalTypeFinder;
use App\Core\ValueObjects\NationalPhone;
use Tests\Integration\Core\Services\Legal\Profile\AddPhoneTest;
use Tests\Integration\Core\Services\Legal\Profile\DeletePhoneTest;
use Tests\Integration\Core\Services\Legal\Profile\UpdateCompanyTest;
use Tests\Integration\Core\Services\Legal\Profile\UpdateRegistryTest;

class LegalProfileService
{
    /**
     * @throws \Throwable
     */
    #[TestClass(UpdateCompanyTest::class)]
    public function updateCompany(int $legalId, int $typeId, Company $company): void
    {
        $legal = LegalFinder::getById($legalId);
        $type = LegalTypeFinder::getById($typeId);

        $legal->updateCompany($type, $company);
    }

    /**
     * @throws \Throwable
     */
    #[TestClass(UpdateRegistryTest::class)]
    public function updateRegistryTemplate(int $legalId, RegistryTemplate $template): void
    {
        $legal = LegalFinder::getById($legalId);
        $legal->updateRegistryTemplate($template);
    }

    /**
     * @throws \Throwable
     */
    #[TestClass(AddPhoneTest::class)]
    public function addPhone(int $legalId, NationalPhone $phone): LegalPhone
    {
        $legal = LegalFinder::getById($legalId);
        return $legal->addPhone($phone);
    }

    /**
     * @param int $legalId
     * @param int $phoneId
     * @return void
     * @throws \Throwable
     */
    #[TestClass(DeletePhoneTest::class)]
    public function deletePhone(int $legalId, int $phoneId): void
    {
        $legal = LegalFinder::getById($legalId);
        $legal->deletePhone($phoneId);
    }
}
