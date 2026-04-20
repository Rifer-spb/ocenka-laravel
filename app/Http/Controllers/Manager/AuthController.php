<?php

namespace App\Http\Controllers\Manager;

use App\Actions\Manager\Auth\SignUpAction;
use App\Http\Controllers\BaseAuthController;
use App\Http\Requests\Auth\SignUpRequest;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthController extends BaseAuthController
{
    public function __construct(StatefulGuard $guard)
    {
        parent::__construct($guard);
    }

    public function viewSignUp()
    {
        return Inertia::render('manager/auth/signUp/signUp');
    }

    /**
     * @throws \Throwable
     */
    public function signUp(SignUpRequest $request, SignUpAction $action)
    {
        $user = $action->signUp($request);

        return $this->_login($user, $request, 'manager.home');
    }

    public function logout(Request $request)
    {
        return $this->_logout($request, 'manager.home');
    }
}
