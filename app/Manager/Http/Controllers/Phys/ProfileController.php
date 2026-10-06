<?php

namespace App\Manager\Http\Controllers\Phys;

use App\Core\Http\Controllers\AbstractController;
use App\Core\Entities\User\Phys\PhysPhone;
use App\Core\Entities\User\Phys\ValueObjects\Holiday;
use App\Core\Entities\User\ValueObjects\FirstName;
use App\Core\Entities\User\ValueObjects\LastName;
use App\Core\Entities\User\ValueObjects\Password;
use App\Core\Entities\User\ValueObjects\SecondName;
use App\Core\Services\PhysProfileService;
use App\Core\Services\UserService;
use App\Core\ValueObjects\NationalPhone;
use App\Manager\Http\Requests\ChangePasswordRequest;
use App\Manager\Http\Requests\Phys\Profile\AddPhoneRequest;
use App\Manager\Http\Requests\Phys\Profile\UpdateHolidayRequest;
use App\Manager\Http\Requests\Phys\Profile\UpdateNameRequest;
use Illuminate\Http\RedirectResponse;

class ProfileController extends AbstractController
{
    public function __construct(
        private UserService $userService,
        private PhysProfileService $profileService
    )
    {
    }

    /**
     * @param UpdateNameRequest $request
     * @return RedirectResponse
     *
     * Тесты @see \Feature\Manager\Http\Controllers\Phys\Profile\UpdateNameTest
     */
    public function updateName(UpdateNameRequest $request): RedirectResponse
    {
        $this->profileService->updateName(
            $this->getUserId(),
            new FirstName($request->firstName),
            new SecondName($request->secondName),
            new LastName($request->lastName),
        );

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @param AddPhoneRequest $request
     * @return RedirectResponse
     *
     * Тесты @see \Feature\Manager\Http\Controllers\Phys\Profile\Phone\AddPhoneTest
     */
    public function addPhone(AddPhoneRequest $request)
    {
        $this->profileService->addPhone(
            $this->getUserId(),
            new NationalPhone($request->phone),
        );

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @param PhysPhone $phone
     * @return RedirectResponse
     *
     * Тесты @see \Feature\Manager\Http\Controllers\Phys\Profile\Phone\DeletePhoneTest
     */
    public function deletePhone(PhysPhone $phone)
    {
        $this->profileService->deletePhone($this->getUserId(), $phone->id);

        return back()->with('success', 'Успешно удалено');
    }

    /**
     * @param UpdateHolidayRequest $request
     * @return RedirectResponse
     *
     * Тесты @see \Feature\Manager\Http\Controllers\Phys\Profile\UpdateHolidayTest
     */
    public function updateHoliday(UpdateHolidayRequest $request)
    {
        $holiday = new Holiday($request->holidayFrom, $request->holidayTo);

        $this->profileService->updateHoliday($this->getUserId(), $holiday);

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @param ChangePasswordRequest $request
     * @return RedirectResponse
     * @throws \Throwable
     *
     * Тесты @see \Feature\Manager\Http\Controllers\User\ChangePasswordTest
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $this->userService->changePassword(
            $this->getUserId(),
            new Password($request->oldPassword),
            new Password($request->newPassword),
        );

        return back()->with('success', 'Пароль успешно изменен');
    }
}
