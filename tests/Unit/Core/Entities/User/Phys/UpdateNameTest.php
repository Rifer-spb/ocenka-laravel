<?php

namespace Tests\Unit\Core\Entities\User\Phys;

use App\Core\Entities\User\Phys\Phys;
use App\Core\Entities\User\ValueObjects\FirstName;
use App\Core\Entities\User\ValueObjects\LastName;
use App\Core\Entities\User\ValueObjects\SecondName;
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
        return Phys::factory()->withProfile()->create();
    }
}
