<?php

namespace Tests\Integration\Core\Services\User;

use App\Core\Entities\User\Role;
use App\Core\Entities\User\User;
use App\Core\Entities\User\ValueObjects\Password;
use App\Core\Jobs\SendMailJob;
use App\Core\Services\UserService;
use App\Core\ValueObjects\Email;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(UserService::class, 'signUpManager')]
class SignUpTest extends TestCase
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
    public function testSignUpPhys(): void
    {
        $user = $this->service->signUpManager(
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

    /**
     * @throws \Throwable
     */
    public function testSignUpLegal(): void
    {
        $user = $this->service->signUpManager(
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

    /**
     * @throws \Throwable
     */
    public function testInvalidRole()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Роль должна быть юр.лицо или физ.лицо.');

        $this->service->signUpManager(
            new Email('test@test.com'),
            new Password('password'),
            Role::CLIENT
        );
    }
}
