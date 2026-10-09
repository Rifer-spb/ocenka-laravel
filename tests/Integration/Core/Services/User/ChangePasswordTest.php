<?php

namespace Tests\Integration\Core\Services\User;

use App\Core\Entities\User\Phys\Phys;
use App\Core\Entities\User\ValueObjects\Password;
use App\Core\Services\UserService;
use App\Core\ValueObjects\Email;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    private UserService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(UserService::class);
    }

    /**
     * @throws \Throwable
     */
    public function testInvalid()
    {
        $user = $this->createUser();

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Неверный текущий пароль.');

        $this->service->changePassword(
            $user->id,
            new Password('invalid-password'),
            new Password('newPassword')
        );
    }

    /**
     * @throws \Throwable
     */
    public function testSuccess()
    {
        $user = $this->createUser();

        $this->service->changePassword(
            $user->id,
            new Password('password'),
            new Password($newPassword = 'newPassword')
        );

        $user = Phys::findOrFail($user->id);
        $this->assertTrue(Hash::check($newPassword, $user->password));
    }

    private function createUser(): Phys
    {
        return Phys::createNew(
            new Email('test@test.com'),
            new Password('password')
        );
    }
}
