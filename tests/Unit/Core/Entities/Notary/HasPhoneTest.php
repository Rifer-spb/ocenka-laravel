<?php

namespace Tests\Unit\Core\Entities\Notary;

use App\Core\Entities\Notary\Notary;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Notary::class, 'hasPhone')]
class HasPhoneTest extends TestCase
{
    public function testFalse()
    {
        $notary = Notary::factory()->create();

        $this->assertFalse($notary->hasPhone(79112223344));
    }

    public function testTrue()
    {
        $notary = Notary::factory()
            ->withPhone($phone = 79112223344)
            ->create();

        $this->assertTrue($notary->hasPhone($phone));
    }
}
