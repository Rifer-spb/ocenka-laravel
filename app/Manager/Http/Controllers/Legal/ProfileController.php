<?php

namespace App\Manager\Http\Controllers\Legal;

use App\Core\Http\Controllers\AbstractController;
use App\Core\Models\User\Legal\Dto\Company;
use App\Core\Models\User\ValueObjects\Password;
use App\Manager\Http\Requests\ChangePasswordRequest;
use App\Manager\Http\Requests\Legal\Profile\UpdateCompanyRequest;
use App\Manager\UseCases\Legal\Profile\GetProfileUseCase;
use App\Manager\UseCases\Legal\Profile\UpdateCompanyUseCase;
use App\Manager\UseCases\User\ChangePasswordUseCase;
use Inertia\Inertia;

class ProfileController extends AbstractController
{
    public function view(GetProfileUseCase $useCase)
    {
        $params = $useCase->execute($this->getUser());

        return Inertia::render('manager/legal/settings/account/index', $params);
    }

    public function updateCompany(UpdateCompanyRequest $request, UpdateCompanyUseCase $useCase)
    {
        $useCase->execute(
            $this->getUser(),
            $request->typeId,
            new Company(
                $request->fullName,
                $request->shortName,
                $request->abbr,
                $request->address,
                $request->dateOgrn,
                $request->inn,
                $request->kpp,
                $request->ogrn,
            )
        );

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @throws \Throwable
     */
    public function changePassword(ChangePasswordRequest $request, ChangePasswordUseCase $useCase)
    {
        $useCase->execute(
            $this->getUser(),
            new Password($request->oldPassword),
            new Password($request->newPassword)
        );

        return back()->with('success', 'Пароль успешно изменен');
    }
}
