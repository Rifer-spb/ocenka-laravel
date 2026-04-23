<?php

namespace App\Http\Controllers;

use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

abstract class AbstractAuthController extends AbstractController
{
    protected function guard()
    {
        return Auth::guard('web');
    }

    /**
     * @throws \Throwable
     */
    protected function _login(User $user, Request $request, string $redirectTo)
    {
        $this->guard()->login($user);

        if ($request->hasSession()) {
            $request->session()->regenerate();
        }

        return redirect()->route($redirectTo);
    }

    protected function _authenticate(array $credentials, Request $request, string|callable $redirectTo)
    {
        if ($this->guard()->attempt($credentials)) {
            if ($request->hasSession()) {
                $request->session()->regenerate();
            }

            if (is_callable($redirectTo)) {
                $user = $this->guard()->user();
                $redirectTo = $redirectTo($user);
            }

            return redirect()->intended(route($redirectTo));
        }

        return false;
    }

    protected function _logout(Request $request, string $redirectTo)
    {
        $this->guard()->logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route($redirectTo);
    }
}
