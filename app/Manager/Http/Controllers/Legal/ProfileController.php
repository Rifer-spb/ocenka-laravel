<?php

namespace App\Manager\Http\Controllers\Legal;

use App\Core\Entities\User\Legal\ValueObjects\Company;
use App\Core\Entities\User\Legal\ValueObjects\RegistryTemplate;
use App\Core\Entities\User\ValueObjects\Password;
use App\Core\Http\Controllers\AbstractController;
use App\Core\Services\LegalProfileService;
use App\Core\Services\UserService;
use App\Manager\Http\Requests\ChangePasswordRequest;
use App\Manager\Http\Requests\Legal\Profile\UpdateCompanyRequest;
use App\Manager\Http\Requests\Legal\Registry\UpdateTemplateRequest;

class ProfileController extends AbstractController
{
    public function __construct(
        private UserService $userService,
        private LegalProfileService $profileService
    )
    {
    }

    /**
     * @throws \Throwable
     */
    public function updateCompany(UpdateCompanyRequest $request)
    {
        $this->profileService->updateCompany(
            $this->getUserId(),
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
    public function changePassword(ChangePasswordRequest $request)
    {
        $this->userService->changePassword(
            $this->getUserId(),
            new Password($request->oldPassword),
            new Password($request->newPassword)
        );

        return back()->with('success', 'Пароль успешно изменен');
    }

    /**
     * @throws \Throwable
     */
    public function updateRegistryTemplate(UpdateTemplateRequest $request)
    {
        $this->profileService->updateRegistryTemplate(
            $this->getUserId(),
            new RegistryTemplate($request->template)
        );

        return back()->with(['success' => 'Успешно обновлено']);
    }
}
