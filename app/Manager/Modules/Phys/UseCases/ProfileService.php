<?php

namespace App\Manager\Modules\Phys\UseCases;

use App\Core\Models\User\Phys\Phys;
use App\Manager\Modules\Phys\Http\Requests\Profile\AddPhoneRequest;
use App\Manager\Modules\Phys\Http\Requests\Profile\ChangePasswordRequest;
use App\Manager\Modules\Phys\Http\Requests\Profile\UpdateHolidayRequest;
use App\Manager\Modules\Phys\Http\Requests\Profile\UpdateNameRequest;
use Illuminate\Support\Facades\Hash;

class ProfileService
{
    public function updateName(int $id, UpdateNameRequest $request): void
    {
        $user = Phys::findOrFail($id);
        $user->updateName(
            $request->firstName,
            $request->secondName,
            $request->lastName
        );
    }

    public function addPhone(int $id, AddPhoneRequest $request): void
    {
        $user = Phys::findOrFail($id);
        $user->addPhone($request->phone);
    }

    public function deletePhone(int $userId, int $phoneId): void
    {
        $user = Phys::findOrFail($userId);
        $user->deletePhone($phoneId);
    }

    public function updateHoliday(int $id, UpdateHolidayRequest $request): void
    {
        $user = Phys::findOrFail($id);
        $user->updateHoliday(
            $request->holidayFrom,
            $request->holidayTo
        );
    }

    /**
     * @throws \Throwable
     */
    public function changePassword(int $id, ChangePasswordRequest $request): void
    {
        $user = Phys::findOrFail($id);

        if (! Hash::check($request->oldPassword, $user->password)) {
            throw new \DomainException('Неверный текущий пароль');
        }

        $user->updatePassword($request->newPassword);
        $user->saveOrFail();
    }
}
