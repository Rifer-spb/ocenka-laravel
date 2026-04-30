<?php

namespace App\Manager\UseCases;

use App\Core\Jobs\SendMailJob;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\User;
use App\Core\Models\User\UserFactory;
use App\Manager\Http\Requests\Auth\SignUpRequest;
use App\Manager\Mails\Auth\SignUpMail;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function __construct(
        private UserFactory $userFactory
    ) {}

    /**
     * @throws \Throwable
     */
    public function register(SignUpRequest $request): User
    {
        /** @var Phys|Legal $userClass */
        $userClass = $this->userFactory->create($request->role);

        DB::beginTransaction();

        try {
            $user = $userClass::signUpManager(
                $request->email,
                $request->password,
                $request->role
            );

            $signUpMail = new SignUpMail(
                username: $user->username,
                password: $request->password,
                emailVerifyToken: $user->email_verify_token,
                emailTo: $user->email,
            );

            SendMailJob::dispatch($signUpMail);

            DB::commit();

            return $user;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
