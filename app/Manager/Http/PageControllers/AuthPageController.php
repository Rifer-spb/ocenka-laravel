<?php

namespace App\Manager\Http\PageControllers;

use App\Core\Http\Controllers\AbstractAuthController;
use App\Core\Models\User\Role;
use App\Core\Models\User\User;
use App\Core\Models\User\ValueObjects\Password;
use App\Core\Services\UserService;
use App\Core\ValueObjects\Email;
use App\Manager\Http\Requests\Auth\SignInRequest;
use App\Manager\Http\Requests\Auth\SignUpRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AuthPageController extends AbstractAuthController
{
    public function __construct(
        private UserService $service
    )
    {
    }

    public function viewSignUp(): Response
    {
        return Inertia::render('manager/auth/signUp/signUp');
    }

    public function viewSignIn(): Response
    {
        return Inertia::render('manager/auth/signIn/signIn');
    }

    /**
     * @throws \Throwable
     *
     * Тесты @see \Feature\Manager\Http\Controllers\User\SignUpTest
     */
    public function signUp(SignUpRequest $request)
    {
        $user = $this->service->signUpManager(
            new Email($request->email),
            new Password($request->password),
            Role::from($request->role)
        );

        return $this->_login($user, $request, "manager.{$user->role}.home");
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     *
     * Тесты @see \Feature\Manager\Http\Controllers\User\LogoutTest
     */
    public function logout(Request $request)
    {
        return $this->_logout($request, 'manager.home');
    }

    /**
     * @param SignInRequest $request
     * @return RedirectResponse
     *
     * Тесты @see \Feature\Manager\Http\Controllers\User\SignInTest
     */
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
