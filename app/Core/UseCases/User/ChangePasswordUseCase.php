<?php

namespace App\Core\UseCases\User;

use App\Core\Models\User\User;
use App\Core\Models\User\ValueObjects\Password;
use Illuminate\Support\Facades\Hash;

/**
 * Тесты @see \Integration\Core\UseCases\User\ChangePasswordTest
 */
class ChangePasswordUseCase
{
    /**
     * @throws \Throwable
     */
    public function execute(User $user, Password $oldPassword, Password $newPassword): void
    {
        if (! Hash::check($oldPassword->getValue(), $user->password)) {
            throw new \DomainException('Неверный текущий пароль.');
        }

        $user->updatePassword($newPassword);
        $user->saveOrFail();
    }
}
