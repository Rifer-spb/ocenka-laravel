<?php

namespace App\Manager\Modules\Legal\UseCases;

use App\Core\Models\Legal\Company;
use App\Core\Models\User\Legal\Legal;
use App\Manager\Modules\Legal\Http\Requests\Profile\UpdateCompanyRequest;

class ProfileService
{
    public function updateCompany(int $userId, UpdateCompanyRequest $request): void
    {
        $user = Legal::findOrFail($userId);

        $company = new Company(
            $request->typeId,
            $request->fullName,
            $request->shortName,
            $request->abbr,
            $request->address,
            $request->dateOgrn,
            $request->inn,
            $request->kpp,
            $request->ogrn,
        );

        $user->updateCompany($company);
    }
}
