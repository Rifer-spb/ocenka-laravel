<?php

namespace Tests\Unit\Core\Entities\Notary;

use App\Core\Entities\Notary\Notary;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Notary::class, 'hasEmail')]
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
