<?php

namespace App\Manager\Modules\Legal\Http\Controllers;

use App\Core\Http\Controllers\AbstractController;
use App\Core\Models\User\ValueObjects\Password;
use App\Core\UseCases\User\ChangePasswordUseCase;
use App\Manager\Http\Requests\ChangePasswordRequest;
use App\Manager\Modules\Legal\Http\Requests\Profile\UpdateCompanyRequest;
use App\Manager\Modules\Legal\UseCases\ProfileService;
use App\Manager\Modules\Legal\Views\ProfileView;
use Inertia\Inertia;

class ProfileController extends AbstractController
{
    public function __construct(
        private ProfileService $profileService
    ) {}

    public function view(ProfileView $view)
    {
        $params = $view->get($this->getUser());

        return Inertia::render('manager/legal/settings/account/index', $params);
    }

    public function updateCompany(UpdateCompanyRequest $request)
    {
        $this->profileService->updateCompany($this->getUserId(), $request);

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
