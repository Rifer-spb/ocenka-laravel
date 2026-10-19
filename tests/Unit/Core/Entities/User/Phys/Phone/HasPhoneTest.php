<?php

namespace Tests\Unit\Core\Entities\User\Phys\Phone;

use App\Core\Entities\User\Phys\Phys;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Phys::class, 'hasPhone')]
class HasPhoneTest extends TestCase
{
    public function testFalse()
    {
        $phys = Phys::factory()->create();

        $this->assertFalse($phys->hasPhone(79112223344));
    }

    public function testTrue()
    {
        $phys = Phys::factory()
            ->withPhone(['phone' => $phone = 79112223344])
            ->create();

        $this->assertTrue($phys->hasPhone($phone));
    }
}
