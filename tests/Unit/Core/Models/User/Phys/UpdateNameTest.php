<?php

namespace Tests\Unit\Core\Models\User\Phys;

use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\ValueObjects\FirstName;
use App\Core\Models\User\ValueObjects\LastName;
use App\Core\Models\User\ValueObjects\Password;
use App\Core\Models\User\ValueObjects\SecondName;
use App\Core\ValueObjects\Email;
use Tests\TestCase;

class UpdateNameTest extends TestCase
{
    public function testFilledSuccess()
    {
        $user = $this->createUser();

        $user->updateName(
            new FirstName($firstName = 'newFirstName'),
            new SecondName($secondName = 'newSecondName'),
            new LastName($lastName = 'newLastName'),
        );

        $user = Phys::findOrFail($user->id);

        $this->assertEquals($user->profile->first_name, $firstName);
        $this->assertEquals($user->profile->second_name, $secondName);
        $this->assertEquals($user->profile->last_name, $lastName);
        $this->assertEquals($user->profile->full_name, "{$firstName} {$secondName} {$lastName}");
    }

    public function testEmptySuccess()
    {
        $user = $this->createUser();

        $user->updateName(
            new FirstName($firstName = ''),
            new SecondName($secondName = ''),
            new LastName($lastName = ''),
        );

        $user = Phys::findOrFail($user->id);

        $this->assertEquals($user->profile->first_name, $firstName);
        $this->assertEquals($user->profile->second_name, $secondName);
        $this->assertEquals($user->profile->last_name, $lastName);
        $this->assertEmpty($user->profile->full_name);
    }

    public function createUser(): Phys
    {
        $user = Phys::new(
            new Email('phys@example.com'),
            new Password('password'),
        );

        $user->updateName(
            new FirstName( 'FirstName'),
            new SecondName('SecondName'),
            new LastName('LastName'),
        );

        return $user;
    }
}
