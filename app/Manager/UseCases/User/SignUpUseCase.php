<?php

namespace App\Manager\UseCases\User;

use App\Core\Jobs\SendMailJob;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\Role;
use App\Core\Models\User\User;
use App\Core\Models\User\ValueObjects\Password;
use App\Core\ValueObjects\Email;
use App\Manager\Mails\Auth\SignUpMail;
use Illuminate\Support\Facades\DB;

class SignUpUseCase
{
    /**
     * @throws \Throwable
     */
    public function execute(Email $email, Password $password, Role $role): User
    {
        $user = DB::transaction(function () use ($email, $password, $role) {
            if ($role->isLegal()) {
                return Legal::signUpManager($email, $password, $role);
            }

            return Phys::signUpManager($email, $password, $role);
        });

        $signUpMail = new SignUpMail(
            username: $user->username,
            password: $password->getValue(),
            emailVerifyToken: $user->email_verify_token,
            emailTo: $user->email,
        );

        SendMailJob::dispatch($signUpMail);

        return $user;
    }
}
