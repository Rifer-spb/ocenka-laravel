<?php

namespace Tests\Unit\Core\Models\Invite;

use App\Core\Models\Invite\Invite;
use Tests\TestCase;

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
