<?php

namespace App\Manager\Actions\Auth;

use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\User;
use App\Core\Models\User\UserFactory;
use App\Manager\Http\Requests\Auth\SignUpRequest;
use App\Manager\Jobs\Auth\SendSignUpEmailJob;
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
