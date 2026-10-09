<?php

namespace Tests\Integration\Core\Services\Phys\Profile;

use App\Core\Entities\User\Phys\Phys;
use App\Core\Entities\User\ValueObjects\FirstName;
use App\Core\Entities\User\ValueObjects\LastName;
use App\Core\Entities\User\ValueObjects\SecondName;
use App\Core\Services\PhysProfileService;
use Tests\TestCase;

class UpdateNameTest extends TestCase
{
    private PhysProfileService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(PhysProfileService::class);
    }

    public function testWithAllFilled()
    {
        $user = $this->createUser();

        $this->service->updateName(
            $user->id,
            new FirstName($firstName = 'newFirstName'),
            new SecondName($secondName = 'newSecondName'),
            new LastName($lastName = 'newLastName'),
        );

        $user->refresh();

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

        $this->service->updateName(
            $user->id,
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
        return Phys::factory()->withProfile()->create();
    }
}
