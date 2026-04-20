<?php

namespace App\Http\Controllers;

use App\Models\User\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;

class BaseAuthController extends Controller
{
    public function __construct(
        protected StatefulGuard $guard
    ) {}

    /**
     * @throws \Throwable
     */
    public function _login(User $user, Request $request, string $redirectTo)
    {
        $this->guard->login($user);

        if ($request->hasSession()) {
            $request->session()->regenerate();
        }

        return redirect()->route($redirectTo);
    }

    public function _authenticate(array $credentials, Request $request, string $redirectTo)
    {
        if ($this->guard->attempt($credentials)) {
            if ($request->hasSession()) {
                $request->session()->regenerate();
            }

            return redirect()->intended(route($redirectTo));
        }

        return false;
    }

    public function _logout(Request $request, string $redirectTo)
    {
        $this->guard->logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route($redirectTo);
    }
}
