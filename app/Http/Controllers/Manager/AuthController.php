<?php

namespace App\Http\Controllers\Manager;

use App\Actions\Manager\Auth\SignUpAction;
use App\Http\Controllers\BaseAuthController;
use App\Http\Requests\Auth\SignInRequest;
use App\Http\Requests\Auth\SignUpRequest;
use App\Models\User\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthController extends BaseAuthController
{
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

        return $this->_login($user, $request, "manager.{$user->role}.home");
    }

    public function logout(Request $request)
    {
        return $this->_logout($request, 'manager.home');
    }

    public function viewSignIn()
    {
        return Inertia::render('manager/auth/signIn/signIn');
    }

    public function signIn(SignInRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $result = $this->_authenticate($credentials, $request, function (User $user) {
            return "manager.{$user->role}.home";
        });

        if (! $result) {
            return back()
                ->withErrors(['email' => 'Неверный email или пароль'])
                ->onlyInput('email');
        }

        return $result;
    }
}
