<?php

namespace Tests\Unit\Core\Models\Notary;

use App\Core\Entities\Notary\Notary;
use Tests\TestCase;

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
