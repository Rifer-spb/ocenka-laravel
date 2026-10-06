<?php

namespace Integration\Manager\UseCases\User;

use App\Core\Entities\User\Phys\Phys;
use App\Core\Entities\User\ValueObjects\Password;
use App\Core\ValueObjects\Email;
use App\Manager\UseCases\User\ChangePasswordUseCase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    private ChangePasswordUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useCase = app(ChangePasswordUseCase::class);
    }

    public function testInvalid()
    {
        $user = $this->createUser();

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Неверный текущий пароль.');

        $this->useCase->execute(
            $user,
            new Password('invalid-password'),
            new Password('newPassword')
        );
    }

    public function testSuccess()
    {
        $user = $this->createUser();

        $this->useCase->execute(
            $user,
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
