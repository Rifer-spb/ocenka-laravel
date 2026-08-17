<?php

namespace Feature\Manager\Http\Controllers\Auth;

use App\Core\Models\User\Role;
use App\Core\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SignUpTest extends TestCase
{
    use RefreshDatabase;

    public function testSignUpRequired()
    {
        $response = $this->post($this->getApiRoute(), [
            'email' => '',
            'password' => '',
            'role' => '',
        ]);

        $response->assertSessionHasErrors(['email', 'password', 'role']);
        $response->assertSessionHasErrors([
            'email' => 'Email обязателен для заполнения',
            'password' => 'Пароль обязателен для заполнения',
            'role' => 'Выберите тип аккаунта',
        ]);
    }

    public function testSignUpInvalidEmail()
    {
        $response = $this->post($this->getApiRoute(), [
            'email' => 'awdawdawd',
            'password' => 'password',
            'role' => Role::LEGAL->value,
        ]);

        $response->assertSessionHasErrors(['email']);
        $response->assertSessionHasErrors([
            'email' => 'Введите корректный email адрес',
        ]);
    }

    public function testSignUpInvalidRole()
    {
        $response = $this->post($this->getApiRoute(), [
            'email' => 'legal@example.com',
            'password' => 'password',
            'role' => 'invalid-role',
        ]);

        $response->assertSessionHasErrors(['role']);
        $response->assertSessionHasErrors([
            'role' => 'Выберите корректный тип аккаунта',
        ]);
    }

    public function testSignUpMinPassword()
    {
        $response = $this->post($this->getApiRoute(), [
            'email' => 'legal@example.com',
            'password' => 'passwd',
            'role' => Role::LEGAL->value,
        ]);

        $response->assertSessionHasErrors(['password']);
        $response->assertSessionHasErrors([
            'password' => 'Пароль должен быть не менее 8 символов',
        ]);
    }

    public function testSignUpTrim()
    {
        $response = $this->post($this->getApiRoute(), [
            'email' => '   legal@example.com   ',
            'password' => '   password123   ',
            'role' => $role = Role::LEGAL->value,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'legal@example.com',
            'role' => $role,
        ]);

        $this->assertAuthenticated();

        $response->assertRedirect($this->getRouteRedirect($role));
    }

    public function testSignUpLowerCase()
    {
        $response = $this->post($this->getApiRoute(), [
            'email' => 'LEGAL@example.COM',
            'password' => 'password123',
            'role' => $role = Role::LEGAL->value,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'legal@example.com',
            'role' => $role,
        ]);

        $this->assertAuthenticated();

        $response->assertRedirect($this->getRouteRedirect($role));
    }

    public function testSignUpLegalSuccess()
    {
        $response = $this->post($this->getApiRoute(), [
            'email' => $email = 'legal@example.com',
            'password' => 'password123',
            'role' => $role = Role::LEGAL->value,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'role' => $role,
        ]);

        $this->assertAuthenticated();

        $response->assertRedirect($this->getRouteRedirect($role));
    }

    public function testSignUpPhysSuccess()
    {
        $response = $this->post($this->getApiRoute(), [
            'email' => $email = 'legal@example.com',
            'password' => 'password123',
            'role' => $role = Role::PHYS->value,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'role' => $role,
        ]);

        $this->assertAuthenticated();

        $response->assertRedirect($this->getRouteRedirect($role));
    }

    public function testSignUpAlreadyExist()
    {
        User::create([
            'username' => 'legal@example.com',
            'email' => 'legal@example.com',
            'password' => 'password123',
            'role' => Role::LEGAL->value,
        ]);

        $response = $this->post($this->getApiRoute(), [
            'email' => 'legal@example.com',
            'password' => 'password123',
            'role' => Role::LEGAL->value,
        ]);

        $response->assertSessionHasErrors(['email']);
        $response->assertSessionHasErrors([
            'email' => 'Пользователь с таким email уже существует',
        ]);
    }

    private function getApiRoute(): string
    {
        return route('manager.auth.signUp');
    }

    private function getRouteRedirect(string $role)
    {
        return route("manager.{$role}.home");
    }
}
