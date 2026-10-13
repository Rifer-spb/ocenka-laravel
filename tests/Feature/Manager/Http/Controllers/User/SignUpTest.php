<?php

namespace Tests\Feature\Manager\Http\Controllers\User;

use App\Core\Jobs\SendMailJob;
use App\Core\Entities\User\Role;
use App\Core\Entities\User\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SignUpTest extends TestCase
{
    public function testRequired()
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

    public function testInvalidEmail()
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

    public function testInvalidRole()
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

    public function testMinPassword()
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

    public function testMaxPassword()
    {
        $response = $this->post($this->getApiRoute(), [
            'email' => 'legal@example.com',
            'password' => 'my-cat-loves-whiskas-and-sleeps-on-the-sofa-every-day',
            'role' => Role::LEGAL->value,
        ]);

        $response->assertSessionHasErrors(['password']);
        $response->assertSessionHasErrors([
            'password' => 'Пароль не может быть длиннее 50 символов',
        ]);
    }

    public function testTrim()
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

    public function testLowerCase()
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

    public function testLegalSuccess()
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
        Queue::assertPushed(SendMailJob::class);
    }

    public function testPhysSuccess()
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
        Queue::assertPushed(SendMailJob::class);
    }

    /**
     * @throws \Throwable
     */
    public function testAlreadyExist()
    {
        $user = new User();
        $user->username = 'legal@example.com';
        $user->email = 'legal@example.com';
        $user->password = Hash::make('password123');
        $user->role = Role::LEGAL->value;
        $user->saveOrFail();

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
