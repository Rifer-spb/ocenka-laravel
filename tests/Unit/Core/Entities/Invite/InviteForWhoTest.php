<?php

namespace Tests\Unit\Core\Entities\Invite;

use App\Core\Entities\Invite\Invite;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Invite::class, 'isForPhys')]
#[CoversMethod(Invite::class, 'isForLegal')]
class InviteForWhoTest extends TestCase
{
    public function testForPhys()
    {
        $invite = Invite::factory()
            ->withForPhys()
            ->create();

        $this->assertTrue($invite->isForPhys());
    }

    public function testForLegal()
    {
        $invite = Invite::factory()
            ->withForLegal()
            ->create();

        $this->assertTrue($invite->isForLegal());
    }
}
