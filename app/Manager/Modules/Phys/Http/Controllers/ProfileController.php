<?php

namespace App\Manager\Modules\Phys\Http\Controllers;

use App\Core\Http\Controllers\AbstractController;
use App\Core\Models\User\ValueObjects\Password;
use App\Manager\Http\Requests\ChangePasswordRequest;
use App\Manager\Modules\Phys\Http\Requests\Profile\AddPhoneRequest;
use App\Manager\Modules\Phys\Http\Requests\Profile\UpdateHolidayRequest;
use App\Manager\Modules\Phys\Http\Requests\Profile\UpdateNameRequest;
use App\Manager\Modules\Phys\UseCases\ProfileService;
use App\Manager\Modules\Phys\Views\ProfileView;
use App\Manager\UseCases\User\ChangePasswordUseCase;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class ProfileController extends AbstractController
{
    public function __construct(
        private ProfileService $profileService,
    ) {}

    public function view(ProfileView $view)
    {
        $params = $view->get($this->getUser());

        return Inertia::render('manager/phys/settings/account/index', $params);
    }

    public function updateName(UpdateNameRequest $request)
    {
        $this->profileService->updateName($this->getUserId(), $request);

        return back()->with('success', 'Успешно обновлено');
    }

    public function addPhone(AddPhoneRequest $request)
    {
        $this->profileService->addPhone($this->getUserId(), $request);

        return back()->with('success', 'Успешно обновлено');
    }

    public function deletePhone(int $id)
    {
        $this->profileService->deletePhone($this->getUserId(), $id);

        return back()->with('success', 'Успешно удалено');
    }

    public function updateHoliday(UpdateHolidayRequest $request)
    {
        $this->profileService->updateHoliday($this->getUserId(), $request);

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @return RedirectResponse
     *
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
