<?php

namespace App\Manager\Modules\Phys\Http\Controllers;

use App\Core\Http\Controllers\AbstractController;
use App\Manager\Modules\Phys\Http\Requests\Profile\AddPhoneRequest;
use App\Manager\Modules\Phys\Http\Requests\Profile\ChangePasswordRequest;
use App\Manager\Modules\Phys\Http\Requests\Profile\UpdateHolidayRequest;
use App\Manager\Modules\Phys\Http\Requests\Profile\UpdateNameRequest;
use App\Manager\Modules\Phys\UseCases\ProfileService;
use App\Manager\Modules\Phys\Views\ProfileView;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class ProfileController extends AbstractController
{
    public function __construct(
        private ProfileService $service
    ) {}

    public function view(ProfileView $view)
    {
        $params = $view->get($this->getUser());

        return Inertia::render('manager/phys/settings/account/index', $params);
    }

    public function updateName(UpdateNameRequest $request)
    {
        $this->service->updateName($this->getUserId(), $request);

        return back()->with('success', 'Успешно обновлено');
    }

    public function addPhone(AddPhoneRequest $request)
    {
        $this->service->addPhone($this->getUserId(), $request);

        return back()->with('success', 'Успешно обновлено');
    }

    public function deletePhone(int $id)
    {
        $this->service->deletePhone($this->getUserId(), $id);

        return back()->with('success', 'Успешно удалено');
    }

    public function updateHoliday(UpdateHolidayRequest $request)
    {
        $this->service->updateHoliday($this->getUserId(), $request);

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @return RedirectResponse
     *
     * @throws \Throwable
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $this->service->changePassword($this->getUserId(), $request);

        return back()->with('success', 'Пароль успешно изменен');
    }
}
