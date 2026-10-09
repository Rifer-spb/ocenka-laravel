<?php

namespace Tests\Feature\Manager\Http\Controllers\User;

use App\Core\Entities\User\Role;
use App\Core\Entities\User\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function testLogout()
    {
        $user = User::create([
            'username' => 'exist@example.com',
            'email' => 'exist@example.com',
            'password' => Hash::make($password = 'password123'),
            'role' => Role::LEGAL->value,
        ]);

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
