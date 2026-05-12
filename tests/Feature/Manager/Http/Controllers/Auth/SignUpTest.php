<?php

namespace Feature\Manager\Http\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SignUpTest extends TestCase
{
    use RefreshDatabase;

    public function test_sign_up_legal_success()
    {
        $response = $this->post($this->getApiRoute(), [
            'email' => $email = 'legal@example.com',
            'password' => 'password123',
            'role' => $role = 'legal',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'role' => $role,
        ]);

        $this->assertAuthenticated();

        $response->assertStatus(302);
        $response->assertRedirect(route("manager.{$role}.home"));
    }

    public function test_sign_up_required()
    {
        $response = $this->post($this->getApiRoute(), [
            'email' => '',
            'password' => '',
            'role' => '',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email', 'password', 'role']);

        $response->assertSessionHasErrors([
            'email' => 'Email обязателен для заполнения',
            'password' => 'Пароль обязателен для заполнения',
            'role' => 'Выберите тип аккаунта',
        ]);
    }

    public function test_sign_up_invalid_email()
    {
        $response = $this->post($this->getApiRoute(), [
            'email' => 'awdawdawd',
            'password' => 'password',
            'role' => 'legal',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email']);

        $response->assertSessionHasErrors([
            'email' => 'Введите корректный email адрес',
        ]);
    }

    private function getApiRoute(): string
    {
        return route('manager.auth.signUp');
    }
}
