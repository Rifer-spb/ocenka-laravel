<?php

namespace Integration\Manager\UseCases\User;

use App\Core\Jobs\SendMailJob;
use App\Core\Models\User\Role;
use App\Core\Models\User\User;
use App\Core\Models\User\ValueObjects\Password;
use App\Core\ValueObjects\Email;
use App\Manager\UseCases\User\SignUpUseCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SignUpTest extends TestCase
{
    private SignUpUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useCase = app(SignUpUseCase::class);
    }

    public function testSignUpPhys(): void
    {
        $user = $this->useCase->execute(
            new Email($email = 'test@test.com'),
            new Password($password = 'password'),
            Role::PHYS
        );

        $this->assertInstanceOf(User::class, $user);

        $this->assertEquals('test@test.com', $user->email);
        $this->assertEquals(Role::PHYS->value, $user->role);

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'role' => Role::PHYS->value,
        ]);

        $this->assertTrue(Hash::check($password, $user->password));
        Queue::assertPushed(SendMailJob::class);
    }

    public function testSignUpLegal(): void
    {
        $user = $this->useCase->execute(
            new Email($email = 'test@test.com'),
            new Password($password = 'password'),
            Role::LEGAL
        );

        $this->assertInstanceOf(User::class, $user);

        $this->assertEquals('test@test.com', $user->email);
        $this->assertEquals(Role::LEGAL->value, $user->role);

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'role' => Role::LEGAL->value,
        ]);

        $this->assertTrue(Hash::check($password, $user->password));
        Queue::assertPushed(SendMailJob::class);
    }

    public function testInvalidRole()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Роль должна быть юр.лицо или физ.лицо.');

        $this->useCase->execute(
            new Email('test@test.com'),
            new Password('password'),
            Role::CLIENT
        );
    }
}
