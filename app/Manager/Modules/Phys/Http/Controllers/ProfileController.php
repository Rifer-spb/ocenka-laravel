<?php

namespace App\Manager\Modules\Phys\Http\Controllers;

use App\Core\Http\Controllers\AbstractController;
use App\Manager\Modules\Phys\Actions\Profile\AddPhoneAction;
use App\Manager\Modules\Phys\Actions\Profile\DeletePhoneAction;
use App\Manager\Modules\Phys\Actions\Profile\GetProfileAction;
use App\Manager\Modules\Phys\Actions\Profile\UpdateHolidayAction;
use App\Manager\Modules\Phys\Actions\Profile\UpdateNameAction;
use App\Manager\Modules\Phys\Http\Requests\Profile\AddPhoneRequest;
use App\Manager\Modules\Phys\Http\Requests\Profile\ChangePasswordRequest;
use App\Manager\Modules\Phys\Http\Requests\Profile\UpdateHolidayRequest;
use App\Manager\Modules\Phys\Http\Requests\Profile\UpdateNameRequest;
use Inertia\Inertia;

class ProfileController extends AbstractController
{
    public function view(GetProfileAction $action)
    {
        $profile = $action->get($this->getUser());

        return Inertia::render('manager/phys/settings/account/index', $profile);
    }

    public function updateName(UpdateNameRequest $request, UpdateNameAction $action)
    {
        $action->update($this->getUser(), $request);

        return back()->with('success', 'Успешно обновлено');
    }

    public function addPhone(AddPhoneRequest $request, AddPhoneAction $action)
    {
        $action->add($this->getUser(), $request);

        return back()->with('success', 'Успешно обновлено');
    }

    public function deletePhone(int $id, DeletePhoneAction $action)
    {
        $action->delete($this->getUser(), $id);

        return back()->with('success', 'Успешно удалено');
    }

    public function updateHoliday(UpdateHolidayRequest $request, UpdateHolidayAction $action)
    {
        $action->update($this->getUser(), $request);

        return back()->with('success', 'Успешно обновлено');
    }

    public function changePassword(ChangePasswordRequest $request)
    {

    }
}
