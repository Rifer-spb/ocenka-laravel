<?php

namespace App\Manager\Http\Controllers\Phys;

use App\Core\Http\Controllers\AbstractController;
use App\Core\Models\User\Phys\PhysPhone;
use App\Core\Models\User\Phys\ValueObjects\Holiday;
use App\Core\Models\User\ValueObjects\FirstName;
use App\Core\Models\User\ValueObjects\LastName;
use App\Core\Models\User\ValueObjects\Password;
use App\Core\Models\User\ValueObjects\SecondName;
use App\Core\ValueObjects\NationalPhone;
use App\Manager\Http\Requests\ChangePasswordRequest;
use App\Manager\Http\Requests\Phys\Profile\AddPhoneRequest;
use App\Manager\Http\Requests\Phys\Profile\UpdateHolidayRequest;
use App\Manager\Http\Requests\Phys\Profile\UpdateNameRequest;
use App\Manager\PageData\Phys\Settings\ProfilePageData;
use App\Manager\UseCases\Phys\Profile\Phone;
use App\Manager\UseCases\Phys\Profile\UpdateHolidayUseCase;
use App\Manager\UseCases\Phys\Profile\UpdateNameUseCase;
use App\Manager\UseCases\User\ChangePasswordUseCase;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class ProfileController extends AbstractController
{
    public function view(ProfilePageData $useCase)
    {
        $params = $useCase->execute($this->getUser());

        return Inertia::render('manager/phys/settings/account/index', $params);
    }

    /**
     * @param UpdateNameRequest $request
     * @param UpdateNameUseCase $useCase
     * @return RedirectResponse
     *
     * Тесты @see \Feature\Manager\Http\Controllers\Phys\Profile\UpdateNameTest
     */
    public function updateName(UpdateNameRequest $request, UpdateNameUseCase $useCase): RedirectResponse
    {
        $useCase->execute(
            $this->getUser(),
            new FirstName($request->firstName),
            new SecondName($request->secondName),
            new LastName($request->lastName),
        );

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @param AddPhoneRequest $request
     * @param Phone\AddUseCase $useCase
     * @return RedirectResponse
     *
     * Тесты @see \Feature\Manager\Http\Controllers\Phys\Profile\Phone\AddPhoneTest
     */
    public function addPhone(AddPhoneRequest $request, Phone\AddUseCase $useCase)
    {
        $useCase->execute(
            $this->getUser(),
            new NationalPhone($request->phone)
        );

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @param PhysPhone $phone
     * @param Phone\DeleteUseCase $useCase
     * @return RedirectResponse
     *
     * Тесты @see \Feature\Manager\Http\Controllers\Phys\Profile\Phone\DeletePhoneTest
     */
    public function deletePhone(PhysPhone $phone, Phone\DeleteUseCase $useCase)
    {
        $useCase->execute($this->getUser(), $phone->id);

        return back()->with('success', 'Успешно удалено');
    }

    /**
     * @param UpdateHolidayRequest $request
     * @param UpdateHolidayUseCase $useCase
     * @return RedirectResponse
     *
     * Тесты @see \Feature\Manager\Http\Controllers\Phys\Profile\UpdateHolidayTest
     */
    public function updateHoliday(UpdateHolidayRequest $request, UpdateHolidayUseCase $useCase)
    {
        $holiday = new Holiday($request->holidayFrom, $request->holidayTo);

        $useCase->execute($this->getUser(), $holiday);

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @param ChangePasswordRequest $request
     * @param ChangePasswordUseCase $useCase
     * @return RedirectResponse
     * @throws \Throwable
     *
     * Тесты @see \Feature\Manager\Http\Controllers\User\ChangePasswordTest
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
