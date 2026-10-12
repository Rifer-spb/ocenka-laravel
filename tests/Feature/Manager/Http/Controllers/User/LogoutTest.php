<?php

namespace Tests\Feature\Manager\Http\Controllers\User;

use App\Core\Entities\User\Role;
use App\Core\Entities\User\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    /**
     * @throws \Throwable
     */
    public function testLogout()
    {
        $user = new User();
        $user->username = 'exist@example.com';
        $user->email = 'exist@example.com';
        $user->password = Hash::make($password = 'password123');
        $user->role = Role::LEGAL->value;
        $user->saveOrFail();

        $this->post($this->getSignInRoute(), [
            'email' => 'exist@example.com',
            'password' => $password,
        ]);
        $this->assertAuthenticatedAs($user);

        $response = $this->post($this->getLogoutRoute());
        $this->assertGuest();
        $response->assertRedirect(route('manager.home'));
    }

    private function getSignInRoute(): string
    {
        return route('manager.auth.signIn');
    }

    private function getLogoutRoute(): string
    {
        return route('manager.auth.logout');
    }
}
