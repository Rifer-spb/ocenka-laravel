<?php

namespace Feature\Manager\Http\Controllers\Auth;

use App\Core\Models\User\Role;
use App\Core\Models\User\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SignInTest extends TestCase
{
    public function testRequired()
    {
        $response = $this->post($this->getApiRoute(), [
            'email' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
        $response->assertSessionHasErrors([
            'email' => 'Email обязателен для заполнения',
            'password' => 'Пароль обязателен для заполнения',
        ]);
    }

    public function testMaxLength()
    {
        $response = $this->post($this->getApiRoute(), [
            'email' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut
            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
            aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
            dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
            deserunt mollit anim id est laborum.',
            'password' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut
            labore et dolore magna aliqua. Ut enim ad minim veniam, ',
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
        $response->assertSessionHasErrors([
            'email' => 'Email не может быть длиннее 255 символов',
            'password' => 'Пароль не может быть длиннее 50 символов',
        ]);
    }

    public function testInvalidEmail()
    {
        $response = $this->post($this->getApiRoute(), [
            'email' => 'invalid-email',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);
        $response->assertSessionHasErrors([
            'email' => 'Введите корректный email адрес',
        ]);
    }

    public function testNotExist()
    {
        $response = $this->post($this->getApiRoute(), [
            'email' => 'not-exist@example.com',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);
        $response->assertSessionHasErrors([
            'email' => 'Пользователь с таким email не найден',
        ]);
    }

    public function testSuccess()
    {
        $user = User::create([
            'username' => 'exist@example.com',
            'email' => 'exist@example.com',
            'password' => Hash::make($password = 'password123'),
            'role' => Role::LEGAL->value,
        ]);

        $response = $this->post($this->getApiRoute(), [
            'email' => 'exist@example.com',
            'password' => $password,
        ]);

        $this->assertAuthenticated();
        $this->assertAuthenticatedAs($user);

        $redirectUrl = route("manager.{$user->role}.home");
        $response->assertRedirect($redirectUrl);
    }

    private function getApiRoute(): string
    {
        return route('manager.auth.signIn');
    }
}
