<?php

namespace Integration\Core\UseCases\User;

use App\Core\Models\User\Role;
use App\Core\Models\User\User;
use App\Core\Models\User\ValueObjects\Password;
use App\Core\ValueObjects\Email;
use App\Manager\UseCases\User\SignUpUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SignUpTest extends TestCase
{
    use RefreshDatabase;

    private SignUpUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useCase = app(SignUpUseCase::class);
    }

    public function test_registry_phys(): void
    {
        $user = $this->useCase->execute(
            new Email('test@test.com'),
            new Password('password'),
            Role::PHYS
        );

        $this->assertInstanceOf(User::class, $user);

        $this->assertSame('test@test.com', $user->email);
        $this->assertSame(Role::PHYS->value, $user->role);

        $this->assertDatabaseHas('users', [
            'email' => 'test@test.com',
            'role' => Role::PHYS->value,
        ]);

        $this->assertTrue(Hash::check('password', $user->password));
    }
}
