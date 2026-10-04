<?php

namespace App\Core\Services;

use App\Core\Jobs\SendMailJob;
use App\Core\Mails\User\SignUpManagerMail;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\Role;
use App\Core\Models\User\User;
use App\Core\Models\User\ValueObjects\Password;
use App\Core\ValueObjects\Email;
use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * @param int $userId
     * @param Password $oldPassword
     * @param Password $newPassword
     * @return void
     * @throws \Throwable
     */
    public function changePassword(int $userId, Password $oldPassword, Password $newPassword): void
    {
        $user = User::findOrFail($userId);
        $user->changePassword($oldPassword, $newPassword);
        $user->saveOrFail();
    }

    /**
     * @param Email $email
     * @param Password $password
     * @param Role $role
     * @return User
     * @throws \Throwable
     */
    public function signUpManager(Email $email, Password $password, Role $role): User
    {
        if (! $role->isManager()) {
            throw new \DomainException('Роль должна быть юр.лицо или физ.лицо.');
        }

        $user = DB::transaction(function () use ($email, $password, $role) {
            if ($role->isLegal()) {
                return Legal::createNew($email, $password);
            }

            return Phys::createNew($email, $password);
        });

        $signUpMail = new SignUpManagerMail(
            username: $user->username,
            password: $password->getValue(),
            emailVerifyToken: $user->email_verify_token,
            emailTo: $user->email,
        );

        SendMailJob::dispatch($signUpMail);

        return $user;
    }
}
