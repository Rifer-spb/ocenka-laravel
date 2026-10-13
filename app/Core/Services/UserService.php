<?php

namespace App\Core\Services;

use App\Core\Attributes\TestClass;
use App\Core\Finders\UserFinder;
use App\Core\Jobs\SendMailJob;
use App\Core\Mails\User\SignUpManagerMail;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Phys\Phys;
use App\Core\Entities\User\Role;
use App\Core\Entities\User\User;
use App\Core\Entities\User\ValueObjects\Password;
use App\Core\ValueObjects\Email;
use Illuminate\Support\Facades\DB;
use Tests\Integration\Core\Services\User\ChangePasswordTest;
use Tests\Integration\Core\Services\User\SignUpTest;

class UserService
{
    /**
     * @param int $userId
     * @param Password $oldPassword
     * @param Password $newPassword
     * @return void
     * @throws \Throwable
     */
    #[TestClass(ChangePasswordTest::class)]
    public function changePassword(int $userId, Password $oldPassword, Password $newPassword): void
    {
        $user = UserFinder::getById($userId);
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
    #[TestClass(SignUpTest::class)]
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
