<?php

namespace Feature\Manager\Http\Controllers\User;

use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\ValueObjects\Password;
use App\Core\ValueObjects\Email;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    public function testRequired()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)->patch($this->getRoute(), [
            'oldPassword' => '',
            'newPassword' => '',
        ]);

        $response->assertSessionHasErrors([
            'oldPassword' => 'Поле обязательно к заполнению',
            'newPassword' => 'Поле обязательно к заполнению',
        ]);
    }

    public function testMinOldPassword()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)->patch($this->getRoute(), [
            'oldPassword' => 'password',
            'newPassword' => 'pass',
        ]);

        $response->assertSessionHasErrors([
            'newPassword' => 'Поле должно быть минимум 8 символов',
        ]);
    }

    public function testMaxOldPassword()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)->patch($this->getRoute(), [
            'oldPassword' => 'password',
            'newPassword' => str_repeat('abc', 20),
        ]);

        $response->assertSessionHasErrors([
            'newPassword' => 'Поле должно быть не больше 50 символов',
        ]);
    }

    public function testInvalidConfirm()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)->patch($this->getRoute(), [
            'oldPassword' => 'invalid-password',
            'newPassword' => 'new-password',
        ]);

        $response->assertSessionHasErrors([
            'oldPassword' => 'Текущий пароль неверен',
        ]);
    }

    public function testSuccess()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)->patch($this->getRoute(), [
            'oldPassword' => 'password',
            'newPassword' => 'new-password',
        ]);

        $response->assertSessionHas(['success' => 'Пароль успешно изменен']);

        $user = Phys::findOrFail($user->id);
        $this->assertTrue(Hash::check('new-password', $user->password));
    }

    private function createUser(): Phys
    {
        return Phys::factory()->create();
    }

    private function getRoute(): string
    {
        return route('manager.phys.settings.account.password.update');
    }
}
