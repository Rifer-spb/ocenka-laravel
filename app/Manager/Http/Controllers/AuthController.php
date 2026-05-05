<?php

namespace App\Manager\Http\Controllers;

use App\Core\Http\Controllers\AbstractAuthController;
use App\Core\Models\User\User;
use App\Manager\Http\Requests\Auth\SignInRequest;
use App\Manager\Http\Requests\Auth\SignUpRequest;
use App\Manager\UseCases\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthController extends AbstractAuthController
{
    public function viewSignUp()
    {
        return Inertia::render('manager/auth/signUp/signUp');
    }

    /**
     * @throws \Throwable
     */
    public function signUp(SignUpRequest $request, UserService $service)
    {
        $user = $service->register($request);

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
