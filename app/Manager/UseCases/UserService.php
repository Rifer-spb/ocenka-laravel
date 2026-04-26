<?php

namespace App\Manager\UseCases;

use App\Core\Jobs\SendMailJob;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\User;
use App\Core\Models\User\UserFactory;
use App\Manager\Http\Requests\Auth\SignUpRequest;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function __construct(
        private UserFactory $userFactory
    ) {}

    /**
     * @param SignUpRequest $request
     * @return User
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

            DB::commit();

            SendMailJob::dispatch(
                'emails.manager.sign-up',
                [
                    'appName' => config('app.name'),
                    'username' => $user->username,
                    'password' => $request->password,
                    'verifyLink' => url('/manager/auth/verify-email?token='),
                ],
                $user->email,
                'Регистрация на сайте',
            );

            return $user;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
