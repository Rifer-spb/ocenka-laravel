<?php

namespace Tests\Unit\Core\Entities\Call;

use App\Core\Entities\Call\Call;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Call::class, 'isMobileFromPhone')]
class IsMobileFromPhoneTest extends TestCase
{
    public function testTrue()
    {
        $call = Call::factory()->create(['phone_from' => '79112223344']);

        $this->assertTrue($call->isMobileFromPhone());
    }

    public function testFalse()
    {
        $call = Call::factory()->create(['phone_from' => '78122223344']);

        $this->assertFalse($call->isMobileFromPhone());
    }
}
