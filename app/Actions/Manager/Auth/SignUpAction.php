<?php

namespace App\Actions\Manager\Auth;

use App\Http\Requests\Manager\Auth\SignUpRequest;
use App\Jobs\Manager\Auth\SendSignUpEmailJob;
use App\Models\User\Legal\Legal;
use App\Models\User\Phys\Phys;
use App\Models\User\User;
use App\Models\User\UserFactory;
use Illuminate\Support\Facades\DB;

class SignUpAction
{
    public function __construct(
        private UserFactory $userFactory
    ) {}

    public function signUp(SignUpRequest $request): User
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

            SendSignUpEmailJob::dispatch($user);

            return $user;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
