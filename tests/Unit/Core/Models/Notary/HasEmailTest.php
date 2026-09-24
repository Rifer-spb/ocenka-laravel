<?php

namespace Tests\Unit\Core\Models\Notary;

use App\Core\Models\Notary\Notary;
use Tests\TestCase;

class HasEmailTest extends TestCase
{
    public function testFalse()
    {
        $notary = Notary::factory()->create();

        $this->assertFalse($notary->hasEmail('not-exist-email@example.com'));
    }

    public function testTrue()
    {
        $notary = Notary::factory()
            ->withEmail($email = 'exist-email@example.com')
            ->create();

        $this->assertTrue($notary->hasEmail($email));
    }
}
