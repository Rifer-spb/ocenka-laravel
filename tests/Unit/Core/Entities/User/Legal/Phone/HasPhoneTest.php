<?php

namespace Tests\Unit\Core\Entities\User\Legal\Phone;

use App\Core\Entities\User\Legal\Legal;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Legal::class, 'hasPhone')]
class HasPhoneTest extends TestCase
{
    public function testFalse()
    {
        $phys = Legal::factory()->create();

        $this->assertFalse($phys->hasPhone(79112223344));
    }

    public function testTrue()
    {
        $phys = Legal::factory()
            ->withPhone(['phone' => $phone = 79112223344])
            ->create();

        $this->assertTrue($phys->hasPhone($phone));
    }
}
