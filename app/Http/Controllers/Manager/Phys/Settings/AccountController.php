<?php

namespace App\Http\Controllers\Manager\Phys\Settings;

use App\Actions\Manager\Phys\Settings\AccountService;
use App\Http\Controllers\AbstractController;
use App\Http\Requests\Manager\Phys\Settings\Account\AddPhoneRequest;
use App\Http\Requests\Manager\Phys\Settings\Account\ChangePasswordRequest;
use App\Http\Requests\Manager\Phys\Settings\Account\HolidayRequest;
use App\Http\Requests\Manager\Phys\Settings\Account\NameRequest;
use App\Models\User\Phys\PhysPhone;
use Inertia\Inertia;

class AccountController extends AbstractController
{
    public function __construct(
        private AccountService $service
    ) {}

    public function view()
    {
        $data = $this->service->getData($this->getUser());

        return Inertia::render('manager/phys/settings/account/index', $data);
    }

    public function updateName(NameRequest $request)
    {
        $this->service->updateName($this->getUser(), $request);

        return back()->with('success', 'Успешно обновлено');
    }

    public function addPhone(AddPhoneRequest $request)
    {
        $this->service->addPhone($this->getUser(), $request);

        return back()->with('success', 'Успешно обновлено');
    }

    public function deletePhone(PhysPhone $phone)
    {
        $this->service->deletePhone($this->getUser(), $phone->id);

        return back()->with('success', 'Успешно удалено');
    }

    public function updateHoliday(HolidayRequest $request)
    {
        $this->service->updateHoliday($this->getUser(), $request);

        return back()->with('success', 'Успешно обновлено');
    }

    public function changePassword(ChangePasswordRequest $request)
    {

    }
}
