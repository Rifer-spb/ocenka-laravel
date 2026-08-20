<?php

namespace Integration\Manager\UseCases\Phys;

use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\ValueObjects\FirstName;
use App\Core\Models\User\ValueObjects\LastName;
use App\Core\Models\User\ValueObjects\Password;
use App\Core\Models\User\ValueObjects\SecondName;
use App\Core\ValueObjects\Email;
use App\Manager\UseCases\Phys\Profile\UpdateNameUseCase;
use Tests\TestCase;

class UpdateNameTest extends TestCase
{
    private UpdateNameUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useCase = app(UpdateNameUseCase::class);
    }

    public function testWithAllFilled()
    {
        $user = $this->createUser();

        $this->useCase->execute(
            $user,
            new FirstName($firstName = 'newFirstName'),
            new SecondName($secondName = 'newSecondName'),
            new LastName($lastName = 'newLastName'),
        );

        $user = Phys::findOrFail($user->id);

        $this->assertEquals($user->profile->first_name, $firstName);
        $this->assertEquals($user->profile->second_name, $secondName);
        $this->assertEquals($user->profile->last_name, $lastName);
    }

    public function testWithAllEmpty()
    {
        $user = $this->createUser();
        $user->updateName(
            new FirstName('FirstName'),
            new SecondName('SecondName'),
            new LastName('LastName'),
        );

        $this->useCase->execute(
            $user,
            new FirstName($firstName = ''),
            new SecondName($secondName = ''),
            new LastName($lastName = ''),
        );

        $user = Phys::findOrFail($user->id);

        $this->assertEquals($user->profile->first_name, $firstName);
        $this->assertEquals($user->profile->second_name, $secondName);
        $this->assertEquals($user->profile->last_name, $lastName);
    }

    private function createUser(): Phys
    {
        return Phys::new(
            new Email('test@mail.ru'),
            new Password('password')
        );
    }
}
