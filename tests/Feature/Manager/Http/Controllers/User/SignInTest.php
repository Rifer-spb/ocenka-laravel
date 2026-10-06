<?php

namespace Feature\Manager\Http\Controllers\User;

use App\Core\Entities\User\Role;
use App\Core\Entities\User\User;
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
            'email' => str_repeat('а', 256),
            'password' => str_repeat('а', 51),
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
