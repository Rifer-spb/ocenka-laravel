<?php

namespace App\Http\Controllers\Manager;

use App\Actions\Manager\Auth\SignUpAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignUpRequest;
use Illuminate\Contracts\Auth\StatefulGuard;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function __construct(
        protected StatefulGuard $guard
    ) {}

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

        $this->guard->login($user);

        if ($request->hasSession()) {
            $request->session()->regenerate();
        }

        return redirect()->route("manager/{$user->role}/home");
    }
}
