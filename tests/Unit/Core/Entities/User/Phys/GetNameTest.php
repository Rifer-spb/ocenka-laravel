<?php

namespace Tests\Unit\Core\Entities\User\Phys;

use App\Core\Entities\User\Phys\Phys;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Phys::class, 'getName')]
class GetNameTest extends TestCase
{
    public function testSuccessWithEmptyProfileName()
    {
        $phys = Phys::factory()->withProfile(['full_name' => ''])->create();

        $this->assertEquals($phys->getName(), $phys->username);
    }

    public function testSuccessWithProfileName()
    {
        $phys = Phys::factory()
            ->withProfile([
                'first_name' => 'new-firstName',
                'second_name' => 'new-secondName',
                'last_name' => 'new-lastName',
            ])
            ->create();

        $this->assertEquals($phys->getName(), $phys->profile->getShortFullName());
    }
}
